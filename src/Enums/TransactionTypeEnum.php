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
     case TAXES = 'Impostos';
    // Taxa liquidação
    case SETTLEMENT_TAX = 'Taxa liquidação';
    // Taxa operacional
    case OPERATIONAL_TAX = 'Taxa operacional';
    // Taxa custódia
    case CUSTODY_TAX = 'Taxa custódia';
    // Imposto de Renda Retido na Fonte
    case IRRF = 'IRRF';
    // Investback
    case INVESTBACK = 'Investback';
    // Frações
    case FRACTION = 'Fração';
    // Emolumentos
    case EMOLUMENT = 'Emolumentos';
    // Juros Sobre Capital Própio
    case JCP = 'JCP';
    // Rendimento
    case YIELD = 'Rendimento';
}