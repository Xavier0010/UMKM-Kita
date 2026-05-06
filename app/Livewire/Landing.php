<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Landing extends Component
{
    public function mount()
    {
        if (Auth::check()) {
            return redirect()->route('catalog');
        }
    }

    public function render()
    {
        return view('livewire.landing')->title('Selamat Datang di UMKM Kita');
    }
}
