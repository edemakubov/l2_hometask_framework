<?php

declare(strict_types=1);

namespace App\Constants;

enum UserRoleEnum: string
{
    case ADMIN = 'admin';
    case USER = 'user';
}
