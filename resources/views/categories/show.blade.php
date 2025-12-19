@extends('layouts.app')

@section('content')
<div class="container">
    <h3>{{ $category->nama }} ({{ $category->kode }})</h3>
    <a href="{{ route('categories.print', $category->id) }}"
        class="btn btn-danger mt-3">
        Download PDF
    </a>

    <h5 class="mt-4">Daftar Master Item</h5>

    @if($category->masterItems->count())
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Jenis</th>
                    <th>Supplier</th>
                    <th>Harga Beli</th>
                    <th>Laba (%)</th>
                    <th>Harga Jual</th>
                </tr>
            </thead>
            <tbody>
                @foreach($category->masterItems as $item)
                    <tr>
                        <td>{{ $item->kode }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->jenis }}</td>
                        <td>{{ $item->supplier }}</td>
                        <td>{{ number_format($item->harga_beli) }}</td>
                        <td>{{ $item->laba }}%</td>
                        <td>
                            {{ number_format(
                                $item->harga_beli + ($item->harga_beli * $item->laba / 100)
                            ) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-muted">Belum ada item.</p>
    @endif

    <a href="{{ route('categories.index') }}" class="btn btn-secondary mt-3">
        Kembali
    </a>
</div>
@endsection
