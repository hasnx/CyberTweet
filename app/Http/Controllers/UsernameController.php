<?php

namespace App\Http\Controllers;

use App\Services\UsernameService;
use Illuminate\Http\Request;

class UsernameController extends Controller
{
    protected $usernameService;

    public function __construct(UsernameService $usernameService)
    {
        $this->usernameService = $usernameService;
    }

    public function check(Request $request)
    {
        $username = $request->input('username');

        $errors = $this->usernameService->validateUsername($username);

        if (empty($errors) && !$this->usernameService->isUsernameAvailable($username)) {
            $errors[] = 'This username is already taken.';
        }

        return response()->json([
            'available' => empty($errors),
            'errors' => $errors
        ]);
    }
}
