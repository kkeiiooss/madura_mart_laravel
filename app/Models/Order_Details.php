<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_Details extends Model
{
    protected $fillable = ['id_pemesanan', 'id_barang', 'harga_jual', 'jumlah_jual', 'subtotal', 'catatan'];
}
