<?php

namespace App\Http\Controllers;

use App\Models\MasterItem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Category;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MasterItemsExportExcel;

class MasterItemsController extends Controller
{
    public function index()
    {
        return view('master_items.index.index');
    }

    public function search(Request $request)
    {
        $data_search = MasterItem::query();

        if ($request->filled('kode')) {
            $data_search->where('kode', $request->kode);
        }

        if ($request->filled('nama')) {
            $data_search->where('nama', 'LIKE', '%' . $request->nama . '%');
        }

        if ($request->filled('hargamin')) {
            $data_search->where('harga_beli', '>=', $request->hargamin);
        }

        if ($request->filled('hargamax')) {
            $data_search->where('harga_beli', '<=', $request->hargamax);
        }

        $data = $data_search
            ->select('kode', 'nama', 'jenis', 'harga_beli', 'laba', 'supplier', 'img')
            ->orderBy('id')
            ->get();

        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }


    public function formView($method, $id = 0)
    {
        if ($method == 'new') {
            $item = [];
        } else {
            $item = MasterItem::find($id);
        }
        $data['item'] = $item;
        $data['method'] = $method;
        $data['categories'] = Category::all();
        return view('master_items.form.index', $data);
    }

    public function singleView($kode)
    {
        $data['data'] = MasterItem::where('kode', $kode)->first();
        return view('master_items.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        if ($method == 'new') {
            $data_item = new MasterItem;
            $kode = MasterItem::count('id');
            $kode = $kode + 1;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
            sleep(3);
        } else {
            $data_item = MasterItem::find($id);
            $kode = $data_item->kode;
        }

        if ($request->hasFile('img')) {

            // hapus gambar lama saat edit
            if ($method != 'new' && $data_item->img) {
                Storage::disk('public')->delete($data_item->img);
            }

            $path = $request->file('img')->store('master-items', 'public');
            $data_item->img = $path;
        }

        $data_item->nama = $request->nama;
        $data_item->harga_beli = $request->harga_beli;
        $data_item->laba = $request->laba;
        $data_item->kode = $kode;
        $data_item->supplier = $request->supplier;
        $data_item->jenis = $request->jenis;
        $data_item->save();

        if($request->has('categories')){
            $data_item->categories()->sync($request->categories);
        } else {
            $data_item->categories()->sync([]);
        }

        return redirect('master-items');
    }

    public function delete($id)
    {
        MasterItem::find($id)->delete();
        return redirect('master-items');
    }

    public function updateRandomData()
    {
        $data = MasterItem::get();
        foreach($data as $item)
        {
            $kode = $item->id;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

            $item->harga_beli = rand(100,1000000);
            $item->laba = rand(10,99);
            $item->kode = $kode;
            $item->supplier = $this->getRandomSupplier();
            $item->jenis = $this->getRandomJenis();
            $item->save();
        }
    }

    private function getRandomSupplier()
    {
        $array = ['Tokopaedi','Bukulapuk','TokoBagas','E Commurz','Blublu'];
        $random = rand(0,4);
        return $array[$random];
    }

    private function getRandomJenis()
    {
        $array = ['Obat','Alkes','Matkes','Umum','ATK'];
        $random = rand(0,4);
        return $array[$random];
    }
    public function exportExcel()
    {
        return Excel::download(new MasterItemsExportExcel, 'master_items.xlsx');
    }
}
