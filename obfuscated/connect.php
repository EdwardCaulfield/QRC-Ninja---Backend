<?php

// db credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'bn_wordpress');
define('DB_PASS', '28d844dc6c');
define('DB_NAME', 'bitnami_wordpress');
define('DB_TABLE_NAME', 'ninja_admin');
define('DB_LINK_TABLE_NAME', 'urllinks');
define('RECORD_KEY', 472);
// Connect with the database.
function connect()
{
 $connect = mysqli_connect(DB_HOST ,DB_USER ,DB_PASS ,DB_NAME);
  // $connect = mysqli_connect('host='.DB_HOST.' dbname='.DB_NAME.' user='.DB_USER.' password='.DB_PASS);

  if (!$connect) {
    echo json_encode(['error'=>"Error011"]);
    exit();
  }
  return $connect;
}

$db_connection = connect();