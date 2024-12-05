<?php

namespace App\Services\User\Contracts;

use Illuminate\Http\Request;

interface iUserService
{
    public function filter(Request $request);
    public function store(Request $request);
}
