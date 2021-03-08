<?php

require_once __DIR__ . '/vendor/autoload.php';

$payload = new \Raingrave\Phpix\Payload();

$payload->setPixKey('pixKeyValida')
    ->setMerchantName('Fulano de Tal')
    ->setMerchantCity('São Paulo')
    ->setPaymentDescription('descrição da cobrança')
    ->setTransactionId('PHPIX000001')
    ->setTransactionAmount(0.01);

// Default
$qrCodeStaticDefault = new \Raingrave\Phpix\QRCode\Static\QRCodeStatic($payload);

echo $qrCodeStaticDefault->generate();

// Custom
$qrCodeStaticCustom = new \Raingrave\Phpix\QRCode\Static\QRCodeStatic($payload);

$qrCodeStaticCustom->setOutputType(\Mpdf\QrCode\Output\Png::class);

echo $qrCodeStaticCustom->generate(300, [36, 48, 69], [255, 255, 255]);