@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    {{ $method == 'new' ? 'Tambah Kategori' : 'Edit Kategori' }}
                </div>

                <div class="card-body">
                    <form method="POST"
                          action="{{ url('categories/form/'.$method.'/'.$category->id ?? '') }}">
                        @csrf

                        <div class="mb-3">
                            <label>Kode</label>
                            <input type="text"
                                   name="kode"
                                   class="form-control"
                                   value="{{ $category->kode ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label>Nama</label>
                            <input type="text"
                                   name="nama"
                                   class="form-control"
                                   value="{{ $category->nama ?? '' }}">
                        </div>

                        <button class="btn btn-primary">Simpan</button>
                        <a href="{{ url('categories') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
