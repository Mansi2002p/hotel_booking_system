<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Models\Country;
use App\Mail\PasswordChangedNotification;
class DashboardController extends Controller
{
    //
    public function index()
    {
        return view('web.customer.index');
    }
    public function profile()
    {
        $user = Auth::user(); // Get the logged-in user
        $countries = Country::all();
        return view('web.customer.profile', compact('user','countries')); // Pass the user to the profile view
    }

    // Update Profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

       
    // Validate input
    $request->validate([
        'fname' => 'required|string|max:255',
        'lname' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'moblieno' => 'required|string|max:15',
        'address' => 'nullable|string|max:255',
        'zipcode' => 'nullable|string|max:10',
        // 'country' => 'required|exists:countries,id',
        // 'state' => 'required|exists:states,id',
        // 'city' => 'required|exists:cities,id',
    ]);

    // Update user details
    $user->first_name = $request->fname;
    $user->last_name = $request->lname;
    $user->email = $request->email;
    $user->moblieno = $request->moblieno;
    $user->address = $request->address;
    $user->zipcode = $request->zipcode;
    // $user->country = $request->country;
    // $user->state = $request->state;
    // $user->city = $request->city;
    
    $user->save();

        return redirect()->route('web.home')->with('success', 'Profile updated successfully.');
    }
    public function password()
    {
        $user = Auth::user(); // Get the logged-in user
        return view('web.customer.changepassword', compact('user')); // Pass the user to the profile view
    }



    public function changePassword(Request $request)
    {
        $user = Auth::user(); // Get the currently authenticated user
    
        // Validate the request
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);
    
        // Check if the current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }
    
        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();

          // Send notification email
        Mail::to($user->email)->send(new PasswordChangedNotification($user));
    
        // Log out the user
        Auth::logout();
    
        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        // Redirect to the login page with a success message
        return redirect()->route('login')->with('success', 'Password changed successfully! Please log in again.');
    }
    
}
