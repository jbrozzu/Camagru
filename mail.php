<?php


$to      = 'jeremie.brozzu@gmail.com'; // Send email to our user
$subject = 'Signup | Verification'; // Give the email a subject 
$message = "
 
Thanks for signing up!
Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
 
------------------------
Username: 'jerem'
Password: 'password'
------------------------
 
Please click this link to activate your account:
http://www.yourwebsite.com/verify.php?email='coucou'&hash='hahaha' "; // Our message above including the link
                     
$headers = 'From:noreply@yourwebsite.com' . "\r\n"; // Set from headers
mail($to, $subject, $message, $headers); // Send our email


?>