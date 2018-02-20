<?php
// require ReCaptcha class
require('recaptcha-master/src/autoload.php');
/*
 *  CONFIGURE EVERYTHING HERE
 */

// an email address that will be in the From field of the email.
$from = 'malski.tomasz@gmail.com';
// an email address that will receive the email with the output of the form
$sendTo = 'malski.tomasz@gmail.com';

// subject of the emailS
$subject = 'New message from contact form';
// form field names and their translations.
// array variable name => Text to appear in the email
$fields = array('name' => 'Name', 'surname' => 'Surname', 'phone' => 'Phone', 'email' => 'Email', 'message' => 'Message'); 

// message that will be displayed when everything is OK :)
$okMessage = 'Wiadomość została wysłana. Dziękujemy, skontaktujemy się z Tobą niezwłocznie !';

// If something goes wrong, we will display this message.
$errorMessage = ' Wystąpił błąd podczas przesyłania formularza.Proszę, spróbuj ponownie';

$recaptchaSecret = '6LeCgEcUAAAAAOXhLIWy64qfpuX8Y3lQAK5nAppb';
/*
 *  LET'S DO THE SENDING
 */

// if you are not debugging and don't need error reporting, turn this off by error_reporting(0);
/*error_reporting(E_ALL & ~E_NOTICE);*/

try
{
    if (!empty($_POST)) {

        // validate the ReCaptcha, if something is wrong, we throw an Exception, 
        // i.e. code stops executing and goes to catch() block
        
        if (!isset($_POST['g-recaptcha-response'])) {
            throw new \Exception('ReCaptcha is not set.');
        }

        // do not forget to enter your secret key in the config above 
        // from https://www.google.com/recaptcha/admin
        
        $recaptcha = new \ReCaptcha\ReCaptcha($recaptchaSecret, new \ReCaptcha\RequestMethod\CurlPost());
        
        // we validate the ReCaptcha field together with the user's IP address
        
        $response = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);


        if (!$response->isSuccess()) {
            throw new \Exception('ReCaptcha was not validated.');
        }
    
    $department = $_POST["department"];
    if(count($_POST) == 0) throw new \Exception('Form is empty');
            
    $emailText = "Masz nową wiadomość przesłaną przez formularz\n=============================\n";

    foreach ($_POST as $key => $value) {
        // If the field exists in the $fields array, include it in the email 
        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }
    
    if (isset($department)) {
        if ($department == "1") {
            $sendTo = "malski.tomasz@gmail.com";
        } elseif ($department == "2") {
            $sendTo = "malski.tomasz@gmail.com";
        }
    }

    // All the neccessary headers for the email.
    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );
    
    // Send email
    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
    }
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}


// if requested by AJAX request return JSON response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
// else just display the message
else {
    echo $responseArray['message'];
}
