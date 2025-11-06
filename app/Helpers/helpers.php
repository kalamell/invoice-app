<?php

use Kittinan\PromptPayQR;

if (!function_exists('generatePromptPayQR')) {
    /**
     * Generate PromptPay QR Code
     *
     * @param string $promptpayId
     * @param float $amount
     * @return string Base64 encoded QR image
     */
    function generatePromptPayQR($promptpayId, $amount = null)
    {
        try {
            $qr = new PromptPayQR($promptpayId);

            if ($amount) {
                $qr->setAmount($amount);
            }

            return $qr->generateQRCode();
        } catch (\Exception $e) {
            \Log::error('PromptPay QR Generation Error: ' . $e->getMessage());
            return null;
        }
    }
}

if (!function_exists('formatCurrency')) {
    /**
     * Format number as Thai Baht currency
     *
     * @param float $amount
     * @return string
     */
    function formatCurrency($amount)
    {
        return '฿' . number_format($amount, 2);
    }
}

if (!function_exists('generateDocumentNumber')) {
    /**
     * Generate next document number for shop
     *
     * @param \App\Models\ShopSetting $settings
     * @return string
     */
    function generateDocumentNumber($settings)
    {
        $number = str_pad($settings->document_number, 5, '0', STR_PAD_LEFT);
        $settings->increment('document_number');
        return $settings->document_prefix . '-' . $number;
    }
}
