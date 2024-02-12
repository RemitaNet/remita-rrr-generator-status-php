# Remita RRR Generator and Status SDK for PHP

## Running the application
*  Clone project, review and run:
   https://github.com/RemitaNet/remita-rrr-generator-status-php/blob/main/TestRRRGeneratorAndStatus.php

**Sample Demo Code:**
```java

function initCredentials()
{
    // DEMO Credentials
    $merchantId = "2547916";
    $apiKey = "1946";
    $serviceTypeId = "4430731";

    $amount = "3000";
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

// +++++++++++++++++++++++++++++++++++++++++++++++++++
// PHP 7.4
// +++++++++++++++++++++++++++++++++++++++++++++++++++
class TestRRRGeneratorAndStatus
{

    function test()
    {
        $credentials = initCredentials();

        // +++++++++++++++++++++++++++++++++++++++++++++++++++
        // Generate RRR
        // +++++++++++++++++++++++++++++++++++++++++++++++++++
        echo "// Generate RRR ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++";
        echo "\n";
        $generateRRRRequest = new GenerateRRRRequest();
        $generateRRRRequest->serviceTypeId = "4430731";
        $generateRRRRequest->orderId = "Regular Payment";
        $generateRRRRequest->payerName = "Michelle Alozie";
        $generateRRRRequest->payerEmail = "alozie@systemspecs.com.ng";
        $generateRRRRequest->payerPhone = "09062067384";
        $generateRRRRequest->description = "payment for Donation 3";

        // +++++++++++++++++++++++++++++++++++++++++++++++++++
        // Custom fields (Optional)
        // +++++++++++++++++++++++++++++++++++++++++++++++++++
        $customField1 = new CustomField();
        $customField1->name = "Matric Number";
        $customField1->value = "1509329285795";
        $customField1->type = "ALL";

        $customField2 = new CustomField();
        $customField2->name = "Invoice Number";
        $customField2->value = "1234";
        $customField2->type = "ALL";

        $generateRRRRequest->customFields = array(
            $customField1,
            $customField2
        );

        // +++++++++++++++++++++++++++++++++++++++++++++++++++
        // Split/Line items (Optional)
        // +++++++++++++++++++++++++++++++++++++++++++++++++++
        $lineItem1 = new LineItems();
        $lineItem1->lineItemsId = "lineItemsId1";
        $lineItem1->beneficiaryName = "Alozie Michael";
        $lineItem1->beneficiaryAccount = "0360883515";
        $lineItem1->bankCode = "057";
        $lineItem1->beneficiaryAmount = "1000";
        $lineItem1->deductFeeFrom = "1";

        $lineItem2 = new LineItems();
        $lineItem2->lineItemsId = "lineItemsId2";
        $lineItem2->beneficiaryName = "Folivi Joshua";
        $lineItem2->beneficiaryAccount = "4017904612";
        $lineItem2->bankCode = "058";
        $lineItem2->beneficiaryAmount = "2000";
        $lineItem2->deductFeeFrom = "0";

        $generateRRRRequest->lineItems = array(
            $lineItem1,
            $lineItem2
        );

        // +++++++++++++++++++++++++++++++++++++++++++++++++++
        // Send POST Request
        // +++++++++++++++++++++++++++++++++++++++++++++++++++
        $generateRRRResponse = RemitaRRRGeneratorAndStatusService::generateRRR($generateRRRRequest, $credentials);
        echo "generateRRRResponse: ", json_encode($generateRRRResponse);

        // +++++++++++++++++++++++++++++++++++++++++++++++++++
        // RRR Status
        // +++++++++++++++++++++++++++++++++++++++++++++++++++
        echo "\n";
        echo "\n";
        echo "// RRR Status ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++";
        echo "\n";
        $rrrStatusRequest = new RRRStatusRequest();
        $rrrStatusRequest->rrr = $generateRRRResponse->RRR;
        $rrrStatusResponse = RemitaRRRGeneratorAndStatusService::rrrStatus($rrrStatusRequest, $credentials);
        echo "\n";
        echo "rrrStatusResponse: ", json_encode($rrrStatusResponse);
    }
}

$testRITs = new TestRRRGeneratorAndStatus();
$testRITs->test();
	
```
## Contributing
- To contribute to this repo, follow these guidelines for creating issues, proposing new features, and submitting pull requests:

Fork the repository.
1. Create a new branch: `git checkout -b "feature-name"`
2. Make your changes and commit: `git commit -m "added some new features"`
3. Push your changes: `git push origin feature-name`
4. Submit a Pull Request (PR).

### Useful links
* Join our [Slack](http://bit.ly/RemitaDevSlack) Developer/Support channel
    
### Support
- For all other support needs, support@remita.net

