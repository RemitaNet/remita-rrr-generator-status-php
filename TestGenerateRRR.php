<?php
include 'RemitaRRRGenService.php';

function initTest()
{
    // SDK Credentials
    $merchantId = "2547916";
    $apiKey = "1946";
    $serviceTypeId = "4430731";
    $amount = "100";
    $orderId = round(microtime(true) * 1000);

    // Initialize SDK
    $credentials = new Credentials();
    $credentials->url = ApplicationUrl::$demoUrl;
    $credentials->merchantId = $merchantId;
    $credentials->serviceTypeId = $serviceTypeId;
    $credentials->apiKey = $apiKey;
    $credentials->amount = $amount;
    $credentials->orderId = $orderId;

    return $credentials;
}

class TestGenerateRRR
{

    function test()
    {
        RemitaRRRGenService::init(initTest());
        echo "\n";
        echo "// Generate RRR ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++";
        $generateRRRRequest = new GenerateRRRRequest();
        $generateRRRRequest->serviceTypeId = rand() * 777;
        $generateRRRRequest->amount = "8909090989";
        $generateRRRRequest->orderId = "Regular Payment";
        $generateRRRRequest->payerName = "Michelle Alozie";
        $generateRRRRequest->payerEmail = "alozie@systemspecs.com.ng";
        $generateRRRRequest->payerPhone = "09062067384";
        $generateRRRRequest->description = "payment for Donation 3";

        $customField1 = new CustomField();
        $customField1->name = "Matric Number";
        $customField1->value = "1509329285795";
        $customField1->type = "ALL";

        $customField2 = new CustomField();
        $customField2->name = "Invoice Number";
        $customField2->value = "1234";
        $customField2->type = "ALL";

        $generateRRRRequest->setCustomField(array(
            $customField1,
            $customField2
        ));

        $response = RemitaRRRGenService::generateRRR($generateRRRRequest);
        echo "\n";
        echo "\n";
        echo "\n";
        echo "RESPONSE: ", json_encode($response);
    }
}

$testRITs = new TestGenerateRRR();
$testRITs->test();

?>

