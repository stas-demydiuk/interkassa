<?php

namespace interkassa;

use \DateTime;
use \DateTimeZone;

class SearchForm
{

    private $params = array();

    public function byCheckout($id)
    {
        $this->params['checkoutId'] = $id;
        return $this;
    }

    public function byPayway($id)
    {
        $this->params['paywayId'] = $id;
        return $this;
    }

    public function byPurse($id)
    {
        $this->params['purseId'] = $id;
        return $this;
    }

    public function fromDate($date)
    {
        $this->params['fromDate'] = $this->prepareDate($date);
        return $this;
    }

    public function toDate($date)
    {
        $this->params['toDate'] = $this->prepareDate($date);
        return $this;
    }

    public function getParams()
    {
        return $this->params;
    }

    private function prepareDate($date)
    {
        if (!$date instanceof DateTime) {
            $date = new DateTime($date);
        }

        $date->setTimezone(new DateTimeZone('Europe/Kiev'));
        return $date->format('Y-m-d H:i:s');
    }

}