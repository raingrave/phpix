<?php

namespace Raingrave\Phpix\QRCode;

use Raingrave\Phpix\Payload;

/**
 * Interface QRCode
 * @package Raingrave\Phpix\QRCode
 */
interface QRCode
{
    /**
     * QRCode constructor.
     * @param Payload $payload
     */
    public function __construct(Payload $payload);

    /**
     * @param int $size
     * @param array|int[] $backgroundColor
     * @param array|int[] $color
     * @return string
     */
    public function generate(int $size = 200, array $backgroundColor= [255, 255, 255], array $color = [0, 0, 0]) : string;
}