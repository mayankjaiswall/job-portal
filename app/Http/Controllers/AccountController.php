<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        $id = auth()->user()->id;
        $user = User::where('id', $id)->first();
        return view('front.account.profile',['user'=>$user]);
    }

    //This is Edit Profile Function 
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'designation' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:20',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        $user->update($request->only('name','email','designation','mobile'));
        session()->flash('success', 'Profile updated successfully!');
        return response()->json(['status' => true]);
    }

    //This is Change Password Function
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false,'errors' => $validator->errors()], 422);
        }
        $user = auth()->user();
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['status' => false,'errors' => ['old_password' => ['Old password does not match']]], 422);
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        return response()->json(['status' => true,'message' => 'Password updated successfully!']);
    }
    
    //This is Profile Picture Update Function
    public function profilePicUpdate(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        $user = Auth::user();
        if ($user->image && file_exists(public_path($user->image))) {
            unlink(public_path($user->image));
        }
        $fileName = time() . '.' . $request->image->extension();
        $filePath = 'uploads/profile/' . $fileName;
        $request->image->move(public_path('uploads/profile'), $fileName);
        $user->image = $filePath;
        $user->save();

        return back()->with('success', 'Profile picture updated successfully!');
    }

    //This is Logout Function
    public function logout()
    {
        auth()->logout();
        return redirect()->route('account.login');
    }
}
