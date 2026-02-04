<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Purchase_Detail;
use App\Models\Distributor;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class PurchaseController extends Controller
{
    public function index()
    {
        return view('purchase.index', [
            'title' => 'Purchase',
            'datas' => Purchase::with('distributor')->paginate(10)
        ]);
    }

    public function create()
    {
        return view('purchase.create', [
            'title' => 'Purchase',
            'distributors' => Distributor::all(),
            'products' => Products::all()
        ]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->only(['no_nota', 'tgl_nota', 'id_distributor']);
            $data['total_bayar'] = preg_replace('/[^0-9]/', '', $request->total_bayar);

            $purchase = Purchase::create($data);

            // handle purchase details if provided
            $total = 0;
            $id_barangs = $request->input('id_barang', []);
            $harga_belis = $request->input('harga_beli', []);
            $margin_juals = $request->input('margin_jual', []);
            $jumlah_belis = $request->input('jumlah_beli', []);

            foreach ($id_barangs as $i => $id_barang) {
                if (empty($id_barang)) continue;
                $harga = isset($harga_belis[$i]) ? intval(preg_replace('/[^0-9]/', '', $harga_belis[$i])) : 0;
                $margin = isset($margin_juals[$i]) ? intval(preg_replace('/[^0-9]/', '', $margin_juals[$i])) : 0;
                $jumlah = isset($jumlah_belis[$i]) ? intval(preg_replace('/[^0-9]/', '', $jumlah_belis[$i])) : 0;
                $subtotal = $harga * $jumlah;

                Purchase_Detail::create([
                    'id_pembelian' => $purchase->id,
                    'id_barang' => $id_barang,
                    'harga_beli' => $harga,
                    'margin_jual' => $margin,
                    'jumlah_beli' => $jumlah,
                    'subtotal' => $subtotal
                ]);

                $total += $subtotal;
            }

            // update total bayar if details exist, otherwise use provided field
            if ($total > 0) {
                $purchase->total_bayar = $total;
                $purchase->save();
            } else {
                // sanitize provided total_bayar (already set above but ensure formatting)
                $purchase->total_bayar = $data['total_bayar'] ?? 0;
                $purchase->save();
            }

            return redirect()->route('purchase.index')->with('simpan', 'Pembelian dengan nota ' . $request->no_nota . ' berhasil disimpan');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->withInput()->with('error', 'Gagal: No Nota sudah ada.');
            }
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan pembelian: ' . $e->getMessage());
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        try {
            return view('purchase.edit', [
                'title' => 'Purchase',
                'data' => Purchase::findOrFail($id),
                'distributors' => Distributor::all()
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('purchase.index')->with('error', 'Data pembelian tidak ditemukan.');
        } catch (Throwable $e) {
            return redirect()->route('purchase.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        try {
           $data = $request->only(['no_nota', 'tgl_nota', 'id_distributor']);
           $data['total_bayar'] = preg_replace('/[^0-9]/', '', $request->total_bayar);

            $purchase = Purchase::findOrFail($id);
            $purchase->update($data);
            return redirect()->route('purchase.index')->with('ubah', 'Pembelian dengan nota ' . $request->no_nota . ' berhasil diupdate');
        } catch (QueryException $e) {
             if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->withInput()->with('error', 'Gagal: No Nota sudah ada.');
            }
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate pembelian: ' . $e->getMessage());
        } catch (ModelNotFoundException $e) {
            return redirect()->route('purchase.index')->with('error', 'Data pembelian tidak ditemukan.');
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $purchase = Purchase::findOrFail($id);
            $nota = $purchase->no_nota;
            $purchase->delete();
            return redirect()->route('purchase.index')->with('hapus', 'Pembelian dengan nota ' . $nota . ' berhasil dihapus');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('purchase.index')->with('error', 'Data pembelian tidak ditemukan atau sudah dihapus.');
        } catch (QueryException $e) {
            return redirect()->route('purchase.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        } catch (Throwable $e) {
            return redirect()->route('purchase.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}