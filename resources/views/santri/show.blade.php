@extends('themeketua.default')

@section('title', 'Detail Santri')

@section('content')
<div class="container mt-4">
    <h3>Detail Santri: {{ $santri->nama }}</h3>
    <ul>
        <li>Tempat Lahir: {{ $santri->tempat_lahir }}</li>
        <li>Tanggal Lahir: {{ \Carbon\Carbon::parse($santri->tanggal_lahir)->translatedFormat('d F Y') }}</li>
        <li>Alamat: {{ $santri->alamat }}</li>
        <li>Orang Tua: {{ $santri->nama_ortu }}</li>
        <li>No HP: {{ $santri->no_hp }}</li>
        <li>Status: {{ $santri->status }}</li>
    </ul>
</div>
@endsection
