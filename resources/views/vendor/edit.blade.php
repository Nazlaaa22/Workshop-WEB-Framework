@extends('layouts.app')

@section('content')

<div class="container">
    <h4 class="mb-3">Edit Vendor</h4>

    <form action="/vendor/{{ $vendor->id }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" value="{{ $vendor->name }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ $vendor->email }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>

@endsection