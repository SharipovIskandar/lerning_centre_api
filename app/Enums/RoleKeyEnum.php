<?php

namespace App\Enums;

enum RoleKeyEnum: string
{
    case ADMIN = 'admin';
    case STUDENT = 'student';
    case TEACHER = 'teacher';
}
