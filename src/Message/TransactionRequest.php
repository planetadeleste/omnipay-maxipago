<?php


namespace Omnipay\MaxiPago\Message;


class TransactionRequest extends AbstractRequest
{

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        $this->setOperation('transaction');
        $data = ['order' => []];

        return $data;
    }

    /**
     * Merchant reference number for this transaction
     *
     * @param string $referenceNum This field accepts alphanumeric values only and must be unique
     */
    public function setReferenceNum($referenceNum)
    {
        $this->setParameter('referenceNum', $referenceNum);
    }

    /**
     * @return string
     */
    public function getReferenceNum()
    {
        return $this->getParameter('referenceNum');
    }

    /**
     * Acquirer code, used to choose the processing acquirer.
     *
     * @param int $processorID Possible values are
     *                         TEST SIMULATOR = 1
     *                         Rede = 2
     *                         Cielo = 4
     *                         TEF = 5
     *                         Elavon = 6
     *                         ChasePaymentech = 8
     *                         GetNet = 3
     */
    public function setProcessorID($processorID)
    {
        $this->setParameter('processorID', intval($processorID));
    }

    /**
     * @return string
     */
    public function getProcessorID()
    {
        return $this->getParameter('processorID');
    }

    /**
     * Flag to send the transaction for fraud check. If left blank the transaction will be verified
     * This field is active only for merchants that have the antifraud service enabled
     *
     * @param mixed $fraudCheck Possible values are:
     *                          Y or empty/null = CHECK
     *                          N = DO NOT CHECK
     */
    public function setFraudCheck($fraudCheck)
    {
        $this->setParameter('fraudCheck', $fraudCheck);
    }

    /**
     * @return string
     */
    public function getFraudCheck()
    {
        return $this->getParameter('fraudCheck');
    }

    /**
     * Buyer's IP address
     *
     * @param mixed $ipAddress
     */
    public function setIpAddress($ipAddress)
    {
        $this->setParameter('ipAddress', $ipAddress);
    }

    /**
     * @return string
     */
    public function getIpAddress()
    {
        $ip = $this->getParameter('ipAddress');
        return ($ip) ? $ip : $this->getUserIp();
    }

    /**
     * Number of installments to divide the transaction
     *
     * @param mixed $numberOfInstallments
     */
    public function setNumberOfInstallments($numberOfInstallments)
    {
        $this->setParameter('numberOfInstallments', intval($numberOfInstallments));
    }

    /**
     * @return int|null
     */
    public function getNumberOfInstallments()
    {
        return $this->getParameter('numberOfInstallments');
    }

    /**
     * Sets the type of installment used
     *
     * @param mixed $chargeInterest Possible values are:
     *                              N = No interest (Default)
     *                              Y = With issuing bank interest (card installment)
     */
    public function setChargeInterest($chargeInterest)
    {
        $this->setParameter('chargeInterest', $chargeInterest);
    }

    /**
     * @return string Y|N
     */
    public function getChargeInterest()
    {
        $param = $this->getParameter('chargeInterest');
        if(!strlen($param) || !in_array($param, ['Y', 'N', 'y', 'n'])) {
            $param = 'N';
        }

        return strtoupper($param);
    }

    /**
     * @param mixed $softDescriptor
     */
    public function setSoftDescriptor($softDescriptor)
    {
        $this->setParameter('softDescriptor', $softDescriptor);
    }

    /**
     * @return string
     */
    public function getSoftDescriptor()
    {
        return $this->getParameter('softDescriptor');
    }

    /**
     * @param mixed $iataFee
     */
    public function setIataFee($iataFee)
    {
        $this->setParameter('iataFee', $iataFee);
    }

    /**
     * @return string
     */
    public function getIataFee()
    {
        return $this->getParameter('iataFee');
    }

    /**
     * @param mixed $orderID
     */
    public function setOrderID($orderID)
    {
        $this->setParameter('orderID', $orderID);
    }

    /**
     * @return string
     */
    public function getOrderID()
    {
        return $this->getParameter('orderID');
    }

    /**
     * @param mixed $payType
     */
    public function setPayType($payType)
    {
        $this->setParameter('payType', $payType);
    }

    /**
     * @return string
     */
    public function getPayType()
    {
        return $this->getParameter('payType');
    }

    /**
     * @param mixed $boletoNumber
     */
    public function setBoletoNumber($boletoNumber)
    {
        $this->setParameter('boletoNumber', $boletoNumber);
    }

    /**
     * @return string
     */
    public function getBoletoNumber()
    {
        return $this->getParameter('boletoNumber');
    }

    /**
     * @param mixed $boletoExpirationDate
     */
    public function setBoletoExpirationDate($boletoExpirationDate)
    {
        $this->setParameter('boletoExpirationDate', $boletoExpirationDate);
    }

    /**
     * @return string
     */
    public function getBoletoExpirationDate()
    {
        return $this->getParameter('boletoExpirationDate');
    }

    /**
     * @param mixed $boletoInstructions
     */
    public function setBoletoInstructions($boletoInstructions)
    {
        $this->setParameter('boletoInstructions', $boletoInstructions);
    }

    /**
     * @return string
     */
    public function getBoletoInstructions()
    {
        return $this->getParameter('boletoInstructions');
    }

    /**
     * @param mixed $parametersURL
     */
    public function setParametersURL($parametersURL)
    {
        $this->setParameter('parametersURL', $parametersURL);
    }

    /**
     * @return string
     */
    public function getParametersURL()
    {
        return $this->getParameter('parametersURL');
    }

    /**
     * @param mixed $customerIdExt
     */
    public function setCustomerIdExt($customerIdExt)
    {
        $this->setParameter('customerIdExt', $customerIdExt);
    }

    /**
     * @return string
     */
    public function getCustomerIdExt()
    {
        return $this->getParameter('customerIdExt');
    }

    protected function getEndpoint()
    {
        return parent::getEndpoint().'/UniversalAPI/postXML';
    }

    /**
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidCreditCardException
     */
    protected function getCardData()
    {
        $card = $this->getCard();
        $card->validate();

        return [
            'number'    => $card->getNumber(),
            'expMonth'  => $card->getExpiryMonth(),
            'expYear'   => $card->getExpiryYear(),
            'cvvNumber' => $card->getCvv()
        ];
    }

    /**
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    protected function getPaymentData()
    {
        $data = [
            'currencyCode' => $this->getCurrency(),
            'chargeTotal'  => $this->getAmount()
        ];

        if ($this->getNumberOfInstallments()) {
            $data['creditInstallment'] = [
                'numberOfInstallments' => $this->getNumberOfInstallments(),
                'chargeInterest'       => $this->getChargeInterest()
            ];
        }

        if($this->getSoftDescriptor()) {
            $data['softDescriptor'] = $this->getSoftDescriptor();
        }

        if($this->getIataFee()) {
            $data['iataFee'] = $this->getIataFee();
        }

        return $data;
    }
}