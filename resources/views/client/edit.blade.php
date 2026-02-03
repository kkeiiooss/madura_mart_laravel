@extends('be.master')

@section('menu')
    @include('be.menu')
@endsection

@section('client')
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $title }}</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">{{ $title }}</h6>
            </nav>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-8">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Edit {{ $title }}</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('client.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                                <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" value="{{ $data->nama_pelanggan }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat_pelanggan" class="form-label">Alamat Pelanggan</label>
                                <textarea class="form-control" id="alamat_pelanggan" name="alamat_pelanggan" rows="4" required>{{ $data->alamat_pelanggan }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="notelepon_pelanggan" class="form-label">No. Telepon</label>
                                <input type="text" class="form-control" id="notelepon_pelanggan" name="notelepon_pelanggan" value="{{ $data->notelepon_pelanggan }}" required>
                            </div>
                            <div class="text-end mt-4">
                                <a href="{{ route('client.index') }}" class="btn bg-gradient-secondary me-3">Cancel</a>
                                <button type="submit" class="btn bg-gradient-primary">Update {{ $title }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
