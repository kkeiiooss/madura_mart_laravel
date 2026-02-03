<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class OrderController extends Controller
{
    public function index()
    {
        return view('order.index', [
            'title' => 'Order',
            'datas' => Order::with('pelanggan')->get()
        ]);
    }

    public function create()
    {
        return view('order.create', [
            'title' => 'Order',
            'clients' => \App\Models\Client::all()
        ]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->only(['tgl_pemesanan', 'id_pelanggan', 'status_pemesanan', 'metode_pembayaran', 'total_bayar', 'keterangan_status']);
            Order::create($data);
            return redirect()->route('order.index')->with('simpan', 'Order berhasil disimpan');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan order: ' . $e->getMessage());
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        try {
            return view('order.edit', [
                'title' => 'Order',
                'data' => Order::findOrFail($id),
                'clients' => \App\Models\Client::all()
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('order.index')->with('error', 'Data order tidak ditemukan.');
        } catch (Throwable $e) {
            return redirect()->route('order.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $data = $request->only(['tgl_pemesanan', 'id_pelanggan', 'status_pemesanan', 'metode_pembayaran', 'total_bayar', 'keterangan_status']);
            $order = Order::findOrFail($id);
            $order->update($data);
            return redirect()->route('order.index')->with('ubah', 'Order berhasil diupdate');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate order: ' . $e->getMessage());
        } catch (ModelNotFoundException $e) {
            return redirect()->route('order.index')->with('error', 'Data order tidak ditemukan.');
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();
            return redirect()->route('order.index')->with('hapus', 'Order berhasil dihapus');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('order.index')->with('error', 'Data order tidak ditemukan atau sudah dihapus.');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                 return redirect()->route('order.index')->with('error', 'Gagal: Order tidak bisa dihapus karena terkait dengan pengiriman.');
            }
            return redirect()->route('order.index')->with('error', 'Gagal menghapus order: ' . $e->getMessage());
        } catch (Throwable $e) {
            return redirect()->route('order.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
