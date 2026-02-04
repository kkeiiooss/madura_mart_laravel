<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class ClientController extends Controller
{
    public function index()
    {
        return view('client.index', [
            'title' => 'Client',
            'datas' => Client::paginate(10)
        ]);
    }

    public function create()
    {
        return view('client.create', [
            'title' => 'Client'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->only(['nama_pelanggan', 'alamat_pelanggan', 'notelepon_pelanggan']);
            Client::create($data);
            return redirect()->route('client.index')->with('simpan', 'Data pelanggan ' . $request->nama_pelanggan . ' berhasil disimpan');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->withInput()->with('error', 'Gagal: Data pelanggan sudah ada (Duplikat).');
            }
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        try {
            return view('client.edit', [
                'title' => 'Client',
                'data' => Client::findOrFail($id)
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('client.index')->with('error', 'Data pelanggan tidak ditemukan.');
        } catch (Throwable $e) {
            return redirect()->route('client.index')->with('error', 'Terjadi kesalahan saat memuat data: ' . $e->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $data = $request->only(['nama_pelanggan', 'alamat_pelanggan', 'notelepon_pelanggan']);
            $client = Client::findOrFail($id);
            $client->update($data);
            return redirect()->route('client.index')->with('ubah', 'Data pelanggan ' . $request->nama_pelanggan . ' berhasil diupdate');
        } catch (QueryException $e) {
             if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->withInput()->with('error', 'Gagal: Data pelanggan sudah ada (Duplikat).');
            }
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        } catch (ModelNotFoundException $e) {
            return redirect()->route('client.index')->with('error', 'Data pelanggan tidak ditemukan.');
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $client = Client::findOrFail($id);
            $nama = $client->nama_pelanggan;
            $client->delete();
            return redirect()->route('client.index')->with('hapus', 'Data pelanggan ' . $nama . ' berhasil dihapus');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('client.index')->with('error', 'Data pelanggan tidak ditemukan atau sudah dihapus.');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                 return redirect()->route('client.index')->with('error', 'Gagal: Data tidak bisa dihapus karena masih digunakan di data lain (Order).');
            }
            return redirect()->route('client.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        } catch (Throwable $e) {
            return redirect()->route('client.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
