<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('pages.dashboard.category', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories', 'name')],
        ]);

        $validated['name'] = trim($validated['name']);

        Category::create($validated);

        return redirect()->route('master.kategori.index')->with('success', 'Kategori baru berhasil ditambahkan.'); // <-- Diubah
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $kategori)
    {
        return response()->json($kategori);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $kategori)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->ignore($kategori->id),
            ],
        ]);

        $validated['name'] = trim($validated['name']);

        $kategori->update($validated);

        return redirect()->route('master.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $kategori)
    {
        $kategori->delete();
        return redirect()->route('master.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
