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
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
        <div class="ms-md-auto pe-md-3 d-flex align-items-center"></div>
        <ul class="navbar-nav justify-content-end">
            <li class="nav-item d-flex align-items-center">
            <div class="mx-3">
              <a href="{{route('client.create')}}" class="btn btn-primary btn-sm mb-0">Add New {{ $title }}</a>
            </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>{{$title}} Data</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-primary text-xs font-weight-bolder opacity-7">No</th>
                      <th class="text-uppercase text-primary text-xs font-weight-bolder opacity-7">Nama Pelanggan</th>
                      <th class="text-uppercase text-primary text-xs font-weight-bolder opacity-7">Alamat</th>
                      <th class="text-uppercase text-primary text-xs font-weight-bolder opacity-7">No. Telepon</th>
                      <th class="text-uppercase text-primary text-xs font-weight-bolder opacity-7">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($datas as $nmr => $data)
                    <tr>
                        <td class="text-uppercase text-xs text-secondary mb-0 ps-4 text-center">{{$nmr + 1 . "."}}</td>
                        <td class="text-uppercase text-xs text-secondary mb-0 ps-4">{{$data->nama_pelanggan}}</td>
                        <td class="text-uppercase text-xs text-secondary mb-0 ps-4">{{$data->alamat_pelanggan}}</td>
                        <td class="text-uppercase text-xs text-secondary mb-0 ps-4">{{$data->notelepon_pelanggan}}</td>
                        <td class="text-uppercase text-xs text-secondary mb-0 ps-4">
                          <a href="{{ route('client.edit', $data->id) }}"><img src="{{asset('be/assets/img/icons/edit.png')}}" alt="" width="20"></a>
                          <form action="{{ route('client.destroy', $data->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="border:none;background:none;cursor:pointer;"><img src="{{asset('be/assets/img/icons/delete.png')}}" alt="" width="20"></button>
                          </form>
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
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
    <script>
      @if (session('simpan'))
        swal("Success", "{{ session('simpan') }}", "success");
      @endif
      @if (session('ubah'))
        swal("Success", "{{ session('ubah') }}", "success");
      @endif
      @if (session('hapus'))
        swal("Deleted", "{{ session('hapus') }}", "success");
      @endif
    </script>
@endsection
