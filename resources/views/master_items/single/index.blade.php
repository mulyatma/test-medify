@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="form-group mb-2">
                <a href="{{url('master-items')}}" class="btn btn-secondary">Kembali ke Daftar Item</a>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Detail Master Item: {{ $data->kode }}</h5>
                </div>

                <div class="card-body">
                    <div class="row">

                        <div class="col-md-4 text-center mb-4 mb-md-0">
                            @if($data->foto && \Storage::exists($data->foto))
                            <img src="{{ \Storage::url($data->foto) }}" alt="Foto {{ $data->nama }}" class="img-fluid rounded shadow-sm" style="max-height: 250px; object-fit: cover;">
                            @else
                            <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 200px; border: 2px dashed #ccc;">
                                <span class="text-muted">Tidak ada foto</span>
                            </div>
                            @endif
                        </div>

                        <div class="col-md-8">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <th width="30%">Nama</th>
                                    <td width="2%">:</td>
                                    <td>{{$data->nama}}</td>
                                </tr>
                                <tr>
                                    <th>Harga Beli</th>
                                    <td>:</td>
                                    <td>Rp {{ number_format($data->harga_beli, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Laba</th>
                                    <td>:</td>
                                    <td>{{$data->laba}}%</td>
                                </tr>
                                <tr>
                                    <th>Harga Jual</th>
                                    <td>:</td>
                                    <td class="text-success fw-bold">Rp {{ number_format($data->harga_beli + ($data->harga_beli * $data->laba / 100), 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Supplier</th>
                                    <td>:</td>
                                    <td>{{$data->supplier}}</td>
                                </tr>
                                <tr>
                                    <th>Jenis</th>
                                    <td>:</td>
                                    <td>
                                        <span class="badge bg-info text-dark">{{$data->jenis}}</span>
                                    </td>
                                </tr>
                            </table>

                            <div class="mt-4 border-top pt-3">
                                <a class="btn btn-warning" href="{{url('master-items/form/edit')}}/{{$data->id}}">Edit Data</a>

                                <form action="{{ url('/master-items/delete/' . $data->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data beserta fotonya?')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@endsection