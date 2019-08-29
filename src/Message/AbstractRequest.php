<?php

namespace Omnipay\MaxiPago\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;
use Spatie\ArrayToXml\ArrayToXml;

/**
 * Class AbstractRequest
 *
 * @package Omnipay\MaxiPago\Message
 *
 * @method string getMerchantId()
 * @method string getMerchantKey()
 */
abstract class AbstractRequest extends BaseAbstractRequest
{
    /**
     * Live Endpoint URL
     *
     * @var string URL
     */
    protected $liveEndpoint = 'https://api.maxipago.net';

    /**
     * Test Endpoint URL
     *
     * @var string URL
     */
    protected $testEndpoint = 'https://testapi.maxipago.net';

    protected $apiVersion = '3.1.1.15';

    /**
     * @param mixed $data
     *
     * @return \Omnipay\Common\Message\ResponseInterface|void
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function sendData($data)
    {
        $this->validate('merchantId', 'merchantKey', 'operation');
        if (!in_array($this->getOperation(), ['api', 'rapi', 'transaction'])) {
            throw new InvalidRequestException("The request type {$this->getOperation()} is invalid");
        }

        $this->addListener4xxErrors();
        $data['version'] = $this->getApiVersion();
        $data['verification'] = [
            'merchantId'  => $this->getMerchantId(),
            'merchantKey' => $this->getMerchantKey()
        ];
        $xml = ArrayToXml::convert($data, $this->getOperation().'-request', true, 'UTF-8');

        $headers = ['Content-Type' => 'text/xml; charset=utf-8'];
        $httpResponse = $this->httpClient
            ->post($this->getEndpoint(), $headers, $xml)
            ->send();

        return $this->createResponse($httpResponse->json());
    }

    /**
     * @return string
     */
    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    /**
     * @param mixed $cardHash
     */
    public function setCardHash($cardHash)
    {
        $this->setParameter('cardHash', $cardHash);
    }

    /**
     * @return string
     */
    public function getCardHash()
    {
        return $this->getParameter('cardHash');
    }

    /**
     * @param mixed $customerId
     */
    public function setCustomerId($customerId)
    {
        $this->setParameter('customerId', $customerId);
    }

    /**
     * @return string
     */
    public function getCustomerId()
    {
        return $this->getParameter('customerId');
    }

    /**
     * @param $data
     *
     * @return \Omnipay\MaxiPago\Message\Response
     */
    protected function createResponse($data)
    {
        return $this->response = new Response($this, $data);
    }

    /**
     * Set operation request. Possible values are transaction, api, rapi
     *      Transaction Request: Processes credit card and boleto transactions
     *      <transaction-request/>, response as <transaction-response/>
     *
     *      Entry Request: Handles data entry in our system, such as storing a credit card
     *      <api-request/>, response as <api-response/>
     *
     *      Report Request: Queries our system for information on transactions
     *      <rapi-request/>, response as <rapi-response/>
     *
     * @param string $operation
     */
    public function setOperation($operation)
    {
        $this->setParameter('operation', $operation);
    }

    public function getOperation()
    {
        return $this->getParameter('operation');
    }

    /**
     * Verify environment of the service payment and return correct endpoint url
     *
     * @return string
     */
    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->getTestEndpoint() : $this->getLiveEndpoint();
    }

    /**
     * @return string
     */
    protected function getLiveEndpoint(): string
    {
        return $this->liveEndpoint;
    }

    /**
     * @return string
     */
    protected function getTestEndpoint(): string
    {
        return $this->testEndpoint;
    }

    /**
     * @return mixed
     */
    protected function getUserIp()
    {
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /**
     * Don't throw exceptions for 4xx errors
     */
    private function addListener4xxErrors()
    {
        $this->httpClient->getEventDispatcher()->addListener(
            'request.error',
            function ($event) {
                if ($event['response']->isClientError()) {
                    $event->stopPropagation();
                }
            }
        );
    }
}