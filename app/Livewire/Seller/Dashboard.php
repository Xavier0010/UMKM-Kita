<?php

namespace App\Livewire\Seller;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Dashboard extends Component
{
    use WithPagination, WithFileUploads;

    public $activeTab = 'products'; // products, settings
    public $search = '';

    // Product Form State
    public $isEditingProduct = false;
    public $isAddingProduct = false;
    public $editingProductId = null;
    public $productData = [
        'category_id' => '',
        'name' => '',
        'description' => '',
        'price' => '',
        'stock' => '',
        'is_active' => true,
    ];
    public $productImage;

    // Store Settings State
    public $storeData = [];
    public $storeLogo;
    public $storeBanner;
    public $storeQRIS;

    public function mount()
    {
        $this->loadStoreData();
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
        $this->cancelProduct();
    }

    public function loadStoreData()
    {
        $store = Auth::user()->store;
        $this->storeData = $store->toArray();
    }

    // Product Management
    public function startAddProduct()
    {
        $this->resetProductForm();
        $this->isAddingProduct = true;
    }

    public function startEditProduct($id)
    {
        $product = Product::where('store_id', Auth::user()->store->id)->findOrFail($id);
        $this->editingProductId = $id;
        $this->productData = $product->toArray();
        $this->isEditingProduct = true;
        $this->productImage = null;
    }

    public function resetProductForm()
    {
        $this->productData = [
            'category_id' => '',
            'name' => '',
            'description' => '',
            'price' => '',
            'stock' => '',
            'is_active' => true,
        ];
        $this->productImage = null;
        $this->isAddingProduct = false;
        $this->isEditingProduct = false;
        $this->editingProductId = null;
    }

    public function cancelProduct()
    {
        $this->resetProductForm();
    }

    public function saveProduct()
    {
        $rules = [
            'productData.name' => 'required|string|max:255',
            'productData.category_id' => 'required|exists:categories,id',
            'productData.description' => 'required|string',
            'productData.price' => 'required|numeric|min:0',
            'productData.stock' => 'required|integer|min:0',
            'productData.is_active' => 'boolean',
        ];

        if ($this->isAddingProduct) {
            $rules['productImage'] = 'required|image|max:1024';
        } else {
            $rules['productImage'] = 'nullable|image|max:1024';
        }

        $this->validate($rules);

        $data = $this->productData;
        $data['store_id'] = Auth::user()->store->id;
        $data['slug'] = Str::slug($data['name']) . '-' . Str::random(5);

        if ($this->productImage) {
            $data['main_image'] = $this->productImage->store('products', 'public');
        }

        if ($this->isAddingProduct) {
            Product::create($data);
            session()->flash('message', 'Produk berhasil ditambahkan.');
        } else {
            $product = Product::findOrFail($this->editingProductId);
            // Delete old image if new one is uploaded
            if ($this->productImage && $product->main_image) {
                Storage::disk('public')->delete($product->main_image);
            }
            $product->update($data);
            session()->flash('message', 'Produk berhasil diperbarui.');
        }

        $this->resetProductForm();
    }

    public function deleteProduct($id)
    {
        $product = Product::where('store_id', Auth::user()->store->id)->findOrFail($id);
        if ($product->main_image) {
            Storage::disk('public')->delete($product->main_image);
        }
        $product->delete();
        session()->flash('message', 'Produk berhasil dihapus.');
    }

    // Store Settings Management
    public function saveStoreSettings()
    {
        $this->validate([
            'storeData.name' => 'required|string|max:255',
            'storeData.description' => 'required|string|max:1000',
            'storeData.phone' => 'required|string|max:20',
            'storeData.whatsapp' => 'required|string|max:20',
            'storeData.address' => 'required|string|max:500',
            'storeData.city' => 'required|string|max:255',
            'storeLogo' => 'nullable|image|max:1024',
            'storeBanner' => 'nullable|image|max:2048',
            'storeQRIS' => 'nullable|image|max:1024',
        ]);

        $store = Auth::user()->store;
        $updateData = $this->storeData;

        if ($this->storeLogo) {
            if ($store->logo) Storage::disk('public')->delete($store->logo);
            $updateData['logo'] = $this->storeLogo->store('stores/logos', 'public');
        }

        if ($this->storeBanner) {
            if ($store->banner) Storage::disk('public')->delete($store->banner);
            $updateData['banner'] = $this->storeBanner->store('stores/banners', 'public');
        }

        if ($this->storeQRIS) {
            if ($store->qris_image) Storage::disk('public')->delete($store->qris_image);
            $updateData['qris_image'] = $this->storeQRIS->store('stores/qris', 'public');
        }

        // Clean up data for update
        unset($updateData['id'], $updateData['user_id'], $updateData['created_at'], $updateData['updated_at'], $updateData['status'], $updateData['approved_at']);

        $store->update($updateData);
        session()->flash('message', 'Pengaturan toko berhasil diperbarui.');
        $this->loadStoreData();
        $this->storeLogo = $this->storeBanner = $this->storeQRIS = null;
    }

    public function render()
    {
        $store = Auth::user()->store;
        $products = Product::where('store_id', $store->id)
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        $categories = Category::all();

        return view('livewire.seller.dashboard', [
            'products' => $products,
            'categories' => $categories,
            'store' => $store
        ])->title('Seller Center — ' . $store->name);
    }
}
