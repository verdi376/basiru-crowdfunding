
<div class="mb-3">
    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $portofolio->nama_lengkap ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $portofolio->tempat_lahir ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $portofolio->tanggal_lahir ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
        <option value="">-- Pilih -- </option>
        <option value="Laki-laki" {{ old('jenis_kelamin', $portofolio->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
        <option value="Perempuan" {{ old('jenis_kelamin', $portofolio->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
    </select>
</div>

<div class="mb-3">
    <label for="no_telepon" class="form-label">No Telepon</label>
    <input type="text" name="no_telepon" id="no_telepon" class="form-control" value="{{ old('no_telepon', $portofolio->no_telepon ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="alamat" class="form-label">Alamat</label>
    <textarea name="alamat" id="alamat" class="form-control" required>{{ old('alamat', $portofolio->alamat ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="pekerjaan" class="form-label">Pekerjaan</label>
    <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" value="{{ old('pekerjaan', $portofolio->pekerjaan ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="penghasilan" class="form-label">Penghasilan (Rp)</label>
    <input type="number" name="penghasilan" id="penghasilan" class="form-control" value="{{ old('penghasilan', $portofolio->penghasilan ?? '') }}" required>
</div>
