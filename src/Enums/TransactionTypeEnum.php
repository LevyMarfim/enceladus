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
    // Dividendo
    case DIVIDEND = 'Dividend';
    // Impostos
     case TAXES = 'Taxes';
     // Imposto de Renda Retido na Fonte
     case IRRF = 'IRRF';
     // Investback
     case INVESTBACK = 'Investback';
    //  Frações
    case FRACTION = 'Fraction';
}