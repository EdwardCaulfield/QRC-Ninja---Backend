<?php
/**
 * Returns the list of currency transactions.
 */

require 'connect.php';

$userID = $_GET['user'];

if ( strlen( $userID ) == 0 ) {
  echo json_encode(['error'=>"Error009"]);
  exit();  
} 
  
$sqlCommand = "SELECT * FROM ".DB_TABLE_NAME." WHERE  userID LIKE '".$userID."'";

$result = mysqli_query($db_connection, $sqlCommand ) ; //, array( $username ) );

if( $result )
{
    $userRecords = [];
    $data_row = 0;
    while($row = mysqli_fetch_assoc($result))
    {
      $userRecords[$data_row]['id']                 = $row['id'];
      $userRecords[$data_row]['userID']             = $row['userID'];
      $userRecords[$data_row]['displayName']        = $row['displayName'];
      $userRecords[$data_row]['openNewTab']         = $row['openNewTab'];
      $userRecords[$data_row]['urlString']          = $row['urlString'];
      $userRecords[$data_row]['shortNameUsed']      = $row['shortNameUsed'];
      $userRecords[$data_row]['shortName']          = $row['shortName'];
      $userRecords[$data_row]['backgroundName']     = $row['backgroundName'];
      $userRecords[$data_row]['headerLanguage']     = $row['headerLanguage'];
      $userRecords[$data_row]['callToActionLine1']  = $row['callToActionLine1'];
      $userRecords[$data_row]['callToActionLine2']  = $row['callToActionLine2'];
      $userRecords[$data_row]['dateCreated']        = $row['dateCreated'];
      $userRecords[$data_row]['dateLastModified']   = $row['dateLastModified'];
      $userRecords[$data_row]['validUntil']         = $row['validUntil'];

      $data_row++;
    }
    echo json_encode(['data'=>$userRecords]);

}
else
{
  echo json_encode(['error'=>"Error002"]);
}

require "close.php";

?>
