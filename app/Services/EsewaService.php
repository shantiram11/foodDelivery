<?php

namespace App\Services;

class EsewaService
{
    public function getSignedFieldsList(): array
    {
        $signedFields = config('services.esewa.signed_fields', 'total_amount,transaction_uuid,product_code');
        return array_filter(array_map('trim', explode(',', $signedFields)));
    }

    public function buildSignString(array $fields, array $signedFieldNames): string
    {
        $pairs = [];
        foreach ($signedFieldNames as $fieldName) {
            if (!array_key_exists($fieldName, $fields)) {
                // Missing field is treated as empty string
                $pairs[] = $fieldName . '=';
            } else {
                $pairs[] = $fieldName . '=' . $fields[$fieldName];
            }
        }
        return implode(',', $pairs);
    }

    public function generateSignature(array $fields): string
    {
        $signedFieldNames = $this->getSignedFieldsList();
        $signString = $this->buildSignString($fields, $signedFieldNames);
        $secretKey = config('services.esewa.secret_key');

        $rawHmac = hash_hmac('sha256', $signString, $secretKey, true);
        return base64_encode($rawHmac);
    }

    public function verifySignature(array $fields, string $signatureProvided): bool
    {
        $calculated = $this->generateSignature($fields);
        return hash_equals($calculated, $signatureProvided);
    }
}
