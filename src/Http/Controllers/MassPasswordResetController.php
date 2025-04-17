<?php

namespace Rutul\MassUsersPasswordResetHttp\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MassPasswordResetController
{
	public function index()
    {
        return view('mass-password-reset::mass-reset');
    }
}