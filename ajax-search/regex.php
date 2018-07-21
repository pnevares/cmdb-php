<?php
function isValid($type,$var) {
 $valid = false;
 switch ($type) {
  case "IP":
   if (ereg('^([0-9]{1,3}\.){3}[0-9]{1,3}$',$var)) {
    $valid = true;
   }
   break;
  case “URL”:
   if (ereg("^[a-zA-Z0-9\-\.]+\.(com|org|net|mil|edu)$",$var)) {
    $valid = true;
   }
   break;
  case “SSN”:
   if (ereg("^[0-9]{3}[- ][0-9]{2}[- ][0-9]{4}|[0-9]{9}$",$var)) {
    $valid = true;
   }
   break;
  case “CC”:
   if (ereg("^([0-9]{4}[- ]){3}[0-9]{4}|[0-9]{16}$",$var)) {
    $valid = true;
   }
   break;
  case “ISBN”:
   if (ereg("^[0-9]{9}[[0-9]|X|x]$",$var)) {
    $valid = true;
   }
   break;
  case “Date”:
   if (ereg("^([0-9][0-2]|[0-9])\/([0-2][0-9]|3[01]|[0-9])\/[0-9]{4}|([0-9][0-2]|[0-9])-([0-2][0-9]|3[01]|[0-9])-[0-9]{4}$",$var)) {
    $valid = true;
   }
   break;
  case “Zip”:
   if (ereg("^[0-9]{5}(-[0-9]{4})?$",$var)) {
    $valid = true;
   }
   break;
  case "Phone":
   if (ereg("^((\([0-9]{3}\) ?)|([0-9]{3}-))?[0-9]{3}-[0-9]{4}$",$var)) {
    $valid = true;
   }
   break;
  case “HexColor”:
   if (ereg('^#?([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?$',$var)) {
    $valid = true;
   }
   break;
  case “User”:
   if (ereg("^[a-zA-Z0-9_]{3,16}$",$var)) {
    $valid = true;
   }
   break;
 }
 return $valid;
}

#Example:
$phone = "789-234";
if (isValid("Phone",$phone)) {
 echo "Valid Phone Number";
} else {
 echo "Invalid Phone Number";
}
?>