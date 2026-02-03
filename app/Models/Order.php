<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Client;

class Order extends Model
{
    protected $fillable = ['tgl_pemesanan', 'id_pelanggan', 'status_pemesanan', 'metode_pembayaran', 'total_bayar', 'keterangan_status'];

    public function pelanggan()
    {
        return $this->belongsTo(Client::class, 'id_pelanggan');
    }
}
