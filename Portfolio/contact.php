<?php
// require ReCaptcha class
//require('recaptcha-master/src/autoload.php');

// configure
// an email address that will be in the From field of the email.
$from = 'Incoming Message DK.com <darci@darcikole.com>';

// an email address that will receive the email with the output of the form
$sendTo = 'darci@darcikole.com';

// subject of the email
$subject = 'New message from darcikole.com';

// form field names and their translations.
// array variable name => Text to appear in the email
$fields = array('name' => 'First Name', 'surname' => 'Last', 'phone' => 'Phone', 'email' => 'Email', 'message' => 'Message');

// message that will be displayed when everything is OK :)
$okMessage = 'Contact form successfully submitted. Thank you, I will get back to you soon!';

// If something goes wrong, we will display this message.
$errorMessage = 'There was an error while submitting the form. Please try again later';

// ReCaptch Secret
//$recaptchaSecret = '6LdrVtQUAAAAANFI5bohZI4AMn9Ivl3Jkc2anu5h';

// let's do the sending

// if you are not debugging and don't need error reporting, turn this off by error_reporting(0);
//error_reporting(E_ALL & ~E_NOTICE);
if (isset($_POST) && isset($_POST["btnSubmit"]))
{
    $recaptchaSecret = '6LdrVtQUAAAAANFI5bohZI4AMn9Ivl3Jkc2anu5h';
    $token = $_POST["g-token"];
    $ip = $_SERVER['REMOTE_ADDR'];

    
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$recaptchaSecret."&response=".$token."&remoteip=".$ip;
    $_REQUEST = file_get_contents ($url);
    $response = json_decode ($_REQUEST);

    echo "<pre>";
    print_r($response);
    echo "</pre>";

    if($response->success)
	{
		echo '<center><h1>Validation Success!</h1></center>';
	}
	else
	{
		echo '<center><h1>Captcha Validation Failed..!</h1></cetner>';
	}
}

try {
    if (!empty($_POST)) {
        
        // we can compose the message
        
        $emailText = "You have a new message from your contact form\n=============================\n";

        foreach ($_POST as $key => $value) {
            // If the field exists in the $fields array, include it in the email
            if (isset($fields[$key])) {
                $emailText .= "$fields[$key]: $value\n";
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
} catch (\Exception $e) {
    $responseArray = array('type' => 'danger', 'message' => $e->getMessage());
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
} else {
    echo $responseArray['message'];
}
