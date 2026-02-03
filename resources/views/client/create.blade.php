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
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Add New {{$title}} Data</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <form action="{{ route('client.store')}}" method="POST" id="form">
                    @csrf
                    <div class="row ms-3 me-3">
                        <div class="col-12">
                            <div class="mb-3 px-3 pt-3">
                                <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                                <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" placeholder="Enter Client Name" required>
                            </div>
                            <div class="mb-3 px-3 pt-3">
                                <label for="alamat_pelanggan" class="form-label">Alamat Pelanggan</label>
                                <textarea type="text" class="form-control" id="alamat_pelanggan" name="alamat_pelanggan" placeholder="Enter Client Address" rows="5" required></textarea>
                            </div>
                            <div class="mb-3 px-3 pt-3">
                                <label for="notelepon_pelanggan" class="form-label">No. Telepon</label>
                                <input type="text" class="form-control" id="notelepon_pelanggan" name="notelepon_pelanggan" placeholder="Enter Client Phone Number" required>
                            </div>
                        </div>
                    </div>
                    <div class="row ms-3 me-3 mt-3">
                        <div class="col-12">
                            <div class="px-3 pb-3 text-end">
                                <a href="{{ route('client.index')}}" class="btn bg-gradient-secondary me-3">Cancel</a>
                                <button type="submit" class="btn bg-gradient-primary">Save New {{ $title }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer pt-3">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>document.write(new Date().getFullYear())</script>, Madura Mart
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>
@endsection
