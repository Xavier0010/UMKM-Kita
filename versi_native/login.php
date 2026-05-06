<?php
require_once 'config.php';
if (isLoggedIn()) {
    header("Location: index.php");
    exit();
}
$error   = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
$tab     = $_GET['tab'] ?? 'login'; // default tab
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — UMKM Kita</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* ===== RESET ===== */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', 'Segoe UI', sans-serif; min-height: 100vh; background: #f5f5f5; }
        
        /* ===== SPLIT LAYOUT ===== */
        .auth-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* --- LEFT: Image Panel --- */
        .auth-image {
            flex: 1;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.55) 0%, rgba(30, 58, 138, 0.65) 100%),
                        url('https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&q=80') center/cover no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 60px 50px;
            position: relative;
            overflow: hidden;
        }

        .auth-image::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60%;
            background: linear-gradient(to top, rgba(15,23,42,0.85) 0%, transparent 100%);
            z-index: 1;
        }

        .image-content {
            position: relative;
            z-index: 2;
            color: #fff;
        }

        .image-tagline {
            font-size: 1rem;
            font-weight: 600;
            color: #93c5fd;
            margin-bottom: 12px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .image-title {
            font-size: 2.4rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 16px;
        }

        .image-desc {
            font-size: 1rem;
            color: #cbd5e1;
            line-height: 1.6;
            max-width: 400px;
        }

        /* Slide indicators */
        .slide-dots {
            display: flex;
            gap: 8px;
            margin-top: 30px;
        }
        .slide-dots span {
            width: 10px; height: 10px;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transition: all 0.3s;
        }
        .slide-dots span.active {
            background: #fff;
            width: 28px;
            border-radius: 5px;
        }

        /* --- RIGHT: Form Panel --- */
        .auth-form-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: #fff;
        }

        .auth-form-container {
            width: 100%;
            max-width: 420px;
        }

        /* --- Brand Header --- */
        .brand-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .brand-header h1 {
            font-size: 1.8rem;
            font-weight: 800;
            color: #0f172a;
        }

        .brand-header h1 span {
            color: #3b82f6;
        }

        .brand-header p {
            color: #64748b;
            font-size: 0.9rem;
            margin-top: 6px;
        }

        /* --- Tab Switcher --- */
        .tab-switcher {
            display: flex;
            border-radius: 12px;
            background: #f1f5f9;
            padding: 4px;
            margin-bottom: 28px;
        }

        .tab-btn {
            flex: 1;
            padding: 12px;
            border: none;
            background: transparent;
            font-family: inherit;
            font-size: 0.95rem;
            font-weight: 600;
            color: #64748b;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .tab-btn.active {
            background: #3b82f6;
            color: #fff;
            box-shadow: 0 2px 8px rgba(59,130,246,0.35);
        }

        .tab-btn:not(.active):hover {
            color: #334155;
        }

        /* --- Alert Messages --- */
        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            animation: slideDown 0.3s ease;
        }
        .alert-error { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .alert-success { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* --- Form Elements --- */
        .form-panel {
            display: none;
            animation: fadeIn 0.35s ease;
        }
        .form-panel.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-field {
            width: 100%;
            padding: 13px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.95rem;
            font-family: inherit;
            background: #f8fafc;
            transition: all 0.25s;
            color: #0f172a;
        }

        .input-field:focus {
            outline: none;
            border-color: #3b82f6;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(59,130,246,0.1);
        }

        .input-field::placeholder {
            color: #94a3b8;
        }

        /* Password toggle */
        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #94a3b8;
            font-size: 1.1rem;
            padding: 4px;
            transition: color 0.2s;
        }
        .toggle-password:hover { color: #475569; }

        .input-field.has-toggle {
            padding-right: 48px;
        }

        /* Select / Dropdown */
        .select-field {
            width: 100%;
            padding: 13px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.95rem;
            font-family: inherit;
            background: #f8fafc;
            color: #0f172a;
            cursor: pointer;
            transition: all 0.25s;
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
        }
        .select-field:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59,130,246,0.1);
        }

        /* --- Submit Button --- */
        .btn-submit {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            font-family: inherit;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 8px;
        }

        .btn-login {
            background: #3b82f6;
            color: #fff;
        }
        .btn-login:hover {
            background: #2563eb;
            box-shadow: 0 6px 20px rgba(59,130,246,0.4);
            transform: translateY(-1px);
        }

        .btn-register {
            background: #0f172a;
            color: #fff;
        }
        .btn-register:hover {
            background: #1e293b;
            box-shadow: 0 6px 20px rgba(15,23,42,0.4);
            transform: translateY(-1px);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
            box-shadow: none !important;
        }

        /* Loading spinner */
        .spinner {
            width: 18px; height: 18px;
            border: 3px solid rgba(255,255,255,0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            display: none;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* --- Divider --- */
        .divider {
            display: flex;
            align-items: center;
            margin: 24px 0;
            color: #94a3b8;
            font-size: 0.8rem;
        }
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }
        .divider span {
            padding: 0 16px;
            font-weight: 500;
        }

        /* --- Footer Link --- */
        .auth-switch {
            text-align: center;
            margin-top: 28px;
            font-size: 0.88rem;
            color: #64748b;
        }
        .auth-switch a {
            color: #3b82f6;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }
        .auth-switch a:hover {
            text-decoration: underline;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 900px) {
            .auth-image { display: none; }
            .auth-form-panel { padding: 30px 20px; }
        }

        @media (max-width: 480px) {
            .auth-form-container { max-width: 100%; }
            .brand-header h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>

<div class="auth-wrapper">
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
                <button class="tab-btn <?= $tab === 'login' ? 'active' : '' ?>" onclick="switchTab('login')" id="tabLogin">Log In</button>
                <button class="tab-btn <?= $tab === 'register' ? 'active' : '' ?>" onclick="switchTab('register')" id="tabRegister">Sign Up</button>
            </div>

            <!-- Alerts -->
            <?php if ($error): ?>
                <div class="alert alert-error">⚠️ <?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success">✅ <?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <!-- ===== LOGIN FORM ===== -->
            <div class="form-panel <?= $tab === 'login' ? 'active' : '' ?>" id="panelLogin">
                <form action="proses_login.php" method="POST" onsubmit="return handleSubmit(this, 'login')">
                    <div class="form-group">
                        <label for="loginEmail">Email Address</label>
                        <input type="email" name="email" id="loginEmail" class="input-field" placeholder="Email Address" required>
                    </div>
                    <div class="form-group">
                        <label for="loginPassword">Password</label>
                        <div class="input-wrapper">
                            <input type="password" name="password" id="loginPassword" class="input-field has-toggle" placeholder="Enter Password" required>
                            <button type="button" class="toggle-password" onclick="togglePass('loginPassword', this)">👁️</button>
                        </div>
                    </div>
                    <button type="submit" class="btn-submit btn-login" id="btnLogin">
                        <span class="spinner" id="spinnerLogin"></span>
                        <span class="btn-text">Log In</span>
                    </button>
                </form>

                <div class="auth-switch">
                    <p>Don't have an account? <a onclick="switchTab('register')">Sign Up</a></p>
                </div>
            </div>

            <!-- ===== REGISTER FORM ===== -->
            <div class="form-panel <?= $tab === 'register' ? 'active' : '' ?>" id="panelRegister">
                <form action="proses_register.php" method="POST" onsubmit="return handleSubmit(this, 'register')">
                    <div class="form-group">
                        <label for="regNama">Nama Lengkap</label>
                        <input type="text" name="nama" id="regNama" class="input-field" placeholder="Nama lengkap Anda" required>
                    </div>
                    <div class="form-group">
                        <label for="regEmail">Email Address</label>
                        <input type="email" name="email" id="regEmail" class="input-field" placeholder="Email Address" required>
                    </div>
                    <div class="form-group">
                        <label for="regPassword">Password</label>
                        <div class="input-wrapper">
                            <input type="password" name="password" id="regPassword" class="input-field has-toggle" placeholder="Minimal 6 karakter" required minlength="6">
                            <button type="button" class="toggle-password" onclick="togglePass('regPassword', this)">👁️</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="regRole">Daftar sebagai</label>
                        <select name="role" id="regRole" class="select-field">
                            <option value="pembeli">Pembeli</option>
                            <option value="penjual">Penjual</option>
                            <option value="user">User Umum</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-submit btn-register" id="btnRegister">
                        <span class="spinner" id="spinnerRegister"></span>
                        <span class="btn-text">Sign Up</span>
                    </button>
                </form>

                <div class="auth-switch">
                    <p>Already have an account? <a onclick="switchTab('login')">Log In</a></p>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ===== JAVASCRIPT ===== -->
<script>
// --- Tab Switching ---
function switchTab(tab) {
    // Toggle panels
    document.getElementById('panelLogin').classList.toggle('active', tab === 'login');
    document.getElementById('panelRegister').classList.toggle('active', tab === 'register');

    // Toggle tab buttons
    document.getElementById('tabLogin').classList.toggle('active', tab === 'login');
    document.getElementById('tabRegister').classList.toggle('active', tab === 'register');

    // Clear alerts on switch
    document.querySelectorAll('.alert').forEach(el => el.style.display = 'none');
}

// --- Password Visibility Toggle ---
function togglePass(inputId, btn) {
    let input = document.getElementById(inputId);
    if (input.type === 'password') {
        input.type = 'text';
        btn.textContent = '🙈';
    } else {
        input.type = 'password';
        btn.textContent = '👁️';
    }
}

// --- Form Submit Handler (Validation + Loading) ---
function handleSubmit(form, type) {
    // Get values
    let email, password;

    if (type === 'login') {
        email = document.getElementById('loginEmail').value.trim();
        password = document.getElementById('loginPassword').value.trim();

        if (!email || !password) {
            showAlert('Email dan password wajib diisi.', 'error');
            return false;
        }
    }

    if (type === 'register') {
        let nama = document.getElementById('regNama').value.trim();
        email = document.getElementById('regEmail').value.trim();
        password = document.getElementById('regPassword').value.trim();

        if (!nama || !email || !password) {
            showAlert('Semua field wajib diisi.', 'error');
            return false;
        }
        if (password.length < 6) {
            showAlert('Password minimal 6 karakter.', 'error');
            document.getElementById('regPassword').focus();
            return false;
        }
    }

    // Show loading state
    let btnId = type === 'login' ? 'btnLogin' : 'btnRegister';
    let spinnerId = type === 'login' ? 'spinnerLogin' : 'spinnerRegister';
    let btn = document.getElementById(btnId);
    let spinner = document.getElementById(spinnerId);

    btn.disabled = true;
    spinner.style.display = 'inline-block';
    btn.querySelector('.btn-text').textContent = 'Memproses...';

    return true;
}

// --- Dynamic Alert ---
function showAlert(message, type) {
    // Remove existing dynamic alerts
    document.querySelectorAll('.alert.dynamic').forEach(el => el.remove());

    let alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-' + type + ' dynamic';
    alertDiv.innerHTML = (type === 'error' ? '⚠️ ' : '✅ ') + message;

    // Insert before active form panel
    let activePanel = document.querySelector('.form-panel.active');
    activePanel.insertBefore(alertDiv, activePanel.firstChild);

    // Auto-hide after 5 seconds
    setTimeout(() => {
        alertDiv.style.opacity = '0';
        alertDiv.style.transform = 'translateY(-10px)';
        alertDiv.style.transition = 'all 0.3s ease';
        setTimeout(() => alertDiv.remove(), 300);
    }, 5000);
}

// --- Slide dot animation (decorative) ---
let currentDot = 0;
setInterval(() => {
    let dots = document.querySelectorAll('.slide-dots span');
    dots.forEach(d => d.classList.remove('active'));
    currentDot = (currentDot + 1) % dots.length;
    dots[currentDot].classList.add('active');
}, 3000);
</script>

</body>
</html>
