<?php

$response_message = ''; // Initialize response message

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Create XML data
    $xml = new SimpleXMLElement('<user></user>');
    $xml->addChild('password', $password);
    $xml->addChild('email', $email);

    // Create SOAP client and send the request
    try {
        $client = new SoapClient("../../user_registration.wsdl");
        $response = $client->loginAdmin($xml->asXML());
        $response_message = $response['response']; // Capture the response
        echo $response;
        echo $response_message;

        if ($response_message == "Login successful!") {
            session_start();
            $_SESSION['adminUserID'] = $response['sessionid'];
            header("Location: ../admin/dashboard.php");
            exit;
        }
    } catch (Exception $e) {
        $response_message = "Error: " . $e->getMessage(); // Capture any errors
        echo $response_message;
    }
}