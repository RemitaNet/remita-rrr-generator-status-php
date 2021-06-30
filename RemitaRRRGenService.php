<?php

// Define a class
include 'Config/Credentials.php';
include 'Constants/ApplicationUrl.php';

include 'Request/GenerateRRRRequest.php';
include 'Request/CustomField.php';
include 'Util/AES128CBC.php';
include 'Util/HTTPUtil.php';

class RemitaRRRGenService
{

    public static $credentials;

    // INITIALIZE CREDENTIALS
    public static function init($initCredentials)
    {
        if (is_null($initCredentials)) {
            echo 'Credentials must be initialized';
            return;
        }

        RemitaRRRGenService::$credentials = $initCredentials;
    }

    // GET HEADERS
    public static function getHeaders()
    {
        $merchantId = RemitaRRRGenService::$credentials->merchantId;
        $serviceTypeId = RemitaRRRGenService::$credentials->serviceTypeId;
        $apiKey = RemitaRRRGenService::$credentials->apiKey;
        $orderId = RemitaRRRGenService::$credentials->orderId;
        $headers = RemitaRRRGenService::$credentials->headers;
        $amount = RemitaRRRGenService::$credentials->amount;
        $apiHash = hash('sha512', $merchantId . $serviceTypeId . $orderId . $amount . $apiKey);
        $headers = array(
            'Content-Type: application/json',
            'Authorization: remitaConsumerKey=' . $merchantId . ',remitaConsumerToken=' . $apiHash
        );
        // array_push($headers);
        // array_push($headers, 'Authorization:' . 'remitaConsumerKey=' . $merchantId . ',remitaConsumerToken=' . $apiHash);
        return $headers;
    }

    // GENERATE RRR
    public static function generateRRR($generateRRRRequest)
    {
        $url = RemitaRRRGenService::$credentials->url . ApplicationUrl::$genRRRpath;
        $serviceTypeId = utf8_encode(RemitaRRRGenService::$credentials->serviceTypeId);
        $orderId = utf8_encode(RemitaRRRGenService::$credentials->orderId);
        $totalAmount = utf8_encode(RemitaRRRGenService::$credentials->amount);
        $headers = RemitaRRRGenService::getHeaders();

        // POST BODY
        $phpArray = array(
            'serviceTypeId' => $serviceTypeId,
            'amount' => $totalAmount,
            'orderId' => $orderId,
            'payerName' => $generateRRRRequest->payerName,
            'payerEmail' => $generateRRRRequest->payerEmail,
            'payerPhone' => $generateRRRRequest->payerPhone,
            'description' => $generateRRRRequest->description,
            'customField' => $generateRRRRequest->customField
        );
        echo "\n";
        echo "headers: ", json_encode($headers);

        echo "\n";
        echo "phpArray: ", json_encode($phpArray);

        // // POST CALL
        $result = HTTPUtil::postMethod($url, $headers, json_encode($phpArray));

        echo "RESULT: ", json_encode($result);

        return json_decode($result);
    }
}

?>

