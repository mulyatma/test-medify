@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="form-group mb-2">
                <a href="{{ url('/kategori') }}" class="btn btn-secondary">Kembali ke Daftar Kategori</a>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Kategori: {{ $category->kode }}</h5>
                        <a href="{{ url('/categories/print/' . $category->id) }}"
                            class="btn btn-light btn-sm"
                            target="_blank"
                            rel="noopener noreferrer">
                            Download PDF
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-borderless table-sm w-75">
                        <tr>
                            <th width="30%">Kode Kategori</th>
                            <td width="2%">:</td>
                            <td>{{ $category->kode }}</td>
                        </tr>
                        <tr>
                            <th>Nama Kategori</th>
                            <td>:</td>
                            <td>{{ $category->nama }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Item</th>
                            <td>:</td>
                            <td>{{ $category->masterItems->count() }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Daftar Master Item dalam Kategori Ini</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Harga Beli</th>
                                <th>Supplier</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($category->masterItems as $item)
                            <tr>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                                <td>{{ $item->supplier }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada barang di kategori ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection