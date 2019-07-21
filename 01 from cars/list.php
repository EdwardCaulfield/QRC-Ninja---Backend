<?php
/**
 * Returns the list of cars.
 */
require 'connect.php';
echo "go past connect";
$cars = [];
$sql = "SELECT * from api_web.vw_bitstamp_currency";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $cars[$cr]['currency'] = $row['currency'];
    $cars[$cr]['currencyName'] = $row['currency_name'];
    $cr++;
  }
    
  echo json_encode(['data'=>$cars]);
}
else
{
  http_response_code(404);
}
?>
