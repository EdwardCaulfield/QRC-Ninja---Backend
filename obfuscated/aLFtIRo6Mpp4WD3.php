<?php

require 'connect.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

//Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
 $request = json_decode($postdata);

  // Validate.
 if (strlen( $request->data ) == 0) {
  // if ( strlen( $key ) == 0) {
    // echo $request;
    return http_response_code(401);    
  }

  // Store.
$statment = $db_connection->prepare( "INSERT INTO ".DB_LINK_TABLE_NAME." ( shortName )  VALUES  (?) ");    

$statment->bind_param("s", $request->data );
// $statment->bind_param("s", $key );

$statment->execute();

if($statment->affected_rows === 0) { // we assume zero rows affected mean that the insert failed because of a duplicate key
    http_response_code(422);
    echo json_encode(['error'=>'422']);
} else {
    http_response_code(201);
//    echo json_encode(['data'=>$request]);
    echo json_encode(['data'=>$key]);
}

 $statment->close();

require 'close.php';

}
