<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $historyModel;
    function __construct()
    {
        $this->historyModel = new History();
    }

    function login(Request $request)
    {
        $payload = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($payload)) {
            return redirect()->route('dashboard');
        }

        return redirect()->back()->withErrors([
            'failed' => 'Email or password is not correct, please login again',
        ]);
    }

    function register(Request $request)
    {
        $payload = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role_id' => 'required',
        ]);

        $payload['password'] = bcrypt($payload['password']);

        User::create($payload);
        $this->historyModel->addHistory([
            'type' => 'etc',
            'action' => 'Create',
            'note' => 'Create new account ' . $payload['name'],
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->back()->with('success', 'Success create new account');
    }

    function logout()
    {
        auth()->logout();

        return redirect()->back();
    }
}