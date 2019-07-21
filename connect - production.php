<?php

// db credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'web57_db');
define('DB_PASS', 'Wonderful4MyData!');
define('DB_NAME', 'web57_db');
define('DB_TABLE_NAME', 'ninja_admin_test');
define('DB_LINK_TABLE_NAME', 'urllinks_test');
define('RECORD_KEY', 472);

// Connect with the database.
function connect()
{
 $connect = mysqli_connect(DB_HOST ,DB_USER ,DB_PASS ,DB_NAME);

  if (!$connect) {
    echo json_encode(['error'=>"Error011"]);
    exit();
  }
  return $connect;
}

$db_connection = connect();