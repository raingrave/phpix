# SDK PHP PARA GERAR QRCODE ESTÁTICO PIX 

Este repositório foi desenvolvido com o objetivo de se aprofundar na nova tecnologia disponibilizada pelo BACEN.

## Requisitos
* PHP >= 8.0


## Como usar?
Para começar, você deve obter uma instância da classe Payload e setar os parâmetros através dos métodos setters, após obtenha uma instância de QrCodeStatic que recebe Payload no construtor utilizando o método público generate.
Por padrão o output será html, mas se for necessária customizar o qrcode, pode utilizar o método setOutputType que recebe 2 instâncias do mpdf/output
```php
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
```

## Documentação oficial do manual de padrões do pix

A documentação completa com todos os padrões está em https://www.bcb.gov.br/content/estabilidadefinanceira/pix/Regulamento_Pix/II-ManualdePadroesparaIniciacaodoPix.pdf.


## Licença ##
Este projeto está licenciado sob a Licença MIT - consulte o arquivo [LICENSE.md](LICENSE) para obter detalhes
