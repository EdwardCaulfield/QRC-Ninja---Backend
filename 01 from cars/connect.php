<?php

// db credentials
define('DB_HOST', '163.172.166.179');
define('DB_USER', 'admin');
define('DB_PASS', '$toomuchcoffee');
define('DB_NAME', 'test');

// Connect with the database.
function connect()
{
  $connect = mysqli_connect(DB_HOST ,DB_USER ,DB_PASS ,DB_NAME);

  if (mysqli_connect_errno($connect)) {
    die("Failed to connect:" . mysqli_connect_error());
  }

  mysqli_set_charset($connect, "utf8");

  return $connect;
}

$con = connect();