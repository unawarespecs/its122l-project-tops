<?php
session_start();
$response_message = ''; // Initialize response message

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Create XML data
    $xml = new SimpleXMLElement('<user></user>');
    $xml->addChild('password_login', $password);
    $xml->addChild('email_login', $email);

    // Create SOAP client and send the request
    try {
        $client = new SoapClient("../user_registration.wsdl");
        $response = $client->loginUser($xml->asXML());
        $response_message = $response['response']; // Capture the response

        if ($response_message == "Login successful!") {
            $_SESSION['userID'] = $response['sessionid'];
            header("Location: admin_dashboard.php");
            exit;
        }
    } catch (Exception $e) {
        $response_message = "Error: " . $e->getMessage(); // Capture any errors
    }
}