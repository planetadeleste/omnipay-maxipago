<?php
namespace Omnipay\MaxiPago;


use Omnipay\Common\AbstractGateway;

/**
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface completePurchase(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface createCard(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = [])
 */
class Gateway extends AbstractGateway
{

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'MaxiPago';
    }

    public function getDefaultParameters()
    {
        return [
            'merchantId'    => '',
            'merchantKey'   => '',
            'testMode' => false,
        ];
    }

    /**
     * Unique ID for each merchant
     *
     * @param string $merchantId
     */
    public function setMerchantId($merchantId)
    {
        $this->setParameter('merchantId', $merchantId);
    }

    /**
     * @return mixed
     */
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    /**
     * Key associated with the Merchant ID
     *
     * @param string $merchantKey
     */
    public function setMerchantKey($merchantKey)
    {
        $this->setParameter('merchantKey', $merchantKey);
    }

    /**
     * @return mixed
     */
    public function getMerchantKey()
    {
        return $this->getParameter('merchantKey');
    }

    /**
     * Create request for to consume service
     *
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function authorize(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\MaxiPago\Message\Transaction\Authorization', $parameters);
    }

    /**
     * Create request for to consume service
     *
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\MaxiPago\Message\Transaction\Sale', $parameters);
    }

    /**
     * Create request for to consume service
     *
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function capture(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\MaxiPago\Message\Transaction\Capture', $parameters);
    }

    /**
     * Create request for to consume service
     *
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function refund(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\MaxiPago\Message\Transaction\Refund', $parameters);
    }

    /**
     * Create request for to consume service
     *
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function void(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\MaxiPago\Message\Transaction\VoidRequest', $parameters);
    }

    /**
     * Create request for to consume service
     *
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function recurring(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\MaxiPago\Message\Transaction\Recurring', $parameters);
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface authorize(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface capture(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface purchase(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface completePurchase(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface refund(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface void(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface createCard(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())
    }
}