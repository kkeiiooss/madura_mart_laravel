<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Distributor;
use App\Models\Products;
use App\Models\Client;
use App\Models\Courier;
use App\Models\Purchase;
use App\Models\Purchase_Detail;
use App\Models\Order;
use App\Models\Order_Details;
use App\Models\Sale;
use App\Models\Sale_Detail;
use App\Models\Delivery;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Distributors
        $distributors = [];
        for ($i = 1; $i <= 5; $i++) {
            $distributors[] = Distributor::create([
                'nama_distributor' => "Distributor " . $i,
                'alamat_distributor' => "Jl. Distributor No. " . $i . ", Madura",
                'notelepon_distributor' => "0812345678" . $i,
            ]);
        }

        // 2. Products
        $products = [];
        $categories = ['Makanan', 'Minuman', 'Sembako', 'Elektronik'];
        for ($i = 1; $i <= 20; $i++) {
            $products[] = Products::create([
                'kd_barang' => "BRG-" . str_pad($i, 4, '0', STR_PAD_LEFT),
                'nama_barang' => "Produk Madura " . $i,
                'jenis_barang' => $categories[array_rand($categories)],
                'tgl_expired' => Carbon::now()->addMonths(rand(6, 24)),
                'harga_jual' => rand(5000, 100000),
                'stok' => rand(50, 200),
                'foto_barang' => "https://picsum.photos/seed/product" . $i . "/300/300",
            ]);
        }

        // 3. Clients
        $clients = [];
        for ($i = 1; $i <= 10; $i++) {
            $clients[] = Client::create([
                'nama_pelanggan' => "Pelanggan Setia " . $i,
                'alamat_pelanggan' => "Jl. Pelanggan No. " . $i . ", Madura",
                'notelepon_pelanggan' => "0898765432" . $i,
            ]);
        }

        // 4. Couriers
        $couriers = [];
        for ($i = 1; $i <= 3; $i++) {
            $couriers[] = Courier::create([
                'nama_kurir' => "Kurir Gesit " . $i,
                'notelepon_kurir' => "0855544332" . $i,
                'plat_kendaraan' => "M " . rand(1000, 9999) . " XX",
            ]);
        }

        // 5. Purchases (Distributor -> Products)
        for ($i = 1; $i <= 10; $i++) {
            $dist = $distributors[array_rand($distributors)];
            $purchase = Purchase::create([
                'no_nota' => "N-" . substr(Carbon::now()->timestamp, -8) . $i,
                'tgl_nota' => Carbon::now()->subDays(rand(1, 30)),
                'id_distributor' => $dist->id,
                'total_bayar' => 0,
            ]);

            $total = 0;
            $items = array_rand($products, rand(2, 5));
            foreach ((array)$items as $prodIndex) {
                $prod = $products[$prodIndex];
                $qty = rand(5, 20);
                $buyPrice = $prod->harga_jual * 0.8;
                $subtotal = $qty * $buyPrice;
                Purchase_Detail::create([
                    'id_pembelian' => $purchase->id,
                    'id_barang' => $prod->id,
                    'harga_beli' => $buyPrice,
                    'margin_jual' => 20,
                    'jumlah_beli' => $qty,
                    'subtotal' => $subtotal,
                ]);
                $total += $subtotal;
            }
            $purchase->update(['total_bayar' => $total]);
        }

        // 6. Orders (Client -> Products)
        $orderStatuses = ['dipesan', 'diproses', 'dikirim', 'selesai'];
        for ($i = 1; $i <= 15; $i++) {
            $client = $clients[array_rand($clients)];
            $order = Order::create([
                'tgl_pemesanan' => Carbon::now()->subDays(rand(1, 15)),
                'id_pelanggan' => $client->id,
                'status_pemesanan' => $orderStatuses[array_rand($orderStatuses)],
                'metode_pembayaran' => rand(0, 1) ? 'tf' : 'cod',
                'total_bayar' => 0,
                'keterangan_status' => "Pesanan via Mobile App",
            ]);

            $total = 0;
            $items = array_rand($products, rand(1, 3));
            foreach ((array)$items as $prodIndex) {
                $prod = $products[$prodIndex];
                $qty = rand(1, 10);
                $subtotal = $qty * $prod->harga_jual;
                Order_Details::create([
                    'id_pemesanan' => $order->id,
                    'id_barang' => $prod->id,
                    'harga_jual' => $prod->harga_jual,
                    'jumlah_jual' => $qty,
                    'subtotal' => $subtotal,
                    'catatan' => "Jangan sampai pecah",
                ]);
                $total += $subtotal;
            }
            $order->update(['total_bayar' => $total]);

            // 7. Deliveries (linked to Orders)
            if ($order->status_pemesanan == 'dikirim' || $order->status_pemesanan == 'selesai') {
                Delivery::create([
                    'tgl_kirim' => Carbon::parse($order->tgl_pemesanan)->addDay(),
                    'id_kurir' => $couriers[array_rand($couriers)]->id,
                    'id_pemesanan' => $order->id,
                    'bukti_foto' => "https://picsum.photos/seed/delivery" . $i . "/300/300",
                    'no_invoice' => "INV-" . substr(Carbon::now()->timestamp, -8) . $i,
                ]);
            }
        }

        // 8. Sales (Direct / Point of Sale)
        for ($i = 1; $i <= 15; $i++) {
            $sale = Sale::create([
                'no_struk' => "S-" . substr(Carbon::now()->timestamp, -8) . $i,
                'tgl_jual' => Carbon::now()->subDays(rand(0, 30)),
                'total_bayar' => 0,
            ]);

            $total = 0;
            $items = array_rand($products, rand(1, 4));
            foreach ((array)$items as $prodIndex) {
                $prod = $products[$prodIndex];
                $qty = rand(1, 5);
                $subtotal = $qty * $prod->harga_jual;
                Sale_Detail::create([
                    'id_penjualan' => $sale->id,
                    'id_barang' => $prod->id,
                    'harga_jual' => $prod->harga_jual,
                    'jumlah_jual' => $qty,
                    'subtotal' => $subtotal,
                ]);
                $total += $subtotal;
            }
            $sale->update(['total_bayar' => $total]);
        }
    }
}
