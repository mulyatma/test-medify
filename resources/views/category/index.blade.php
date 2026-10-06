@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Data Kategori</h2>
        <a href="{{ url('/categories/form/new') }}" class="btn btn-success">+ Tambah Kategori</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-3">
        <div class="card-body" id="filter-container">
            <h5 class="card-title">Filter Data</h5>
            <div class="row">
                <div class="col-md-5 form-group">
                    <label>Kode Kategori</label>
                    <input type="text" class="form-control" id="filter-kode" placeholder="Cari kode...">
                </div>
                <div class="col-md-5 form-group">
                    <label>Nama Kategori</label>
                    <input type="text" class="form-control" id="filter-nama" placeholder="Cari nama...">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100 btn-get-data">Filter</button>
                </div>
            </div>
            <span id="loading-filter" style="display: none;" class="mt-2 text-primary">Memuat data...</span>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="table-kategori">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode Kategori</th>
                            <th>Nama Kategori</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    // Load data kategori tanpa bergantung pada jQuery
    function loadData() {
        const loading = document.getElementById('loading-filter');
        const tbody = document.querySelector('#table-kategori tbody');
        const kode = document.getElementById('filter-kode').value;
        const nama = document.getElementById('filter-nama').value;

        loading.style.display = 'inline';

        const params = new URLSearchParams({
            kode,
            nama
        });

        fetch(`{{ url('/categories/search') }}?${params.toString()}`)
            .then((response) => response.json())
            .then((res) => {
                let html = '';

                if (res.status == 200 && Array.isArray(res.data) && res.data.length > 0) {
                    res.data.forEach((item, index) => {
                        html += `<tr>
                            <td>${index + 1}</td>
                            <td>${item.kode}</td>
                            <td>${item.nama}</td>
                            <td>
                                <a href="{{ url('/categories/view') }}/${item.id}" class="btn btn-info btn-sm text-white">View</a>
                                <a href="{{ url('/categories/form/edit') }}/${item.id}" class="btn btn-warning btn-sm text-white">Edit</a>

                                <form action="{{ url('/categories/delete') }}/${item.id}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>`;
                    });
                } else {
                    html = `<tr><td colspan="4" class="text-center">Data Kategori Tidak Ditemukan</td></tr>`;
                }

                tbody.innerHTML = html;
                loading.style.display = 'none';
            })
            .catch((error) => {
                console.log(error);
                loading.style.display = 'none';
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        loadData();

        document.querySelector('.btn-get-data').addEventListener('click', function() {
            loadData();
        });
    });
</script>
@endsection