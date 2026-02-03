<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale_Detail extends Model
{
    protected $fillable = ['id_penjualan', 'id_barang', 'harga_jual', 'jumlah_jual', 'subtotal'];
}
