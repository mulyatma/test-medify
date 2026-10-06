@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{ url('/categories') }}" class="btn btn-secondary">Kembali ke Daftar Kategori</a>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ $method == 'new' ? 'Tambah' : 'Edit' }} Kategori</h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="card-body">
                        @include('category.form.form')
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection