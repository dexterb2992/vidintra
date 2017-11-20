<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    public function __construct()
    {
        $this->rules = [
            'name' => 'required|string|max:255',
            'license_key' => 'required'
        ];
    }

    public function index()
    {
        $user = auth()->guard('api')->user()->only('name', 'email', 'license_key');
        return ['form' => $user];
    }

    public function update(Request $request)
    {
        if ($request->has('password') && trim($request->password) != "") {
            $this->rules['password'] = 'required|string|min:6|confirmed';
        }

        $var = $this->validate($request, $this->rules);
        
        $user = auth()->guard('api')->user();
        $user->name = $request->name;

        if (!validateLicense($request->license_key, $user->email)) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'license_key' => ['Invalid license']
                ]
            ], 422);
        }

        $user->license_key = $request->license_key;
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($user->save()) {
            return [
                'success' => 1,
                'message' => 'Profile has been updated successfully.'
            ];
        }

        return [
            'success' => 0,
            'message' => "Something went wrong while trying to update profile information. Please try again later."
        ];
    }
}
