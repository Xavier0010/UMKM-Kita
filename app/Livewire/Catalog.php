<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Catalog extends Component
{
    public $search = '';
    public $kategoriFilter = 'semua';
    public $cart = [];

    public function filterKategori($kategori)
    {
        $this->kategoriFilter = $kategori;
    }

    public function pesan($productId, $namaProduk, $jumlah = 1)
    {
        if (!Auth::check()) {
            return redirect()->route('authentication', ['tab' => 'login']);
        }

        // Simple logic to redirect to WhatsApp, similar to what native JS did
        // But since user wants to stay Livewire, we can emit an event or just redirect
        $phone = '6281234567890';
        $text = "Halo, saya ingin pesan: " . $jumlah . "x " . $namaProduk;
        $url = "https://wa.me/" . $phone . "?text=" . urlencode($text);
        $this->redirect($url, navigate: false);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('authentication', ['tab' => 'login']);
    }

    public function render()
    {
        $query = DB::table('products');

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->kategoriFilter !== 'semua') {
            // we assume the category is joined or we use category_id
            // in native it was just a string "kategori"
            // For now let's assume we fetch category name through a join
            $query->join('categories', 'products.category_id', '=', 'categories.id')
                  ->where('categories.name', $this->kategoriFilter)
                  ->select('products.*', 'categories.name as kategori_name');
        } else {
            $query->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                  ->select('products.*', 'categories.name as kategori_name');
        }

        $all_produk = $query->orderBy('products.id', 'desc')->get();
        $kategori_list = DB::table('categories')->pluck('name');
        $rekomendasi = DB::table('products')->inRandomOrder()->limit(3)->get();
        $total_produk = DB::table('products')->count();
        $user = Auth::user() ?? (object) ['name' => 'Guest', 'role' => 'user'];

        return view('livewire.catalog', [
            'all_produk' => $all_produk,
            'kategori_list' => $kategori_list,
            'rekomendasi' => $rekomendasi,
            'total_produk' => $total_produk,
            'user' => $user
        ])->title('Katalog — UMKM Kita');
    }
}
