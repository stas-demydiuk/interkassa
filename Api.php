<?php

namespace interkassa;

class Api
{

    const API_URL = 'https://api.interkassa.com/v1/';

    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    public function getCurrencyList()
    {
        return $this->query('currency');
    }

    public function getCurrency($id)
    {
        return $this->query('currency/' . $id);
    }

    public function getPaySystemInputList()
    {
        return $this->query('paysystem-input-payway');
    }

    public function getPaySystemInputItem($id)
    {
        return $this->query('paysystem-input-payway/' . $id);
    }

    public function getPaySystemOutputList()
    {
        return $this->query('paysystem-output-payway');
    }

    public function getPaySystemOutputItem($id)
    {
        return $this->query('paysystem-output-payway/' . $id);
    }

    public function getAccountList($user, $password)
    {
        return $this->personalQuery($user, $password, 'account');
    }

    public function getAccount($user, $password, $id)
    {
        return $this->personalQuery($user, $password, 'account/' . $id);
    }

    public function getPurseList($user, $password, $account)
    {
        return $this->personalQuery($user, $password, 'purse', $account);
    }

    public function getPurse($user, $password, $account, $id)
    {
        return $this->personalQuery($user, $password, 'purse/' . $id, $account);
    }

    public function getInvoiceList($user, $password, $account, SearchForm $searchParams)
    {
        return $this->personalQuery($user, $password, 'co-invoice', $account, $searchParams->getParams());
    }

    public function getInvoice($user, $password, $account, $id)
    {
        return $this->personalQuery($user, $password, 'co-invoice/' . $id, $account);
    }

    public function getWithdrawList($user, $password, $account, SearchForm $searchParams)
    {
        return $this->personalQuery($user, $password, 'withdraw', $account, $searchParams->getParams());
    }

    public function getWithdraw($user, $password, $account, $id)
    {
        return $this->personalQuery($user, $password, 'withdraw/' . $id, $account);
    }

    public function createWithdraw($user, $password, $account, WithdrawForm $form)
    {
        return $this->personalQuery($user, $password, 'withdraw', $account, $form->getParams(), self::METHOD_POST);
    }

    private function personalQuery($user, $password, $action, $account = null, array $params = array(), $method = self::METHOD_GET)
    {
        $options = array(
            CURLOPT_USERPWD => $user . ":" . $password
        );

        if ($account) {
            $options[CURLOPT_HTTPHEADER] = array('Ik-Api-Account-Id: ' . $account);
        }

        return $this->query($action, $params, $method, $options);
    }

    private function query($action, array $params = array(), $method = self::METHOD_GET, array $options = array())
    {
        $url = self::API_URL . $action;

        if ($method === self::METHOD_GET && count($params) > 0) {
            $url .= '?' . http_build_query($params);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        if ($method === self::METHOD_POST && count($params) > 0) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        }

        foreach ($options as $option => $value) {
            curl_setopt($ch, $option, $value);
        }

        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === false) {
            throw new Exception('curl error: ' . curl_error($ch));
        }

        $data = json_decode($response, true);

        if ($data['status'] !== 'ok') {
            throw new Exception($data['message'], $data['code']);
        }

        return isset($data['data']) ? $data['data'] : array();
    }

}