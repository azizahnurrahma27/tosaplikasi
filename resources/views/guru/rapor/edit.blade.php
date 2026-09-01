<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Rapor</title>
    @include('guru.rapor._styles')
</head>
<body>
<div class="page">

    <a
        href="{{ route('guru.raporsiswa.show', ['idsiswa' => $rapor->idsiswa, 'idkelas' => $rapor->idkelas, 'idta' => $rapor->idta]) }}"
        class="back-link"
    >
        &larr; Kembali
    </a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('guru.raporsiswa.update', $rapor->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('guru.rapor._form', ['jenisRapot' => $jenisRapot, 'rapor' => $rapor])
    </form>

</div>
</body>
</html>