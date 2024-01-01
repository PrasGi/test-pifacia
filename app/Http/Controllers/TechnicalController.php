<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\History;
use App\Models\Technical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TechnicalController extends Controller
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
        if ($request->has('search')) {
            $datas = Technical::where('title', 'LIKE', '%' . $request->search . '%')->where('user_id', auth()->user()->id)->get();
        } else {
            $datas = Technical::where('user_id', auth()->user()->id)->get();
        }

        $categories = Category::all();
        return view('pages.technical', compact(['datas', 'categories']));
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
            'title' => 'required|string',
            'description' => 'required|string',
            'file' => 'required|file|mimes:pdf|max:500|min:100',
            'tags' => 'required|array',
            'category_id' => 'required|exists:categories,id',
        ]);

        $payload['file'] = $request->file('file')->store('files');
        $payload['tags'] = json_encode($payload['tags']);
        $payload['user_id'] = auth()->user()->id;

        if (Technical::create($payload)) {
            $this->historyModel->addHistory([
                'type' => 'technical',
                'action' => 'Create',
                'note' => 'Create new technical ' . $payload['title'],
                'user_id' => auth()->user()->id,
            ]);
            return redirect()->back()->with('success', 'Technical added successfully');
        }

        return redirect()->back()->withErrors(['error' => 'Technical failed to add']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Technical $technical)
    {
        $technical->tags = json_decode($technical->tags, true);
        return view('pages.technical-detail', compact('technical'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Technical $technical)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $payload = $request->validate([
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf|max:500|min:100',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $technical = Technical::find($request->id);

        if ($request->has('file')) {
            Storage::delete($technical->file);
            $payload['file'] = $request->file('file')->store('files');
        }

        if ($technical->update($payload)) {
            $this->historyModel->addHistory([
                'type' => 'technical',
                'action' => 'Update',
                'note' => 'Update technical ' . $technical->title,
                'user_id' => auth()->user()->id,
            ]);
            return redirect()->back()->with('success', 'Technical updated successfully');
        }

        return redirect()->back()->withErrors(['failed' => 'Technical failed to update']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Technical $technical)
    {
        Storage::delete($technical->file);
        if ($technical->delete()) {
            $this->historyModel->addHistory([
                'type' => 'technical',
                'action' => 'Delete',
                'note' => 'Delete technical ' . $technical->title,
                'user_id' => auth()->user()->id,
            ]);
            return redirect()->back()->with('success', 'Technical deleted successfully');
        }

        return redirect()->back()->withErrors(['failed' => 'Technical failed to delete']);
    }

    function changeStatus(Technical $technical)
    {
        $technical->enable = !$technical->enable;
        $technical->save();
        $this->historyModel->addHistory([
            'type' => 'technical',
            'action' => 'Update',
            'note' => 'Change status technical ' . $technical->title,
            'user_id' => auth()->user()->id,
        ]);
        return redirect()->back()->with('success', 'Technical status changed successfully');
    }

    function downloadFile(Technical $technical)
    {
        $filePath = storage_path("app/public/{$technical->file}");

        // Mendapatkan ekstensi file dari path
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

        // Tentukan tipe konten sesuai dengan ekstensi file
        $contentType = mime_content_type($filePath);

        // Atur header sesuai dengan tipe konten
        $headers = [
            'Content-Type' => $contentType,
        ];

        $this->historyModel->addHistory([
            'type' => 'technical',
            'action' => 'Download',
            'note' => 'Download technical ' . $technical->title,
            'user_id' => auth()->user()->id,
        ]);
        return response()->download($filePath, $technical->title . '.' . $extension, $headers);
    }
}