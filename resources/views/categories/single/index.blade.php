@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card">
                <div class="card-header">
                    Detail Kategori
                </div>

                <div class="card-body">
                    <h5>{{ $category->nama }} ({{ $category->kode }})</h5>

                    <a href="{{ url('categories/print/'.$category->id) }}"
                       class="btn btn-danger mb-3">
                        Download PDF
                    </a>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Kode Item</th>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Supplier</th>
                                <th>Harga Beli</th>
                                <th>Laba</th>
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
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <a href="{{ url('categories') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
