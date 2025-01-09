<?php

namespace App\Models;

use App\Traits\HasFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory, hasFile;

    protected $fillable = ['name'];
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

}
