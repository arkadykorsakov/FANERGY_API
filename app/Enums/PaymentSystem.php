<?php

namespace App\Enums;

enum PaymentSystem: string
{
    case VISA = 'Visa';
    case MASTER_CARD = 'Master Card';
    case MIR = 'Мир';
    case SBP = 'Система бстрых платежей';
}
