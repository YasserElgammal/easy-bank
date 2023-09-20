<?php

namespace App\Enums\V1;

use App\Http\Traits\EnumRetriever;

enum RoleType: string
{
    use EnumRetriever;

    case ADMIN = 'admin';
    case EMPLOYEE = 'employee';
    case CUSTOMER = 'customer';
}
