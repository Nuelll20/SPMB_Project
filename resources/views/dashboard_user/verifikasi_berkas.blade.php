<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Berkas</title>
</head>
<body>
    <h1>Detail Pendaftaran</h1>

    <h3>Data Anak</h3>
    <p>Nama: {{ $siswa->nama }}</p>
    <p>NIK: {{ $siswa->nik }}</p>
    <p>Agama: {{ $siswa->agama }}</p>
    <p>Status: {{ $siswa->status }}</p>

    <h3>Berkas Upload</h3>

    @forelse($berkas as $file)
        <p>
            {{ $file->jenis_berkas }} -
            <a href="{{ asset('storage/' . $file->file_url) }}" target="_blank">
                Lihat File
            </a>
        </p>
    @empty
        <p>Belum ada berkas yang diupload.</p>
    @endforelse

    <br>
    <a href="{{ route('dashboard') }}">Kembali ke Dashboard</a>
</body>
</html>