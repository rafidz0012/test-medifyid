<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\MasterItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        return view('categories.index.index');
    }

    public function search (Request $request)
    {
        $data_search = Category::query();

        if ($request->filled('kode')) {
            $data_search->where('kode', $request->kode);
        }

        if ($request->filled('nama')) {
            $data_search->where('nama', 'LIKE', '%' . $request->nama . '%');
        }

        $data = $data_search
            ->select('id', 'kode', 'nama')
            ->orderBy('id')
            ->get();

        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }
    public function formview($method, $id = 0)
    {
        if ($method == 'new') {
            $category = new Category();
        } else {
            $category = Category::find($id);
        }
        $data['category'] = $category;
        $data['method'] = $method;
        return view('categories.form.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        if ($method == 'new') {
            $category = new Category;
        } else {
            $category = Category::findOrFail($id);
        }

        $request->validate([
            'kode' => 'required|unique:categories,kode,' . ($method == 'edit' ? $id : ''),
            'nama' => 'required'
        ]);

        $category->kode = $request->kode;
        $category->nama = $request->nama;
        $category->save();
        return redirect('categories')->with('success', 'Kategori berhasil disimpan');
    }
    public function singleView($id)
    {
        $category = Category::with('masterItems')->findOrFail($id);
        return view('categories.single.index', compact('category'));
    }
    public function destroy($id)
    {
        Category::findOrFail($id)->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
    public function print($id){
        $category = Category::with('masterItems')->findOrFail($id);
        $printedAt = Carbon::now()->format('d M Y H:i:s');
        $pdf = Pdf::loadView('categories.print', compact('category', 'printedAt'));
        $tanggal = Carbon::now()->format('Y-m-d_H-i-s');
        return $pdf->download('category_'.$category->kode.'_'.$tanggal.'.pdf');
    }
}
