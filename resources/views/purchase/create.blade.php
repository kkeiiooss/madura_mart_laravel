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
                        <h6>Add New {{ $title }}</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('purchase.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">No Nota</label>
                                    <input type="text" class="form-control" name="no_nota" placeholder="Enter Invoice Number" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Nota</label>
                                    <input type="date" class="form-control" name="tgl_nota" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Distributor</label>
                                    <select class="form-control" name="id_distributor" required>
                                        <option value="">Pilih Distributor</option>
                                        @foreach($distributors as $d)
                                            <option value="{{ $d->id }}">{{ $d->nama_distributor }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 mb-3">
                                    <h6>Purchase Items</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="purchase-items-table">
                                            <thead>
                                                <tr>
                                                    <th style="width:35%">Product</th>
                                                    <th style="width:15%">Purchase Price</th>
                                                    <th style="width:15%">Seller Margin</th>
                                                    <th style="width:15%">Purchase Amount</th>
                                                    <th style="width:15%">Sub Total</th>
                                                    <th style="width:5%">#</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <select name="id_barang[]" class="form-control id_barang">
                                                            <option value="">-- Pilih Produk --</option>
                                                            @foreach($products as $p)
                                                                <option value="{{ $p->id }}">{{ $p->nama_barang }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="harga_beli[]" class="form-control harga_beli" min="0" step="1" value="0">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="margin_jual[]" class="form-control margin_jual" min="0" step="1" value="0">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="jumlah_beli[]" class="form-control jumlah_beli" min="0" step="1" value="1">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="subtotal[]" class="form-control subtotal" readonly value="0">
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger btn-sm remove-row">-</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn bg-gradient-secondary btn-sm" id="add-item">+ Add Item</button>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Total Bayar</label>
                                    <input type="text" readonly class="form-control" name="total_bayar" id="total_bayar" placeholder="0" required>
                                </div>
                            </div>
                            <div class="text-end mt-4">
                                <a href="{{ route('purchase.index') }}" class="btn bg-gradient-secondary me-3">Cancel</a>
                                <button type="submit" class="btn bg-gradient-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // helper to parse int safely
        function toInt(v) {
            return parseInt(v) || 0;
        }

        function recalcRow(tr) {
            const harga = toInt(tr.querySelector('.harga_beli').value);
            const jumlah = toInt(tr.querySelector('.jumlah_beli').value);
            const subtotal = harga * jumlah;
            tr.querySelector('.subtotal').value = subtotal;
            recalcTotal();
        }

        function recalcTotal() {
            let total = 0;
            document.querySelectorAll('#purchase-items-table tbody tr').forEach(function(row) {
                total += toInt(row.querySelector('.subtotal').value);
            });
            document.getElementById('total_bayar').value = total;
        }

        document.addEventListener('click', function(e) {
            if (e.target && e.target.id === 'add-item') {
                const tbody = document.querySelector('#purchase-items-table tbody');
                const newRow = tbody.querySelector('tr').cloneNode(true);
                newRow.querySelectorAll('input').forEach(function(inp) {
                    if (inp.classList.contains('subtotal')) inp.value = 0;
                    else if (inp.classList.contains('jumlah_beli')) inp.value = 1;
                    else inp.value = 0;
                });
                newRow.querySelector('select').value = '';
                tbody.appendChild(newRow);
            }

            if (e.target && e.target.classList.contains('remove-row')) {
                const tbody = document.querySelector('#purchase-items-table tbody');
                if (tbody.querySelectorAll('tr').length > 1) {
                    e.target.closest('tr').remove();
                    recalcTotal();
                } else {
                    // reset first row
                    const tr = tbody.querySelector('tr');
                    tr.querySelector('select').value = '';
                    tr.querySelectorAll('input').forEach(function(inp){ inp.value = inp.classList.contains('jumlah_beli') ? 1 : 0; });
                    recalcTotal();
                }
            }
        });

        // delegate input events
        document.addEventListener('input', function(e) {
            if (e.target && (e.target.classList.contains('harga_beli') || e.target.classList.contains('jumlah_beli'))) {
                const tr = e.target.closest('tr');
                recalcRow(tr);
            }
        });

        // init
        recalcTotal();
    </script>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
