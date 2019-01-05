<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;

class UserController extends Controller
{

    public function login() {

    	$credentials = request(['email', 'password']);

    	if (Auth::attempt($credentials)) {

            $success['user'] = Auth::user()->name;
    		$success['token'] = Auth::user()->createToken('MyApp')->accessToken;

    		return compact('success');
    	}

    	return $this->error('Invalid credentials');
    }

    public function register() {

    	$validator = \Validator::make(request()->all(), [
    		'name' => 'required',
    		'email' => 'required|email',
    		'password' => 'required'
    	]);

    	if ($validator->fails()) {
    		return $this->error($validator->errors());
    	}

    	$data = request()->all();
    	$data['password'] = bcrypt($data['password']);

    	$user = User::create($data);

    	$success['token'] = $user->createToken('MyApp')->accessToken;
    	$success['name'] = $user->name;

    	return compact('success');
    }

    public function getDetails() {
    	return ['success' => Auth::user()];
    }

    public function error($data, $statusCode = 403) {
    	return response()->json([
    		'error' => $data
    	], $statusCode);
    }
}
