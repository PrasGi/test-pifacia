<?php

namespace App\Http\Controllers;

use App\Exports\CategoryExport;
use App\Imports\CategoryImport;
use App\Models\Category;
use App\Models\History;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
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
            $datas = Category::where('name', 'LIKE', '%' . $request->search . '%')->get();
        } else {
            $datas = Category::all();
        }

        return view('pages.category', compact('datas'));
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
            'name' => 'required|string|max:255',
        ]);

        if (Category::create($payload)) {
            $this->historyModel->addHistory([
                'type' => 'category',
                'action' => 'Create',
                'note' => 'Create new category ' . $payload['name'],
                'user_id' => auth()->user()->id,
            ]);
            return redirect()->back()->with('success', 'Category created successfully');
        } else {
            return redirect()->back()->withErrors(['error' => 'Category failed to create']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $payload = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::find($request->id);
        $category->name = $request->name;

        if ($category->update($payload)) {
            $this->historyModel->addHistory([
                'type' => 'category',
                'action' => 'Update',
                'note' => 'Update category ' . $payload['name'],
                'user_id' => auth()->user()->id,
            ]);
            return redirect()->back()->with('success', 'Category updated successfully');
        } else {
            return redirect()->back()->withErrors(['error' => 'Category failed to update']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->delete()) {
            $this->historyModel->addHistory([
                'type' => 'category',
                'action' => 'Delete',
                'note' => 'Delete category ' . $category->name,
                'user_id' => auth()->user()->id,
            ]);
            return redirect()->back()->with('success', 'Category deleted successfully');
        } else {
            return redirect()->back()->withErrors(['error' => 'Category failed to delete']);
        }
    }

    function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new CategoryImport, $request->file('file'));
        $this->historyModel->addHistory([
            'type' => 'category',
            'action' => 'Create',
            'note' => 'Import category using importer',
            'user_id' => auth()->user()->id,
        ]);
        return redirect()->back()->with('success', 'Category imported successfully');
    }

    function export()
    {
        return Excel::download(new CategoryExport, 'category.xlsx');
    }
}