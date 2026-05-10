<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use App\Models\User;
use App\Models\Store;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Auth extends Component
{
    use WithFileUploads;
    
    #[Url]
    public $tab = 'login';
    public $showPassword = false;
    
    // Login Form
    public $loginId = '';
    public $loginPassword = '';

    // Signup Form
    public $regNama = '';
    public $regUsername = '';
    public $regEmail = '';
    public $regPassword = '';
    public $regRole = 'buyer';
    public $regPhone = '';
    public $regAddress = '';

    // Store Details (For Seller)
    public $storeName = '';
    public $storeDescription = '';
    public $storeLogo;
    public $storeBanner;
    public $storePhone = '';
    public $storeWA = '';
    public $storeAddress = '';
    public $storeCity = '';
    public $storeQRIS;

    public function togglePassword()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function switchTab($tab)
    {
        $this->tab = $tab;
        $this->resetValidation();
        
        $title = ($this->tab === 'signup' ? 'Signup' : 'Login') . ' - UMKM Kita';
        $this->dispatch('update-title', title: $title);
    }

    public function login()
    {
        $this->validate([
            'loginId' => 'required',
            'loginPassword' => 'required',
        ]);

        $fieldType = filter_var($this->loginId, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Check if user exists (checking both username and name as fallback)
        $user = User::where($fieldType, $this->loginId)->first();

        if (!$user && $fieldType === 'username') {
            $user = User::where('name', $this->loginId)->first();
            if ($user) {
                $fieldType = 'name';
            }
        }

        if (!$user) {
            $this->addError('loginId', 'Email atau username salah');
            return;
        }

        if (FacadesAuth::attempt([$fieldType => $this->loginId, 'password' => $this->loginPassword])) {
            return $this->redirectUser();
        }

        $this->addError('loginPassword', 'Password salah');
    }

    public function signup()
    {
        $rules = [
            'regNama' => 'required|string|max:255',
            'regUsername' => 'required|string|max:255|unique:users,username',
            'regEmail' => 'required|string|email|max:255|unique:users,email',
            'regPassword' => 'required|string|min:6',
            'regRole' => 'required|in:buyer,seller',
            'regPhone' => 'required|string|max:20',
            'regAddress' => 'required|string|max:500',
        ];

        if ($this->regRole === 'seller') {
            $rules = array_merge($rules, [
                'storeName' => 'required|string|max:255',
                'storeDescription' => 'required|string|max:1000',
                'storePhone' => 'required|string|max:20',
                'storeWA' => 'required|string|max:20',
                'storeAddress' => 'required|string|max:500',
                'storeCity' => 'required|string|max:255',
                'storeLogo' => 'required|image|max:1024', // 1MB max
                'storeBanner' => 'nullable|image|max:2048', // 2MB max
                'storeQRIS' => 'nullable|image|max:1024',
            ]);
        }

        $this->validate($rules);

        $user = User::create([
            'name' => $this->regNama,
            'username' => $this->regUsername,
            'email' => $this->regEmail,
            'password' => Hash::make($this->regPassword),
            'role' => $this->regRole,
            'phone' => $this->regPhone,
            'address' => $this->regAddress,
        ]);

        if ($this->regRole === 'seller') {
            $logoPath = $this->storeLogo ? $this->storeLogo->store('stores/logos', 'public') : null;
            $bannerPath = $this->storeBanner ? $this->storeBanner->store('stores/banners', 'public') : null;
            $qrisPath = $this->storeQRIS ? $this->storeQRIS->store('stores/qris', 'public') : null;

            Store::create([
                'user_id' => $user->id,
                'name' => $this->storeName,
                'slug' => Str::slug($this->storeName) . '-' . Str::random(5),
                'description' => $this->storeDescription,
                'logo' => $logoPath,
                'banner' => $bannerPath,
                'phone' => $this->storePhone,
                'whatsapp' => $this->storeWA,
                'address' => $this->storeAddress,
                'city' => $this->storeCity,
                'qris_image' => $qrisPath,
                'status' => 'pending',
            ]);
        }

        FacadesAuth::login($user);

        return $this->redirectUser();
    }

    private function redirectUser()
    {
        $user = FacadesAuth::user();
        
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        if ($user->role === 'seller') {
            $store = $user->store;
            if ($store && $store->status === 'approved') {
                return redirect()->route('seller.dashboard');
            }
            return redirect()->to('/')->with('message', 'Pendaftaran berhasil! Akun penjual Anda sedang menunggu persetujuan admin.');
        }
        
        return redirect()->to('/');
    }

    public function render()
    {
        $title = ($this->tab === 'signup' ? 'Signup' : 'Login') . ' - UMKM Kita';
        return view('livewire.auth')->title($title);
    }
}
