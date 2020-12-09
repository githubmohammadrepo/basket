<?php


$counter=0;
$mobile = '9186609682';

//solve problem with phone number
if (strlen($mobile) == 10 && $mobile[0] != 0) {
  $sub = $mobile;
  $mobile = '0' . $sub;
}
echo $mobile."\r\n";
// if phone number is correct
if (strlen($mobile) == 11) {
  //phone number is correct and sent sms
  echo "elevent \r\n";
} else {
  //phone number is not correct
  $counter++;
  
}

echo $counter;
