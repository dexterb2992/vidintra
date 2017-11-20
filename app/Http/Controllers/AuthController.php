<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('logout');
    }

    public function register(Request $request)
    {

        $this->data = $request->all();

        $validator = Validator::make($this->data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'license_key' => 'required'
        ]);

        $validator->after(function ($validator) {
            if (!validateLicense($this->data['license_key'], $this->data['email'])) {
                $validator->errors()->add('license_key', "Invalid license.");
            }
        });

        if ($validator->fails()) {
            return response()
                ->json($validator->errors(), 422);
        }

        $user = new User($request->all());
        $user->password = bcrypt($request->password);
        $user->save();

        return response()
            ->json([
                'registered' => true
            ]);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|between:6,25'
        ]);

        $user = User::where('email', $request->email)
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // generate new api token
            $user->api_token = str_random(60);
            $user->save();

            return response()
                ->json([
                    'user_name' => $user->name,
                    'authenticated' => true,
                    'api_token' => $user->api_token,
                    'user_id' => $user->id
                ]);
        }

        return response()
            ->json([
                'email' => ['Provided email and password does not match!']
            ], 422);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->api_token = null;
        $user->save();

        return response()
            ->json([
                'done' => true
            ]);
    }

    public function licenseKeyIsValid()
    {
        $client = new \GuzzleHttp\Client();
        $url = 'http://topdogimsolutions.com/licensing/?pl_type=video_intro&licensekey='.$this->data['license_key']
            .'&domainname='.$_SERVER['HTTP_HOST'].'&email='.$this->data['email'];
        $res = $client->request('GET', $url);
        $result = json_decode($res->getBody());
        if ($result->valid == 1) {
            return true;
        }
        
        return false;
    }
}
