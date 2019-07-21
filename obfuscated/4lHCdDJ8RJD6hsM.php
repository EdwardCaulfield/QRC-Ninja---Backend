<?php

require 'connect.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

//Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
  if( ( (int)$request->data->userID < 1 ) ) {
    return http_response_code(401);
  }
  else if ( ( trim($request->data->displayName) === '' ) ) {
    return http_response_code(402);    
  }
  else if ( ( (bool)$request->data->shortNameUsed) && ($request->data->shortName == '') ) {
    return http_response_code(403);    
  }
  else if (  ( $request->data->backgroundName == '')  ) {
    return http_response_code(404);    
  }
  else if ( ( $request->data->callToActionLine1 == '' ) && (  $request->data->callToActionLine2 == '' ) ) {
    return http_response_code(405);
  }
  else if ( $request->data->dateCreated == '') {
    return http_response_code(406);
  }
  else if ( $request->data->headerLanguage == '') {
    return http_response_code(407);
  }
  else if ( $request->data->validUntil == '' )
  {
    return http_response_code(408);
  }
  //
  $realID = round( $request->data->id / (int) RECORD_KEY ); // make the record number a multiple of 472 as well
  if ( ( $realID * RECORD_KEY) != $request->data->id )
  {
    return http_response_code(409);
  }

// Update.
$statment = $db_connection->prepare( "UPDATE ".DB_TABLE_NAME." SET userID = ?, displayName = ?, openNewTab = ?, urlString = ?, shortNameUsed = ?, shortName = ?, backgroundName = ?, headerLanguage = ?, callToActionLine1 = ?, callToActionLine2 = ?, dateCreated = ?, dateLastModified = ?, validUntil = ?  WHERE id = ? ");    

$statment->bind_param("isisissssssssi", 
  $request->data->userID, 
  $request->data->displayName,
  $request->data->openNewTab,
  $request->data->urlString,
  $request->data->shortNameUsed,
  $request->data->shortName,
  $request->data->backgroundName,
  $request->data->headerLanguage,
  $request->data->callToActionLine1,
  $request->data->callToActionLine2,
  $request->data->dateCreated,
  $request->data->dateLastModified,
  $request->data->validUntil,
  $realID
);

$statment->execute();

if($statment->affected_rows === 0) { // we assume zero rows affected mean that the insert failed
    http_response_code(422);
    echo json_encode(['error'=>'No rows changed']);
} else {
    http_response_code(201);
    $request->data->id = mysqli_insert_id($db_connection);
    echo json_encode(['data'=>$request]);

}
}
 $statment->close();

require 'close.php';
