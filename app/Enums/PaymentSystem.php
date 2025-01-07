<?php

namespace App\Enums;

enum PaymentSystem: string
{
    case VISA = 'Visa';
    case MIR = 'Мир';
    case MASTERCARD = 'MasterCard';
    case PAYPAL = 'PayPal';
}
