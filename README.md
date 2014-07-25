PHP Library for Interkassa API
==========

PHP implementation for Interkassa Mass Payments API v 0.4 (28.03.2014)

Usage
===

To execute queries to server you must create new instance of API class.

```code
$api = new interkassa\Api();
```

Retrieve currencies list:

```code
$currencies = $api->getCurrencyList();
```

Retrieve list of payment system for input:

```code
$items = $api->getPaySystemInputList();
```

Retrieve list of payment system for output:

```code
$items = $api->getPaySystemOutputList();
```

Retrieve account list

```code
$items = $api->getAccountList($user, $password);
```

Retrieve purses list for selected account

```code
$items = $api->getAccountList($user, $password, $accountId);
```

Search and retrieve invoices

```code
$form = new interkassa\SearchForm();
$form->fromDate('2014-07-24 16:00:00')->toDate('2014-07-25 16:00:00')->byPurse($id);

$items = $api->getInvoiceList($user, $password, $accountId, $form);
```

Search and retrieve withdraw

```code
$form = new interkassa\SearchForm();
$form->fromDate('2014-07-24 16:00:00')->toDate('2014-07-25 16:00:00')->byPurse($id);

$items = $api->getWithdrawList($user, $password, $accountId, $form);
```

Create new withdraw

```code
$wform = new interkassa\WithdrawForm();
$wform->setAction(interkassa\WithdrawForm::ACTION_CALC);
$wform->setCalcKey(interkassa\WithdrawForm::CALC_PAYEE_AMOUNT);
$wform->setAmount(100.50);
$wform->setPayway('52ef9b77e4ae1a3008000000');
$wform->setPurse('207291561721');
$wform->setDetails(array(
    'card' => '4000123423454578'
));

$api->createWithdraw($username, $password, $account, $wform);
```
