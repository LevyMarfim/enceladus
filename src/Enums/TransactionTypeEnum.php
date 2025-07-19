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
    // Taxa liquidação
     case SETTLEMENT_TAX = 'Taxa liquidação';
     // Taxa operacional
     case OPERATIONAL_TAX = 'Taxa operacional';
     // Imposto de Renda Retido na Fonte
     case IRRF = 'IRRF';
     // Investback
     case INVESTBACK = 'Investback';
    //  Frações
    case FRACTION = 'Fração';
    //  Emolumentos
    case EMOLUMENT = 'Emolumentos';
}