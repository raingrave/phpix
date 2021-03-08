<?php

namespace Raingrave\Phpix;

/**
 * Class Payload
 * @package Raingrave\Phpix
 */
class Payload
{
    const ID_PAYLOAD_FORMAT_INDICATOR = '00';
    const ID_MERCHANT_ACCOUNT_INFORMATION = '26';
    const ID_MERCHANT_ACCOUNT_INFORMATION_GUI = '00';
    const ID_MERCHANT_ACCOUNT_INFORMATION_KEY = '01';
    const ID_MERCHANT_ACCOUNT_INFORMATION_DESCRIPTION = '02';
    const ID_MERCHANT_CATEGORY_CODE = '52';
    const ID_TRANSACTION_CURRENCY = '53';
    const ID_TRANSACTION_AMOUNT = '54';
    const ID_COUNTRY_CODE = '58';
    const ID_MERCHANT_NAME = '59';
    const ID_MERCHANT_CITY = '60';
    const ID_ADDITIONAL_DATA_FIELD_TEMPLATE = '62';
    const ID_ADDITIONAL_DATA_FIELD_TEMPLATE_TXID = '05';
    const ID_CRC16 = '63';

    /**
     * @var
     */
    private string $pixKey;

    /**
     * @var string
     */
    private string $paymentDescription;

    /**
     * @var string
     */
    private string $merchantName;

    /**
     * @var string
     */
    private string $merchantCity;

    /**
     * @var string
     */
    private string $transactionId;

    /**
     * @var float
     */
    private float $transactionAmount;

    /**
     * @param mixed $pixKey
     */
    public function setPixKey($pixKey)
    {
        $this->pixKey = $pixKey;

        return $this;
    }

    /**
     * @param mixed $paymentDescription
     */
    public function setPaymentDescription($paymentDescription)
    {
        $this->paymentDescription = $paymentDescription;

        return $this;
    }

    /**
     * @param mixed $merchantName
     */
    public function setMerchantName($merchantName)
    {
        $this->merchantName = $merchantName;

        return $this;
    }

    /**
     * @param mixed $merchantCity
     */
    public function setMerchantCity($merchantCity)
    {
        $this->merchantCity = $merchantCity;

        return $this;
    }

    /**
     * @param mixed $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    /**
     * @param mixed $transactionAmount
     */
    public function setTransactionAmount($transactionAmount)
    {
        $this->transactionAmount = (string) number_format($transactionAmount, 2, '.', '');

        return $this;
    }

    /**
     * @param $id
     * @param $value
     * @return string
     */
    private function formatValue($id, $value)
    {
        return $id . str_pad(strlen($value), 2, '0', STR_PAD_LEFT) . $value;
    }

    /**
     * @param string $value
     * @return string
     */
    private function makePayloadFormatIndication($value = '01')
    {
        return $this->formatValue(self::ID_PAYLOAD_FORMAT_INDICATOR, $value);
    }

    /**
     * @param string $value
     * @return string
     */
    private function makeMerchantCategoryCode($value = '0000')
    {
        return $this->formatValue(self::ID_MERCHANT_CATEGORY_CODE, $value);
    }

    /**
     * @return string
     */
    private function makeMerchantAccountInformation()
    {
        $gui = $this->formatValue(self::ID_MERCHANT_ACCOUNT_INFORMATION_GUI, 'BR.GOV.BCB.PIX');

        $key = $this->formatValue(self::ID_MERCHANT_ACCOUNT_INFORMATION_KEY, $this->pixKey);

        $description = $this->formatValue(self::ID_MERCHANT_ACCOUNT_INFORMATION_DESCRIPTION, $this->paymentDescription);

        return $this->formatValue(self::ID_MERCHANT_ACCOUNT_INFORMATION, $gui . $key . $description);
    }

    /**
     * @param int $value
     * @return string
     */
    private function makeTransactionCurrency($value = 986)
    {
        return $this->formatValue(self::ID_TRANSACTION_CURRENCY, $value);
    }

    /**
     * @return string
     */
    private function makeTransactionAmount()
    {
        return $this->formatValue(self::ID_TRANSACTION_AMOUNT, $this->transactionAmount);
    }

    /**
     * @param string $value
     * @return string
     */
    private function makeCountryCode($value = 'BR')
    {
        return $this->formatValue(self::ID_COUNTRY_CODE, $value);
    }

    /**
     * @return string
     */
    private function makeMerchantName()
    {
        return $this->formatValue(self::ID_MERCHANT_NAME, $this->merchantName);
    }

    /**
     * @return string
     */
    private function makeMerchantCity()
    {
        return $this->formatValue(self::ID_MERCHANT_CITY, $this->merchantCity);
    }

    /**
     * @return string
     */
    private function makeTransactionId()
    {
        return $this->formatValue(self::ID_ADDITIONAL_DATA_FIELD_TEMPLATE_TXID, $this->transactionId);
    }

    /**
     * @return string
     */
    private function makeAdicionalDataFieldTemplate()
    {
        return $this->formatValue(self::ID_ADDITIONAL_DATA_FIELD_TEMPLATE, $this->makeTransactionId());
    }

    /**
     * @return string
     */
    public function makePayload()
    {
        $payload = "{$this->makePayloadFormatIndication()}{$this->makeMerchantAccountInformation()}{$this->makeMerchantCategoryCode()}{$this->makeTransactionCurrency()}{$this->makeTransactionAmount()}{$this->makeCountryCode()}{$this->makeMerchantName()}{$this->makeMerchantCity()}{$this->makeAdicionalDataFieldTemplate()}";

        return "{$payload}{$this->makeCRC16($payload)}";
    }

    /**
     * @param $payload
     * @return string
     */
    private function makeCRC16($payload) {
        $payload .= self::ID_CRC16.'04';

        $polinomio = 0x1021;

        $resultado = 0xFFFF;

        if (($length = strlen($payload)) > 0) {
            for ($offset = 0; $offset < $length; $offset++) {
                $resultado ^= (ord($payload[$offset]) << 8);
                for ($bitwise = 0; $bitwise < 8; $bitwise++) {
                    if (($resultado <<= 1) & 0x10000) $resultado ^= $polinomio;
                    $resultado &= 0xFFFF;
                }
            }
        }

        return self::ID_CRC16.'04'.strtoupper(dechex($resultado));
    }
}