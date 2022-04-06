<?php

use Illuminate\Support\Facades\Validator;

function userValidation($req) {
    $msg = [
        'name.required' => 'Please input your name',
        'email.required' => 'Please Input your email',
        'email.unique' => 'Email is already registered',
        'password.required' => 'Please input your password',
        'password.min' => "Password must be 8 character",
        'password.confirmed' => "Password confirm not be empty please input the password",
        'password.regex' => "Passwords must use numbers and contain capitals"
    ];

    $validated = Validator::make($req, [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => [
            'required',
            'confirmed',
            'string',
            'min:8',             // must be at least 10 characters in length
            'regex:/[a-z]/',      // must contain at least one lowercase letter
            'regex:/[A-Z]/',      // must contain at least one uppercase letter
            'regex:/[0-9]/',      // must contain at least one digit
        ]
    ],$msg);
    return $validated;
}

function productValidation($req) {
    $validated = Validator::make($req, [
        'title' => 'required',
        'category' => 'required',
        'price' => 'required|numeric',
    ]);
    return $validated;
}
