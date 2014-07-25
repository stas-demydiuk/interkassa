<?php

namespace interkassa;

class WithdrawForm
{
    const ACTION_PROCESS = 'process';
    const ACTION_CALC = 'calc';

    const CALC_PAYER_PRICE = 'ikPayerPrice';
    const CALC_PAYEE_AMOUNT = 'psPayeeAmount';

    private $params = array();

    public function __construct()
    {
        $this->setCalcKey(self::CALC_PAYER_PRICE);
        $this->setAction(self::ACTION_CALC);
    }

    public function setAmount($amount)
    {
        $this->params['amount'] = (double)$amount;
        return $this;
    }

    public function setPayway($id)
    {
        $this->params['paywayId'] = $id;
        return $this;
    }

    public function setPurse($id)
    {
        $this->params['purseId'] = $id;
        return $this;
    }

    public function setCalcKey($key)
    {
        $this->params['calcKey'] = $key;
        return $this;
    }

    public function setAction($action)
    {
        $this->params['action'] = $action;
        return $this;
    }

    public function setDetails(array $details)
    {
        $this->params['details'] = $details;
        return $this;
    }

    public function getParams()
    {
        return $this->params;
    }
}