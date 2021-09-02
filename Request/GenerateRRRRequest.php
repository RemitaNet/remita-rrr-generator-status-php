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
}
?>
