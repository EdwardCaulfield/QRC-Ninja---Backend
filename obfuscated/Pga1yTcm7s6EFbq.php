<?php

require 'connect.php';

// Extract, validate and sanitize the id.
//$id = ($_GET['rtfu'] !== null && (int)$_GET['rtfu'] > 0)? mysqli_real_escape_string($con, (int)$_GET['rtfu']) : false;
$id = ($_GET['rtfu'] !== null && (int)$_GET['rtfu'] > 0)? mysqli_real_escape_string($db_connection, (int)$_GET['rtfu']) : false;

if(!$id)
{
  return http_response_code(400);
}
//
$key = $_GET['ipsilip'];
$match = "8zmiM2uhXVCo9q6";
if ( $key != $match )
{
  http_response_code(401);
  return json_encode(['error'=>"Bad key"]);

}
//
$realID = round( $id / (int) RECORD_KEY); // make the record number a multiple of 472 as well
if ( ( $realID * RECORD_KEY ) != $id )
{
  return http_response_code(402);
}

// Delete.
$sql = "DELETE FROM ".DB_TABLE_NAME." WHERE id =".$realID." LIMIT 1";

$result = mysqli_query($db_connection, $sql);

if( $result )
{
  http_response_code(204);
}
else
{
   http_response_code(422);
}
