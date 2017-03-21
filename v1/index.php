<?php

require_once '../include/DbHandler.php';
require_once '../include/PassHash.php';
require_once '../include/Firebase.php';
require_once '../include/Push.php';
require '.././libs/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

// User id from db - Global Variable
$user_id = NULL;

/**
 * Adding Middle Layer to authenticate every request
 * Checking if the request has valid api key in the 'Authorization' header
 */
function authenticate(\Slim\Route $route) {
    // Getting request headers
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();

    // Verifying Authorization Header
    if (isset($headers['Authorization'])) {
        $db = new DbHandler();

        // get the api key
        $api_key = $headers['Authorization'];
        // validating api key
        if (!$db->isValidApiKey($api_key)) {
            // api key is not present in users table
            $response["error"] = true;
            $response["message"] = "Access Denied. Invalid Api key";
            echoRespnse(401, $response);
            $app->stop();
        } else {
            global $user_id;
            // get user primary keR23y id
            $user_id = $db->getUserId($api_key);
        }
    } else {
        // api key is missing in header
        $response["error"] = true;
        $response["message"] = "Api key is misssing";
        echoRespnse(400, $response);
        $app->stop();
    }
}

$app->post('/register', function() use ($app) {
    // check for required params
    verifyRequiredParams(array('name', 'email', 'password'));
    $response = array();

    // reading post params
    $name = $app->request->post('name');
    $email = $app->request->post('email');
    $password = $app->request->post('password');

    // validating email address
    validateEmail($email);

    $db = new DbHandler();
    $res = $db->createUser($name, $email, $password);

    if ($res == USER_CREATED_SUCCESSFULLY) {
        $response["error"] = false;
        $response["message"] = "You are successfully registered";
    } else if ($res == USER_CREATE_FAILED) {
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while registereing";
    } else if ($res == USER_ALREADY_EXISTED) {
        $response["error"] = true;
        $response["message"] = "Sorry, this email already existed";
    }
    // echo json response
    echoRespnse(201, $response);
});

$app->post('/login', function() use ($app) {
    // check for required params
    verifyRequiredParams(array('email', 'password'));

    // reading post params
    $email = $app->request()->post('email');
    $password = $app->request()->post('password');
    $response = array();

    $db = new DbHandler();
    // check for correct email and password
    if ($db->checkLogin($email, $password)) {
        // get the user by email
        $user = $db->getUserByEmail($email);

        if ($user != NULL) {
            $response["error"] = false;
            $response['username'] = $user['username'];
            $response['email'] = $user['email'];
            $response['apiKey'] = $user['api_key'];
            $response['createdAt'] = $user['created_at'];
        } else {
            // unknown error occurred
            $response['error'] = true;
            $response['message'] = "An error occurred. Please try again";
        }
    } else {
        // user credentials are wrong
        $response['error'] = true;
        $response['message'] = 'Login failed. Incorrect credentials';
    }

    echoRespnse(200, $response);
});

$app->put('/users', 'authenticate', function() use ($app) {
    global $user_id;
 
    verifyRequiredParams(array('gcm_registration_id'));
 
    $gcm_registration_id = $app->request->put('gcm_registration_id');
    $db = new DbHandler();
    $response = $db->updateGcmID($user_id, $gcm_registration_id);
 
    echoRespnse(200, $response);
});

$app->put('/alatuser', 'authenticate', function() use ($app) {
    verifyRequiredParams(array('rssi', 'battery', 'idalat'));
 
    $rssi = $app->request->put('rssi');
    $battery = $app->request->put('battery');
    $idalat = $app->request->put('idalat');
    $db = new DbHandler();
    $response = $db->updateAlatUser($rssi, $battery, $idalat);
 
    echoRespnse(200, $response);
});

$app->get('/tasks', 'authenticate', function() {
    global $user_id;
    $response = array();
    $db = new DbHandler();

    // fetching all user tasks
    $result = $db->getAllUserTasks($user_id);

    $response["error"] = false;
    $response["tasks"] = array();

    // looping through result and preparing tasks array
    while ($task = $result->fetch_assoc()) {
        $tmp = array();
        $tmp["id"] = $task["id"];
        $tmp["sensor1"] = $task["sensor1"];
        $tmp["sensor2"] = $task["sensor2"];
        $tmp["sensor3"] = $task["sensor3"];
        $tmp["output"] = $task["output"];
        $tmp["status"] = $task["status"];
        $tmp["createdAt"] = $task["created_at"];
        array_push($response["tasks"], $tmp);
    }
    echoRespnse(200, $response);
});


$app->get('/tasks/:id', 'authenticate', function($task_id) {
    global $user_id;
    $response = array();
    $db = new DbHandler();

    // fetch task
    $result = $db->getTask($task_id, $user_id);

    if ($result != NULL) {
        $response["error"] = false;
        $response["id"] = $result["id"];
        $response["sensor1"] = $result["sensor1"];
        $response["sensor2"] = $result["sensor2"];
        $response["sensor3"] = $result["sensor3"];
        $response["output"] = $result["output"];
        $response["status"] = $result["status"];
        $response["createdAt"] = $result["created_at"];
        echoRespnse(200, $response);
    } else {
        $response["error"] = true;
        $response["message"] = "The requested resource doesn't exists";
        echoRespnse(404, $response);
    }
});

$app->post('/data_sensor', 'authenticate', function() use ($app) {
    // check for required params
    verifyRequiredParams(array('hpsp', 'hpc', 'uk', 'optime','idalat'));

    $response = array();
    $hpsp = $app->request->post('hpsp');
    $hpc = $app->request->post('hpc');
    $uk = $app->request->post('uk');
    $optime = $app->request->post('optime');
    $idalat = $app->request->post('idalat');

    global $user_id;
    $db = new DbHandler();

    $task_id = $db->createDataSensor($user_id, $idalat, $hpsp, $hpc, $uk, $optime);

    if ($task_id != NULL) {
        
        $response["error"] = false;
        $response['hpsp'] = $task_id['hpsp'];
        $response['hpc'] = $task_id['hpc'];
        $response['uk'] = $task_id['uk'];
        $response['optime'] = $task_id['optime'];
       
        echoRespnse(201, $response);
    } else {
        $response["error"] = true;
        $response["message"] = "Failed to create task. Please try again";
        echoRespnse(200, $response);
    }
});

$app->get('/data_sensor/:id', 'authenticate', function($task_id) {
    global $user_id;
    $response = array();
    $db = new DbHandler();

    // fetch task
    $result = $db->getDataSsensor($task_id, $user_id);

    if ($result != NULL) {
        $response["error"] = false;
        $response["id"] = $result["id"];
        $response["hpsp"] = $result["hpsp"];
        $response["hpc"] = $result["hpc"];
        $response["uk"] = $result["uk"];
        $response["optime"] = $result["optime"];
        $response["createdAt"] = $result["created_at"];
        echoRespnse(200, $response);
    } else {
        $response["error"] = true;
        $response["message"] = "The requested resource doesn't exists";
        echoRespnse(404, $response);
    }
});

$app->get('/databyidalat/:id', 'authenticate', function($id_alat) use ($app){
    global $user_id;
    $response = array();
    $db = new DbHandler();
    
    // fetching all user tasks
    $result = $db->getAllDataByIdAlat($id_alat);
    $response["error"] = false;
    $response["tasks"] = array();

    // looping through result and preparing tasks array
    while ($task = $result->fetch_assoc()) {
        $tmp = array();
        $tmp["id"] = $task["id"];
        $tmp["hpsp"] = $task["hpsp"];
        $tmp["hpc"] = $task["hpc"];
        $tmp["uk"] = $task["uk"];
        $tmp["optime"] = $task["optime"];
        $tmp["createdAt"] = $task["created_at"];
        array_push($response["tasks"], $tmp);
    }

    echoRespnse(200, $response);
});

$app->get('/lastdatabyidalat/:id', 'authenticate', function($id_alat) use ($app){
    global $user_id;
    $response = array();
    $db = new DbHandler();
    
    // fetching all user tasks
    $result = $db->getLastDataByIdAlat($id_alat);
    $response["error"] = false;
    $response["tasks"] = array();

    // looping through result and preparing tasks array
    while ($task = $result->fetch_assoc()) {
        $tmp = array();
        $tmp["id"] = $task["id"];
        $tmp["suhu"] = $task["suhu"];
        $tmp["ph"] = $task["ph"];
        $tmp["do"] = $task["do"];
        $tmp["hasil"] = $task["hasil"];
        $tmp["status"] = $task["status"];
        $tmp["createdAt"] = $task["create_at"];
        array_push($response["tasks"], $tmp);
    }

    echoRespnse(200, $response);
});
$app->get('/getalatuser', 'authenticate', function() use ($app){
    global $user_id;
    $response = array();
    $db = new DbHandler();
    
    // fetching all user tasks
    $result = $db->getAlatUser($user_id);
    $response["error"] = false;
    $response["tasks"] = array();

    // looping through result and preparing tasks array
    while ($task = $result->fetch_assoc()) {
        $tmp = array();
        $tmp["id"] = $task["id"];
        $tmp["id_alat"] = $task["id_alat"];
        $tmp["id_user"] = $task["id_user"];
	$tmp["nama"] = $task["nama"];
        $tmp["latitude"] = $task["latitude"];
        $tmp["longitude"] = $task["longitude"];
        $tmp["rssi"] = $task["rssi"];
        $tmp["battery"] = $task["battery"];
        $tmp["status"] = $task["status"];

        array_push($response["tasks"], $tmp);
    }
	echoRespnse(200, $response);
});

$app->post('/registeralat', 'authenticate', function() use ($app) {

    $response = array();
    global $user_id;
   
    $db = new DbHandler();
    $res = $db->createDataAlat($user_id);

    if ($res == ID_ALAT_CREATED_SUCCESSFULLY) {
        $response["error"] = false;
        $response["message"] = "Tools s uccessfully registered";
    } else if ($res == ID_ALAT_USER_CREATE_FAILED) {
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while registereing";
    } 
    // echo json response
    echoRespnse(201, $response);
});

$app->post('/registeralatuser', 'authenticate', function() use ($app) {
    // check for required params
    verifyRequiredParams(array('id_alat', 'nama'));
    $response = array();
    global $user_id;
    // reading post params
    $id_alat = $app->request->post('id_alat');
    $nama = $app->request->post('nama');

    $db = new DbHandler();
    $res = $db->createAlatUser($id_alat, $user_id, $nama);

    if ($res == ALAT_USER_CREATED_SUCCESSFULLY) {
        $response["error"] = false;
        $response["message"] = "Tools are successfully registered";
    } else if ($res == ALAT_USER_CREATE_FAILED) {
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while registereing";
	} else if ($res == ALAT_USER_ISNOT_EXISTED) {
        $response["error"] = true;
        $response["message"] = "Sorry, this tools already existed";
    }
    // echo json response
    echoRespnse(201, $response);
});

//post data from alat
$app->post('/datasensor/:id', 'authenticate', function($id_alat) use ($app) {
    // check for required params
    verifyRequiredParams(array('hpsp', 'hpc', 'uk', 'optime'));
    $response = array();
    
    $hpsp = $app->request->post('hpsp');
    $hpc = $app->request->post('hpc');
    $uk = $app->request->post('uk');
    $optime = $app->request->post('optime');

    global $user_id;
    $db = new DbHandler();

    // creating new task
    $task_id = $db->dataSensorByIdAlat($id_alat, $hpsp, $hpc, $uk, $optime);

    if ($task_id) {
        $response['error'] = false;
	$response['message'] = "Succesfull to create data sensor. Please try again";
        echoRespnse(201, $response);
    } else {
        $response["error"] = true;
        $response["message"] = "Failed to create data sensor. Please try again";
        echoRespnse(200, $response);
    }
});

$app->delete('/deletealatuser/:id', 'authenticate', function($id_alat) use ($app) {
    // check for required params
    global $user_id;
    
    $db = new DbHandler();
	$response = array();
    $result = $db->deleteAlatUser($id_alat, $user_id);

    if ($result) {
        // task deleted successfully
        $response["error"] = false;
        $response["message"] = "Alat deleted succesfully";
    } else {
        // task failed to delete
        $response["error"] = true;
        $response["message"] = "Alat failed to delete. Please try again!";
    }
    echoRespnse(200, $response);
});

$app->post('/sendtotopic', function() use ($app){
    
    verifyRequiredParams(array('title', 'message'));
    $response = array();
    global $user_id;
    // reading post params
    $title = $app->request->post('title');
    $message = $app->request->post('message');

    $db = new DbHandler();
    $res = $db->sendToTopic($title, $message);

    if ($res == MESSAGE_SENT_SUCCESSFULLY) {
        $response["error"] = false;
        $response["message"] = "message are successfully sent";
    } else if ($res == MESSAGE_SENT_FAILED) {
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while sending message";
    } 
    // echo json response
    echoRespnse(201, $response);
});

$app->post('/sendsingle', function() use ($app){
    
    verifyRequiredParams(array('to', 'title', 'message'));
    $response = array();
    global $user_id;
    // reading post params
    $to = $app->request->post('to');
    $title = $app->request->post('title');
    $message = $app->request->post('message');
    $firebase = new Firebase();
    $push = new Push();
    
    $push->setTitle($title);
    $push->setMessage($message);
    $push->setImage('');
    $push->setIsBackground(FALSE);
    $payload = array();
    $payload['team'] = 'India';
    $payload['score'] = '5.6';
    $push->setPayload($payload);
    $json = '';
    $json = $push->getPush();
    
    $db = new DbHandler();
    //$res = $db->send($to, $json);
    $res = $firebase->send($to, $json);

    if ($res == MESSAGE_SENT_SUCCESSFULLY) {
        $response["error"] = false;
        $response["message"] = "message are successfully sent";
    } else if ($res == MESSAGE_SENT_FAILED) {
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while sending message";
    } 
    // echo json response
    echoRespnse(201, $response);
});


$app->post('/tasks', 'authenticate', function() use ($app) {
    // check for required params
    verifyRequiredParams(array('sensor1', 'sensor2', 'sensor3', 'output'));

    $response = array();
    $sensor1 = $app->request->post('sensor1');
    $sensor2 = $app->request->post('sensor2');
    $sensor3 = $app->request->post('sensor3');
    $output = $app->request->post('output');

    global $user_id;
    $db = new DbHandler();

    // creating new task
    $task_id = $db->createTask($user_id, $sensor1, $sensor2, $sensor3, $output);

    if ($task_id != NULL) {
        $msg = array();
        $msg['sensor1'] = $sensor1;
        $msg['sensor2'] = $sensor2;
        $msg['sensor3'] = $sensor3;
        $msg['sensor3'] = $sensor3;
        $msg['output'] = $output;
        $msg['created_at'] = date('Y-m-d G:i:s');

        $response['user'] = $msg;
        $response['error'] = false;
        
        echoRespnse(201, $push->getPush());
    } else {
        $response["error"] = true;
        $response["message"] = "Failed to create task. Please try again";
        echoRespnse(200, $response);
    }
});

/**
 * Creating new task in db
 * method POST
 * params - name
 * url - /tasks/
 */
$app->post('/tasks', 'authenticate', function() use ($app) {
    // check for required params
    verifyRequiredParams(array('sensor1', 'sensor2', 'sensor3', 'output'));

    $response = array();
    $sensor1 = $app->request->post('sensor1');
    $sensor2 = $app->request->post('sensor2');
    $sensor3 = $app->request->post('sensor3');
    $output = $app->request->post('output');

    global $user_id;
    $db = new DbHandler();

    // creating new task
    $task_id = $db->createTask($user_id, $sensor1, $sensor2, $sensor3, $output);

    if ($task_id != NULL) {
        require_once __DIR__ . '/../libs/gcm/gcm.php';
        require_once __DIR__ . '/../libs/gcm/push.php';
        $gcm = new GCM();
        $push = new Push();
        
        $user = $db->getUser($user_id);
        
        $msg = array();
        $msg['sensor1'] = $sensor1;
        $msg['sensor2'] = $sensor2;
        $msg['sensor3'] = $sensor3;
        $msg['sensor3'] = $sensor3;
        $msg['output'] = $output;
        $msg['created_at'] = date('Y-m-d G:i:s');

        $data = array();
        $data['message'] = $msg;
        $data['image'] = '';

        $push->setTitle("Skripsian Apps");
        $push->setIsBackground(FALSE);
        $push->setFlag(PUSH_FLAG_USER);
        $push->setData($data);
        
        // sending message to topic `global`
        // On the device every user should subscribe to `global` topic
        $gcm->send($user['gcm_registration_id'], $push->getPush());

        $response['user'] = $user;
        $response['error'] = false;
        
        echoRespnse(201, $push->getPush());
    } else {
        $response["error"] = true;
        $response["message"] = "Failed to create task. Please try again";
        echoRespnse(200, $response);
    }
});

/**
 * Updating existing task
 * method PUT
 * params task, status
 * url - /tasks/:id
 */
$app->put('/tasks/:id', 'authenticate', function($task_id) use($app) {
    // check for required params
    verifyRequiredParams(array('sensor1', 'sensor2', 'sensor3', 'output', 'status'));

    global $user_id;
    $sensor1 = $app->request->put('sensor1');
    $sensor2 = $app->request->put('sensor2');
    $sensor3 = $app->request->put('sensor3');
    $output = $app->request->put('output');
    $status = $app->request->put('status');

    $db = new DbHandler();
    $response = array();

    // updating task
    $result = $db->updateTask($user_id, $task_id, $sensor1, $sensor2, $sensor3, $output, $status);
    if ($result) {
        // task updated successfully
        $response["error"] = false;
        $response["message"] = "Task updated successfully";
    } else {
        // task failed to update
        $response["error"] = true;
        $response["message"] = "Task failed to update. Please try again!";
    }
    echoRespnse(200, $response);
});

/**
 * Deleting task. Users can delete only their tasks
 * method DELETE
 * url /tasks
 */
$app->delete('/tasks/:id', 'authenticate', function($task_id) use($app) {
    global $user_id;

    $db = new DbHandler();
    $response = array();
    $result = $db->deleteTask($user_id, $task_id);
    if ($result) {
        // task deleted successfully
        $response["error"] = false;
        $response["message"] = "Task deleted succesfully";
    } else {
        // task failed to delete
        $response["error"] = true;
        $response["message"] = "Task failed to delete. Please try again!";
    }
    echoRespnse(200, $response);
});

/**
 * Verifying required params posted or not
 */
function verifyRequiredParams($required_fields) {
    $error = false;
    $error_fields = "";
    $request_params = array();
    $request_params = $_REQUEST;
    // Handling PUT request params
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }
    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }

    if ($error) {
        // Required field(s) are missing or empty
        // echo error json and stop the app
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error"] = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoRespnse(400, $response);
        $app->stop();
    }
}

/**
 * Validating email address
 */
function validateEmail($email) {
    $app = \Slim\Slim::getInstance();
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["error"] = true;
        $response["message"] = 'Email address is not valid';
        echoRespnse(400, $response);
        $app->stop();
    }
}

/**
 * Echoing json response to client
 * @param String $status_code Http response code
 * @param Int $response Json response
 */
function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);

    // setting response content type to json
    $app->contentType('application/json');

    echo json_encode($response);
}

$app->run();

?>