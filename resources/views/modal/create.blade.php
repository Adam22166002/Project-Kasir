@extends('layouts.main')

@section('content')
<h2>Tambah Modal</h2>

<form action="{{ route('modal.store') }}" method="POST">
    @csrf
    <label>Jumlah Modal:</label>
    <input type="number" name="amount" required><br>

    <label>Keterangan (opsional):</label>
    <input type="text" name="description"><br>

    <button type="submit">Simpan</button>
</form>
@endsection
