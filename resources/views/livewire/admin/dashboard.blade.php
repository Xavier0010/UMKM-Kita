<div class="admin-wrapper">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
        
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
            background: #f8fafc;
            font-family: 'Plus Jakarta Sans', sans-serif;
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
            background: #f8fafc;
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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(226, 232, 240, 0.5);
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 1.25rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            line-height: 1;
        }

        .stat-label {
            color: #64748b;
            font-weight: 500;
            margin-top: 0.5rem;
        }

        .glass-card {
            background: white;
            border-radius: 24px;
            padding: 2rem;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(226, 232, 240, 0.5);
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

        tr:last-child td {
            border-bottom: none;
        }

        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-approved { background: #dcfce7; color: #166534; }
        .badge-rejected { background: #fee2e2; color: #991b1b; }

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
        .btn-success { background: #dcfce7; color: #22c55e; }
        .btn-success:hover { background: #bbf7d0; }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #475569;
            font-size: 0.875rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            transition: all 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.3s ease forwards;
        }

        /* Hide global footer */
        footer {
            display: none !important;
        }
    </style>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="24" height="24" rx="6" fill="#2563EB"/>
                <path d="M12 7V17M7 12H17" stroke="white" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <span>Admin Kita</span>
        </div>

        <nav>
            <ul class="nav-list">
                <li wire:click="setTab('statistics')" class="nav-item {{ $activeTab === 'statistics' ? 'active' : '' }}">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Statistics
                </li>
                <li wire:click="setTab('users')" class="nav-item {{ $activeTab === 'users' ? 'active' : '' }}">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Users Management
                </li>
                <li wire:click="setTab('stores')" class="nav-item {{ $activeTab === 'stores' ? 'active' : '' }}">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Stores & Approvals
                </li>
                <li wire:click="setTab('products')" class="nav-item {{ $activeTab === 'products' ? 'active' : '' }}">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Products Catalog
                </li>
                <li wire:click="setTab('categories')" class="nav-item {{ $activeTab === 'categories' ? 'active' : '' }}">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 11h.01M7 15h.01M11 7h.01M11 11h.01M11 15h.01M15 7h.01M15 11h.01M15 15h.01"></path></svg>
                    Categories
                </li>
                <li wire:click="setTab('orders')" class="nav-item {{ $activeTab === 'orders' ? 'active' : '' }}">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Orders
                </li>
            </ul>
        </nav>

        <div style="margin-top: auto;">
            <a href="{{ route('home') }}" class="nav-item">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Back to Site
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-item w-full bg-transparent border-none" style="color: #ef4444;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
        <header class="header">
            <div class="header-title">
                <h1>{{ ucfirst($activeTab) }}</h1>
                <p>Manage your application data and monitors stats</p>
            </div>
            <div class="header-actions">
                @if($activeTab !== 'statistics')
                    <button wire:click="startAdd" class="btn btn-primary">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Add New Data
                    </button>
                @endif
            </div>
        </header>

        @if(session()->has('message'))
            <div class="fade-in" style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 12px; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.5rem;">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                {{ session('message') }}
            </div>
        @endif

        @if($activeTab === 'statistics')
            <div class="stats-grid fade-in">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #eff6ff; color: #2563eb;">👤</div>
                    <div class="stat-value">{{ number_format($stats['pembeli']) }}</div>
                    <div class="stat-label">Total Buyers</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #fdf2f8; color: #db2777;">🛍️</div>
                    <div class="stat-value">{{ number_format($stats['penjual']) }}</div>
                    <div class="stat-label">Total Sellers</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #f0fdf4; color: #16a34a;">📦</div>
                    <div class="stat-value">{{ number_format($stats['total_produk']) }}</div>
                    <div class="stat-label">Products Registered</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #fffbeb; color: #d97706;">⏳</div>
                    <div class="stat-value">{{ number_format($stats['pending_stores']) }}</div>
                    <div class="stat-label">Pending Verifications</div>
                </div>
            </div>

            <!-- Recent Activity Placeholder -->
            <div class="glass-card fade-in">
                <h3 style="margin-top: 0; color: #1e293b;">Quick Overview</h3>
                <p style="color: #64748b;">Welcome back, Admin. You have <strong>{{ $stats['pending_stores'] }}</strong> store registration requests waiting for your approval.</p>
                <button wire:click="setTab('stores')" class="btn btn-primary" style="margin-top: 1rem;">Go to Approvals</button>
            </div>
        @else
            <!-- DBMS Section -->
            <div class="fade-in">
                @if($isAdding || $editingId)
                    <!-- Edit/Add Form -->
                    <div class="glass-card" style="max-width: 800px;">
                        <h3 style="margin-top: 0; margin-bottom: 1.5rem;">{{ $isAdding ? 'Add New' : 'Edit' }} {{ ucfirst($activeTab) }}</h3>
                        <div class="grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            @foreach($formData as $key => $value)
                                @if(!in_array($key, ['id', 'created_at', 'updated_at']))
                                    <div class="form-group" style="{{ count($formData) % 2 !== 0 && $loop->last ? 'grid-column: span 2;' : '' }}">
                                        <label class="form-label">{{ ucwords(str_replace('_', ' ', $key)) }}</label>
                                        @if(in_array($key, ['description', 'address']))
                                            <textarea wire:model="formData.{{ $key }}" class="form-input" rows="3"></textarea>
                                        @elseif($key === 'role')
                                            <select wire:model="formData.{{ $key }}" class="form-input">
                                                <option value="buyer">Buyer</option>
                                                <option value="seller">Seller</option>
                                                <option value="admin">Admin</option>
                                            </select>
                                        @elseif($key === 'status' && $activeTab === 'stores')
                                            <select wire:model="formData.{{ $key }}" class="form-input">
                                                <option value="pending">Pending</option>
                                                <option value="approved">Approved</option>
                                                <option value="rejected">Rejected</option>
                                            </select>
                                        @else
                                            <input type="text" wire:model="formData.{{ $key }}" class="form-input">
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div style="margin-top: 2rem; display: flex; gap: 1rem; justify-content: flex-end;">
                            <button wire:click="cancel" class="btn btn-ghost">Cancel</button>
                            <button wire:click="save" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                @else
                    <!-- Search and Table -->
                    <div class="glass-card">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                            <div style="position: relative; width: 300px;">
                                <input type="text" wire:model.live="search" class="form-input" placeholder="Search data..." style="padding-left: 2.5rem;">
                                <svg style="position: absolute; left: 0.875rem; top: 50%; transform: translateY(-50%); color: #94a3b8;" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                        </div>

                        <div class="table-container">
                            <table>
                                <thead>
                                    <tr>
                                        @foreach($columns as $col)
                                            <th>{{ str_replace('_', ' ', $col) }}</th>
                                        @endforeach
                                        <th style="text-align: right;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tableData as $row)
                                        <tr>
                                            @foreach($columns as $col)
                                                <td>
                                                    @if($col === 'status')
                                                        <span class="badge badge-{{ $row->$col }}">{{ ucfirst($row->$col) }}</span>
                                                    @elseif($col === 'logo' || $col === 'banner' || $col === 'main_image')
                                                        @if($row->$col)
                                                            <img src="{{ $row->$col }}" alt="image" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;">
                                                        @else
                                                            <span style="color: #cbd5e1;">None</span>
                                                        @endif
                                                    @else
                                                        {{ \Illuminate\Support\Str::limit($row->$col, 30) }}
                                                    @endif
                                                </td>
                                            @endforeach
                                            <td style="text-align: right;">
                                                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                                    @if($activeTab === 'stores' && $row->status === 'pending')
                                                        <button wire:click="approveStore({{ $row->id }})" class="btn btn-success" style="padding: 0.4rem; border-radius: 8px;" title="Approve">
                                                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                        </button>
                                                        <button wire:click="rejectStore({{ $row->id }})" class="btn btn-danger" style="padding: 0.4rem; border-radius: 8px; background: #fee2e2; color: #ef4444;" title="Reject">
                                                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                        </button>
                                                    @endif
                                                    <button wire:click="startEdit({{ $row->id }})" class="btn btn-ghost" style="padding: 0.4rem; border-radius: 8px;">
                                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                    </button>
                                                    <button onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="delete({{ $row->id }})" class="btn btn-ghost" style="padding: 0.4rem; border-radius: 8px; color: #ef4444;">
                                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="{{ count($columns) + 1 }}" style="text-align: center; padding: 3rem; color: #94a3b8;">
                                                No data found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div style="margin-top: 1.5rem;">
                            {{ $tableData->links() }}
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </main>
</div>
