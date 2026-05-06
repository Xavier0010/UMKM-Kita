<div>
    <style>
        /* Modern Landing Page Styles */
        :root {
            --primary: #4F46E5;
            --primary-hover: #4338CA;
            --secondary: #EC4899;
            --dark: #1E293B;
            --light: #F8FAFC;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            color: var(--dark);
            overflow-x: hidden;
        }

        .landing-nav {
            position: fixed;
            top: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 5%;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            z-index: 100;
            box-sizing: border-box;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .landing-logo {
            font-size: 24px;
            font-weight: 800;
            color: var(--dark);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .landing-logo span {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .landing-nav-links a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            margin-left: 20px;
            transition: color 0.3s;
        }

        .landing-nav-links a:hover {
            color: var(--primary);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white !important;
            padding: 10px 24px;
            border-radius: 50px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary) !important;
            border: 2px solid var(--primary);
            padding: 8px 22px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white !important;
        }

        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 5%;
            padding-top: 80px;
            position: relative;
            overflow: hidden;
            background: radial-gradient(circle at top right, rgba(236,72,153,0.1), transparent 40%),
                        radial-gradient(circle at bottom left, rgba(79,70,229,0.1), transparent 40%);
        }

        .hero-content {
            flex: 1;
            max-width: 600px;
            z-index: 2;
            animation: slideUp 1s ease-out forwards;
        }

        .hero-badge {
            display: inline-block;
            padding: 8px 16px;
            background: rgba(79, 70, 229, 0.1);
            color: var(--primary);
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 20px;
            backdrop-filter: blur(5px);
        }

        .hero-content h1 {
            font-size: 56px;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 24px;
            color: var(--dark);
        }

        .hero-content p {
            font-size: 18px;
            color: #64748B;
            line-height: 1.6;
            margin-bottom: 40px;
        }

        .hero-actions {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .hero-image {
            flex: 1;
            display: flex;
            justify-content: flex-end;
            position: relative;
            z-index: 1;
        }

        .hero-image img {
            max-width: 100%;
            width: 550px;
            height: auto;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            transform: perspective(1000px) rotateY(-10deg) rotateX(5deg);
            transition: transform 0.5s ease;
            animation: float 6s ease-in-out infinite;
        }

        .hero-image:hover img {
            transform: perspective(1000px) rotateY(0deg) rotateX(0deg);
        }

        /* Abstract shapes */
        .shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            z-index: 0;
            opacity: 0.6;
        }

        .shape-1 {
            top: -100px;
            right: -100px;
            width: 400px;
            height: 400px;
            background: rgba(236, 72, 153, 0.3);
            animation: morph 8s ease-in-out infinite alternate;
        }

        .shape-2 {
            bottom: -50px;
            left: -100px;
            width: 300px;
            height: 300px;
            background: rgba(79, 70, 229, 0.3);
            animation: morph 6s ease-in-out infinite alternate-reverse;
        }

        /* Features Section */
        .features-section {
            padding: 100px 5%;
            background: #f8fafc;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-header h2 {
            font-size: 36px;
            color: var(--dark);
            margin-bottom: 15px;
        }

        .section-header p {
            color: #64748b;
            font-size: 18px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
        }

        .feature-card {
            background: white;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            transition: transform 0.3s ease;
            text-align: center;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-icon {
            font-size: 40px;
            margin-bottom: 20px;
            display: inline-block;
            background: rgba(79, 70, 229, 0.1);
            width: 80px;
            height: 80px;
            line-height: 80px;
            border-radius: 50%;
        }

        .feature-card h3 {
            font-size: 22px;
            margin-bottom: 15px;
            color: var(--dark);
        }

        .feature-card p {
            color: #64748b;
            line-height: 1.6;
        }

        /* Call to Action */
        .cta-section {
            padding: 100px 5%;
            background: linear-gradient(135deg, var(--dark), #0f172a);
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .cta-content {
            position: relative;
            z-index: 2;
            max-width: 600px;
            margin: 0 auto;
        }

        .cta-content h2 {
            font-size: 40px;
            margin-bottom: 20px;
        }

        .cta-content p {
            font-size: 18px;
            color: #cbd5e1;
            margin-bottom: 40px;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes float {
            0% { transform: translateY(0px) perspective(1000px) rotateY(-10deg) rotateX(5deg); }
            50% { transform: translateY(-20px) perspective(1000px) rotateY(-5deg) rotateX(2deg); }
            100% { transform: translateY(0px) perspective(1000px) rotateY(-10deg) rotateX(5deg); }
        }

        @keyframes morph {
            0% { border-radius: 40% 60% 70% 30% / 40% 40% 60% 50%; }
            100% { border-radius: 58% 42% 75% 25% / 76% 46% 54% 24%; }
        }

        /* Hide global footer if on landing page (optional) */
        footer { display: none !important; }

        @media (max-width: 768px) {
            .hero-section {
                flex-direction: column;
                text-align: center;
                padding-top: 120px;
            }
            .hero-actions {
                justify-content: center;
            }
            .hero-image {
                margin-top: 50px;
            }
            .hero-content h1 {
                font-size: 40px;
            }
        }
    </style>

    <!-- Navigation -->
    <nav class="landing-nav">
        <a href="/" class="landing-logo">🛍️ <span>UMKM Kita</span></a>
        <div class="landing-nav-links">
            <a href="{{ route('authentication', ['tab' => 'login']) }}" class="btn-outline">Masuk</a>
            <a href="{{ route('authentication', ['tab' => 'register']) }}" class="btn-primary">Daftar Sekarang</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        
        <div class="hero-content">
            <div class="hero-badge">🚀 Platform UMKM Nomor 1</div>
            <h1>Berdayakan Bisnis Lokal Bersama Kami</h1>
            <p>UMKM Kita menghubungkan produk-produk kreatif dan berkualitas dari pengrajin lokal langsung ke tangan Anda. Dukung ekonomi daerah dengan berbelanja cerdas hari ini.</p>
            <div class="hero-actions">
                <a href="{{ route('catalog') }}" class="btn-primary" style="padding: 14px 32px; font-size: 16px;">Lihat Katalog</a>
                <a href="#fitur" class="btn-outline" style="padding: 12px 28px; font-size: 16px;">Pelajari Lebih Lanjut</a>
            </div>
        </div>

        <div class="hero-image">
            <img src="https://images.unsplash.com/photo-1556740738-b6a63e27c4df?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="UMKM Lokal" onerror="this.src='https://placehold.co/800x600/e2e8f0/64748b?text=UMKM+Lokal'">
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="fitur">
        <div class="section-header">
            <h2>Mengapa Memilih UMKM Kita?</h2>
            <p>Platform yang dirancang khusus untuk memajukan produk lokal Indonesia.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">✨</div>
                <h3>Kualitas Terjamin</h3>
                <p>Setiap produk telah melalui proses kurasi ketat untuk memastikan Anda mendapatkan yang terbaik dari UMKM lokal.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💬</div>
                <h3>Pesan via WhatsApp</h3>
                <p>Komunikasi langsung dan transaksi mudah melalui WhatsApp dengan para penjual tanpa biaya tambahan platform.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🤝</div>
                <h3>Dukung Ekonomi Lokal</h3>
                <p>Setiap pembelian Anda memberikan dampak langsung terhadap kesejahteraan pengrajin dan pelaku usaha daerah.</p>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="shape shape-1" style="background: rgba(255,255,255,0.1); right: 10%; left: auto;"></div>
        <div class="cta-content">
            <h2>Siap untuk Mulai Berbelanja?</h2>
            <p>Bergabunglah dengan ribuan pembeli lainnya yang telah mendukung produk UMKM lokal.</p>
            <a href="{{ route('authentication', ['tab' => 'register']) }}" class="btn-primary" style="background: white; color: var(--dark) !important; padding: 14px 40px; font-size: 18px;">Buat Akun Gratis</a>
        </div>
    </section>

    <!-- Landing Footer -->
    <footer style="display: block !important; background: var(--dark); color: #cbd5e1; text-align: center; padding: 30px 5%; border-top: 1px solid rgba(255,255,255,0.1);">
        <p>&copy; {{ date('Y') }} UMKM Kita — SMK Telkom Sidoarjo. Dibuat dengan ❤️ untuk UMKM lokal.</p>
    </footer>
</div>
