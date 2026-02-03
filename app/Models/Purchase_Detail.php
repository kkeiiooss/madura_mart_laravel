<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase_Detail extends Model
{
    protected $fillable = ['id_pembelian', 'id_barang', 'harga_beli', 'margin_jual', 'jumlah_beli', 'subtotal'];
}
