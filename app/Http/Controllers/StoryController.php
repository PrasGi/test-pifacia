<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\History;
use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    private $historyModel;
    function __construct()
    {
        $this->historyModel = new History();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $datas = Story::query();

        if (request()->has('search')) {
            $datas = $datas->where('title', 'like', '%' . request('search') . '%');
        }

        if ($request->has('by')) {
            if ($request->by == 'owned') {
                $datas = $datas->where('user_id', $request->category);
            } else if ($request->by == 'except me') {
                $datas = $datas->where('user_id', '!=', auth()->user()->id);
            }
        }

        $datas = $datas->orderBy('created_at', 'desc')->get();

        $categories = Category::all();
        return view('pages.story', compact(['datas', 'categories']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $payload = $request->validate([
            'type' => 'story',
            'title' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
        ]);

        $payload['user_id'] = auth()->user()->id;

        if (Story::create($payload)) {
            $this->historyModel->addHistory([
                'action' => 'Create',
                'note' => 'Create new story ' . $payload['title'],
                'user_id' => auth()->user()->id,
            ]);
            return redirect()->back()->with('success', 'Story created successfully');
        }

        return redirect()->back()->withErrors(['failed' => 'Failed to create story']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Story $story)
    {
        return view('pages.story-detail', compact('story'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Story $story)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $payload = $request->validate([
            'type' => 'story',
            'title' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
        ]);

        $story = Story::find($request->id);

        if ($story->update($payload)) {
            $this->historyModel->addHistory([
                'action' => 'Update',
                'note' => 'Update story ' . $story->title,
                'user_id' => auth()->user()->id,
            ]);
            return redirect()->back()->with('success', 'Story updated successfully');
        }

        return redirect()->back()->withErrors(['failed' => 'Failed to update story']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Story $story)
    {
        if ($story->delete()) {
            $this->historyModel->addHistory([
                'type' => 'story',
                'action' => 'Delete',
                'note' => 'Delete story ' . $story->title,
                'user_id' => auth()->user()->id,
            ]);
            return redirect()->back()->with('success', 'Story deleted successfully');
        }

        return redirect()->back()->withErrors(['failed' => 'Failed to delete story']);
    }
}