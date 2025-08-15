<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Contracts\Service\Attribute\Required;
use App\Models\Country;
use Illuminate\Http\JsonResponse;
use App\Models\State;
use App\Models\City;

class AuthController extends Controller
{
    //
    public function getCountries()
    {
        $countries = Country::all(["name", "id"]);
        // dd($countries);
        return response()->json(['countries' => $countries]);
    }
 
    public function showRegisterForm()
    {
        $countries = Country::all(["name", "id"]);
        return view('backend.auth.register', compact('countries'));
    }
   
    
  

    public function fetchStates(Request $request): JsonResponse
    {
        $states = State::where("country_id", $request->country_id)->get(["name", "id"]);
        return response()->json(["states" => $states]);
    }
    
    public function fetchCity(Request $request): JsonResponse
    {
        // Fetch cities based on the selected state
        $cities = City::where("state_id", $request->state_id)->get(["name", "id"]);
        return response()->json(["cities" => $cities]);
    }


    // Handle the registration logic
    public function register(Request $request)
    {
     
        
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            $user->moblieno = $request->moblieno;
            $user->address = $request->address;
            $user->country = $request->country;
            // dd($user);

            $user->state = $request->state;
            $user->city = $request->city;
            $user->zipcode = $request->zipcode;
            $user->role = $request->role;
            $user->save();
            return redirect()->route('web.home')->with('success', 'User successfully registered.');
      
      
    }


    public function showLogin(){
        return view('backend.auth.login');
    }

    public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|string',
    ]);


    if ($validator->fails()) {
        return redirect()->route('login')->withInput()->withErrors($validator);
    }

    // Attempt to log the user in
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        // Get the authenticated user
        $user = Auth::user();

        // dd($request->all());
        // Check the user's role and redirect accordingly
        if ($user->role == 'hotel_owner') {
            return redirect()->route('owner.dashboard');
        } elseif ($user->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role == 'customer') {
            if ($request->has('room_set')) {
                return redirect()->route('web.rooms'); // Redirect to room list page
            } else {
                return redirect()->route('web.home'); // Default redirect for customers
            }
        }
    } else {
        return redirect()->route('login')->with('error', 'Invalid login credentials');
    }
}

public function logout(){
    Auth::logout();
    return redirect()->route('login');
}

  
}

