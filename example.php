<!doctype html>
<html lang="en" class="h-full">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory Manager</title>
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <script src="/_sdk/element_sdk.js"></script>
  <script src="/_sdk/data_sdk.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
  <style>
    * { font-family: 'DM Sans', sans-serif; }
    .low-stock { animation: pulse-warning 2s infinite; }
    @keyframes pulse-warning {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.7; }
    }
    .fade-in { animation: fadeIn 0.3s ease-out; }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
  <style>body { box-sizing: border-box; }</style>
 </head>
 <body class="h-full"><!-- Login Screen -->
  <div id="login-screen" class="h-full w-full flex items-center justify-center p-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
   <div class="w-full max-w-md">
    <div class="text-center mb-12">
     <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6" style="background: #6366f1;">
      <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewbox="0 0 24 24">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
      </svg>
     </div>
     <h1 class="text-4xl font-bold text-white mb-2">Inventory Manager</h1>
     <p style="color: #94a3b8;">Select your role to continue</p>
    </div>
    <div class="space-y-3"><button onclick="loginAs('staff')" class="w-full px-6 py-4 rounded-xl font-semibold text-white transition-all hover:scale-105" style="background: #6366f1;">
      <div class="flex items-center justify-center gap-2">
       <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
       </svg><span>Continue as Staff</span>
      </div></button> <button onclick="loginAs('admin')" class="w-full px-6 py-4 rounded-xl font-semibold text-white transition-all hover:scale-105" style="background: #8b5cf6;">
      <div class="flex items-center justify-center gap-2">
       <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
       </svg><span>Continue as Admin</span>
      </div></button>
    </div>
    <div class="mt-8 pt-8 border-t border-slate-700">
     <p class="text-center text-sm" style="color: #64748b;"><strong style="color: #94a3b8;">Staff:</strong> View and adjust quantities<br><strong style="color: #94a3b8;">Admin:</strong> Full management access</p>
    </div>
   </div>
  </div><!-- App Container -->
  <div id="app-container" class="hidden h-full w-full overflow-auto" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
   <div class="max-w-6xl mx-auto p-6"><!-- Header -->
    <header class="mb-8">
     <div class="flex items-center justify-between flex-wrap gap-4">
      <div class="flex items-center gap-3">
       <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: #6366f1;">
        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewbox="0 0 24 24">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
        </svg>
       </div>
       <div>
        <h1 id="app-title" class="text-3xl font-bold text-white">Inventory Manager</h1>
        <p id="role-badge" class="text-sm" style="color: #64748b;">Staff</p>
       </div>
      </div>
      <div class="flex gap-3"><button id="add-btn" onclick="openModal()" class="px-5 py-2.5 rounded-xl font-semibold text-white transition-all hover:scale-105" style="background: #6366f1;"> <span class="flex items-center gap-2">
         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
         </svg><span id="add-btn-text">Add Item</span> </span> </button> <button onclick="logout()" class="px-4 py-2.5 rounded-xl font-semibold text-white transition-all" style="background: #334155;">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
        </svg></button>
      </div>
     </div>
    </header><!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
     <div class="rounded-2xl p-5" style="background: #1e293b; border: 1px solid #334155;">
      <div class="flex items-center gap-3">
       <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: rgba(99, 102, 241, 0.2);">
        <svg class="w-5 h-5" style="color: #6366f1;" fill="none" stroke="currentColor" viewbox="0 0 24 24">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
        </svg>
       </div>
       <div>
        <p class="text-sm" style="color: #94a3b8;">Total Items</p>
        <p id="stat-total" class="text-2xl font-bold text-white">0</p>
       </div>
      </div>
     </div>
     <div class="rounded-2xl p-5" style="background: #1e293b; border: 1px solid #334155;">
      <div class="flex items-center gap-3">
       <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: rgba(34, 197, 94, 0.2);">
        <svg class="w-5 h-5" style="color: #22c55e;" fill="none" stroke="currentColor" viewbox="0 0 24 24">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
       </div>
       <div>
        <p class="text-sm" style="color: #94a3b8;">In Stock</p>
        <p id="stat-instock" class="text-2xl font-bold text-white">0</p>
       </div>
      </div>
     </div>
     <div class="rounded-2xl p-5" style="background: #1e293b; border: 1px solid #334155;">
      <div class="flex items-center gap-3">
       <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: rgba(249, 115, 22, 0.2);">
        <svg class="w-5 h-5" style="color: #f97316;" fill="none" stroke="currentColor" viewbox="0 0 24 24">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
       </div>
       <div>
        <p class="text-sm" style="color: #94a3b8;">Low Stock</p>
        <p id="stat-low" class="text-2xl font-bold text-white">0</p>
       </div>
      </div>
     </div>
     <div class="rounded-2xl p-5" style="background: #1e293b; border: 1px solid #334155;">
      <div class="flex items-center gap-3">
       <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: rgba(239, 68, 68, 0.2);">
        <svg class="w-5 h-5" style="color: #ef4444;" fill="none" stroke="currentColor" viewbox="0 0 24 24">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
        </svg>
       </div>
       <div>
        <p class="text-sm" style="color: #94a3b8;">Out of Stock</p>
        <p id="stat-out" class="text-2xl font-bold text-white">0</p>
       </div>
      </div>
     </div>
    </div><!-- Search and Filter -->
    <div class="flex flex-wrap gap-4 mb-6">
     <div class="flex-1 min-w-[200px]">
      <div class="relative">
       <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5" style="color: #64748b;" fill="none" stroke="currentColor" viewbox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
       </svg><input type="text" id="search-input" placeholder="Search by name or SKU..." class="w-full pl-12 pr-4 py-3 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2" style="background: #1e293b; border: 1px solid #334155;" oninput="filterItems()">
      </div>
     </div><select id="category-filter" onchange="filterItems()" class="px-4 py-3 rounded-xl text-white focus:outline-none focus:ring-2" style="background: #1e293b; border: 1px solid #334155;"> <option value="">All Categories</option> <option value="Electronics">Electronics</option> <option value="Clothing">Clothing</option> <option value="Food">Food</option> <option value="Office">Office</option> <option value="Other">Other</option> </select> <select id="stock-filter" onchange="filterItems()" class="px-4 py-3 rounded-xl text-white focus:outline-none focus:ring-2" style="background: #1e293b; border: 1px solid #334155;"> <option value="">All Stock Levels</option> <option value="in-stock">In Stock</option> <option value="low-stock">Low Stock</option> <option value="out-of-stock">Out of Stock</option> </select>
    </div><!-- Inventory Table -->
    <div class="rounded-2xl overflow-hidden" style="background: #1e293b; border: 1px solid #334155;">
     <div class="overflow-x-auto">
      <table class="w-full">
       <thead>
        <tr style="background: #0f172a;">
         <th class="px-6 py-4 text-left text-sm font-semibold" style="color: #94a3b8;">Product</th>
         <th class="px-6 py-4 text-left text-sm font-semibold" style="color: #94a3b8;">SKU</th>
         <th class="px-6 py-4 text-left text-sm font-semibold" style="color: #94a3b8;">Category</th>
         <th class="px-6 py-4 text-center text-sm font-semibold" style="color: #94a3b8;">Quantity</th>
         <th class="px-6 py-4 text-center text-sm font-semibold" style="color: #94a3b8;">Status</th>
         <th class="px-6 py-4 text-right text-sm font-semibold" style="color: #94a3b8;">Price</th>
         <th class="px-6 py-4 text-center text-sm font-semibold" style="color: #94a3b8;">Actions</th>
        </tr>
       </thead>
       <tbody id="inventory-table">
        <!-- Items will be rendered here -->
       </tbody>
      </table>
     </div>
     <div id="empty-state" class="hidden p-12 text-center">
      <svg class="w-16 h-16 mx-auto mb-4" style="color: #475569;" fill="none" stroke="currentColor" viewbox="0 0 24 24">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
      </svg>
      <p class="text-lg font-medium" style="color: #94a3b8;">No items in inventory</p>
      <p class="text-sm mt-1" style="color: #64748b;">Add your first item to get started</p>
     </div>
     <div id="no-results" class="hidden p-12 text-center">
      <svg class="w-16 h-16 mx-auto mb-4" style="color: #475569;" fill="none" stroke="currentColor" viewbox="0 0 24 24">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
      </svg>
      <p class="text-lg font-medium" style="color: #94a3b8;">No matching items</p>
      <p class="text-sm mt-1" style="color: #64748b;">Try adjusting your search or filters</p>
     </div>
    </div><!-- Limit Warning -->
    <div id="limit-warning" class="hidden mt-4 p-4 rounded-xl" style="background: rgba(249, 115, 22, 0.1); border: 1px solid #f97316;">
     <p class="text-sm font-medium" style="color: #f97316;">⚠️ You've reached the maximum limit of 999 items. Please delete some items to add more.</p>
    </div>
   </div>
  </div><!-- Add/Edit Modal -->
  <div id="modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" style="background: rgba(0, 0, 0, 0.7);">
   <div class="w-full max-w-md rounded-2xl p-6 fade-in" style="background: #1e293b; border: 1px solid #334155;">
    <div class="flex items-center justify-between mb-6">
     <h2 id="modal-title" class="text-xl font-bold text-white">Add New Item</h2><button onclick="closeModal()" class="p-2 rounded-lg hover:bg-slate-700 transition-colors">
      <svg class="w-5 h-5" style="color: #94a3b8;" fill="none" stroke="currentColor" viewbox="0 0 24 24">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg></button>
    </div>
    <form id="item-form" onsubmit="handleSubmit(event)">
     <div class="space-y-4">
      <div>
       <label for="item-name" class="block text-sm font-medium mb-2" style="color: #94a3b8;">Product Name</label> <input type="text" id="item-name" required class="w-full px-4 py-3 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2" style="background: #0f172a; border: 1px solid #334155;" placeholder="Enter product name">
      </div>
      <div class="grid grid-cols-2 gap-4">
       <div>
        <label for="item-sku" class="block text-sm font-medium mb-2" style="color: #94a3b8;">SKU</label> <input type="text" id="item-sku" required class="w-full px-4 py-3 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2" style="background: #0f172a; border: 1px solid #334155;" placeholder="SKU-001">
       </div>
       <div>
        <label for="item-category" class="block text-sm font-medium mb-2" style="color: #94a3b8;">Category</label> <select id="item-category" required class="w-full px-4 py-3 rounded-xl text-white focus:outline-none focus:ring-2" style="background: #0f172a; border: 1px solid #334155;"> <option value="">Select</option> <option value="Electronics">Electronics</option> <option value="Clothing">Clothing</option> <option value="Food">Food</option> <option value="Office">Office</option> <option value="Other">Other</option> </select>
       </div>
      </div>
      <div class="grid grid-cols-3 gap-4">
       <div>
        <label for="item-quantity" class="block text-sm font-medium mb-2" style="color: #94a3b8;">Quantity</label> <input type="number" id="item-quantity" required min="0" class="w-full px-4 py-3 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2" style="background: #0f172a; border: 1px solid #334155;" placeholder="0">
       </div>
       <div>
        <label for="item-min-stock" class="block text-sm font-medium mb-2" style="color: #94a3b8;">Min Stock</label> <input type="number" id="item-min-stock" required min="0" class="w-full px-4 py-3 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2" style="background: #0f172a; border: 1px solid #334155;" placeholder="5">
       </div>
       <div>
        <label for="item-price" class="block text-sm font-medium mb-2" style="color: #94a3b8;">Price ($)</label> <input type="number" id="item-price" required min="0" step="0.01" class="w-full px-4 py-3 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2" style="background: #0f172a; border: 1px solid #334155;" placeholder="0.00">
       </div>
      </div>
     </div>
     <div class="flex gap-3 mt-6">
      <button type="button" onclick="closeModal()" class="flex-1 px-4 py-3 rounded-xl font-semibold transition-colors" style="background: #334155; color: #94a3b8;"> Cancel </button> <button type="submit" id="submit-btn" class="flex-1 px-4 py-3 rounded-xl font-semibold text-white transition-all hover:scale-105" style="background: #6366f1;"> <span id="submit-text">Add Item</span> </button>
     </div>
    </form>
   </div>
  </div><!-- Delete Confirmation Modal -->
  <div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" style="background: rgba(0, 0, 0, 0.7);">
   <div class="w-full max-w-sm rounded-2xl p-6 fade-in" style="background: #1e293b; border: 1px solid #334155;">
    <div class="text-center">
     <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center" style="background: rgba(239, 68, 68, 0.2);">
      <svg class="w-8 h-8" style="color: #ef4444;" fill="none" stroke="currentColor" viewbox="0 0 24 24">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
      </svg>
     </div>
     <h3 class="text-xl font-bold text-white mb-2">Delete Item?</h3>
     <p class="text-sm mb-6" style="color: #94a3b8;">This action cannot be undone. The item will be permanently removed from your inventory.</p>
     <div class="flex gap-3">
      <button onclick="closeDeleteModal()" class="flex-1 px-4 py-3 rounded-xl font-semibold transition-colors" style="background: #334155; color: #94a3b8;"> Cancel </button> <button id="confirm-delete-btn" onclick="confirmDelete()" class="flex-1 px-4 py-3 rounded-xl font-semibold text-white transition-all" style="background: #ef4444;"> Delete </button>
     </div>
    </div>
   </div>
  </div>
  <script>
    // State
    let inventoryData = [];
    let filteredData = [];
    let editingItem = null;
    let deletingItem = null;
    let isLoading = false;
    let currentRole = null;

    // Default config
    const defaultConfig = {
      app_title: 'Inventory Manager',
      add_button_text: 'Add Item',
      background_color: '#0f172a',
      surface_color: '#1e293b',
      text_color: '#94a3b8',
      primary_action_color: '#6366f1',
      font_family: 'DM Sans',
      font_size: 16,
      staff_delete_allowed: 'false'
    };

    // Element SDK initialization
    if (window.elementSdk) {
      window.elementSdk.init({
        defaultConfig,
        onConfigChange: async (config) => {
          const title = config.app_title || defaultConfig.app_title;
          const btnText = config.add_button_text || defaultConfig.add_button_text;
          const fontFamily = config.font_family || defaultConfig.font_family;
          const fontSize = config.font_size || defaultConfig.font_size;

          document.getElementById('app-title').textContent = title;
          document.getElementById('add-btn-text').textContent = btnText;
          document.body.style.fontFamily = `${fontFamily}, sans-serif`;
          document.body.style.fontSize = `${fontSize}px`;
        },
        mapToCapabilities: (config) => ({
          recolorables: [
            {
              get: () => config.background_color || defaultConfig.background_color,
              set: (v) => { config.background_color = v; window.elementSdk.setConfig({ background_color: v }); }
            },
            {
              get: () => config.surface_color || defaultConfig.surface_color,
              set: (v) => { config.surface_color = v; window.elementSdk.setConfig({ surface_color: v }); }
            },
            {
              get: () => config.text_color || defaultConfig.text_color,
              set: (v) => { config.text_color = v; window.elementSdk.setConfig({ text_color: v }); }
            },
            {
              get: () => config.primary_action_color || defaultConfig.primary_action_color,
              set: (v) => { config.primary_action_color = v; window.elementSdk.setConfig({ primary_action_color: v }); }
            }
          ],
          borderables: [],
          fontEditable: {
            get: () => config.font_family || defaultConfig.font_family,
            set: (v) => { config.font_family = v; window.elementSdk.setConfig({ font_family: v }); }
          },
          fontSizeable: {
            get: () => config.font_size || defaultConfig.font_size,
            set: (v) => { config.font_size = v; window.elementSdk.setConfig({ font_size: v }); }
          }
        }),
        mapToEditPanelValues: (config) => new Map([
          ['app_title', config.app_title || defaultConfig.app_title],
          ['add_button_text', config.add_button_text || defaultConfig.add_button_text],
          ['staff_delete_allowed', config.staff_delete_allowed || defaultConfig.staff_delete_allowed]
        ])
      });
    }

    // Data SDK initialization
    const dataHandler = {
      onDataChanged(data) {
        inventoryData = data;
        filterItems();
        updateStats();
        checkLimit();
      }
    };

    async function initDataSdk() {
      if (window.dataSdk) {
        const result = await window.dataSdk.init(dataHandler);
        if (!result.isOk) {
          console.error('Failed to initialize data SDK');
        }
      }
    }
    initDataSdk();

    // Role management
    function loginAs(role) {
      currentRole = role;
      localStorage.setItem('inventoryRole', role);
      document.getElementById('login-screen').classList.add('hidden');
      document.getElementById('app-container').classList.remove('hidden');
      document.getElementById('role-badge').textContent = role.charAt(0).toUpperCase() + role.slice(1);
      updateUIForRole();
    }

    function logout() {
      currentRole = null;
      localStorage.removeItem('inventoryRole');
      document.getElementById('login-screen').classList.remove('hidden');
      document.getElementById('app-container').classList.add('hidden');
      document.getElementById('item-form').reset();
      closeModal();
      closeDeleteModal();
    }

    function updateUIForRole() {
      const isAdmin = currentRole === 'admin';
      const addBtn = document.getElementById('add-btn');
      const staffDeleteAllowed = window.elementSdk && window.elementSdk.config ? 
        (window.elementSdk.config.staff_delete_allowed === 'true' || window.elementSdk.config.staff_delete_allowed === true) : 
        false;

      if (isAdmin) {
        addBtn.style.display = 'flex';
      } else {
        addBtn.style.display = 'none';
      }

      renderTable();
    }

    // Stats update
    function updateStats() {
      const total = inventoryData.length;
      const inStock = inventoryData.filter(i => i.quantity > i.min_stock).length;
      const lowStock = inventoryData.filter(i => i.quantity > 0 && i.quantity <= i.min_stock).length;
      const outOfStock = inventoryData.filter(i => i.quantity === 0).length;

      document.getElementById('stat-total').textContent = total;
      document.getElementById('stat-instock').textContent = inStock;
      document.getElementById('stat-low').textContent = lowStock;
      document.getElementById('stat-out').textContent = outOfStock;
    }

    // Check limit
    function checkLimit() {
      const warning = document.getElementById('limit-warning');
      if (inventoryData.length >= 999) {
        warning.classList.remove('hidden');
      } else {
        warning.classList.add('hidden');
      }
    }

    // Filter items
    function filterItems() {
      const search = document.getElementById('search-input').value.toLowerCase();
      const category = document.getElementById('category-filter').value;
      const stockFilter = document.getElementById('stock-filter').value;

      filteredData = inventoryData.filter(item => {
        const matchesSearch = item.name.toLowerCase().includes(search) || item.sku.toLowerCase().includes(search);
        const matchesCategory = !category || item.category === category;
        
        let matchesStock = true;
        if (stockFilter === 'in-stock') {
          matchesStock = item.quantity > item.min_stock;
        } else if (stockFilter === 'low-stock') {
          matchesStock = item.quantity > 0 && item.quantity <= item.min_stock;
        } else if (stockFilter === 'out-of-stock') {
          matchesStock = item.quantity === 0;
        }

        return matchesSearch && matchesCategory && matchesStock;
      });

      renderTable();
    }

    // Render table
    function renderTable() {
      const tbody = document.getElementById('inventory-table');
      const emptyState = document.getElementById('empty-state');
      const noResults = document.getElementById('no-results');
      const isAdmin = currentRole === 'admin';
      const staffDeleteAllowed = window.elementSdk && window.elementSdk.config ? 
        (window.elementSdk.config.staff_delete_allowed === 'true' || window.elementSdk.config.staff_delete_allowed === true) : 
        false;

      if (inventoryData.length === 0) {
        tbody.innerHTML = '';
        emptyState.classList.remove('hidden');
        noResults.classList.add('hidden');
        return;
      }

      if (filteredData.length === 0) {
        tbody.innerHTML = '';
        emptyState.classList.add('hidden');
        noResults.classList.remove('hidden');
        return;
      }

      emptyState.classList.add('hidden');
      noResults.classList.add('hidden');

      const existingRows = new Map([...tbody.querySelectorAll('tr')].map(r => [r.dataset.id, r]));

      filteredData.forEach(item => {
        const status = getStatus(item);
        const existingRow = existingRows.get(item.__backendId);

        if (existingRow) {
          updateRow(existingRow, item, status, isAdmin, staffDeleteAllowed);
          existingRows.delete(item.__backendId);
        } else {
          const row = createRow(item, status, isAdmin, staffDeleteAllowed);
          tbody.appendChild(row);
        }
      });

      existingRows.forEach(row => row.remove());
    }

    function getStatus(item) {
      if (item.quantity === 0) return { label: 'Out of Stock', class: 'bg-red-500/20 text-red-400', isLow: false };
      if (item.quantity <= item.min_stock) return { label: 'Low Stock', class: 'bg-orange-500/20 text-orange-400', isLow: true };
      return { label: 'In Stock', class: 'bg-green-500/20 text-green-400', isLow: false };
    }

    function createRow(item, status, isAdmin, staffDeleteAllowed) {
      const row = document.createElement('tr');
      row.dataset.id = item.__backendId;
      row.className = `border-t border-slate-700 hover:bg-slate-800/50 transition-colors ${status.isLow ? 'low-stock' : ''}`;
      row.innerHTML = getRowHTML(item, status, isAdmin, staffDeleteAllowed);
      return row;
    }

    function updateRow(row, item, status, isAdmin, staffDeleteAllowed) {
      row.className = `border-t border-slate-700 hover:bg-slate-800/50 transition-colors ${status.isLow ? 'low-stock' : ''}`;
      row.innerHTML = getRowHTML(item, status, isAdmin, staffDeleteAllowed);
    }

    function getRowHTML(item, status, isAdmin, staffDeleteAllowed) {
      const canDelete = isAdmin || staffDeleteAllowed;
      const canEdit = isAdmin;

      return `
        <td class="px-6 py-4">
          <p class="font-semibold text-white">${escapeHtml(item.name)}</p>
        </td>
        <td class="px-6 py-4">
          <span class="text-sm font-mono" style="color: #64748b;">${escapeHtml(item.sku)}</span>
        </td>
        <td class="px-6 py-4">
          <span class="px-3 py-1 rounded-full text-xs font-medium" style="background: rgba(99, 102, 241, 0.2); color: #a5b4fc;">
            ${escapeHtml(item.category)}
          </span>
        </td>
        <td class="px-6 py-4 text-center">
          <div class="flex items-center justify-center gap-2">
            <button onclick="adjustQuantity('${item.__backendId}', -1)" 
              class="w-7 h-7 rounded-lg flex items-center justify-center transition-colors hover:bg-slate-600"
              style="background: #334155;">
              <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
              </svg>
            </button>
            <span class="w-12 text-center font-semibold text-white">${item.quantity}</span>
            <button onclick="adjustQuantity('${item.__backendId}', 1)" 
              class="w-7 h-7 rounded-lg flex items-center justify-center transition-colors hover:bg-slate-600"
              style="background: #334155;">
              <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
              </svg>
            </button>
          </div>
        </td>
        <td class="px-6 py-4 text-center">
          <span class="px-3 py-1 rounded-full text-xs font-medium ${status.class}">
            ${status.label}
          </span>
        </td>
        <td class="px-6 py-4 text-right">
          <span class="font-semibold text-white">$${item.price.toFixed(2)}</span>
        </td>
        <td class="px-6 py-4">
          <div class="flex items-center justify-center gap-2">
            ${canEdit ? `<button onclick="editItem('${item.__backendId}')" 
              class="p-2 rounded-lg transition-colors hover:bg-slate-700" title="Edit">
              <svg class="w-4 h-4" style="color: #94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
              </svg>
            </button>` : ''}
            ${canDelete ? `<button onclick="openDeleteModal('${item.__backendId}')" 
              class="p-2 rounded-lg transition-colors hover:bg-red-500/20" title="Delete">
              <svg class="w-4 h-4" style="color: #ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
              </svg>
            </button>` : ''}
          </div>
        </td>
      `;
    }

    function escapeHtml(text) {
      const div = document.createElement('div');
      div.textContent = text;
      return div.innerHTML;
    }

    // Modal functions
    function openModal() {
      if (currentRole !== 'admin') return;
      editingItem = null;
      document.getElementById('modal-title').textContent = 'Add New Item';
      document.getElementById('submit-text').textContent = 'Add Item';
      document.getElementById('item-form').reset();
      document.getElementById('modal').classList.remove('hidden');
      document.getElementById('modal').classList.add('flex');
    }

    function closeModal() {
      document.getElementById('modal').classList.add('hidden');
      document.getElementById('modal').classList.remove('flex');
      editingItem = null;
    }

    function editItem(id) {
      if (currentRole !== 'admin') return;
      const item = inventoryData.find(i => i.__backendId === id);
      if (!item) return;

      editingItem = item;
      document.getElementById('modal-title').textContent = 'Edit Item';
      document.getElementById('submit-text').textContent = 'Save Changes';
      document.getElementById('item-name').value = item.name;
      document.getElementById('item-sku').value = item.sku;
      document.getElementById('item-category').value = item.category;
      document.getElementById('item-quantity').value = item.quantity;
      document.getElementById('item-min-stock').value = item.min_stock;
      document.getElementById('item-price').value = item.price;
      document.getElementById('modal').classList.remove('hidden');
      document.getElementById('modal').classList.add('flex');
    }

    async function handleSubmit(e) {
      e.preventDefault();
      if (isLoading || currentRole !== 'admin') return;

      const submitBtn = document.getElementById('submit-btn');
      const submitText = document.getElementById('submit-text');
      
      isLoading = true;
      submitBtn.disabled = true;
      submitText.textContent = 'Saving...';

      const itemData = {
        name: document.getElementById('item-name').value.trim(),
        sku: document.getElementById('item-sku').value.trim(),
        category: document.getElementById('item-category').value,
        quantity: parseInt(document.getElementById('item-quantity').value) || 0,
        min_stock: parseInt(document.getElementById('item-min-stock').value) || 5,
        price: parseFloat(document.getElementById('item-price').value) || 0,
        created_at: editingItem ? editingItem.created_at : new Date().toISOString()
      };

      let result;
      if (editingItem) {
        result = await window.dataSdk.update({ ...editingItem, ...itemData });
      } else {
        if (inventoryData.length >= 999) {
          isLoading = false;
          submitBtn.disabled = false;
          submitText.textContent = editingItem ? 'Save Changes' : 'Add Item';
          return;
        }
        result = await window.dataSdk.create(itemData);
      }

      isLoading = false;
      submitBtn.disabled = false;
      submitText.textContent = editingItem ? 'Save Changes' : 'Add Item';

      if (result.isOk) {
        closeModal();
      } else {
        console.error('Failed to save item');
      }
    }

    // Quantity adjustment
    async function adjustQuantity(id, delta) {
      const item = inventoryData.find(i => i.__backendId === id);
      if (!item) return;

      const newQuantity = Math.max(0, item.quantity + delta);
      const result = await window.dataSdk.update({ ...item, quantity: newQuantity });
      if (!result.isOk) {
        console.error('Failed to update quantity');
      }
    }

    // Delete functions
    function openDeleteModal(id) {
      const isAdmin = currentRole === 'admin';
      const staffDeleteAllowed = window.elementSdk && window.elementSdk.config ? 
        (window.elementSdk.config.staff_delete_allowed === 'true' || window.elementSdk.config.staff_delete_allowed === true) : 
        false;
      
      if (!isAdmin && !staffDeleteAllowed) return;
      
      deletingItem = inventoryData.find(i => i.__backendId === id);
      if (!deletingItem) return;
      document.getElementById('delete-modal').classList.remove('hidden');
      document.getElementById('delete-modal').classList.add('flex');
    }

    function closeDeleteModal() {
      document.getElementById('delete-modal').classList.add('hidden');
      document.getElementById('delete-modal').classList.remove('flex');
      deletingItem = null;
    }

    async function confirmDelete() {
      if (!deletingItem || isLoading) return;

      const btn = document.getElementById('confirm-delete-btn');
      isLoading = true;
      btn.disabled = true;
      btn.textContent = 'Deleting...';

      const result = await window.dataSdk.delete(deletingItem);
      
      isLoading = false;
      btn.disabled = false;
      btn.textContent = 'Delete';

      if (result.isOk) {
        closeDeleteModal();
      } else {
        console.error('Failed to delete item');
      }
    }

    // Check for existing role on page load
    window.addEventListener('load', () => {
      const savedRole = localStorage.getItem('inventoryRole');
      if (savedRole) {
        loginAs(savedRole);
      }
    });
  </script>
 <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9d98ba43f5639894',t:'MTc3MzA0NTEzMS4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>