{{--
    Partial form Rapor — dipakai bareng oleh create.blade.php & edit.blade.php.
    Variabel dari controller:
    - $jenisRapot : Collection [{id, nama, semester}]
    - $rapor      : instance Rapor (hanya ada saat mode edit)
    - $siswa      : instance Tsiswa (hanya ada saat mode create)
--}}

@php
    $isEdit = isset($rapor);
    $namaSiswa = $isEdit ? $rapor->siswa->namlen : $siswa->namlen;
@endphp

<div class="title-row">
<h1>{{ $namaSiswa }}</h1></div>

<input type="hidden" name="idsiswa" value="{{ $isEdit ? $rapor->idsiswa : $siswa->id }}">
<input type="hidden" name="idkelas" value="{{ $isEdit ? $rapor->idkelas : $idKelas }}">
<input type="hidden" name="idta"    value="{{ $isEdit ? $rapor->idta : $idTa }}">

<div class="card form-card">

    {{-- Jenis rapor --}}
    <div class="field">
        <label for="idjenisrapot" class="label">Jenis rapor :</label>
        <select name="idjenisrapot" id="idjenisrapot" class="select @error('idjenisrapot') invalid @enderror">
            <option value="">-- Pilih jenis rapor --</option>
            @foreach ($jenisRapot as $jenis)
                <option value="{{ $jenis->id }}" @selected(old('idjenisrapot', $isEdit ? $rapor->idjenisrapot : null) == $jenis->id)>
                    {{ $jenis->nama }} ({{ $jenis->semester }})
                </option>
            @endforeach
        </select>
        @error('idjenisrapot')<div class="error-text">{{ $message }}</div>@enderror
    </div>

    {{-- Tanggal --}}
    <div class="field">
        <label for="tanggal" class="label">Tanggal</label>
        <input
            type="date" name="tanggal" id="tanggal"
            class="input @error('tanggal') invalid @enderror"
            value="{{ old('tanggal', $isEdit ? $rapor->tanggal?->format('Y-m-d') : now()->format('Y-m-d')) }}"
        >
        @error('tanggal')<div class="error-text">{{ $message }}</div>@enderror
    </div>

    {{-- Deskripsi --}}
    <div class="field">
        <label for="deskripsi" class="label">Deskripsi</label>
        <textarea
            name="deskripsi" id="deskripsi"
            class="textarea @error('deskripsi') invalid @enderror"
            placeholder="Tulis deskripsi/catatan rapor di sini..."
        >{{ old('deskripsi', $isEdit ? $rapor->deskripsi : '') }}</textarea>
        @error('deskripsi')<div class="error-text">{{ $message }}</div>@enderror
    </div>

    {{-- Upload rapor --}}
    <div class="field">
        <label for="lampiran" class="label">Upload Rapor</label>
        <div class="upload-box">
            <input type="file" name="lampiran" id="lampiran" accept=".pdf,.jpg,.jpeg,.png">
            <div class="help-text">Format PDF/JPG/JPEG/PNG, maksimal 5MB.</div>

            @if ($isEdit && $rapor->lampiran)
                <div class="upload-current">
                    File saat ini:
                    <a href="{{ Storage::url($rapor->lampiran) }}" target="_blank" rel="noopener">
                        {{ basename($rapor->lampiran) }}
                    </a>
                    — upload file baru untuk mengganti.
                </div>
            @endif
        </div>
        @error('lampiran')<div class="error-text">{{ $message }}</div>@enderror
    </div>

    <div class="actions">
        <a
            href="{{ route('guru.raporsiswa.show', [
                'idsiswa' => $isEdit ? $rapor->idsiswa : $siswa->id,
                'idkelas' => $isEdit ? $rapor->idkelas : $idKelas,
                'idta'    => $isEdit ? $rapor->idta : $idTa,
            ]) }}"
            class="btn btn-ghost"
        >
            Batal
        </a>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>

</div>