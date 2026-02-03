@extends('be.master')

@section('menu')
    @include('be.menu')
@endsection

@section('distributor')
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
                        <form action="{{ route('distributor.update', $data->id) }}" method="POST" id="form">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="nama_distributor" class="form-label">Nama Distributor</label>
                                <input type="text" class="form-control" id="nama_distributor" name="nama_distributor" placeholder="Enter Distributor Name" value="{{ $data->nama_distributor }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat_distributor" class="form-label">Alamat Distributor</label>
                                <textarea class="form-control" id="alamat_distributor" name="alamat_distributor" placeholder="Enter Distributor Addresses" rows="4" required>{{ $data->alamat_distributor }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="notelepon_distributor" class="form-label">No. Telp Distributor</label>
                                <input type="text" class="form-control" id="notelepon_distributor" name="notelepon_distributor" placeholder="Enter Distributor Phone Number" value="{{ $data->notelepon_distributor }}" required>
                            </div>
                            <div class="text-end mt-4">
                                <a href="{{ route('distributor.index') }}" class="btn bg-gradient-secondary me-3">Cancel</a>
                                <button type="submit" class="btn bg-gradient-primary">Update {{ $title }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection