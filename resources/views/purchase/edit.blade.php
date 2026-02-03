@extends('be.master')

@section('menu')
    @include('be.menu')
@endsection

@section('purchase')
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
                        <h6>Edit {{ $title }}</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('purchase.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">No Nota</label>
                                    <input type="text" class="form-control" name="no_nota" value="{{ $data->no_nota }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Nota</label>
                                    <input type="date" class="form-control" name="tgl_nota" value="{{ $data->tgl_nota }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Distributor</label>
                                    <select class="form-control" name="id_distributor" required>
                                        @foreach($distributors as $d)
                                            <option value="{{ $d->id }}" @if($data->id_distributor == $d->id) selected @endif>{{ $d->nama_distributor }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Total Bayar</label>
                                    <input type="number" class="form-control" name="total_bayar" value="{{ $data->total_bayar }}" required>
                                </div>
                            </div>
                            <div class="text-end mt-4">
                                <a href="{{ route('purchase.index') }}" class="btn bg-gradient-secondary me-3">Cancel</a>
                                <button type="submit" class="btn bg-gradient-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
