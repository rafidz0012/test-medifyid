@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Kategori</h3>

    <form method="POST" action="{{ route('categories.update', $category->id) }}">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Kode</label>
            <input type="text" name="kode"
                   value="{{ $category->kode }}"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama"
                   value="{{ $category->nama }}"
                   class="form-control">
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
