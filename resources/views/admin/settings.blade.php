<form method="POST" action="{{ route('admin.updateTheme') }}">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="theme">Pilih Tema</label>
        <select name="theme" class="form-control">
            <option value="light" {{ auth()->user()->theme == 'light' ? 'selected' : '' }}>Tema Terang</option>
            <option value="dark" {{ auth()->user()->theme == 'dark' ? 'selected' : '' }}>Tema Gelap</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Simpan Tema</button>
</form>
