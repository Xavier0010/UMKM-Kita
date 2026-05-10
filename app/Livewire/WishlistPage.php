<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistPage extends Component
{
    public function removeItem($wishlistId)
    {
        Wishlist::where('user_id', Auth::id())->where('id', $wishlistId)->delete();
        $this->dispatch('wishlistUpdated');
    }

    public function pesan($productId, $namaProduk)
    {
        if (!Auth::check()) {
            return redirect()->route('authentication', ['tab' => 'login']);
        }

        $phone = '6281234567890';
        $text = "Halo, saya ingin pesan: 1x " . $namaProduk;
        $url = "https://wa.me/" . $phone . "?text=" . urlencode($text);
        $this->redirect($url, navigate: false);
    }

    public function render()
    {
        $wishlists = Wishlist::with('product')->where('user_id', Auth::id())->latest()->get();

        return view('livewire.wishlist-page', [
            'wishlists' => $wishlists
        ])->title('Wishlist — UMKM Kita');
    }
}
