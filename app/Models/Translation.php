<?php

namespace App\Models;

use App\Traits\Scopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasFactory, Scopes;

    protected $hidden = [
        'field_id',
        'table_name',
        'updated_at',
        'created_at',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'table_name',
        'field_name',
        'field_id',
        'field_value',
        'language_url',
    ];
}
