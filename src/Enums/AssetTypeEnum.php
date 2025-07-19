<?php

namespace App\Enums;

enum AssetTypeEnum: string
{
    case ACAO = 'Ação';
    case FII = 'Fundo Imobiliário';
    case ETF = 'ETF – Fundo de Índice';
}