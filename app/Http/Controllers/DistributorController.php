<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class DistributorController extends Controller
{
    public function index()
    {
        return view('distributor.index', [
            'title' => 'Distributor',
            'datas' => Distributor::paginate(10)
        ]);
    }

    public function create()
    {
        return view('distributor.create', [
            'title' => 'Distributor'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->only(['nama_distributor', 'alamat_distributor', 'notelepon_distributor']);
            Distributor::create($data);
            return redirect()->route('distributor.index')->with('simpan', 'The new Distributor Data, ' . $request->nama_distributor . ', has been succesfully saved');
        } catch (QueryException $e) {
             if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->withInput()->with('error', 'Failed: Distributor data already exists (Duplicate).');
            }
            return redirect()->back()->withInput()->with('error', 'Failed to save data: ' . $e->getMessage());
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'System Error: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        try {
            return view('distributor.edit', [
                'title' => 'Distributor',
                'data' => Distributor::findOrFail($id)
            ]);
        } catch (ModelNotFoundException $e) {
             return redirect()->route('distributor.index')->with('error', 'Distributor not found.');
        } catch (Throwable $e) {
             return redirect()->route('distributor.index')->with('error', 'Error loading data: ' . $e->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $data = $request->only(['nama_distributor', 'alamat_distributor', 'notelepon_distributor']);
            $distributor = Distributor::findOrFail($id);
            $distributor->update($data);
            return redirect()->route('distributor.index')->with('ubah', 'The Distributor Data, ' . $request->nama_distributor . ', has been succesfully updated');
        } catch (QueryException $e) {
             if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->withInput()->with('error', 'Failed: Distributor data already exists (Duplicate).');
            }
            return redirect()->back()->withInput()->with('error', 'Failed to update data: ' . $e->getMessage());
        } catch (ModelNotFoundException $e) {
             return redirect()->route('distributor.index')->with('error', 'Distributor not found.');
        } catch (Throwable $e) {
             return redirect()->back()->withInput()->with('error', 'System Error: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $distributor = Distributor::findOrFail($id);
            $distributor->delete();
            return redirect()->route('distributor.index')->with('hapus', 'The Distributor Data has been succesfully deleted');
        } catch (ModelNotFoundException $e) {
             return redirect()->route('distributor.index')->with('error', 'Distributor not found or already deleted.');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                 return redirect()->route('distributor.index')->with('error', 'Failed: Cannot delete because data is used in Purchase transactions.');
            }
             return redirect()->route('distributor.index')->with('error', 'Failed to delete data: ' . $e->getMessage());
        } catch (Throwable $e) {
             return redirect()->route('distributor.index')->with('error', 'System Error: ' . $e->getMessage());
        }
    }
}
