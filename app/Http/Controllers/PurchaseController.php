<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Distributor;
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
            'distributors' => Distributor::all()
        ]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->only(['no_nota', 'tgl_nota', 'id_distributor', 'total_bayar']);
            Purchase::create($data);
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
            $data = $request->only(['no_nota', 'tgl_nota', 'id_distributor', 'total_bayar']);
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
