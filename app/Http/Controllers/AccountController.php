<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    //This is Register Function
    public function registrationPage()
    {
        return view('front.account.registration');
    }

    public function processRgistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|same:confirm_password',
            'confirm_password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false,'errors' => $validator->errors(),404]);
        }
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
        return response()->json(['status' => true,'message' => 'Registration successful!',200]);
    }

    
}
