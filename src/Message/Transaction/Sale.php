<?php
namespace Omnipay\MaxiPago\Message\Transaction;

class Sale extends Authorization
{
    /**
     * @return mixed
     * @throws \Omnipay\Common\Exception\InvalidCreditCardException
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $data = parent::getData();
        $data['order']['sale'] = $data['order']['auth'];
        unset($data['order']['auth']);

        return $data;
    }
}