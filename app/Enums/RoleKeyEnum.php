<?php

namespace App\Enums;

use App\Traits\EnumHelper;

enum RoleKeyEnum: string
{
    use EnumHelper;
    case ADMIN = 'admin';
    case STUDENT = 'student';
    case TEACHER = 'teacher';
}
