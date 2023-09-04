<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function register(Request $request) {
        /** 
        $incomingFields = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]); */

        // More specific validation
        // Laravel can check in db if any of those values are unique by calling Rule::unique(table, field)
        $incomingFields = $request->validate([
            'name' => ['required', 'min:3', 'max:10', Rule::unique('users', 'name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'max:200']
        ]);

        // Hash the user's password
        $incomingFields['password'] = bcrypt($incomingFields['password']); // laravel has bcrypt dependency

        // By default, Laravel already has a User model
        // Create an instance of a User
        $user = User::create($incomingFields);

        // Call the globally available auth() utility function, and look inside it for the login() method
        auth()->login($user);

        // redirect to the homepage URL
        return redirect('/');
    }

    public function logout() {
        // call the globally available function auth(), then call the logout() method
        auth()->logout();
        return redirect('/');
    }

    public function login(Request $request) {
        $incomingFields = $request->validate([
            'loginname' => 'required',
            'loginpassword' => 'required'
        ]);

        // Check when attempting to login
        if (auth()->attempt(['name' => $incomingFields['loginname'], 'password' => $incomingFields['loginpassword']])) {

            // if credentials are right, create session
            $request->session()->regenerate();
        }

        return redirect('/');
    }
}
