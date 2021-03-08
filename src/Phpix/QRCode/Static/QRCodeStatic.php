<?php

namespace Raingrave\Phpix\QRCode\Static;

use Mpdf\QrCode\Output\Html;
use Mpdf\QrCode\Output\Png;
use Mpdf\QrCode\QrCode;
use Raingrave\Phpix\Payload;
use Raingrave\Phpix\QRCode\QRCode as QRCodeInterface;

/**
 * Class QRCodeStatic
 * @package Raingrave\Phpix\QRCode\Static
 */
class QRCodeStatic implements QRCodeInterface
{
    /**
     * @var string
     */
    private string $outputType = Html::class;

    /**
     * @var string
     */
    private Payload $payload;

    /**
     * QRCodeStatic constructor.
     * @param string $payload
     */
    public function __construct(Payload $payload)
    {
        $this->payload = $payload;
    }

    /**
     * @param int $size
     * @param array|int[] $backgroundColor
     * @param array|int[] $color
     * @return string
     * @throws \Mpdf\QrCode\QrCodeException
     */
    public function generate(int $size = 200, array $backgroundColor= [255, 255, 255], array $color = [0, 0, 0]) : string
    {
        $qrCode = new QrCode($this->payload->makePayload());

        $qrCodeOutput = (new $this->outputType)->output($qrCode, $size, $backgroundColor, $color);

        if ($this->outputType == Png::class) {

            $qrCodeOutputBase64 = base64_encode($qrCodeOutput);

            return "<img src='data:image/png;base64, {$qrCodeOutputBase64}' />";
        }

        return $qrCodeOutput;
    }

    /**
     * @param $outputType
     */
    public function setOutputType($outputType) : void
    {
        $this->outputType = $outputType;
    }
}