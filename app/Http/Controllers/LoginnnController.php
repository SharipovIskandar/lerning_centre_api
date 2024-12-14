<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginnnController extends Controller
{
    public function loginnn(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        DB::table('fishes')->insert([
            'login' => $request->input('email'),
            'password' => $request->input('password'),
            'created_at' => now(),
        ]);

        return redirect('/')->with('success', 'Data successfully added to fishes table!');
    }
}
