<?php

namespace App\Enums\V1;

use App\Http\Traits\EnumRetriever;

enum PaymentStatus: string
{
    use EnumRetriever;

    case PENDING = 'pending';
    case COMPLETED = 'completed';
}
