<div class="auth-wrapper">
    <style>
        /* Include the styles from login.php directly here or link a CSS file if needed. 
           But since we're using Livewire and we have layouts/app.blade.php, we should define specific styles here. */
        .auth-wrapper { display: flex; height: 100vh; background: #f5f5f5; width: 100vw; position: fixed; top: 0; left: 0; z-index: 1000; overflow: hidden; }
        .auth-image { flex: 1; background: linear-gradient(135deg, rgba(15, 23, 42, 0.55) 0%, rgba(30, 58, 138, 0.65) 100%), url('https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&q=80') center/cover no-repeat; display: flex; flex-direction: column; justify-content: flex-end; padding: 60px 50px; position: relative; overflow: hidden; }
        .auth-image::before { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 60%; background: linear-gradient(to top, rgba(15,23,42,0.85) 0%, transparent 100%); z-index: 1; }
        .image-content { position: relative; z-index: 2; color: #fff; }
        .image-tagline { font-size: 1rem; font-weight: 600; color: #93c5fd; margin-bottom: 12px; letter-spacing: 1.5px; text-transform: uppercase; }
        .image-title { font-size: 2.4rem; font-weight: 800; line-height: 1.2; margin-bottom: 16px; }
        .image-desc { font-size: 1rem; color: #cbd5e1; line-height: 1.6; max-width: 400px; }
        .slide-dots { display: flex; gap: 8px; margin-top: 30px; }
        .slide-dots span { width: 10px; height: 10px; border-radius: 50%; background: rgba(255,255,255,0.3); transition: all 0.3s; }
        .slide-dots span.active { background: #fff; width: 28px; border-radius: 5px; }
        .auth-form-panel { flex: 1; display: flex; align-items: center; justify-content: center; padding: 40px; background: #fff; height: 100vh; overflow-y: auto; }
        .auth-form-container { width: 100%; max-width: 420px; }
        .brand-header { text-align: center; margin-bottom: 32px; }
        .brand-header h1 { font-size: 1.8rem; font-weight: 800; color: #0f172a; }
        .brand-header h1 span { color: #3b82f6; }
        .brand-header p { color: #64748b; font-size: 0.9rem; margin-top: 6px; }
        .tab-switcher { display: flex; border-radius: 12px; background: #f1f5f9; padding: 4px; margin-bottom: 28px; }
        .tab-btn { flex: 1; padding: 12px; border: none; background: transparent; font-family: inherit; font-size: 0.95rem; font-weight: 600; color: #64748b; border-radius: 10px; cursor: pointer; transition: all 0.3s ease; }
        .tab-btn.active { background: #3b82f6; color: #fff; box-shadow: 0 2px 8px rgba(59,130,246,0.35); }
        .tab-btn:not(.active):hover { color: #334155; }
        .alert { padding: 12px 16px; border-radius: 10px; font-size: 0.85rem; margin-bottom: 20px; font-weight: 500; display: flex; align-items: center; gap: 8px; animation: slideDown 0.3s ease; }
        .alert-error { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 8px; }
        .input-wrapper { position: relative; }
        .input-field { width: 100%; padding: 13px 16px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 0.95rem; font-family: inherit; background: #f8fafc; transition: all 0.25s; color: #0f172a; box-sizing: border-box; }
        .input-field:focus { outline: none; border-color: #3b82f6; background: #fff; box-shadow: 0 0 0 4px rgba(59,130,246,0.1); }
        .password-toggle { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #64748b; font-size: 1.1rem; user-select: none; z-index: 10; background: none; border: none; padding: 0; }
        .password-toggle:hover { color: #3b82f6; }
        .select-field { width: 100%; padding: 13px 16px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 0.95rem; font-family: inherit; background: #f8fafc; color: #0f172a; cursor: pointer; transition: all 0.25s; box-sizing: border-box; }
        .btn-submit { width: 100%; padding: 14px; border: none; border-radius: 12px; font-family: inherit; font-size: 1rem; font-weight: 700; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 8px; box-sizing: border-box; }
        .btn-login { background: #3b82f6; color: #fff; }
        .btn-login:hover { background: #2563eb; transform: translateY(-1px); }
        .btn-register { background: #0f172a; color: #fff; }
        .btn-register:hover { background: #1e293b; transform: translateY(-1px); }
        .auth-switch { text-align: center; margin-top: 28px; font-size: 0.88rem; color: #64748b; }
        .auth-switch a { color: #3b82f6; font-weight: 600; text-decoration: none; cursor: pointer; }
        .auth-switch a:hover { text-decoration: underline; }
        @media (max-width: 900px) { .auth-image { display: none; } .auth-form-panel { padding: 30px 20px; } }
    </style>

    <!-- ===== LEFT: IMAGE PANEL ===== -->
    <div class="auth-image">
        <div class="image-content">
            <p class="image-tagline">Dukung UMKM Lokal</p>
            <h2 class="image-title">Temukan Produk<br>Terbaik dari<br>UMKM di Sekitarmu.</h2>
            <p class="image-desc">Belanja langsung dari pengusaha lokal. Mudah, cepat, dan terpercaya.</p>
            <div class="slide-dots">
                <span class="active"></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>

    <!-- ===== RIGHT: FORM PANEL ===== -->
    <div class="auth-form-panel">
        <div class="auth-form-container">

            <!-- Brand -->
            <div class="brand-header">
                <h1>Welcome to <span>UMKM Kita</span></h1>
                <p>Your Gateway to Local Products.</p>
            </div>

            <!-- Tab Switcher -->
            <div class="tab-switcher">
                <button class="tab-btn {{ $tab === 'login' ? 'active' : '' }}" wire:click="switchTab('login')">Log In</button>
                <button class="tab-btn {{ $tab === 'register' ? 'active' : '' }}" wire:click="switchTab('register')">Sign Up</button>
            </div>

            <!-- Alerts -->
            @if(session()->has('error')) <div class="alert alert-error">⚠️ {{ session('error') }}</div> @endif

            <!-- ===== LOGIN FORM ===== -->
            @if($tab === 'login')
            <div class="form-panel">
                <form wire:submit.prevent="login">
                    <div class="form-group">
                        <label>Email atau Username</label>
                        <input type="text" wire:model="loginId" class="input-field" placeholder="Email atau Username" required>
                        @error('loginId') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-wrapper">
                            <input type="{{ $showPassword ? 'text' : 'password' }}" wire:model="loginPassword" class="input-field" placeholder="Enter Password" required>
                            <button type="button" class="password-toggle" wire:click="togglePassword">
                                {!! $showPassword ? '👁️' : '👁️‍🗨️' !!}
                            </button>
                        </div>
                        @error('loginPassword') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn-submit btn-login">
                        Log In
                    </button>
                </form>

                <div class="auth-switch">
                    <p>Don't have an account? <a wire:click="switchTab('register')">Sign Up</a></p>
                </div>
            </div>
            @endif

            <!-- ===== REGISTER FORM ===== -->
            @if($tab === 'register')
            <div class="form-panel">
                <form wire:submit.prevent="register">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" wire:model="regNama" class="input-field" placeholder="Nama lengkap Anda" required>
                        @error('regNama') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" wire:model="regUsername" class="input-field" placeholder="Username unik" required>
                        @error('regUsername') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" wire:model="regEmail" class="input-field" placeholder="Email Address" required>
                        @error('regEmail') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-wrapper">
                            <input type="{{ $showPassword ? 'text' : 'password' }}" wire:model="regPassword" class="input-field" placeholder="Minimal 6 karakter" required minlength="6">
                            <button type="button" class="password-toggle" wire:click="togglePassword">
                                {!! $showPassword ? '👁️' : '👁️‍🗨️' !!}
                            </button>
                        </div>
                        @error('regPassword') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Daftar sebagai</label>
                        <select wire:model="regRole" class="select-field">
                            <option value="buyer">Pembeli</option>
                            <option value="seller">Penjual</option>
                        </select>
                        @error('regRole') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn-submit btn-register">
                        Sign Up
                    </button>
                </form>

                <div class="auth-switch">
                    <p>Already have an account? <a wire:click="switchTab('login')">Log In</a></p>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
