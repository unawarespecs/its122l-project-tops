<?php
$response = ''; // Initialize the response variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Create XML data
    $xml = new SimpleXMLElement('<user></user>');
    $xml->addChild('username', $username);
    $xml->addChild('password', $password);
    $xml->addChild('email', $email);

    // Create SOAP client and send the request
    try {
        $client = new SoapClient("../../user_registration.wsdl");
        $response = $client->registerAdmin($xml->asXML()); // Capture the SOAP response
        echo $response;
        if ($response == "Registration successful!") {
            header("Location: login.php");
            exit;
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        $response = "Error: " . $e->getMessage(); // Capture any SOAP or system error
    }
}