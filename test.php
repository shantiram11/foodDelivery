<?php

// CLI tool to test eSewa request signing and (optionally) POST to eSewa RC endpoint.
// Usage examples:
//   php test.php
//   php test.php --amount=1234.56 --post

if (php_sapi_name() !== 'cli') {
    fwrite(STDERR, "Please run this script from the terminal (CLI).\n");
    exit(1);
}

// Bootstrap Laravel so we can use config(), routes, and the EsewaService
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\EsewaService;

function runEsewaServiceCheck(float $amount, bool $doPost = false): void
{
    $productCode = config('services.esewa.product_code', 'EPAYTEST');
    $formUrl = config('services.esewa.form_url', 'https://rc-epay.esewa.com.np/api/epay/main/v2/form');

    $transactionUuid = 'TXN-' . date('YmdHis') . '-' . bin2hex(random_bytes(4));

    $successUrl = route('payment.esewa.success');
    $failureUrl = route('payment.esewa.failure');

    $service = new EsewaService();
    $fields = [
        'amount' => number_format($amount, 2, '.', ''),
        'tax_amount' => number_format(0, 2, '.', ''),
        'total_amount' => number_format($amount, 2, '.', ''),
        'transaction_uuid' => $transactionUuid,
        'product_code' => $productCode,
        'product_service_charge' => number_format(0, 2, '.', ''),
        'product_delivery_charge' => number_format(0, 2, '.', ''),
        'success_url' => $successUrl,
        'failure_url' => $failureUrl,
    ];

    $signature = $service->generateSignature($fields);
    $fields['signature'] = $signature;
    $fields['signed_field_names'] = implode(',', $service->getSignedFieldsList());

    $signString = $service->buildSignString($fields, $service->getSignedFieldsList());

    // Output for debugging
    echo "\n=== eSewa RC Test Payload ===\n";
    echo "Form URL: {$formUrl}\n";
    echo "Amount: {$fields['total_amount']}\n";
    echo "Transaction UUID: {$fields['transaction_uuid']}\n";
    echo "Product Code: {$fields['product_code']}\n";
    echo "Success URL: {$successUrl}\n";
    echo "Failure URL: {$failureUrl}\n";
    echo "Signed Field Names: {$fields['signed_field_names']}\n";
    echo "Sign String: {$signString}\n";
    echo "Signature: {$fields['signature']}\n\n";

    // Print cURL command for manual testing
    $curlData = http_build_query($fields);
    echo "Run this cURL to POST to eSewa RC:\n";
    echo "curl -X POST '" . $formUrl . "' --data '" . $curlData . "'\n\n";

    if ($doPost) {
        echo "\nPosting to eSewa RC...\n";
        $ch = curl_init($formUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);

        echo "HTTP Status: {$httpCode}\n";
        if ($err) {
            echo "cURL error: {$err}\n";
        }
        echo "Response (first 1000 chars):\n";
        echo substr($response, 0, 1000) . (strlen($response) > 1000 ? "\n...[truncated]" : "") . "\n";
    }

    echo "\nDone.\n";
}

// Parse CLI args and execute
$args = [];
foreach ($argv as $arg) {
    if (strpos($arg, '--') === 0) {
        $parts = explode('=', substr($arg, 2), 2);
        $args[$parts[0]] = $parts[1] ?? true;
    }
}

$amount = isset($args['amount']) ? (float)$args['amount'] : 100.00;
$doPost = isset($args['post']);

runEsewaServiceCheck($amount, $doPost);
