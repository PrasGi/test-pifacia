<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    private $historyModel;
    function __construct()
    {
        $this->historyModel = new History();
    }

    function index(Request $request)
    {
        if ($request->has('search')) {
            $datas = User::where('name', 'like', '%' . $request->search . '%')->get();
        } else {
            $datas = User::all();
        }
        $roles = Role::all();
        return view('pages.account', compact(['datas', 'roles']));
    }

    function update(Request $request)
    {
        $payload = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::find($request->id);

        if ($user->update($payload)) {
            $this->historyModel->addHistory([
                'type' => 'etc',
                'action' => 'Update',
                'note' => 'Update account ' . $user->name,
                'user_id' => auth()->user()->id,
            ]);
            return redirect()->back()->with('success', 'Success update account');
        } else {
            return redirect()->back()->withErrors(['failed' => 'Failed update account']);
        }
    }

    function updatePassword(Request $request)
    {
        $payload = $request->validate([
            'password' => 'required|min:8',
        ]);
        $user = User::find($request->id);
        $user->password = bcrypt($payload['password']);

        if ($user->update($payload)) {
            $this->historyModel->addHistory([
                'type' => 'etc',
                'action' => 'Update',
                'note' => 'Update password account ' . $user->name,
                'user_id' => auth()->user()->id,
            ]);
            return redirect()->back()->with('success', 'Success update password');
        } else {
            return redirect()->back()->withErrors(['failed' => 'Failed update password']);
        }
    }

    function destroy(User $user)
    {
        if ($user->delete()) {
            $this->historyModel->addHistory([
                'type' => 'etc',
                'action' => 'Delete',
                'note' => 'Delete account ' . $user->name,
                'user_id' => auth()->user()->id,
            ]);
            return redirect()->back()->with('success', 'Success delete account');
        } else {
            return redirect()->back()->withErrors(['failed' => 'Failed delete account']);
        }
    }
}