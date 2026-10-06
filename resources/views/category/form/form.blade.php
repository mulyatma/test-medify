 <form action="{{ url('categories/form/' . $method . '/' . ($category->id ?? '')) }}" method="POST">
     @csrf

     <div class="form-group">
         <label>Kode Kategori</label>
         <input type="text" class="form-control" name="kode" required value="{{ old('kode', $category->kode ?? '') }}" placeholder="Contoh: KAT-001" {{ $method == 'edit' ? 'readonly' : '' }}>
         <small class="text-muted">Kode wajib unik dan tidak dapat diubah setelah dibuat.</small>
     </div>

     <div class="form-group mt-3">
         <label>Nama Kategori</label>
         <input type="text" class="form-control" name="nama" required value="{{ old('nama', $category->nama ?? '') }}" placeholder="Masukkan nama kategori">
     </div>

     <div class="mt-4 border-top pt-3">
         <button type="submit" class="btn btn-primary">Simpan Kategori</button>
         <a href="{{ url('/categories') }}" class="btn btn-secondary">Batal</a>
     </div>
 </form>