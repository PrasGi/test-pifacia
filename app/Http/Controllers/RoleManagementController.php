<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RoleManagementController extends Controller
{
    function index(Request $request)
    {
        if ($request->has('search')) {
            $datas = User::where('name', 'like', '%' . $request->search . '%')->get();
        } else {
            $datas = User::all();
        }

        return view('pages.role-management', compact('datas'));
    }
}