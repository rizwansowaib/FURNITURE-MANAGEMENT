<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furniture Stock Management System</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @layer base {
            body { @apply bg-slate-50 text-slate-800 font-sans; }
        }
    </style>
</head>
<body class="p-4 md:p-8">

    <div class="max-w-7xl mx-auto">
        <header class="mb-8 pb-4 border-b border-slate-200">
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Furniture Inventory Dashboard</h1>
            <p class="text-slate-500 mt-1">Manage showroom stock, track material classifications, pricing, and active quantities.</p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-xs border border-slate-200 p-6 sticky top-8">
                    <h2 class="text-xl font-semibold text-slate-800 mb-6 flex items-center gap-2">
                        <span>📦</span> Register Furniture Asset
                    </h2>
                    
                    <form id="furnitureForm" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Item Name</label>
                            <input type="text" id="itemName" required placeholder="e.g., Ergonomic Office Chair" 
                                class="w-full p-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">SKU / Code</label>
                                <input type="text" id="itemSku" required placeholder="CH-402" 
                                    class="w-full p-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Category</label>
                                <select id="itemCategory" class="w-full p-2.5 border border-slate-200 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                                    <option value="Seating">Seating / Chairs</option>
                                    <option value="Tables">Tables & Desks</option>
                                    <option value="Storage">Storage / Cabinets</option>
                                    <option value="Bedding">Bedding & Sofas</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Unit Price ($)</label>
                                <input type="number" id="itemPrice" min="0" step="0.01" required placeholder="249.99" 
                                    class="w-full p-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Stock Qty</label>
                                <input type="number" id="itemQty" min="0" required placeholder="15" 
                                    class="w-full p-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Material Composition</label>
                            <input type="text" id="itemMaterial" placeholder="e.g., Walnut Wood, Mesh Fabric" 
                                class="w-full p-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>

                        <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-semibold p-3 rounded-lg transition duration-200 mt-2">
                            Add to Catalog
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white rounded-xl shadow-xs border border-slate-200 p-4 flex flex-col md:flex-row gap-4 items-center justify-between">
                    <div class="w-full md:w-72">
                        <input type="text" id="searchBox" placeholder="Search by name or SKU..." 
                            class="w-full p-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm">
                    </div>
                    <div class="flex gap-2 w-full md:w-auto justify-end">
                        <select id="filterCategory" class="p-2 border border-slate-200 rounded-lg bg-white text-sm focus:outline-none">
                            <option value="All">All Categories</option>
                            <option value="Seating">Seating</option>
                            <option value="Tables">Tables</option>
                            <option value="Storage">Storage</option>
                            <option value="Bedding">Bedding</option>
                        </select>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-xs border border-slate-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs font-bold uppercase tracking-wider">
                                    <th class="p-4">Item Profile</th>
                                    <th class="p-4">SKU Code</th>
                                    <th class="p-4">Classification</th>
                                    <th class="p-4">Financials</th>
                                    <th class="p-4">Status Tracking</th>
                                    <th class="p-4 text-right">System Action</th>
                                </tr>
                            </table>
                            <table class="w-full text-left border-collapse">
                            <tbody id="inventoryGrid" class="divide-y divide-slate-100 text-sm text-slate-700">
                                </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Data Cache & Memory Synchronization State
        let stockItems = JSON.parse(localStorage.getItem('furniture_sys_db')) || [
            { name: "Scandi Oak Dining Table", sku: "TB-011", category: "Tables", price: 599.00, qty: 8, material: "Solid White Oak" },
            { name: "Minimalist Fabric Sofa", sku: "BD-089", category: "Bedding", price: 899.50, qty: 3, material: "Linen, Memory Foam" },
            { name: "Modular File Cabinet", sku: "ST-402", category: "Storage", price: 145.00, qty: 0, material: "Alloy Steel" }
        ];

        const form = document.getElementById('furnitureForm');
        const gridContainer = document.getElementById('inventoryGrid');
        const searchInput = document.getElementById('searchBox');
        const filterDropdown = document.getElementById('filterCategory');

        // Main Template UI Renderer
        function renderInventory(dataset = stockItems) {
            gridContainer.innerHTML = '';

            if (dataset.length === 0) {
                gridContainer.innerHTML = `
                    <tr>
                        <td colspan="6" class="p-12 text-center text-slate-400 font-medium">
                            No furniture asset records found matching parameters.
                        </td>
                    </tr>`;
                return;
            }

            dataset.forEach((item) => {
                // Pin index configuration mappings cleanly against unique global keys
                const globalIndex = stockItems.findIndex(el => el.sku === item.sku);
                const tr = document.createElement('tr');
                tr.className = "hover:bg-slate-50/70 transition-colors";

                // Quantity threshold visual checking
                let statusBadge = `<span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">In Stock (${item.qty})</span>`;
                if (item.qty === 0) {
                    statusBadge = `<span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-rose-100 text-rose-800">Out of Stock</span>`;
                } else if (item.qty <= 3) {
                    statusBadge = `<span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800">Low Stock (${item.qty})</span>`;
                }

                tr.innerHTML = `
                    <td class="p-4">
                        <div class="font-semibold text-slate-900">${item.name}</div>
                        <div class="text-xs text-slate-400 mt-0.5">${item.material || 'N/A'}</div>
                    </td>
                    <td class="p-4"><code class="text-xs bg-slate-100 px-1.5 py-0.5 rounded font-mono text-slate-600">${item.sku}</code></td>
                    <td class="p-4 text-slate-500">${item.category}</td>
                    <td class="p-4 font-medium text-slate-900">$${parseFloat(item.price).toFixed(2)}</td>
                    <td class="p-4">${statusBadge}</td>
                    <td class="p-4 text-right space-x-1">
                        <button onclick="modifyStock(${globalIndex}, 1)" class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-md text-xs transition" title="Increment Inventory">+</button>
                        <button onclick="modifyStock(${globalIndex}, -1)" class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-md text-xs transition" title="Decrement Inventory">-</button>
                        <button onclick="purgeItem(${globalIndex})" class="p-1.5 hover:bg-rose-50 text-rose-600 rounded-md text-xs transition ml-2" title="Delete Asset">🗑️</button>
                    </td>
                `;
                gridContainer.appendChild(tr);
            });
        }

        // Persistent Cache Helper
        function saveToCache() {
            localStorage.setItem('furniture_sys_db', JSON.stringify(stockItems));
        }

        // Form Submission Handling Logic
        form.addEventListener('submit', (e) => {
            e.preventDefault();

            const inputSku = document.getElementById('itemSku').value.trim().toUpperCase();

            // Enforce Unique Identifiers (SKUs)
            if (stockItems.some(item => item.sku === inputSku)) {
                alert("Inventory Error: An asset with this unique SKU classification code already exists.");
                return;
            }

            const newFurnitureItem = {
                name: document.getElementById('itemName').value.trim(),
                sku: inputSku,
                category: document.getElementById('itemCategory').value,
                price: parseFloat(document.getElementById('itemPrice').value),
                qty: parseInt(document.getElementById('itemQty').value),
                material: document.getElementById('itemMaterial').value.trim()
            };

            stockItems.push(newFurnitureItem);
            saveToCache();
            dispatchSearchFilter();
            form.reset();
        });

        // Quick Stock Value Multipliers
        window.modifyStock = function(index, modifier) {
            stockItems[index].qty = Math.max(0, stockItems[index].qty + modifier);
            saveToCache();
            dispatchSearchFilter();
        };

        // Record Removal Action
        window.purgeItem = function(index) {
            if (confirm(`Are you sure you want to permanently remove "${stockItems[index].name}" from stock records?`)) {
                stockItems.splice(index, 1);
                saveToCache();
                dispatchSearchFilter();
            }
        };

        // Unified Search & Filter Execution Pipeline
        function dispatchSearchFilter() {
            const query = searchInput.value.toLowerCase().trim();
            const categorySelection = filterDropdown.value;

            const filteredArray = stockItems.filter(item => {
                const matchesQuery = item.name.toLowerCase().includes(query) || item.sku.toLowerCase().includes(query);
                const matchesCategory = categorySelection === "All" || item.category === categorySelection;
                return matchesQuery && matchesCategory;
            });

            renderInventory(filteredArray);
        }

        searchInput.addEventListener('input', dispatchSearchFilter);
        filterDropdown.addEventListener('change', dispatchSearchFilter);

        // App Boot Trigger
        renderInventory();
    </script>
</body>
</html>
