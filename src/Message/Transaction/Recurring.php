<?php

namespace Omnipay\MaxiPago\Message\Transaction;

use Omnipay\Common\Exception\InvalidRequestException;

class Recurring extends Authorization
{
    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate)
    {
        $this->setParameter('startDate', $startDate);
    }

    /**
     * @return string
     */
    public function getStartDate()
    {
        return $this->getParameter('startDate');
    }

    /**
     * @param string $period Accepted value as "daily", "weekly" or "monthly"
     *
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function setPeriod($period)
    {
        $period = strtolower($period);
        if (!in_array($period, ['daily', 'weekly', 'monthly'])) {
            throw new InvalidRequestException('Invalid Period value. Must be "daily", "weekly" or "monthly"');
        }
        $this->setParameter('period', $period);
    }

    /**
     * @return string
     */
    public function getPeriod()
    {
        return $this->getParameter('period');
    }

    /**
     * @param mixed $frequency
     */
    public function setFrequency($frequency)
    {
        $this->setParameter('frequency', $frequency);
    }

    /**
     * @return string
     */
    public function getFrequency()
    {
        $frequency = $this->getParameter('frequency');
        return ($frequency) ? $frequency : 1;
    }

    /**
     * @param mixed $installments
     */
    public function setInstallments($installments)
    {
        $this->setParameter('installments', $installments);
    }

    /**
     * @return string
     */
    public function getInstallments()
    {
        return $this->getParameter('installments');
    }

    /**
     * @param mixed $failureThreshold
     */
    public function setFailureThreshold($failureThreshold)
    {
        $this->setParameter('failureThreshold', $failureThreshold);
    }

    /**
     * @return string
     */
    public function getFailureThreshold()
    {
        $failure = $this->getParameter('failureThreshold');
        return ($failure) ? $failure : 1;
    }


    /**
     * @return mixed
     * @throws \Omnipay\Common\Exception\InvalidCreditCardException
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('period', 'action', 'startDate', 'installments');
        $data = parent::getData();
        $data['order']['recurringPayment'] = $data['order']['auth'];
        unset($data['order']['auth']);

        $recurring = [
            'action'           => 'new',
            'startDate'        => $this->getStartDate(),
            'frequency'        => $this->getFrequency(),
            'period'           => $this->getPeriod(),
            'installments'     => $this->getInstallments(),
            'failureThreshold' => $this->getFailureThreshold()
        ];
        $data['order']['recurringPayment']['recurring'] = $recurring;

        return $data;
    }

}