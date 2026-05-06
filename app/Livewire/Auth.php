<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Auth extends Component
{
    #[Url]
    public $tab = 'login';
    public $showPassword = false;
    
    // Login Form
    public $loginId = '';
    public $loginPassword = '';

    // Register Form
    public $regNama = '';
    public $regUsername = '';
    public $regEmail = '';
    public $regPassword = '';
    public $regRole = 'buyer';

    public function togglePassword()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function switchTab($tab)
    {
        $this->tab = $tab;
        $this->resetValidation();
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
            return redirect()->to('/catalog');
        }

        $this->addError('loginPassword', 'Password salah');
    }

    public function register()
    {
        $this->validate([
            'regNama' => 'required|string|max:255',
            'regUsername' => 'required|string|max:255|unique:users,username',
            'regEmail' => 'required|string|email|max:255|unique:users,email',
            'regPassword' => 'required|string|min:6',
            'regRole' => 'required|in:buyer,seller',
        ]);

        $user = User::create([
            'name' => $this->regNama,
            'username' => $this->regUsername,
            'email' => $this->regEmail,
            'password' => Hash::make($this->regPassword),
            'role' => $this->regRole,
        ]);

        FacadesAuth::login($user);

        return redirect()->to('/catalog');
    }

    public function render()
    {
        return view('livewire.auth')->title('Login — UMKM Kita');
    }
}
