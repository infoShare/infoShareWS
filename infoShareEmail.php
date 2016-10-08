<?php

$subject = "Welcome to InfoShare";

function sendEmail($email){
  $comment = "Hello, \nplease confirm your account by visiting website http://infoshare.esy.es/services/confirmAccount.php?email=".$email."\n\nInfoShare Team";
  echo "Sending email to ".$email;
  //send email
  mail($email, $subject, $comment);
}

?>