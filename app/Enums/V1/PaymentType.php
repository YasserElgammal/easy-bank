<?php

namespace App\Enums\V1;

use App\Http\Traits\EnumRetriever;

enum PaymentType: string
{
    use EnumRetriever;

    case CASH = 'cash';
    case PAYPAL = 'paypal';
}
