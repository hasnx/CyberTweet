<?php

use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:30',
                'unique:users',
                'alpha_dash',
                'not_in:admin,root,system', // Reserved usernames
                'regex:/^[a-zA-Z][a-zA-Z0-9_]*$/' // Must start with a letter
            ],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
}
