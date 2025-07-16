<?php

namespace App\Enums;

enum TransactionTypeEnum: string
{
    // Transferência
    case TRANSFER = 'Transferência';
    // Aporte
    case INVESTMENT = 'Aporte';
    // Resgate
    case REDEMPTION = 'Resgate';
    // Dividendo
    case DIVIDEND = 'Dividendo';
    // Impostos
     case TAXES = 'Taxas';
     // Imposto de Renda Retido na Fonte
     case IRRF = 'IRRF';
     // Investback
     case INVESTBACK = 'Investback';
    //  Frações
    case FRACTION = 'Fração';
}