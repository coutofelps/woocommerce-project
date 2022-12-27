<?php

namespace MercadoPago\PP\Sdk\Entity\Payment;

use MercadoPago\PP\Sdk\Common\AbstractEntity;

/**
 * Class AdditionalInfoPayerAddress
 *
 * @package MercadoPago\PP\Sdk\Entity\Payment
 */
class AdditionalInfoPayerAddress extends AbstractEntity
{
    /**
     * @var string
     */
    protected $zip_code;
    
    /**
     * @var string
     */
    protected $street_name;
}
