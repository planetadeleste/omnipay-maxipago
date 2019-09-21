<?php


namespace Omnipay\MaxiPago\Message;


class TransactionRequest extends AbstractRequest
{
    // CREDIT CARD PROCESSORS
    const PROCESSOR_TEST_SIMULATOR = 1;
    const PROCESSOR_REDE = 2;
    const PROCESSOR_GETNET = 3;
    const PROCESSOR_CIELO = 4;
    const PROCESSOR_TEF = 5;
    const PROCESSOR_ELAVON = 6;
    const PROCESSOR_CHASE_PAYMENTECH = 8;

    // BOLETO PROCESSORS
    const PROCESSOR_ITAU = 11;
    const PROCESSOR_BRADESCO = 12; // Used for test boleto
    const PROCESSOR_BANCO_DO_BRASIL = 13;
    const PROCESSOR_HSBC = 14;
    const PROCESSOR_SANTANDER = 15;
    const PROCESSOR_CAIXA = 16;


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
     * Order ID in Store
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
        if (!strlen($param) || !in_array($param, ['Y', 'N', 'y', 'n'])) {
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
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->setParameter('number', $number);
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->getParameter('number');
    }

    /**
     * @param mixed $expirationDate
     */
    public function setExpirationDate($expirationDate)
    {
        $this->setParameter('expirationDate', $expirationDate);
    }

    /**
     * @return string
     */
    public function getExpirationDate()
    {
        return $this->getParameter('expirationDate');
    }

    /**
     * @param mixed $instructions
     */
    public function setInstructions($instructions)
    {
        $this->setParameter('instructions', $instructions);
    }

    /**
     * @return string
     */
    public function getInstructions()
    {
        return $this->getParameter('instructions');
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
     * Buyer CPF
     *
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

        if ($this->getSoftDescriptor()) {
            $data['softDescriptor'] = $this->getSoftDescriptor();
        }

        if ($this->getIataFee()) {
            $data['iataFee'] = $this->getIataFee();
        }

        return $data;
    }
}