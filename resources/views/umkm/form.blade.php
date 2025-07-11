<div class="mb-3">
    <label for="nama" class="form-label">Nama UMKM</label>
    <input type="text" class="form-control" id="nama" name="nama"
           value="{{ old('nama', $umkm->nama ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="kategori" class="form-label">Kategori</label>
    <select class="form-select" id="kategori" name="kategori" required onchange="toggleKategoriLainnya(this)">
        <option disabled value="">Pilih Kategori</option>
        @php
            $kategoriList = ['Makanan & Minuman', 'Fashion', 'Kerajinan Tangan', 'Teknologi', 'Jasa', 'Pertanian', 'Perdagangan', 'Lainnya'];
            $kategoriTerpilih = old('kategori', $umkm->kategori ?? '');
        @endphp
        @foreach($kategoriList as $kategori)
            <option value="{{ $kategori }}" {{ $kategori == $kategoriTerpilih ? 'selected' : '' }}>
                {{ $kategori }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3" id="kategori-lainnya-field" style="display: none;">
    <label for="kategori_lainnya" class="form-label">Tulis Kategori Lainnya</label>
    <input type="text" class="form-control" id="kategori_lainnya" name="kategori_lainnya"
           value="{{ old('kategori_lainnya') }}">
</div>

<div class="mb-3">
    <label for="deskripsi" class="form-label">Deskripsi</label>
    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi', $umkm->deskripsi ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="lokasi" class="form-label">Lokasi</label>
    <input type="text" class="form-control" id="lokasi" name="lokasi"
           value="{{ old('lokasi', $umkm->lokasi ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="kontak" class="form-label">Kontak</label>
    <input type="text" class="form-control" id="kontak" name="kontak"
           value="{{ old('kontak', $umkm->kontak ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="foto" class="form-label">Foto (opsional)</label>
    <input type="file" class="form-control" id="foto" name="foto">
    @if(isset($umkm) && $umkm->foto)
        <div class="mt-2">
            <img src="{{ asset('storage/' . $umkm->foto) }}" alt="Foto UMKM" width="150" class="rounded shadow-sm">
        </div>
    @endif
</div>

<div class="mb-3">
    <label for="durasi_investasi" class="form-label">Durasi Investasi (bulan)</label>
    <input type="number" min="1" max="60" class="form-control" id="durasi_investasi" name="durasi_investasi"
           value="{{ old('durasi_investasi', $umkm->durasi_investasi ?? 10) }}" required>
</div>
