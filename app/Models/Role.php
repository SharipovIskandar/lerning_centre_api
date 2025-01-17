<?php

namespace App\Models;

use App\Enums\RoleKeyEnum;
use App\Traits\DataFormatter;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    public $fillable = ['name', 'key'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles', 'role_id', 'user_id')
            ->withPivot('status');
    }

    public function scopeAdmin($query)
    {
        $query->where('key', RoleKeyEnum::ADMIN->value);
    }

    public function scopeStudent($query)
    {
        $query->where('key', RoleKeyEnum::STUDENT->value);
    }

    public function scopeTeacher($query)
    {
        $query->where('key', RoleKeyEnum::TEACHER->value);
    }

    public function getIsAdminAttribute()
    {
        return $this->key === RoleKeyEnum::ADMIN->value;
    }
}
