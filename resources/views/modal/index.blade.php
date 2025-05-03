@extends('layouts.main')

@section('content')
<h2>Data Modal</h2>
<a href="{{ route('modal.create') }}">+ Tambah Modal</a>

<table border="1" cellpadding="10">
    <tr>
        <th>Jumlah</th>
        <th>Keterangan</th>
        <th>Tanggal</th>
    </tr>
    @foreach($modals as $modal)
    <tr>
        <td>Rp {{ number_format($modal->amount, 0, ',', '.') }}</td>
        <td>{{ $modal->description }}</td>
        <td>{{ $modal->date }}</td>
    </tr>
    @endforeach
</table>
@endsection