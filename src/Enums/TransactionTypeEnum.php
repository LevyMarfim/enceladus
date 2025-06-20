<?php

namespace App\Enums;

enum TransactionTypeEnum: string
{
    // Transferência
    case TRANSFER = 'Transfer';
    // Aporte
    case INVESTMENT = 'Investment';
    // Resgate
    case REDEMPTION = 'Redemption';
}