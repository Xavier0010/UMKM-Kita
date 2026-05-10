<div class="admin-wrapper">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        
        :root {
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --bg-glass: rgba(255, 255, 255, 0.7);
            --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        }

        /* === ADMIN LAYOUT === */
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }

        .admin-wrapper {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
            background: #f1f5f9;
            font-family: 'Inter', 'Segoe UI', sans-serif;
        }

        .sidebar {
            width: 280px;
            background: white;
            border-right: 1px solid #e2e8f0;
            padding: 2rem 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 2rem;
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .sidebar-logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .nav-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .nav-item {
            padding: 0.75rem 1rem;
            border-radius: 12px;
            color: #64748b;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .nav-item:hover {
            background: #f1f5f9;
            color: #1e293b;
        }

        .nav-item.active {
            background: #eff6ff;
            color: var(--primary);
        }

        .admin-main {
            flex: 1;
            height: 100vh;
            overflow-y: auto;
            padding: 2rem;
            background: #f1f5f9;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header-title h1 {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        .header-title p {
            color: #64748b;
            margin-top: 0.25rem;
        }

        .glass-card {
            background: white;
            border-radius: 24px;
            padding: 2rem;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(226, 232, 240, 0.5);
            margin-bottom: 2rem;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 1rem;
            color: #64748b;
            font-weight: 600;
            border-bottom: 1px solid #f1f5f9;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        td {
            padding: 1rem;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.875rem;
        }

        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-active { background: #dcfce7; color: #166534; }
        .badge-inactive { background: #fee2e2; color: #991b1b; }

        .btn {
            padding: 0.625rem 1.25rem;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }

        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-hover); }
        .btn-ghost { background: transparent; color: #64748b; }
        .btn-ghost:hover { background: #f1f5f9; color: #1e293b; }
        .btn-danger { background: #fee2e2; color: #ef4444; }
        .btn-danger:hover { background: #fecaca; }

        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #475569; font-size: 0.875rem; }
        .form-input { width: 100%; padding: 0.75rem 1rem; border-radius: 12px; border: 1px solid #e2e8f0; background: #f8fafc; transition: all 0.2s; font-family: inherit; }
        .form-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1); }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeIn 0.3s ease forwards; }
        footer { display: none !important; }
    </style>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div style="width: 32px; height: 32px; border-radius: 8px; background: var(--primary); display: flex; align-items: center; justify-content: center; color: white; font-size: 14px; font-weight: bold;">
                S
            </div>
            <span>Seller Center</span>
        </div>

        <div style="padding: 1rem; background: #f8fafc; border-radius: 16px; margin-bottom: 1rem;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <img src="{{ $store->logo ? asset('storage/'.$store->logo) : 'https://ui-avatars.com/api/?name='.urlencode($store->name) }}" style="width: 40px; height: 40px; border-radius: 10px; object-fit: cover;">
                <div style="overflow: hidden;">
                    <p style="margin: 0; font-weight: 700; font-size: 0.85rem; color: #1e293b; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">{{ $store->name }}</p>
                    <p style="margin: 0; font-size: 0.75rem; color: #22c55e; font-weight: 600;">Status: Approved</p>
                </div>
            </div>
        </div>

        <nav>
            <ul class="nav-list">
                <li wire:click="setTab('products')" class="nav-item {{ $activeTab === 'products' ? 'active' : '' }}">
                    Produk Saya
                </li>
                <li wire:click="setTab('settings')" class="nav-item {{ $activeTab === 'settings' ? 'active' : '' }}">
                    Pengaturan Toko
                </li>
            </ul>
        </nav>

        <div style="margin-top: auto;">
            <a href="{{ route('home') }}" class="nav-item">
                Back to Site
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-item w-full bg-transparent border-none" style="color: #ef4444; width: 100%; text-align: left; cursor: pointer;">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
        <header class="header">
            <div class="header-title">
                <h1>{{ $activeTab === 'products' ? 'Kelola Produk' : 'Pengaturan Toko' }}</h1>
                <p>{{ $activeTab === 'products' ? 'Tambah, edit, dan hapus produk toko Anda.' : 'Perbarui informasi dan tampilan profil toko Anda.' }}</p>
            </div>
            <div class="header-actions">
                @if($activeTab === 'products' && !$isAddingProduct && !$isEditingProduct)
                    <button wire:click="startAddProduct" class="btn btn-primary">
                        + Tambah Produk
                    </button>
                @endif
            </div>
        </header>

        @if(session()->has('message'))
            <div class="fade-in" style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 12px; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.5rem;">
                {{ session('message') }}
            </div>
        @endif

        @if($activeTab === 'products')
            @if($isAddingProduct || $isEditingProduct)
                <!-- Product Form -->
                <div class="glass-card fade-in" style="max-width: 800px;">
                    <h3 style="margin-top: 0; margin-bottom: 2rem;">{{ $isAddingProduct ? 'Tambah Produk Baru' : 'Edit Produk' }}</h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                        <div class="form-section">
                            <div class="form-group">
                                <label class="form-label">Nama Produk</label>
                                <input type="text" wire:model="productData.name" class="form-input" placeholder="Nama produk">
                                @error('productData.name') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Kategori</label>
                                <select wire:model="productData.category_id" class="form-input">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                @error('productData.category_id') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                <div class="form-group">
                                    <label class="form-label">Harga (Rp)</label>
                                    <input type="number" wire:model="productData.price" class="form-input">
                                    @error('productData.price') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Stok</label>
                                    <input type="number" wire:model="productData.stock" class="form-input">
                                    @error('productData.stock') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-section">
                            <div class="form-group">
                                <label class="form-label">Foto Produk</label>
                                <div style="width: 100%; height: 180px; border-radius: 16px; background: #f1f5f9; border: 2px dashed #cbd5e1; display: flex; align-items: center; justify-content: center; overflow: hidden; margin-bottom: 1rem;">
                                    @if($productImage)
                                        <img src="{{ $productImage->temporaryUrl() }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @elseif(isset($productData['main_image']) && $productData['main_image'])
                                        <img src="{{ asset('storage/'.$productData['main_image']) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <span style="color: #94a3b8;">Klik untuk upload foto</span>
                                    @endif
                                </div>
                                <input type="file" wire:model="productImage">
                                @error('productImage') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Status Produk</label>
                                <select wire:model="productData.is_active" class="form-input">
                                    <option value="1">Aktif (Tampil di Katalog)</option>
                                    <option value="0">Draft (Sembunyikan)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 1rem;">
                        <label class="form-label">Deskripsi Produk</label>
                        <textarea wire:model="productData.description" class="form-input" rows="4"></textarea>
                        @error('productData.description') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                    </div>
                    <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem;">
                        <button wire:click="cancelProduct" class="btn btn-ghost">Batal</button>
                        <button wire:click="saveProduct" class="btn btn-primary">Simpan Produk</button>
                    </div>
                </div>
            @else
                <!-- Product List -->
                <div class="glass-card fade-in">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <div style="position: relative; width: 300px;">
                            <input type="text" wire:model.live="search" class="form-input" placeholder="Cari produk..." style="padding-left: 1rem;">
                        </div>
                    </div>

                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Status</th>
                                    <th style="text-align: right;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $prod)
                                    <tr>
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 12px;">
                                                <img src="{{ asset('storage/'.$prod->main_image) }}" style="width: 45px; height: 45px; border-radius: 8px; object-fit: cover;">
                                                <span style="font-weight: 600;">{{ $prod->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $prod->category->name }}</td>
                                        <td>Rp {{ number_format($prod->price, 0, ',', '.') }}</td>
                                        <td>{{ $prod->stock }}</td>
                                        <td>
                                            <span class="badge {{ $prod->is_active ? 'badge-active' : 'badge-inactive' }}">
                                                {{ $prod->is_active ? 'Aktif' : 'Draft' }}
                                            </span>
                                        </td>
                                        <td style="text-align: right;">
                                            <button wire:click="startEditProduct({{ $prod->id }})" class="btn btn-ghost" style="padding: 0.5rem;">Edit</button>
                                            <button onclick="confirm('Hapus produk ini?') || event.stopImmediatePropagation()" wire:click="deleteProduct({{ $prod->id }})" class="btn btn-ghost" style="padding: 0.5rem; color: #ef4444;">Hapus</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center; padding: 3rem; color: #94a3b8;">Belum ada produk.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div style="margin-top: 1.5rem;">
                        {{ $products->links() }}
                    </div>
                </div>
            @endif
        @else
            <!-- Store Settings -->
            <div class="glass-card fade-in" style="max-width: 900px;">
                <h3 style="margin-top: 0; margin-bottom: 2rem;">Profil & Informasi Toko</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem;">
                    <div class="form-section">
                        <div class="form-group">
                            <label class="form-label">Nama Toko</label>
                            <input type="text" wire:model="storeData.name" class="form-input">
                            @error('storeData.name') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Deskripsi Toko</label>
                            <textarea wire:model="storeData.description" class="form-input" rows="4"></textarea>
                            @error('storeData.description') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label class="form-label">Telepon</label>
                                <input type="text" wire:model="storeData.phone" class="form-input">
                                @error('storeData.phone') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">WhatsApp</label>
                                <input type="text" wire:model="storeData.whatsapp" class="form-input">
                                @error('storeData.whatsapp') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kota</label>
                            <input type="text" wire:model="storeData.city" class="form-input">
                            @error('storeData.city') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Alamat</label>
                            <textarea wire:model="storeData.address" class="form-input" rows="3"></textarea>
                            @error('storeData.address') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-section">
                        <div class="form-group">
                            <label class="form-label">Logo Toko</label>
                            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                                <img src="{{ $storeLogo ? $storeLogo->temporaryUrl() : ($store->logo ? asset('storage/'.$store->logo) : 'https://via.placeholder.com/100') }}" style="width: 80px; height: 80px; border-radius: 16px; object-fit: cover; border: 2px solid #e2e8f0;">
                                <input type="file" wire:model="storeLogo" style="font-size: 12px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Banner Toko</label>
                            <div style="margin-bottom: 0.5rem;">
                                <img src="{{ $storeBanner ? $storeBanner->temporaryUrl() : ($store->banner ? asset('storage/'.$store->banner) : 'https://via.placeholder.com/400x150') }}" style="width: 100%; height: 100px; border-radius: 12px; object-fit: cover; border: 2px solid #e2e8f0;">
                            </div>
                            <input type="file" wire:model="storeBanner" style="font-size: 12px;">
                        </div>
                        <div class="form-group">
                            <label class="form-label">QRIS Toko</label>
                            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                                <img src="{{ $storeQRIS ? $storeQRIS->temporaryUrl() : ($store->qris_image ? asset('storage/'.$store->qris_image) : 'https://via.placeholder.com/100') }}" style="width: 80px; height: 80px; border-radius: 8px; object-fit: contain; border: 2px solid #e2e8f0;">
                                <input type="file" wire:model="storeQRIS" style="font-size: 12px;">
                            </div>
                        </div>
                        <div style="padding: 1.5rem; background: #fffbeb; border-radius: 16px; border: 1px solid #fde68a;">
                            <p style="margin: 0; font-size: 0.85rem; color: #92400e;">
                                <strong>Tips:</strong> Gunakan logo dengan latar belakang transparan (PNG) untuk tampilan terbaik di katalog.
                            </p>
                        </div>
                    </div>
                </div>
                <div style="display: flex; justify-content: flex-end; margin-top: 3rem; padding-top: 2rem; border-top: 1px solid #f1f5f9;">
                    <button wire:click="saveStoreSettings" class="btn btn-primary" style="padding: 1rem 2.5rem;">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        @endif
    </main>
</div>
