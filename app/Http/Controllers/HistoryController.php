<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    function indexTechnical(Request $request)
    {
        $datas = History::query();

        if ($request->has('search')) {
            $datas = $datas->where('note', 'like', '%' . $request->search . '%');
        }

        $datas = $datas->where('type', 'technical')->get();
        return view('pages.history.technical', compact(['datas']));
    }

    function indexStory(Request $request)
    {
        $datas = History::query();

        if ($request->has('search')) {
            $datas = $datas->where('note', 'like', '%' . $request->search . '%');
        }

        $datas = $datas->where('type', 'story')->get();
        return view('pages.history.story', compact(['datas']));
    }

    function indexCategory(Request $request)
    {
        $datas = History::query();

        if ($request->has('search')) {
            $datas = $datas->where('note', 'like', '%' . $request->search . '%');
        }

        $datas = $datas->where('type', 'category')->get();
        return view('pages.history.category', compact(['datas']));
    }

    function indexEtc(Request $request)
    {
        $datas = History::query();

        if ($request->has('search')) {
            $datas = $datas->where('note', 'like', '%' . $request->search . '%');
        }

        $datas = $datas->where('type', 'etc')->get();
        return view('pages.history.etc', compact(['datas']));
    }
}