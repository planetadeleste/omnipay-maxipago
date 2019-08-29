<?php

namespace Omnipay\MaxiPago\Message\Transaction;


use Omnipay\MaxiPago\Message\TransactionRequest;

class Refund extends TransactionRequest
{
    /**
     * @return mixed
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('orderID', 'referenceNum');

        $data = parent::getData();
        $data['order']['return'] = [
            'orderID'      => $this->getOrderID(),
            'referenceNum' => $this->getReferenceNum(),
            'chargeTotal'  => $this->getAmount()
        ];

        return $data;
    }
}