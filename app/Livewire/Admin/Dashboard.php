<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    use WithPagination;

    public $activeTab = 'statistics'; // statistics, users, stores, products, categories, orders
    
    // DBMS State
    public $editingId = null;
    public $isAdding = false;
    public $formData = [];
    public $search = '';

    protected $queryString = ['activeTab'];

    public function mount()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home');
        }
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
        $this->resetDBMS();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function resetDBMS()
    {
        $this->editingId = null;
        $this->isAdding = false;
        $this->formData = [];
        $this->search = '';
    }

    // Generic DBMS Methods
    public function startAdd()
    {
        $this->isAdding = true;
        $this->editingId = null;
        $this->formData = [];
        
        // Pre-fill columns based on table
        $table = $this->getTable();
        $columns = Schema::getColumnListing($table);
        foreach ($columns as $column) {
            if (!in_array($column, ['id', 'created_at', 'updated_at', 'password', 'remember_token', 'email_verified_at', 'approved_at'])) {
                $this->formData[$column] = '';
            }
        }
    }

    public function startEdit($id)
    {
        $this->editingId = $id;
        $this->isAdding = false;
        $data = (array) DB::table($this->getTable())->where('id', $id)->first();
        $this->formData = $data;
        unset($this->formData['id'], $this->formData['created_at'], $this->formData['updated_at'], $this->formData['password'], $this->formData['remember_token'], $this->formData['email_verified_at']);
    }

    public function cancel()
    {
        $this->resetDBMS();
    }

    public function save()
    {
        $table = $this->getTable();
        
        if ($this->isAdding) {
            $this->formData['created_at'] = now();
            $this->formData['updated_at'] = now();
            DB::table($table)->insert($this->formData);
            session()->flash('message', 'Data added successfully.');
        } else {
            $this->formData['updated_at'] = now();
            DB::table($table)->where('id', $this->editingId)->update($this->formData);
            session()->flash('message', 'Data updated successfully.');
        }

        $this->resetDBMS();
    }

    public function delete($id)
    {
        DB::table($this->getTable())->where('id', $id)->delete();
        session()->flash('message', 'Data deleted successfully.');
    }

    // Specific Store Actions
    public function approveStore($id)
    {
        DB::table('stores')->where('id', $id)->update([
            'status' => 'approved',
            'approved_at' => now(),
            'updated_at' => now()
        ]);
        session()->flash('message', 'Store approved.');
    }

    public function rejectStore($id)
    {
        DB::table('stores')->where('id', $id)->update([
            'status' => 'rejected',
            'updated_at' => now()
        ]);
        session()->flash('message', 'Store rejected.');
    }

    private function getTable()
    {
        return match ($this->activeTab) {
            'users' => 'users',
            'stores' => 'stores',
            'products' => 'products',
            'categories' => 'categories',
            'orders' => 'orders',
            default => 'users',
        };
    }

    public function render()
    {
        $stats = [
            'penjual' => DB::table('users')->where('role', 'seller')->count(),
            'pembeli' => DB::table('users')->where('role', 'buyer')->count(),
            'total_produk' => DB::table('products')->count(),
            'pending_stores' => DB::table('stores')->where('status', 'pending')->count(),
        ];

        $tableData = [];
        $columns = [];

        if ($this->activeTab !== 'statistics') {
            $table = $this->getTable();
            $query = DB::table($table);
            
            if ($this->search) {
                // Simple search logic
                $cols = Schema::getColumnListing($table);
                $query->where(function($q) use ($cols) {
                    foreach ($cols as $col) {
                        $q->orWhere($col, 'like', '%' . $this->search . '%');
                    }
                });
            }

            $tableData = $query->latest('id')->paginate(10);
            $columns = Schema::getColumnListing($table);
            // Filter columns to show in table
            $columns = array_filter($columns, fn($c) => !in_array($c, ['password', 'remember_token', 'email_verified_at', 'updated_at']));
        }

        return view('livewire.admin.dashboard', [
            'stats' => $stats,
            'tableData' => $tableData,
            'columns' => $columns
        ])->title('Admin Dashboard — UMKM Kita');
    }
}
