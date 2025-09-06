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

    //This is Process Registration Function
    public function processRgistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|same:confirm_password',
            'confirm_password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        session()->flash('success', 'Registration successful! You can login now.');
        return response()->json([
            'status' => true,
            'redirect' => route('account.registration')
        ]);
    }
    //This is Login Function
    public function loginPage()
    {
        return view('front.account.login');
    }

    //This is Process Login Function
    public function processLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('account.login')->withErrors($validator)->withInput($request->only('email'));
        }
        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('account.profile')->with('success', 'Login successful!');
        } else {
            return redirect()->route('account.login')->withErrors(['email' => 'Invalid email or password'])->withInput($request->only('email'));
        }
    }

    //This is Profile Function
    public function profilePage()
    {
        echo "Profile Page";
    }
}
