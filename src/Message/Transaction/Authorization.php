<?php


namespace Omnipay\MaxiPago\Message\Transaction;


use Omnipay\MaxiPago\Message\TransactionRequest;

class Authorization extends TransactionRequest
{

    /**
     * @return mixed
     * @throws \Omnipay\Common\Exception\InvalidCreditCardException
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('referenceNum', 'processorID');
        $data = parent::getData();
        $auth = [
            'processorID'       => $this->getProcessorID(),
            'referenceNum'      => $this->getReferenceNum(),
            'fraudCheck'        => $this->getFraudCheck(),
            'ipAddress'         => $this->getIpAddress(),
            'customerIdExt'     => $this->getCustomerIdExt(),
            'transactionDetail' => [
                'payType' => $this->getPayTypeData()
            ],
            'payment'           => $this->getPaymentData()
        ];

        $card = $this->getCard();
        if ($card->getBillingName()) {
            $auth['billing'] = [
                'name'       => $card->getBillingName(),
                'address'    => $card->getBillingAddress1(),
                'address2'   => $card->getBillingAddress2(),
                'city'       => $card->getBillingCity(),
                'state'      => $card->getBillingState(),
                'postalcode' => $card->getBillingPostcode(),
                'country'    => $card->getBillingCountry(),
                'phone'      => $card->getBillingPhone(),
                'email'      => $card->getEmail()
            ];
        }

        if ($card->getShippingName()) {
            $auth['shipping'] = [
                'name'       => $card->getShippingName(),
                'address'    => $card->getShippingAddress1(),
                'address2'   => $card->getShippingAddress2(),
                'city'       => $card->getShippingCity(),
                'state'      => $card->getShippingState(),
                'postalcode' => $card->getShippingPostcode(),
                'country'    => $card->getShippingCountry(),
                'phone'      => $card->getShippingPhone(),
                'email'      => $card->getEmail()
            ];
        }

        if($itemList = $this->getItemsListData()) {
            $auth = array_merge($auth, $itemList);
        }

        $data['order']['auth'] = $auth;

        return $data;
    }

    /**
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidCreditCardException
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    protected function getPayTypeData()
    {
        switch ($this->getPayType()) {
            case 'boleto':
                $this->validate('expirationDate', 'number');
                return [
                    'boleto' => [
                        'expirationDate' => $this->getExpirationDate(),
                        'number'         => $this->getNumber(),
                        'instructions'   => $this->getInstructions()
                    ]
                ];
                break;

            case 'onlineDebit':
                $this->validate('parametersURL', 'processorID');
                if ($this->getProcessorID() == '18') {
                    $this->validate('customerIdExt');
                }
                return [
                    'onlineDebit' => [
                        'parametersURL' => $this->getParametersURL()
                    ]
                ];
                break;

            case 'eWallet':
                $this->validate('parametersURL');
                return [
                    'eWallet' => [
                        'parametersURL' => $this->getParametersURL()
                    ]
                ];
                break;

            case 'creditcard':
            default:
                if ($this->getCardHash()) {
                    $this->validate('customerId', 'cardHash');
                    return [
                        'onFile' => [
                            'token'      => $this->getCardHash(),
                            'customerId' => $this->getCustomerId()
                        ]
                    ];
                } else {
                    return [
                        'creditCard' => $this->getCardData()
                    ];
                }
                break;
        }
    }

    protected function getItemsListData()
    {
        $data = [];
        if ($this->getItems()->count()) {
            $itemList = [
                '_attributes' => ['itemCount' => $this->getItems()->count()],
                'item'        => []
            ];
            $index = 0;
            foreach ($this->getItems() as $item) {
                $index++;
                /** @var \Omnipay\Common\Item $item */
                $itemList['item'][] = [
                    'itemIndex'       => $index,
                    'itemProductCode' => $item->getName(),
                    'itemDescription' => $item->getDescription(),
                    'itemQuantity'    => $item->getQuantity(),
                    'itemTotalAmount' => $item->getPrice() * $item->getQuantity(),
                    'itemUnitCost'    => $item->getPrice()
                ];
            }
            $data['itemList'] = $itemList;
        }

        return $data;
    }
}