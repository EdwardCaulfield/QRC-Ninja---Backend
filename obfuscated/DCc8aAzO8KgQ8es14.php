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
  if(  (int)$request->data->id != (int) RECORD_KEY  ) {
    return http_response_code(411);
  } else if( ( (int)$request->data->userID < 1 ) ) {
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
  else if ( ( $request->data->dateCreated == '') || 
      ( $request->data->dateLastModified == '') || 
      ( $request->data->validUntil == '' ) || 
      ( $request->data->headerLanguage == '')
      )
  {
    return http_response_code(410);
  }
  // Store.
  $statment = $db_connection->prepare( "INSERT INTO ".DB_TABLE_NAME." ( userID, displayName, urlString, shortNameUsed, shortName, backgroundName, headerLanguage, callToActionLine1, callToActionLine2, dateCreated, dateLastModified, validUntil )  VALUES  (?,?,?,?,?,?,?,?,?,?,?,?) ");    

  $statment->bind_param("ississssssss", 
  $request->data->userID,
  $request->data->displayName,
  $request->data->urlString,
  $request->data->shortNameUsed,
  $request->data->shortName,
  $request->data->backgroundName,
  $request->data->headerLanguage,
  $request->data->callToActionLine1,
  $request->data->callToActionLine2,
  $request->data->dateCreated,
  $request->data->dateLastModified,
  $request->data->validUntil
);

$statment->execute();

if($statment->affected_rows === 0) { // we assume zero rows affected mean that the insert failed
    http_response_code(422);
    echo json_encode(['error'=>'No rows added']);
} else {
    http_response_code(201);
    $request->data->id = mysqli_insert_id($db_connection);
    echo json_encode(['data'=>$request->data]);
}

 $statment->close();

require 'close.php';

}
