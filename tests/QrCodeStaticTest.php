<?php

test('generate html qrcode', function () {

    $payload = new \Raingrave\Phpix\Payload();

    $payload->setPixKey('pixKey')
            ->setMerchantName('merchantName')
            ->setMerchantCity('merchantCity')
            ->setPaymentDescription('paymentDescription')
            ->setTransactionId('RAINTECH' . rand(00000, 99999))
            ->setTransactionAmount(9.24);

    $qrCodeStatic = new Raingrave\Phpix\QRCode\Static\QRCodeStatic($payload);

    expect($qrCodeStatic->generate())->toBeString()->toContain('table');
});

test('generate png qrcode', function () {

    $payload = new \Raingrave\Phpix\Payload();

    $payload->setPixKey('pixKey')
        ->setMerchantName('merchantName')
        ->setMerchantCity('merchantCity')
        ->setPaymentDescription('paymentDescription')
        ->setTransactionId('RAINTECH' . rand(00000, 99999))
        ->setTransactionAmount(9.24);

    $qrCodeStatic = new Raingrave\Phpix\QRCode\Static\QRCodeStatic($payload);

    $qrCodeStatic->setOutputType(\Mpdf\QrCode\Output\Png::class);

    expect($qrCodeStatic->generate())->toBeString('PNG');
});
