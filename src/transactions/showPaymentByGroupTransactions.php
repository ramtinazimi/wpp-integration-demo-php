<?php
require_once('../util/helperFunctions.php');

// # PayPal notification

// Wirecard sends a server-to-server request regarding any changes in the transaction status.

// ## Required objects

// To include the necessary files, we use the composer for PSR-4 autoloading.
require '../../vendor/autoload.php';
require_once('../config.php');

$paymentMethod = htmlspecialchars($_POST['paymentMethod']);
$transactionId = htmlspecialchars($_POST['transactionId']);

if (isNullOrEmptyString($paymentMethod) || isNullOrEmptyString($transactionId)) {
    echo "No payment method or transaction id found. Please enter a valid payment method and transaction id.";
    return;
}
$service = createTransactionService($paymentMethod);
try {
    // get a transaction by passing transactionId and paymentMethod to getTransactionByTransactionId method.
    $transaction = $service->getGroupOfTransactions($transactionId, $paymentMethod);
    require 'showPayment.php';
} catch (Exception $e) {
    echo get_class($e), ': ', $e->getMessage(), '<br>';
}
