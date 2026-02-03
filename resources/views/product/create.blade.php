@extends('be.master')

@section('menu')
    @include('be.menu')
@endsection

@section('product')
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
            <div class="col-12 col-xl-10">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Add New {{ $title }}</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('product.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kode Barang</label>
                                    <input type="text" class="form-control" name="kd_barang" placeholder="Enter Product Code" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Barang</label>
                                    <input type="text" class="form-control" name="nama_barang" placeholder="Enter Product Name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jenis Barang</label>
                                    <input type="text" class="form-control" name="jenis_barang" placeholder="Enter Category" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Expired</label>
                                    <input type="date" class="form-control" name="tgl_expired" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Harga Jual</label>
                                    <input type="number" class="form-control" name="harga_jual" placeholder="Enter Price" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Stok</label>
                                    <input type="number" class="form-control" name="stok" placeholder="Enter Quantity" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Foto Barang (URL)</label>
                                    <input type="text" class="form-control" name="foto_barang" placeholder="Enter Image URL" required>
                                </div>
                            </div>
                            <div class="text-end mt-4">
                                <a href="{{ route('product.index') }}" class="btn bg-gradient-secondary me-3">Cancel</a>
                                <button type="submit" class="btn bg-gradient-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
