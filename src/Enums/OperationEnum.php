<?php

namespace App\Enums;

enum OperationEnum: string
{
    case CREDIT = 'Credit';
    case DEBIT = 'Debit';
}