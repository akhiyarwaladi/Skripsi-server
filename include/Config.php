<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Config
 *
 * @author erdearik
 */
/**
 * Database configuration
 */
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');
define('DB_NAME', 'sigap');

define('USER_CREATED_SUCCESSFULLY', 0);
define('USER_CREATE_FAILED', 1);
define('USER_ALREADY_EXISTED', 2);

define('ALAT_USER_CREATED_SUCCESSFULLY', 0);
define('ALAT_USER_CREATE_FAILED', 1);
define('ALAT_USER_ISNOT_EXISTED', 2);

define('ID_ALAT_CREATED_SUCCESSFULLY', 0);
define('ID_ALAT_USER_CREATE_FAILED', 1);

define('DATA_SENSOR_CREATED_SUCCESSFULLY', 0);
define('DATA_SENSOR_CREATE_FAILED', 1);

define('MESSAGE_SENT_SUCCESSFULLY', 0);
define('MESSAGE_SENT_FAILED', 1);

define("GOOGLE_API_KEY", "AIzaSyB9n-b-B_06a5uRM6ZrmE80fjQx0iieycw");
define("FIREBASE_API_KEY", "AIzaSyA4orLk4ufVP4ovbHVnwQOZQ-KDgNh4qpA");

define('PUSH_FLAG_CHATROOM', 1);
define('PUSH_FLAG_USER', 2);

?>