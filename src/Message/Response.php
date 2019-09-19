<?php


namespace Omnipay\MaxiPago\Message;


use Omnipay\Common\Message\AbstractResponse;

/**
 * Class Response
 *
 * @property-read array $data = [
 *      'boletoURL' => '',
 *      'onlineDebitUrl' => '',
 *      'authenticationURL' => '',
 *      'authCode' => '005772',
 *      'referenceNum' => '123456789',
 *      'orderID' => '7F000001:013829A1C09E:8DE9:016891F0',
 *      'transactionID' => '1418605',
 *      'transactionTimestamp' => '1340728262',
 *      'responseCode' => '0',
 *      'responseMessage' => 'CAPTURED',
 *      'avsResponseCode' => '',
 *      'processorCode' => '',
 *      'processorMessage' => 'APPROVED',
 *      'processorReferenceNumber' => '',
 *      'processorTransactionID' => '',
 *      'fraudScore' => '',
 *      'errorMessage' => '',
 *      'token' => '',
 *      'error' => ''
 *  ]
 * @package Omnipay\MaxiPago\Message
 */
class Response extends AbstractResponse
{

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->getCode() == '0' || !$this->getCode();
    }

    /**
     * @return bool
     */
    public function isWaiting()
    {
        return $this->getMessage() == 'ISSUED';
    }

    /**
     * @return bool
     */
    public function isPaid()
    {
        return $this->getMessage() == 'CAPTURED';
    }

    /**
     * @return bool
     */
    public function isApproved()
    {
        return $this->getMessage() == 'CAPTURED' || $this->getCode() == '0';
    }

    /**
     * @return bool
     */
    public function isCancelled()
    {
        return $this->getMessage() == 'DECLINED' || ($this->getCode() == '1' || $this->getCode() == '2');
    }

    /**
     * @return string|null
     */
    public function getMessage()
    {
        return $this->isSuccessful() && !$this->getErrorMessage(
        ) ? $this->data['responseMessage'] : $this->getErrorMessage();
    }

    /**
     * @return string|null
     */
    public function getErrorMessage()
    {
        return !empty($this->data['errorMessage']) ? $this->data['errorMessage'] : null;
    }

    /**
     * 0 = Approved
     * 1 = Declined
     * 2 = Declined due to Fraud or Duplicity
     * 5 = Fraud Review
     *
     * @return integer
     */
    public function getCode()
    {
        return $this->data['responseCode'];
    }

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->data['transactionID'];
    }

    /**
     * @return mixed|string|null
     */
    public function getTransactionReference()
    {
        return $this->data['referenceNum'];
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->data['orderID'];
    }
}