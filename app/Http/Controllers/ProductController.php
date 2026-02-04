<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ProductController extends Controller
{
    public function index()
    {
        return view('product.index', [
            'title' => 'Products',
            'datas' => Products::paginate(50)
        ]);
    }

    public function create()
    {
        return view('product.create', [
            'title' => 'Products'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'foto_barang' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            $data = $request->only(['kd_barang', 'nama_barang', 'jenis_barang', 'tgl_expired', 'harga_jual', 'stok']);
            
            // Handle file upload
            if ($request->hasFile('foto_barang')) {
                $file = $request->file('foto_barang');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('products', $filename, 'public');
                $data['foto_barang'] = $path;
            }
            
            Products::create($data);
            return redirect()->route('product.index')->with('simpan', 'Produk ' . $request->nama_barang . ' berhasil disimpan');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->withInput()->with('error', 'Gagal: Kode Barang atau Nama Produk sudah ada.');
            }
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan produk: ' . $e->getMessage());
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        try {
            return view('product.edit', [
                'title' => 'Products',
                'data' => Products::findOrFail($id)
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('product.index')->with('error', 'Produk tidak ditemukan.');
        } catch (Throwable $e) {
            return redirect()->route('product.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'foto_barang' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            $data = $request->only(['kd_barang', 'nama_barang', 'jenis_barang', 'tgl_expired', 'harga_jual', 'stok']);
            $product = Products::findOrFail($id);
            
            // Handle file upload if new file is provided
            if ($request->hasFile('foto_barang')) {
                // Delete old image if exists
                if ($product->foto_barang && Storage::disk('public')->exists($product->foto_barang)) {
                    Storage::disk('public')->delete($product->foto_barang);
                }
                
                $file = $request->file('foto_barang');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('products', $filename, 'public');
                $data['foto_barang'] = $path;
            }
            
            $product->update($data);
            return redirect()->route('product.index')->with('ubah', 'Produk ' . $request->nama_barang . ' berhasil diupdate');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->withInput()->with('error', 'Gagal: Kode Barang atau Nama Produk sudah ada.');
            }
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate produk: ' . $e->getMessage());
        } catch (ModelNotFoundException $e) {
            return redirect()->route('product.index')->with('error', 'Produk tidak ditemukan.');
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $product = Products::findOrFail($id);
            $nama = $product->nama_barang;
            
            // Delete image file if exists
            if ($product->foto_barang && Storage::disk('public')->exists($product->foto_barang)) {
                Storage::disk('public')->delete($product->foto_barang);
            }
            
            $product->delete();
            return redirect()->route('product.index')->with('hapus', 'Produk ' . $nama . ' berhasil dihapus');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('product.index')->with('error', 'Produk tidak ditemukan atau sudah dihapus.');
        } catch (QueryException $e) {
            // Check for foreign key constraint (e.g., used in transaction details)
           if ($e->errorInfo[1] == 1451) {
                 return redirect()->route('product.index')->with('error', 'Gagal: Produk tidak bisa dihapus karena sudah ada transaksi.');
            }
            return redirect()->route('product.index')->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        } catch (Throwable $e) {
            return redirect()->route('product.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
