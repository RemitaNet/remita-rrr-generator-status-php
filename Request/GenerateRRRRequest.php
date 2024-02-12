<?php

class GenerateRRRRequest
{

    public $serviceTypeId;

    public $amount;

    public $orderId;

    public $payerName;

    public $payerEmail;

    public $payerPhone;

    public $description;

    public $customField = array();

    // array( CustomField )
    public function getCustomField()
    {
        return $this->customField;
    }

    public function setCustomField($customField)
    {
        $this->customField = $customField;
    }

    public $lineItems = array();

    public function getLineItems()
    {
        return $this->lineItems;
    }

    public function setLineItems($lineItems)
    {
        $this->lineItems = $lineItems;
    }
}
?>
