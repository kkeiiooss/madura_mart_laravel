<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class SaleController extends Controller
{
    public function index()
    {
        return view('sale.index', [
            'title' => 'Sale',
            'datas' => Sale::paginate(10)
        ]);
    }

    public function create()
    {
        return view('sale.create', [
            'title' => 'Sale'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->only(['no_struk', 'tgl_jual', 'total_bayar']);
            Sale::create($data);
            return redirect()->route('sale.index')->with('simpan', 'Penjualan dengan struk ' . $request->no_struk . ' berhasil disimpan');
        } catch (QueryException $e) {
             if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->withInput()->with('error', 'Gagal: No Struk sudah ada.');
            }
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan penjualan: ' . $e->getMessage());
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        try {
            return view('sale.edit', [
                'title' => 'Sale',
                'data' => Sale::findOrFail($id)
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('sale.index')->with('error', 'Data penjualan tidak ditemukan.');
        } catch (Throwable $e) {
            return redirect()->route('sale.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $data = $request->only(['no_struk', 'tgl_jual', 'total_bayar']);
            $sale = Sale::findOrFail($id);
            $sale->update($data);
            return redirect()->route('sale.index')->with('ubah', 'Penjualan dengan struk ' . $request->no_struk . ' berhasil diupdate');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->withInput()->with('error', 'Gagal: No Struk sudah ada.');
            }
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate penjualan: ' . $e->getMessage());
        } catch (ModelNotFoundException $e) {
            return redirect()->route('sale.index')->with('error', 'Data penjualan tidak ditemukan.');
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $sale = Sale::findOrFail($id);
            $struk = $sale->no_struk;
            $sale->delete();
            return redirect()->route('sale.index')->with('hapus', 'Penjualan dengan struk ' . $struk . ' berhasil dihapus');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('sale.index')->with('error', 'Data penjualan tidak ditemukan atau sudah dihapus.');
        } catch (QueryException $e) {
            return redirect()->route('sale.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        } catch (Throwable $e) {
            return redirect()->route('sale.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
