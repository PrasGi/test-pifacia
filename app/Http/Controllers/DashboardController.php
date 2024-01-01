<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Technical;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function index(Request $request)
    {
        $datas = Technical::query();

        if ($request->has('search')) {
            $datas->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category_id')) {
            if ($request->category_id != 0) {
                $datas->where('category_id', $request->category_id);
            }
        }

        $datas = $datas->where('enable', true)->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        return view('pages.dashboard', compact(['datas', 'categories']));
    }
}