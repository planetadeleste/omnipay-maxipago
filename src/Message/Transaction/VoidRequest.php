<?php
namespace Omnipay\MaxiPago\Message\Transaction;


use Omnipay\MaxiPago\Message\TransactionRequest;

class VoidRequest extends TransactionRequest
{
    /**
     * @return mixed
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('transactionID');
        $data = parent::getData();

        $data['order']['void'] = [
            'transactionID' => $this->getTransactionId()
        ];

        return $data;
    }
}