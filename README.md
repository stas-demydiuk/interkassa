PHP Library for Interkassa API
==========

PHP implementation for Interkassa Mass Payments API v 0.4 (28.03.2014)

Usage
===

To execute queries to server you must create new instance of API class.

```php
$api = new interkassa\Api();
```

Retrieve currencies list:

```php
$currencies = $api->getCurrencyList();
```

Retrieve list of payment system for input:

```php
$items = $api->getPaySystemInputList();
```

Retrieve list of payment system for output:

```php
$items = $api->getPaySystemOutputList();
```

Retrieve account list

```php
$items = $api->getAccountList($user, $password);
```

Retrieve purses list for selected account

```php
$items = $api->getAccountList($user, $password, $accountId);
```

Search and retrieve invoices

```php
$form = new interkassa\SearchForm();
$form->fromDate('2014-07-24 16:00:00')->toDate('2014-07-25 16:00:00')->byPurse($id);

$items = $api->getInvoiceList($user, $password, $accountId, $form);
```

Search and retrieve withdraw

```php
$form = new interkassa\SearchForm();
$form->fromDate('2014-07-24 16:00:00')->toDate('2014-07-25 16:00:00')->byPurse($id);

$items = $api->getWithdrawList($user, $password, $accountId, $form);
```

Create new withdraw

```php
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

License
-------

This library is released under the Open Source MIT license, which gives you the
possibility to use it and modify it in every circumstance.

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
