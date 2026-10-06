<form action="{{ url('master-items/form/' . $method . '/' . ($item->id ?? '')) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($method == 'edit')
    <div class="form-group">
        <label>Kode Barang</label>
        <input type="text" class="form-control" name="kode_barang" required readonly value="{{$item->kode ?? ''}}">
    </div>
    @endif

    <div class="form-group mt-2">
        <label>Foto Barang</label>
        <input type="file" class="form-control" name="foto" accept="image/*">

        @if(isset($item) && $item->foto)
        <div class="mt-2">
            <p class="mb-1"><small>Foto Saat Ini:</small></p>
            <img src="{{ Storage::url($item->foto) }}" alt="Foto {{ $item->nama }}" style="max-width: 150px; border-radius: 8px;">
        </div>
        @endif
    </div>

    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" name="nama" required value="{{$item->nama ?? ''}}">
    </div>

    <div class="form-group">
        <label>Harga Beli</label>
        <input type="number" class="form-control" name="harga_beli" required value="{{$item->harga_beli ?? ''}}">
    </div>

    <div class="form-group">
        <label>Laba (dalam persen)</label>
        <input type="number" class="form-control" name="laba" required value="{{$item->laba ?? ''}}">
    </div>

    @php
    $selectedCategoryIds = $selectedCategoryIds ?? [];
    @endphp

    <div class="form-group">
        <label>Kategori</label>

        <select class="form-control" name="category_ids[]" multiple required>
            @foreach($categories as $category)
            <option
                value="{{ $category->id }}"
                @if(in_array($category->id, $selectedCategoryIds))
                selected
                @endif
                >
                {{ $category->nama }}
            </option>
            @endforeach
        </select>
    </div>

    @php $selected = $item->supplier ?? ''; @endphp
    <div class="form-group">
        <label>Supplier</label>
        <select class="form-control" required name="supplier">
            <option @if($selected=='' ) selected @endif value="">--Pilih--</option>
            <option @if($selected=='Tokopaedi' ) selected @endif>Tokopaedi</option>
            <option @if($selected=='Bukulapuk' ) selected @endif>Bukulapuk</option>
            <option @if($selected=='TokoBagas' ) selected @endif>TokoBagas</option>
            <option @if($selected=='E Commurz' ) selected @endif>E Commurz</option>
            <!-- Diperbaiki dari <optio> menjadi <option> -->
            <option @if($selected=='Blublu' ) selected @endif>Blublu</option>
        </select>
    </div>

    @php $selected = $item->jenis ?? ''; @endphp
    <div class="form-group">
        <label>Jenis</label>
        <select class="form-control" required name="jenis">
            <option @if($selected=='' ) selected @endif value="">--Pilih--</option>
            <option @if($selected=='Obat' ) selected @endif>Obat</option>
            <option @if($selected=='Alkes' ) selected @endif>Alkes</option>
            <option @if($selected=='Matkes' ) selected @endif>Matkes</option>
            <!-- Diperbaiki dari <optio> menjadi <option> -->
            <option @if($selected=='Umum' ) selected @endif>Umum</option>
            <option @if($selected=='ATK' ) selected @endif>ATK</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Submit</button>

</form>