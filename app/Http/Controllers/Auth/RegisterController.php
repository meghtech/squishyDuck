<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Customer;
use App\Models\Seller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'user_name' => ['required', 'string', 'max:20','unique:customers','unique:sellers'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {


        if ($data['role'] == 'buyer') {

            $data =  Customer::create([
                'name' => $data['name'],
                'user_name' => $data['user_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'remember_token' => Str::random(10),
             ]);

            User::insert([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone_number' => '8564',
                'password' => Hash::make($data['password']),
                'customer_id' => $data['id'],
                'seller_id' => $data['id'],  //optional as it is a customer
                'remember_token' => Str::random(10),
            ]); 

           return $data;

        }
        else{

            $data =  Seller::create([
                'name' => $data['name'],
                'user_name' => $data['user_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'remember_token' => Str::random(10),
             ]);
            // $sellerID = $seller->id;
            User::insert([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone_number' => '8564',
                'password' => Hash::make($data['password']),
                'seller_id' => $data['id'],
                'customer_id' => $data['id'], // optional as it is a seller
                'remember_token' => Str::random(10),
            ]); 
            return $data;
            // return redirect()->route('seller.dashboard');

        }
        
    }
}
