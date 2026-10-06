<?php

namespace App\Http\Controllers;

use App\Exports\MasterItemsExport;
use App\Models\MasterItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class MasterItemsController extends Controller
{
    public function index()
    {
        return view('master_items.index.index');
    }

    public function downloadExcel()
    {
        return Excel::download(new MasterItemsExport, 'master_items.xlsx');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;
        $hargamin = $request->hargamin;
        $hargamax = $request->hargamax;

        $data_search = MasterItem::query();

        if (!empty($kode)) $data_search = $data_search->where('kode', $kode);
        if (!empty($nama)) $data_search = $data_search->where('nama', 'LIKE', '%' . $nama . '%');
        if ($hargamin != '') {
            $data_search->where('harga_beli', '>=', $hargamin);
        }
        if ($hargamax != '') {
            $data_search->where('harga_beli', '<=', $hargamax);
        }
        $data_search = $data_search->select('kode', 'nama', 'jenis', 'harga_beli', 'laba', 'supplier')->orderBy('id')->get();


        return json_encode([
            'status' => 200,
            'data' => $data_search
        ]);
    }

    public function formView($method, $id = 0)
    {
        if ($method == 'new') {
            $item = new MasterItem;
        } else {
            $item = MasterItem::with('category')->findOrFail($id);
        }
        $data['item'] = $item;
        $data['method'] = $method;
        $data['categories'] = \App\Models\Category::all();
        $data['selectedCategoryIds'] = $method == 'edit' ? $item->category->pluck('id')->toArray() : [];
        return view('master_items.form.index', $data);
    }

    public function singleView($kode)
    {
        $data['data'] = MasterItem::where('kode', $kode)->first();
        return view('master_items.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        $request->validate([
            'nama' => 'required',
            'harga_beli' => 'required|numeric',
            'laba' => 'required|numeric',
            'supplier' => 'required',
            'jenis' => 'required',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'nullable|exists:categories,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($method == 'new') {
            $data_item = new MasterItem;

            $lastId = MasterItem::max('id') ?? 0;
            $kodeAngka = $lastId + 1;
            $kode = str_pad($kodeAngka, 5, '0', STR_PAD_LEFT);
        } else {
            $data_item = MasterItem::findOrFail($id);
            $kode = $data_item->kode;
        }

        $data_item->nama = $request->nama;
        $data_item->harga_beli = $request->harga_beli;
        $data_item->laba = $request->laba;
        $data_item->kode = $kode;
        $data_item->supplier = $request->supplier;
        $data_item->jenis = $request->jenis;

        if ($request->hasFile('foto')) {
            if ($data_item->foto && Storage::exists($data_item->foto)) {
                Storage::delete($data_item->foto);
            }
            $path = $request->file('foto')->store('public/barang');

            $data_item->foto = $path;
        }

        $data_item->save();

        $categoryIds = $request->input('category_ids', []);
        $data_item->category()->sync($categoryIds);

        return redirect('master-items')->with('success', 'Data berhasil disimpan');
    }

    public function delete($id)
    {
        $item = MasterItem::findOrFail($id);
        if ($item->foto && Storage::exists($item->foto)) {
            Storage::delete($item->foto);
        }
        $item->delete();
        return redirect('master-items');
    }

    public function updateRandomData()
    {
        $data = MasterItem::get();
        foreach ($data as $item) {
            $kode = $item->id;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

            $item->harga_beli = rand(100, 1000000);
            $item->laba = rand(10, 99);
            $item->kode = $kode;
            $item->supplier = $this->getRandomSupplier();
            $item->jenis = $this->getRandomJenis();
            $item->save();
        }
    }

    private function getRandomSupplier()
    {
        $array = ['Tokopaedi', 'Bukulapuk', 'TokoBagas', 'E Commurz', 'Blublu'];
        $random = rand(0, 4);
        return $array[$random];
    }

    private function getRandomJenis()
    {
        $array = ['Obat', 'Alkes', 'Matkes', 'Umum', 'ATK'];
        $random = rand(0, 4);
        return $array[$random];
    }
}
