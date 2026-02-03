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
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center"></div>
                <ul class="navbar-nav  justify-content-end">
                    <li class="nav-item d-flex align-items-center">
                        <div class="mx-3">
                            <a href="{{ route('product.create') }}" class="btn bg-gradient-primary btn-sm mb-0">Add New {{ $title }}</a>
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
                        <h6>{{ $title }} Data</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Foto</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kode</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Barang</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jenis</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Harga Jual</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Stok</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $nmr => $data)
                                        <tr>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0 ps-3">{{ $nmr + 1 }}</p>
                                            </td>
                                            <td>
                                                @if($data->foto_barang)
                                                    <img src="{{ asset('storage/' . $data->foto_barang) }}" 
                                                         alt="{{ $data->nama_barang }}" 
                                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px; cursor: pointer;"
                                                         onclick="showProductDetail({{ $data->id }}, '{{ $data->kd_barang }}', '{{ addslashes($data->nama_barang) }}', '{{ $data->jenis_barang }}', {{ $data->harga_jual }}, {{ $data->stok }}, '{{ asset('storage/' . $data->foto_barang) }}')"
                                                         title="Klik untuk melihat detail">
                                                @else
                                                    <div style="width: 50px; height: 50px; background: #e9ecef; border-radius: 6px; display: flex; align-items: center; justify-content: center; cursor: pointer;"
                                                         onclick="showProductDetail({{ $data->id }}, '{{ $data->kd_barang }}', '{{ addslashes($data->nama_barang) }}', '{{ $data->jenis_barang }}', {{ $data->harga_jual }}, {{ $data->stok }}, '')"
                                                         title="Klik untuk melihat detail">
                                                        <i class="fas fa-image text-secondary"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $data->kd_barang }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $data->nama_barang }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $data->jenis_barang }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">Rp {{ number_format($data->harga_jual) }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $data->stok }}</p>
                                            </td>
                                            <td class="align-middle text-center">
                                                
                                                <a href="{{ route('product.edit', $data->id) }}" class="btn btn-link text-info px-2 mb-0" data-toggle="tooltip" title="Edit">
                                                    <i class="fas fa-pencil-alt text-info" style="font-size: 18px;"></i>
                                                </a>
                                                <form action="{{ route('product.destroy', $data->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger px-2 mb-0" data-toggle="tooltip" title="Hapus">
                                                        <i class="fas fa-trash text-danger" style="font-size: 18px;"></i>
                                                    </button>
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
    </div>

    <!-- Product Detail Modal -->
    <div class="modal fade" id="productDetailModal" tabindex="-1" aria-labelledby="productDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary">
                    <h5 class="modal-title text-white" id="productDetailModalLabel">
                        <i class="fas fa-box me-2"></i>Detail Produk
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5 text-center">
                            <div id="modalImageContainer" class="mb-3">
                                <img id="modalProductImage" src="" alt="Product Image" 
                                     style="max-width: 100%; max-height: 300px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
                            </div>
                            <div id="modalNoImage" style="display: none; width: 100%; height: 200px; background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-image text-secondary" style="font-size: 48px;"></i>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-secondary" style="width: 40%;"><i class="fas fa-barcode me-2"></i>Kode Barang</td>
                                    <td class="font-weight-bold" id="modalKode">-</td>
                                </tr>
                                <tr>
                                    <td class="text-secondary"><i class="fas fa-tag me-2"></i>Nama Barang</td>
                                    <td class="font-weight-bold" id="modalNama">-</td>
                                </tr>
                                <tr>
                                    <td class="text-secondary"><i class="fas fa-layer-group me-2"></i>Jenis</td>
                                    <td id="modalJenis">
                                        <span class="badge bg-gradient-info">-</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-secondary"><i class="fas fa-money-bill-wave me-2"></i>Harga Jual</td>
                                    <td class="font-weight-bold text-success" style="font-size: 1.2rem;" id="modalHarga">-</td>
                                </tr>
                                <tr>
                                    <td class="text-secondary"><i class="fas fa-boxes me-2"></i>Stok</td>
                                    <td id="modalStokContainer">
                                        <span class="badge bg-gradient-success" style="font-size: 1rem;" id="modalStok">-</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Tutup
                    </button>
                    <a href="#" id="modalEditBtn" class="btn bg-gradient-info">
                        <i class="fas fa-edit me-1"></i>Edit Produk
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showProductDetail(id, kode, nama, jenis, harga, stok, imageUrl) {
            // Set modal content
            document.getElementById('modalKode').textContent = kode;
            document.getElementById('modalNama').textContent = nama;
            document.getElementById('modalJenis').innerHTML = '<span class="badge bg-gradient-info">' + jenis + '</span>';
            document.getElementById('modalHarga').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(harga);
            
            // Set stok with appropriate color
            let stokBadge = document.getElementById('modalStok');
            stokBadge.textContent = stok + ' unit';
            if (stok <= 5) {
                stokBadge.className = 'badge bg-gradient-danger';
            } else if (stok <= 20) {
                stokBadge.className = 'badge bg-gradient-warning';
            } else {
                stokBadge.className = 'badge bg-gradient-success';
            }
            stokBadge.style.fontSize = '1rem';
            
            // Set image
            let imgElement = document.getElementById('modalProductImage');
            let noImageDiv = document.getElementById('modalNoImage');
            let imgContainer = document.getElementById('modalImageContainer');
            
            if (imageUrl && imageUrl !== '') {
                imgElement.src = imageUrl;
                imgElement.style.display = 'block';
                imgContainer.style.display = 'block';
                noImageDiv.style.display = 'none';
            } else {
                imgElement.style.display = 'none';
                imgContainer.style.display = 'none';
                noImageDiv.style.display = 'flex';
            }
            
            // Set edit button link
            document.getElementById('modalEditBtn').href = '/product/' + id + '/edit';
            
            // Show modal
            var modal = new bootstrap.Modal(document.getElementById('productDetailModal'));
            modal.show();
        }

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
