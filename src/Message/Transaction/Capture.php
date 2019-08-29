<?php
namespace Omnipay\MaxiPago\Message\Transaction;


use Omnipay\MaxiPago\Message\TransactionRequest;

class Capture extends TransactionRequest
{
    /**
     * @return mixed
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('referenceNum', 'orderID', 'amount');
        $data = parent::getData();
        $capture = [
            'orderID'       => $this->getOrderID(),
            'chargeTotal'        => $this->getAmount(),
            'referenceNum'      => $this->getReferenceNum(),
        ];

        if($this->getIataFee()) {
            $capture['iataFee'] = $this->getIataFee();
        }

        $data['order']['capture'] = $capture;

        return $data;
    }
}