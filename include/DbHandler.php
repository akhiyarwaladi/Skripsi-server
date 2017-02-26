<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of DbHandler
 *
 * @author erdearik
 */
class DbHandler {

    //put your code hereprivate $conn;
	//hahahahahahaha
    function __construct() {
        require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    /* ------------- `users` table method ------------------ */

    public function createUser($name, $email, $password) {
        $response = array();

        // First check if user already existed in db
        if (!$this->isUserExists($email)) {
            // Generating password hash
            $password_hash = PassHash::hash($password);

            // Generating API key
            $api_key = $this->generateApiKey();

            // insert query
            $stmt = $this->conn->prepare("INSERT INTO user(username, email, password_hash, api_key, status) values(?, ?, ?, ?, 1)");
            $stmt->bind_param("ssss", $name, $email, $password_hash, $api_key);

            $result = $stmt->execute();

            $stmt->close();

            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                return USER_CREATED_SUCCESSFULLY;
            } else {
                // Failed to create user
                return USER_CREATE_FAILED;
            }
        } else {
            // User with same email already existed in the db
            return USER_ALREADY_EXISTED;
        }

        return $response;
    }

    // updating user GCM registration ID
    public function updateGcmID($user_id, $gcm_registration_id) {
        $response = array();
        $stmt = $this->conn->prepare("UPDATE users SET gcm_registration_id = ? WHERE id = ?");
        $stmt->bind_param("si", $gcm_registration_id, $user_id);

        if ($stmt->execute()) {
            // User successfully updated
            $response["error"] = false;
            $response["message"] = 'GCM registration ID updated successfully';
        } else {
            // Failed to update user
            $response["error"] = true;
            $response["message"] = "Failed to update GCM registration ID";
            $stmt->error;
        }
        $stmt->close();

        return $response;
    }

    /**
     * Checking user login
     * @param String $email User login email id
     * @param String $password User login password
     * @return boolean User login status success/fail
     */
    public function checkLogin($email, $password) {
        // fetching user by email
        $stmt = $this->conn->prepare("SELECT password_hash FROM user WHERE email = ?");

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $stmt->bind_result($password_hash);

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Found user with the email
            // Now verify the password

            $stmt->fetch();

            $stmt->close();

            if (PassHash::check_password($password_hash, $password)) {
                // User password is correct
                return TRUE;
            } else {
                // user password is incorrect
                return FALSE;
            }
        } else {
            $stmt->close();

            // user not existed with the email
            return FALSE;
        }
    }

    /**
     * Checking for duplicate user by email address
     * @param String $email email to check in db
     * @return boolean
     */
	 
    private function isUserExists($email) {
        $stmt = $this->conn->prepare("SELECT id from user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
	
	public function createAlatUser($id_alat, $user_id, $nama) {
        $response = array();

        // Generating API key
        //$api_key = $this->generateApiKey();
		$haha = 1;
        // insert query
		if (!$this->isAlatExists($id_alat)) {
			return ALAT_USER_ISNOT_EXISTED;
		}
		else{
		
			$stmt = $this->conn->prepare("INSERT INTO alatuser(id_alat, id_user, nama) values(?, ?, ?)");
			$stmt->bind_param("sss", $id_alat, $user_id, $nama);

			$result = $stmt->execute();

			$stmt->close();

			// Check for successful insertion
			if ($result) {
				// User successfully inserted
				return ALAT_USER_CREATED_SUCCESSFULLY;
			} else {
				// Failed to create user
				return ALAT_USER_CREATE_FAILED;
			}
		}
        return $response;
    }
	
	private function isAlatExists($id_alat) {
        $stmt = $this->conn->prepare("SELECT id from dataalat WHERE kode = ?");
        $stmt->bind_param("s", $id_alat);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
	
    public function deleteAlatUser($id_alat, $user_id) {
        $response = array();

        // delete query
        $stmt = $this->conn->prepare("DELETE from alatuser WHERE id = ?");
        $stmt->bind_param("s", $id_alat);
        $stmt->execute();
        $num_affected_rows = $stmt->affected_rows;
        $stmt->close();
        return $num_affected_rows > 0;
    }

    /**
     * Fetching user by email
     * @param String $email User email id
     */
    public function getUserByEmail($email) {
        $stmt = $this->conn->prepare("SELECT username, email, api_key, status, created_at FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            // $user = $stmt->get_result()->fetch_assoc();
            $stmt->bind_result($username, $email, $api_key, $status, $created_at);
            $stmt->fetch();
            $user = array();
            $user["username"] = $username;
            $user["email"] = $email;
            $user["api_key"] = $api_key;
            $user["status"] = $status;
            $user["created_at"] = $created_at;
            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
    }

    /**
     * Fetching user api key
     * @param String $user_id user id primary key in user table
     */
    public function getApiKeyById($user_id) {
        $stmt = $this->conn->prepare("SELECT api_key FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            // $api_key = $stmt->get_result()->fetch_assoc();
            // TODO
            $stmt->bind_result($api_key);
            $stmt->close();
            return $api_key;
        } else {
            return NULL;
        }
    }

    /**
     * Fetching user id by api key
     * @param String $api_key user api key
     */
    public function getUserId($api_key) {
        $stmt = $this->conn->prepare("SELECT id FROM user WHERE api_key = ?");
        $stmt->bind_param("s", $api_key);
        if ($stmt->execute()) {
            $stmt->bind_result($user_id);
            $stmt->fetch();
            // TODO
            // $user_id = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user_id;
        } else {
            return NULL;
        }
    }

    // fetching single user by id
    public function getUser($user_id) {
        $stmt = $this->conn->prepare("SELECT id, username, email, gcm_registration_id, created_at FROM user WHERE id = ?");
        $stmt->bind_param("s", $user_id);
        if ($stmt->execute()) {
            // $user = $stmt->get_result()->fetch_assoc();
            $stmt->bind_result($user_id, $name, $email, $gcm_registration_id, $created_at);
            $stmt->fetch();
            $user = array();
            $user["user_id"] = $user_id;
            $user["name"] = $name;
            $user["email"] = $email;
            $user["gcm_registration_id"] = $gcm_registration_id;
            $user["created_at"] = $created_at;
            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
    }

    /**
     * Validating user api key
     * If the api key is there in db, it is a valid key
     * @param String $api_key user api key
     * @return boolean
     */
    public function isValidApiKey($api_key) {
        $stmt = $this->conn->prepare("SELECT id from user WHERE api_key = ?");
        $stmt->bind_param("s", $api_key);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    /**
     * Generating random Unique MD5 String for user Api key
     */
    private function generateApiKey() {
        return md5(uniqid(rand(), true));
    }

    /* ------------- `alat` table method ------------------ */

    public function createDataSensor($user_id, $alat_id, $sensor1, $sensor2, $sensor3, $output) {
        $api_key = $this->generateApiKey();
        $stmt = $this->conn->prepare("INSERT INTO datasensor(id_alat, hpsp, hpc, uk, optime) VALUES(?,?,?,?,?)");
        $stmt->bind_param("sssss", $alat_id, $sensor1, $sensor2, $sensor3, $output);
        $result = $stmt->execute();
        $stmt->close();
        echo "sdfsdfsdf ";
        if ($result) {
            echo "sdfsdfsdf ";
            // task row created
            // now assign the task to user
            $new_task_id = $this->conn->insert_id;
            echo "sdfsdfsdf ";
//            $res = $this->createUserTask($user_id, $new_task_id);
            echo "sdfsdfsdf ";
            if (TRUE) {
                // task created successfully
                return $new_task_id;
            } else {
                // task failed to create
                return NULL;
            }
        } else {
            // task failed to create
            return NULL;
        }
    }

    public function getDataSsensor($task_id, $user_id) {

        $stmt = $this->conn->prepare("SELECT t.id, t.hpsp, t.hpc, t.uk, t.optime, t.created_at from datasensor t WHERE t.id = ?");
        $stmt->bind_param("i", $task_id);
        echo "sadsa";
        if ($stmt->execute()) {
            $res = array();
            $stmt->bind_result($id, $sensor1, $sensor2, $sensor3, $output, $created_at);
            // TODO
            // $task = $stmt->get_result()->fetch_assoc();
            $stmt->fetch();
            $res["id"] = $id;
            $res["hpsp"] = $sensor1;
            $res["hpc"] = $sensor2;
            $res["uk"] = $sensor3;
            $res["optime"] = $output;
            $res["created_at"] = $created_at;
            $stmt->close();
            return $res;
        } else {
            return NULL;
        }
    }

    public function getAllDataByIdAlat($id_alat) {
        $stmt = $this->conn->prepare("SELECT t.* FROM datasensor t WHERE t.id_alat = ? ORDER BY t.created_at DESC LIMIT 30");
        $stmt->bind_param("s", $id_alat);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }
	
    public function dataSensorByIdAlat($idAlat, $hpsp, $hpc, $uk, $optime){
        $response = array();

        // insert query
        $stmt = $this->conn->prepare("INSERT INTO datasensor(id_alat, hpsp, hpc, uk, optime) values(?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $idAlat,$hpsp, $hpc, $uk, $optime);

        $result = $stmt->execute();
        $stmt->close();

        if($result){
                return DATA_SENSOR_CREATED_SUCCESSFULLY;
        } else {
                return DATA_SENSOR_CREATE_FAILED;
        }
    }

    public function getLastDataByIdAlat($id_alat) {
        $stmt = $this->conn->prepare("SELECT t.* FROM datasensor t WHERE t.id_alat = ? ORDER BY t.create_at DESC LIMIT 1");
        $stmt->bind_param("s", $id_alat);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }
	
	public function getAlatUser($user_id) {
        $stmt = $this->conn->prepare("SELECT t.* FROM alatuser t WHERE t.id_user = ?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }

    public function createDataAlat($user_id) {
        $response = array();

        // Generating API key
        $api_key = $this->generateApiKey();
		$date = date('Y-m-d G:i:s');
        // insert query
        $stmt = $this->conn->prepare("INSERT INTO dataalat(kode, tanggal_produksi) values(?, ?)");
        $stmt->bind_param("ss", $api_key, $date);

        $result = $stmt->execute();

        $stmt->close();

        // Check for successful insertion
        if ($result) {
            // User successfully inserted
            return ID_ALAT_CREATED_SUCCESSFULLY;
        } else {
            // Failed to create user
            return ID_ALAT_USER_CREATE_FAILED;
        }

        return $response;
    }
    
    public function send($to, $message) {
        $fields = array(
            'to' => $to,
            'data' => $message,
        );
        return $this->sendPushNotification($fields);
    }
 
    // Sending message to a topic by topic name
    public function sendToTopic($to, $message) {
        $fields = array(
            'to' => '/topics/' . $to,
            'data' => $message,
        );
        return $this->sendPushNotification($fields);
    }
 
    // sending push message to multiple users by firebase registration ids
    public function sendMultiple($registration_ids, $message) {
        $fields = array(
            'to' => $registration_ids,
            'data' => $message,
        );
 
        return $this->sendPushNotification($fields);
    }
    
    public function sendPushNotification($fields) {
         
        require_once __DIR__ . '/config.php';
 
        // Set POST variables
        $url = 'https://fcm.googleapis.com/fcm/send';
 
        $headers = array(
            'Authorization: key=' . FIREBASE_API_KEY,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        // Close connection
        curl_close($ch);
 
        return $result;
    }

    /* ------------- `tasks` table method ------------------ */

    /**
     * Creating new task
     * @param String $user_id user id to whom task belongs to
     * @param String $task task text
     */
    public function createTask($user_id, $sensor1, $sensor2, $sensor3, $output) {
        $stmt = $this->conn->prepare("INSERT INTO tasks(sensor1, sensor2, sensor3, output) VALUES(?,?,?,?)");
        $stmt->bind_param("ssss", $sensor1, $sensor2, $sensor3, $output);
        $result = $stmt->execute();
        $stmt->close();
        echo "sdfsdfsdf ";
        if ($result) {
            echo "sdfsdfsdf ";
            // task row created
            // now assign the task to user
            $new_task_id = $this->conn->insert_id;
            echo "sdfsdfsdf ";
//            $res = $this->createUserTask($user_id, $new_task_id);
            echo "sdfsdfsdf ";
            if (TRUE) {
                // task created successfully
                return $new_task_id;
            } else {
                // task failed to create
                return NULL;
            }
        } else {
            // task failed to create
            return NULL;
        }
    }

    /**
     * Fetching single task
     * @param String $task_id id of the task
     */
    public function getTask($task_id, $user_id) {
        $stmt = $this->conn->prepare("SELECT t.id, t.sensor1, t.sensor2, t.sensor3, t.output, t.status, t.created_at from tasks t, user_tasks ut WHERE t.id = ? AND ut.task_id = t.id AND ut.user_id = ?");
        $stmt->bind_param("ii", $task_id, $user_id);
        if ($stmt->execute()) {
            $res = array();
            $stmt->bind_result($id, $sensor1, $sensor2, $sensor3, $output, $status, $created_at);
            // TODO
            // $task = $stmt->get_result()->fetch_assoc();
            $stmt->fetch();
            $res["id"] = $id;
            $res["sensor1"] = $sensor1;
            $res["sensor2"] = $sensor2;
            $res["sensor3"] = $sensor3;
            $res["output"] = $output;
            $res["status"] = $status;
            $res["created_at"] = $created_at;
            $stmt->close();
            return $res;
        } else {
            return NULL;
        }
    }

    /**
     * Fetching all user tasks
     * @param String $user_id id of the user// ORDER BY t.created_at DESC
     */
    public function getAllUserTasks($user_id) {
        $stmt = $this->conn->prepare("SELECT t.* FROM tasks t, user_tasks ut WHERE t.id = ut.task_id AND ut.user_id = ? ORDER BY t.created_at DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }

    /**
     * Updating task
     * @param String $task_id id of the task
     * @param String $task task text
     * @param String $status task status
     */
    public function updateTask($user_id, $task_id, $sensor1, $sensor2, $sensor3, $output, $status) {
        $stmt = $this->conn->prepare("UPDATE tasks t, user_tasks ut set t.sensor1 = ?, t.sensor2 = ?, t.sensor3 = ?, t.output = ?, t.status = ? WHERE t.id = ? AND t.id = ut.task_id AND ut.user_id = ?");
        $stmt->bind_param("siiiiii", $sensor1, $sensor2, $sensor3, $output, $status, $task_id, $user_id);
        $stmt->execute();
        $num_affected_rows = $stmt->affected_rows;
        $stmt->close();
        return $num_affected_rows > 0;
    }

    /**
     * Deleting a task
     * @param String $task_id id of the task to delete
     */
    public function deleteTask($user_id, $task_id) {
        $stmt = $this->conn->prepare("DELETE t FROM tasks t, user_tasks ut WHERE t.id = ? AND ut.task_id = t.id AND ut.user_id = ?");
        $stmt->bind_param("ii", $task_id, $user_id);
        $stmt->execute();
        $num_affected_rows = $stmt->affected_rows;
        $stmt->close();
        return $num_affected_rows > 0;
    }

    /* ------------- `user_tasks` table method ------------------ */

    /**
     * Function to assign a task to user
     * @param String $user_id id of the user
     * @param String $task_id id of the task
     */
    public function createUserTask($user_id, $task_id) {
        $stmt = $this->conn->prepare("INSERT INTO user_tasks(user_id, task_id) values(?, ?)");
        $stmt->bind_param("ii", $user_id, $task_id);
        $result = $stmt->execute();

        if (false === $result) {
            die('execute() failed: ' . htmlspecialchars($stmt->error));
        }
        $stmt->close();
        return $result;
    }
}
?>