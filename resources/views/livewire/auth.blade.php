<div class="auth-wrapper">
    <style>
        /* Include the styles from login.php directly here or link a CSS file if needed. 
           But since we're using Livewire and we have layouts/app.blade.php, we should define specific styles here. */
        .auth-wrapper { display: flex; height: 100vh; background: #f5f5f5; width: 100vw; position: fixed; top: 0; left: 0; z-index: 1000; overflow: hidden; }
        .auth-image { flex: 1; position: relative; background: #0f172a; }
        .carousel-track { display: flex; height: 100%; overflow-x: auto; scroll-snap-type: x mandatory; scroll-behavior: smooth; -ms-overflow-style: none; scrollbar-width: none; }
        .carousel-track::-webkit-scrollbar { display: none; }
        .carousel-slide { min-width: 100%; height: 100%; position: relative; display: flex; flex-direction: column; justify-content: flex-end; padding: 100px 50px 120px; box-sizing: border-box; overflow: hidden; scroll-snap-align: start; }
        
        .slide-bg { position: absolute; inset: 0; background-size: cover; background-position: center; z-index: 0; transition: transform 1.5s ease; }
        .slide-overlay { position: absolute; inset: 0; background: linear-gradient(135deg, rgba(15, 23, 42, 0.6) 0%, rgba(30, 58, 138, 0.7) 100%); z-index: 1; }
        .slide-overlay::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 60%; background: linear-gradient(to top, rgba(15,23,42,0.9) 0%, transparent 100%); }

        .image-content { position: relative; z-index: 2; color: #fff; transform: translateY(0); transition: all 0.6s ease; }
        .carousel-slide.active .image-content { transform: translateY(0); opacity: 1; }
        
        .image-tagline { font-size: 1rem; font-weight: 600; color: #93c5fd; margin-bottom: 12px; letter-spacing: 1.5px; text-transform: uppercase; }
        .image-title { font-size: 2.4rem; font-weight: 800; line-height: 1.2; margin-bottom: 16px; }
        .image-desc { font-size: 1rem; color: #cbd5e1; line-height: 1.6; max-width: 400px; }
        
        .slide-dots { position: absolute; bottom: 40px; left: 50px; display: flex; gap: 8px; z-index: 10; }
        .slide-dots span { width: 10px; height: 10px; border-radius: 50%; background: rgba(255,255,255,0.3); cursor: pointer; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .slide-dots span.active { background: #fff; width: 32px; border-radius: 6px; }
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
        .alert-error { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
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
        .btn-signup { background: #0f172a; color: #fff; }
        .btn-signup:hover { background: #1e293b; transform: translateY(-1px); }
        .auth-switch { text-align: center; margin-top: 28px; font-size: 0.88rem; color: #64748b; }
        .auth-switch a { color: #3b82f6; font-weight: 600; text-decoration: none; cursor: pointer; }
        .auth-switch a:hover { text-decoration: underline; }
        @media (max-width: 900px) { .auth-image { display: none; } .auth-form-panel { padding: 30px 20px; } }
    </style>

    <!-- ===== LEFT: IMAGE PANEL ===== -->
    <div class="auth-image">
        <div class="carousel-track" id="carouselTrack">
            <!-- Slide 1 -->
            <div class="carousel-slide active">
                <div class="slide-bg" style="background-image: url('https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1000&q=80')"></div>
                <div class="slide-overlay"></div>
                <div class="image-content">
                    <p class="image-tagline">Dukung UMKM Lokal</p>
                    <h2 class="image-title">Temukan Produk<br>Terbaik dari<br>UMKM di Sekitarmu.</h2>
                    <p class="image-desc">Belanja langsung dari pengusaha lokal. Mudah, cepat, dan terpercaya.</p>
                </div>
            </div>
            <!-- Slide 2 -->
            <div class="carousel-slide">
                <div class="slide-bg" style="background-image: url('https://images.unsplash.com/photo-1542838132-92c53300491e?w=1000&q=80')"></div>
                <div class="slide-overlay"></div>
                <div class="image-content">
                    <p class="image-tagline">Produk Kreatif</p>
                    <h2 class="image-title">Kreativitas Lokal<br>Tanpa Batas<br>Untuk Anda.</h2>
                    <p class="image-desc">Mulai dari kerajinan tangan hingga kuliner khas daerah, semua ada di sini.</p>
                </div>
            </div>
            <!-- Slide 3 -->
            <div class="carousel-slide">
                <div class="slide-bg" style="background-image: url('https://images.unsplash.com/photo-1513161455079-7dc1de15ef3e?w=1000&q=80')"></div>
                <div class="slide-overlay"></div>
                <div class="image-content">
                    <p class="image-tagline">Transaksi Aman</p>
                    <h2 class="image-title">Belanja Nyaman<br>Lewat WhatsApp<br>Langsung.</h2>
                    <p class="image-desc">Hubungi penjual secara langsung tanpa perantara untuk proses yang lebih personal.</p>
                </div>
            </div>
        </div>
        <div class="slide-dots">
            <span class="active" onclick="goToSlide(0)"></span>
            <span onclick="goToSlide(1)"></span>
            <span onclick="goToSlide(2)"></span>
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
                <button class="tab-btn {{ $tab === 'signup' ? 'active' : '' }}" wire:click="switchTab('signup')">Sign Up</button>
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
                    <p>Don't have an account? <a wire:click="switchTab('signup')">Sign Up</a></p>
                </div>
            </div>
            @endif

            <!-- ===== SIGNUP FORM ===== -->
            @if($tab === 'signup')
            <div class="form-panel">
                <form wire:submit.prevent="signup">
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
                        <label>Nomor WhatsApp</label>
                        <input type="text" wire:model="regPhone" class="input-field" placeholder="Contoh: 08123456789" required>
                        @error('regPhone') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <textarea wire:model="regAddress" class="input-field" placeholder="Alamat pengiriman atau lokasi toko" required rows="3" style="resize: none;"></textarea>
                        @error('regAddress') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Daftar sebagai</label>
                        <select wire:model.live="regRole" class="select-field">
                            <option value="buyer">Pembeli</option>
                            <option value="seller">Penjual</option>
                        </select>
                        @error('regRole') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                    </div>

                    @if($regRole === 'seller')
                    <div class="seller-details fade-in" style="background: #f1f5f9; padding: 20px; border-radius: 16px; margin-top: 10px; border: 1px dashed #cbd5e1;">
                        <h3 style="font-size: 1.1rem; margin-top: 0; margin-bottom: 15px; color: #1e293b; display: flex; align-items: center; gap: 8px;">
                            🏢 Informasi Toko
                        </h3>
                        
                        <div class="form-group">
                            <label>Nama Toko</label>
                            <input type="text" wire:model="storeName" class="input-field" placeholder="Nama toko Anda">
                            @error('storeName') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Deskripsi Toko</label>
                            <textarea wire:model="storeDescription" class="input-field" placeholder="Ceritakan tentang toko Anda..." rows="3"></textarea>
                            @error('storeDescription') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                            <div class="form-group">
                                <label>Telepon Toko</label>
                                <input type="text" wire:model="storePhone" class="input-field" placeholder="0812...">
                                @error('storePhone') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label>WhatsApp Toko</label>
                                <input type="text" wire:model="storeWA" class="input-field" placeholder="0812...">
                                @error('storeWA') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Kota</label>
                            <input type="text" wire:model="storeCity" class="input-field" placeholder="Contoh: Sidoarjo">
                            @error('storeCity') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Alamat Lengkap Toko</label>
                            <textarea wire:model="storeAddress" class="input-field" placeholder="Alamat fisik toko" rows="2"></textarea>
                            @error('storeAddress') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Logo Toko (Required)</label>
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div style="width: 60px; height: 60px; border-radius: 12px; background: #e2e8f0; overflow: hidden; display: flex; align-items: center; justify-content: center; border: 2px solid #fff;">
                                    @if($storeLogo)
                                        <img src="{{ $storeLogo->temporaryUrl() }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <span style="font-size: 20px;">🖼️</span>
                                    @endif
                                </div>
                                <input type="file" wire:model="storeLogo" style="font-size: 12px;">
                            </div>
                            @error('storeLogo') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Banner Toko (Optional)</label>
                            <input type="file" wire:model="storeBanner" style="font-size: 12px; width: 100%;">
                            @error('storeBanner') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label>QRIS Toko (Optional)</label>
                            <input type="file" wire:model="storeQRIS" style="font-size: 12px; width: 100%;">
                            @error('storeQRIS') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    @endif
                    <button type="submit" class="btn-submit btn-signup">
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
    <script>
        const track = document.getElementById('carouselTrack');
        const slides = document.querySelectorAll('.carousel-slide');
        const dots = document.querySelectorAll('.slide-dots span');
        let autoPlayInterval;

        function updateDots() {
            const index = Math.round(track.scrollLeft / track.offsetWidth);
            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
            });
        }

        function goToSlide(index) {
            track.scrollTo({
                left: index * track.offsetWidth,
                behavior: 'smooth'
            });
            resetAutoPlay();
        }

        function nextSlide() {
            let nextIndex = Math.round(track.scrollLeft / track.offsetWidth) + 1;
            if (nextIndex >= slides.length) nextIndex = 0;
            goToSlide(nextIndex);
        }

        function startAutoPlay() {
            autoPlayInterval = setInterval(nextSlide, 5000);
        }

        function resetAutoPlay() {
            clearInterval(autoPlayInterval);
            startAutoPlay();
        }

        track.addEventListener('scroll', () => {
            updateDots();
        });

        // Listen for title updates from Livewire
        window.addEventListener('update-title', event => {
            document.title = event.detail.title;
        });

        // Initial setup
        startAutoPlay();
        updateDots();
    </script>
</div>
