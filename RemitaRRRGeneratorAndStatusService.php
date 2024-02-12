<?php
include 'Config/Credentials.php';
include 'Constants/ApplicationUrl.php';
include 'Util/HTTPUtil.php';

class RemitaRRRGeneratorAndStatusService
{

    // FORMAT RESPONSE
    public static function formatResponse($response)
    {
        echo "\n";
        // echo "response: ", json_encode($response);
        echo "\n";
        $result = $response;
        $result = substr($result, 7);
        $newLength = strlen($result);
        $result = substr($result, 0, $newLength - 1);
        return json_decode($result);
    }

    // GENERATE RRR
    public static function generateRRR($generateRRRRequest, $credentials)
    {
        if (is_null($credentials)) {
            echo 'Credentials must be initialized';
            return;
        }

        $merchantId = $credentials->merchantId;
        $serviceTypeId = $credentials->serviceTypeId;
        $apiKey = $credentials->apiKey;
        $orderId = $credentials->orderId;
        $headers = $credentials->headers;
        $amount = $credentials->amount;
        $apiHash = hash('sha512', $merchantId . $serviceTypeId . $orderId . $amount . $apiKey);
        $headers = array(
            'Content-Type: application/json',
            'Authorization: remitaConsumerKey=' . $merchantId . ',remitaConsumerToken=' . $apiHash
        );

        $url = utf8_encode($credentials->url . ApplicationUrl::$genRRRpath);
        $serviceTypeId = utf8_encode($credentials->serviceTypeId);
        $orderId = utf8_encode($credentials->orderId);
        $totalAmount = utf8_encode($credentials->amount);

        // POST BODY
        $phpArray = array(
            'serviceTypeId' => $serviceTypeId,
            'amount' => $totalAmount,
            'orderId' => $orderId,
            'payerName' => $generateRRRRequest->payerName,
            'payerEmail' => $generateRRRRequest->payerEmail,
            'payerPhone' => $generateRRRRequest->payerPhone,
            'description' => $generateRRRRequest->description,
            'customFields' => $generateRRRRequest->customField,
            'lineItems' => $generateRRRRequest->lineItems
        );
        // echo "\n";
        // echo "headers: ", json_encode($headers);

        // echo "\n";
        // echo "phpArray: ", json_encode($phpArray);

        // // POST CALL
        $result = HTTPUtil::postMethod($url, $headers, json_encode($phpArray));
        return RemitaRRRGeneratorAndStatusService::formatResponse($result);
    }

    // RRR STATUS
    public static function rrrStatus($rrrStatusRequest, $credentials)
    {
        if (is_null($credentials)) {
            echo 'Credentials must be initialized';
            return;
        }

        $merchantId = $credentials->merchantId;
        $serviceTypeId = $credentials->serviceTypeId;
        $apiKey = $credentials->apiKey;
        $headers = $credentials->headers;
        $rrr = $rrrStatusRequest->rrr;
        $apiHash = hash('sha512', $rrr . $apiKey . $merchantId);
        $headers = array(
            'Content-Type: application/json',
            'Authorization: remitaConsumerKey=' . $merchantId . ',remitaConsumerToken=' . $apiHash
        );

        $url = $credentials->url . ApplicationUrl::$rrrStatusPath . $merchantId . "/" . $rrr . "/" . $apiHash . "/status.reg";

        // echo "\n";
        // echo "url: ", json_encode($url);
        // echo "\n";
        // echo "headers: ", json_encode($headers);

        // // GET METHOD CALL
        $result = HTTPUtil::getMethod($url, $headers);
        return json_decode($result);
    }
}

?>

