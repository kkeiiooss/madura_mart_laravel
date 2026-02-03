@extends('be.master')

@section('menu')
    @include('be.menu')
@endsection

@section('order')
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
                        <form action="{{ route('order.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Pemesanan</label>
                                    <input type="date" class="form-control" name="tgl_pemesanan" value="{{ $data->tgl_pemesanan }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Pelanggan</label>
                                    <select class="form-control" name="id_pelanggan" required>
                                        @foreach($clients as $c)
                                            <option value="{{ $c->id }}" @if($data->id_pelanggan == $c->id) selected @endif>{{ $c->nama_pelanggan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status Pemesanan</label>
                                    <select class="form-control" name="status_pemesanan" required>
                                        <option value="Proses" @if($data->status_pemesanan == 'Proses') selected @endif>Proses</option>
                                        <option value="Selesai" @if($data->status_pemesanan == 'Selesai') selected @endif>Selesai</option>
                                        <option value="Batal" @if($data->status_pemesanan == 'Batal') selected @endif>Batal</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Metode Pembayaran</label>
                                    <select class="form-control" name="metode_pembayaran" required>
                                        <option value="Tunai" @if($data->metode_pembayaran == 'Tunai') selected @endif>Tunai</option>
                                        <option value="Transfer" @if($data->metode_pembayaran == 'Transfer') selected @endif>Transfer</option>
                                        <option value="COD" @if($data->metode_pembayaran == 'COD') selected @endif>COD</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Total Bayar</label>
                                    <input type="number" class="form-control" name="total_bayar" value="{{ $data->total_bayar }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Keterangan Status</label>
                                    <input type="text" class="form-control" name="keterangan_status" value="{{ $data->keterangan_status }}">
                                </div>
                            </div>
                            <div class="text-end mt-4">
                                <a href="{{ route('order.index') }}" class="btn bg-gradient-secondary me-3">Cancel</a>
                                <button type="submit" class="btn bg-gradient-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
