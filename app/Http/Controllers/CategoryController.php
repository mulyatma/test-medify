<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('category.index');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;

        $data_search = \App\Models\Category::query();

        if (!empty($kode)) {
            $data_search->where('kode', $kode);
        }
        if (!empty($nama)) {
            $data_search->where('nama', 'LIKE', '%' . $nama . '%');
        }

        $data = $data_search->select('id', 'kode', 'nama')->orderBy('id')->get();

        return json_encode([
            'status' => 200,
            'data' => $data
        ]);
    }

    public function formView($method, $id = 0)
    {
        if ($method == 'new') {
            $category = new \App\Models\Category;
        } else {
            $category = \App\Models\Category::findOrFail($id);
        }

        return view('category.form.index', compact('category', 'method'));
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        $request->validate([
            'kode' => 'required|max:20|unique:categories,kode,' . ($method == 'edit' ? $id : ''),
            'nama' => 'required|string|max:255',
        ]);

        if ($method == 'new') {
            $category = new \App\Models\Category;
        } else {
            $category = \App\Models\Category::findOrFail($id);
        }

        $category->kode = $request->kode;
        $category->nama = $request->nama;
        $category->save();

        return redirect()->route('category.index')->with('success', 'Category saved successfully.');
    }

    public function delete($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Category deleted successfully.');
    }

    public function singleView($id)
    {
        $category = \App\Models\Category::with('masterItems')->findOrFail($id);
        return view('category.single', compact('category'));
    }

    public function printView($id)
    {
        $category = \App\Models\Category::with('masterItems')->findOrFail($id);

        $pdf = Pdf::loadView('category.pdf', compact('category'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('category.pdf');
    }
}
