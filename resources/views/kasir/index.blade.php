@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="p-4 space-y-4 bg-gray-100 min-h-screen">
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

    <!-- KIRI: Produk -->
    <div class="lg:col-span-2 space-y-4">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <h2 class="text-2xl font-bold text-green-700">🛒 Kasir Herbal Village</h2>
        <div class="flex gap-2">
          <input type="text" id="product-search" placeholder="Cari Nama Produk..." class="border px-3 py-2 rounded w-full sm:w-60" />
          <select id="category-filter" class="border px-2 py-2 rounded w-full sm:w-40">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
              <option value="{{ strtolower(str_replace(' ', '-', $cat)) }}">{{ $cat }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="grid grid-cols-2 md:grid-cols-4 gap-3" id="product-list">
        @foreach($products as $product)
        <div class="product-card bg-white p-3 rounded-lg shadow hover:shadow-md transition flex flex-col items-center text-center"
             data-name="{{ strtolower($product->name) }}"
             data-category="{{ strtolower(str_replace(' ', '-', $product->category ?? '')) }}">
          <img src="{{ asset('storage/'.$product->photo) }}" alt="{{ $product->name }}" class="w-28 h-28 object-cover rounded border"/>
          <p class="mt-2 font-medium text-sm truncate w-full">{{ $product->name }}</p>
          <p class="text-gray-600 text-sm">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
          <button onclick="addItem({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, {{ $product->stock }})"
                  class="bg-green-600 hover:bg-green-700 text-white text-xs px-3 py-1 rounded mt-1">
            <i class="fas fa-plus"></i> Tambah
          </button>
        </div>
        @endforeach
      </div>
    </div>

    <!-- KANAN: Keranjang -->
    <div class="bg-white rounded-lg shadow p-4">
      <h3 class="text-lg font-semibold mb-2" id="cart-title">🧺 Daftar Pesanan</h3>
      <div id="notif" class="hidden mb-2 p-2 rounded text-sm"></div>

      <div class="overflow-auto max-h-[320px]">
        <table class="w-full text-sm">
          <thead class="bg-gray-50">
            <tr>
              <th class="p-2 text-left">Produk</th>
              <th class="p-2 text-right">Harga</th>
              <th class="p-2 text-center">Qty</th>
              <th class="p-2 text-right">Subtotal</th>
              <th class="p-2"></th>
            </tr>
          </thead>
          <tbody id="cart"></tbody>
        </table>
      </div>

      <div class="border-t mt-3 pt-2">
        <div class="text-sm flex justify-between"><span>Total:</span><span id="total">Rp. 0</span></div>
        <div class="text-sm flex justify-between"><span>Diskon:</span><span id="summaryDiscount">Rp. 0</span></div>
        <div class="text-sm flex justify-between"><span>Total Bayar:</span><span id="summaryBayar">Rp. 0</span></div>
        <div class="text-sm flex justify-between"><span>Kembalian:</span><span id="summaryKembalian">Rp. 0</span></div>
      </div>

      <div class="mt-3 space-y-2">
        <input type="text" id="customer" placeholder="Nama Customer (Opsional)" class="border px-2 py-1 rounded w-full"/>
        <input type="number" id="pay" placeholder="Bayar (Rp)" class="border px-2 py-1 rounded w-full"/>
        <input type="number" id="discount" value="0" min="0" max="100" class="border px-2 py-1 rounded w-full"/>
        <p id="payStatus" class="text-xs hidden"></p>
      </div>

      <div class="mt-4 flex gap-2">
        <button onclick="saveTransaction()" class="bg-purple-600 hover:bg-purple-700 text-white text-sm px-4 py-2 rounded w-full">
          <i class="fas fa-print"></i> Bayar & Cetak
        </button>
        <button onclick="resetCart()" class="bg-yellow-400 hover:bg-yellow-500 text-black text-sm px-4 py-2 rounded w-full">
          <i class="fas fa-undo"></i> Reset
        </button>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
const searchInput = document.getElementById('product-search');
const categorySelect = document.getElementById('category-filter');
const productCards = document.querySelectorAll('.product-card');

function filterProducts() {
  const keyword = searchInput.value.toLowerCase();
  const category = categorySelect.value.toLowerCase().trim();
  productCards.forEach(card => {
    const name = card.dataset.name || '';
    const cat = card.dataset.category || '';
    const matchName = name.includes(keyword);
    const matchCategory = category === '' || cat === category;
    card.style.display = (matchName && matchCategory) ? 'block' : 'none';
  });
}
searchInput.addEventListener('input', filterProducts);
categorySelect.addEventListener('change', filterProducts);

let cart = [];

function addItem(id, name, price, stock) {
  if (stock <= 0) return showNotif(`Stok <strong>${name}</strong> habis.`);
  const existing = cart.find(item => item.product_id === id);
  if (existing) {
    if (existing.qty >= stock) return showNotif(`Stok <strong>${name}</strong> tinggal ${stock} item.`);
    existing.qty++;
    existing.subtotal = existing.qty * existing.price;
  } else {
    cart.push({ product_id: id, name, price, qty: 1, stock, subtotal: price });
  }

  // Fokus otomatis ke kolom bayar
  document.getElementById('pay').focus();

  // Animasi barang masuk keranjang
  animateAddToCart(id);

  renderCart();
}

function animateAddToCart(productId) {
  const btn = document.querySelector(`button[onclick^="addItem(${productId}"]`);
  if (!btn) return;
  const productCard = btn.closest('.product-card');
  const img = productCard.querySelector('img');
  const cartTitle = document.getElementById('cart-title');

  const imgClone = img.cloneNode(true);
  const rect = img.getBoundingClientRect();
  imgClone.style.position = 'fixed';
  imgClone.style.left = rect.left + 'px';
  imgClone.style.top = rect.top + 'px';
  imgClone.style.width = rect.width + 'px';
  imgClone.style.height = rect.height + 'px';
  imgClone.style.zIndex = 9999;
  imgClone.style.transition = 'all 0.7s ease-in-out';

  document.body.appendChild(imgClone);

  const cartRect = cartTitle.getBoundingClientRect();
  setTimeout(() => {
    imgClone.style.left = cartRect.left + 'px';
    imgClone.style.top = cartRect.top + 'px';
    imgClone.style.width = '20px';
    imgClone.style.height = '20px';
    imgClone.style.opacity = '0.3';
  }, 50);

  setTimeout(() => {
    imgClone.remove();
  }, 800);
}

function showNotif(message, type = 'error') {
  const notif = document.getElementById('notif');
  notif.innerHTML = message;
  notif.className = `mb-2 p-2 rounded text-sm ${type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`;
  notif.classList.remove('hidden');
  setTimeout(() => notif.classList.add('hidden'), 2500);
}

function renderCart() {
  let html = '', total = 0;
  cart.forEach((item, index) => {
    total += item.subtotal;
    html += `
      <tr>
        <td class="border px-3 py-2">${item.name}</td>
        <td class="border px-3 py-2 text-right">Rp. ${item.price.toLocaleString()}</td>
        <td class="border px-3 py-2 text-center">
          <button onclick="decreaseQty(${index})" class="text-red-600 px-1"><i class="fas fa-minus"></i></button>
          ${item.qty}
          <button onclick="increaseQty(${index})" class="text-green-600 px-1"><i class="fas fa-plus"></i></button>
        </td>
        <td class="border px-3 py-2 text-right">Rp. ${item.subtotal.toLocaleString()}</td>
        <td class="border px-3 py-2 text-center">
          <button onclick="removeItem(${index})" class="text-gray-500 hover:text-red-600"><i class="fas fa-trash"></i></button>
        </td>
      </tr>`;
  });
  document.getElementById('cart').innerHTML = html;
  document.getElementById('total').innerText = 'Rp. ' + total.toLocaleString();
  updateSummary();
}

function increaseQty(index) {
  if (cart[index].qty >= cart[index].stock) return showNotif(`Stok <strong>${cart[index].name}</strong> tinggal ${cart[index].stock} item.`);
  cart[index].qty++;
  cart[index].subtotal = cart[index].qty * cart[index].price;
  renderCart();
}

function decreaseQty(index) {
  if (cart[index].qty > 1) {
    cart[index].qty--;
    cart[index].subtotal = cart[index].qty * cart[index].price;
  } else {
    cart.splice(index, 1);
  }
  renderCart();
}

function removeItem(index) {
  cart.splice(index, 1);
  renderCart();
}

function resetCart() {
  cart = [];
  renderCart();
  document.getElementById('pay').value = '';
  document.getElementById('customer').value = '';
  document.getElementById('discount').value = 0;
  updateSummary();
}

function printReceipt(data) {
  const receiptWindow = window.open('', 'Print Receipt', 'height=600,width=400');

  let itemsHTML = '';
  data.items.forEach(item => {
    itemsHTML += `
      <tr>
        <td>${item.name}</td>
        <td style="text-align:right">${item.qty} x Rp.${item.price.toLocaleString()}</td>
      </tr>
      <tr>
        <td colspan="2" style="text-align:right">Rp.${item.subtotal.toLocaleString()}</td>
      </tr>
    `;
  });

  const html = `
    <html>
    <head>
      <title>Struk Herbal Village</title>
      <style>
        body { font-family:'Courier New', monospace; font-size:12px; padding:10px; color:#333 }
        h2 { text-align:center; margin:0; font-size:16px }
        .subtext { text-align:center; font-size:11px; margin-bottom:8px }
        table { width:100%; border-collapse:collapse; margin-top:10px }
        td { padding:3px 0; font-size:12px }
        .line { border-top:1px dashed #333; margin:6px 0 }
        .total-row td { font-weight:bold }
        .thank { text-align:center; margin-top:12px; font-size:12px; border-top:1px dashed #333; padding-top:6px }
      </style>
    </head>
    <body onload="window.print(); setTimeout(() => window.close(), 500)">
      <h2>HERBAL VILLAGE</h2>
      <div class="subtext">Jl. Pakuan - Telp. Gapunya</div>
      <div class="line"></div>

      <table>
        <tr><td>Kasir</td><td style="text-align:right">${data.cashier}</td></tr>
        <tr><td>Customer</td><td style="text-align:right">${data.customer || '-'}</td></tr>
        <tr><td>Tanggal</td><td style="text-align:right">${new Date().toLocaleString()}</td></tr>
      </table>

      <div class="line"></div>

      <table>
        ${itemsHTML}
        <tr class="line"><td colspan="2"></td></tr>
        <tr class="total-row">
          <td>Total</td><td style="text-align:right">Rp.${data.total.toLocaleString()}</td>
        </tr>
        <tr>
          <td>Diskon</td><td style="text-align:right">Rp.${data.discount.toLocaleString()}</td>
        </tr>
        <tr>
          <td>Bayar</td><td style="text-align:right">Rp.${data.pay.toLocaleString()}</td>
        </tr>
        <tr>
          <td>Kembalian</td><td style="text-align:right">Rp.${data.change.toLocaleString()}</td>
        </tr>
      </table>

      <div class="thank">-- Terima Kasih --</div>
    </body>
    </html>
  `;

  receiptWindow.document.write(html);
  receiptWindow.document.close();
}


function saveTransaction() {
  const pay = parseInt(document.getElementById('pay').value);
  const discountPercent = parseFloat(document.getElementById('discount').value) || 0;
  const total = cart.reduce((sum, item) => sum + item.subtotal, 0);
  const discountAmount = total * (discountPercent / 100);
  const customer = document.getElementById('customer').value;
  const change = pay - (total - discountAmount);

  if (pay < (total - discountAmount)) {
    showNotif('Pembayaran kurang.');
    return;
  }

  fetch('/kasir/transaksi-store', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({
      cashier: 'Administrator',
      customer,
      total,
      discount: discountAmount,
      pay,
      change,
      items: cart
    })
  })
  .then(async res => {
    if (!res.ok) {
      const error = await res.json();
      console.error(error);
      showNotif('Gagal menyimpan transaksi: ' + (error.message || ''));
      return;
    }
    return res.json();
  })
.then(res => {
  if (res?.success) {
    showNotif('Transaksi berhasil', 'success');
    // Tambahkan ini:
    printReceipt({
      cashier: 'Administrator',
      customer: customer,
      total: total,
      discount: discountAmount,
      pay: pay,
      change: change,
      items: cart
    });
    resetCart();
  }
})

  .catch(err => {
    console.error(err);
    showNotif('Gagal menyimpan transaksi.');
  });
}

const payInput = document.getElementById('pay');
const discountInput = document.getElementById('discount');
const payStatus = document.getElementById('payStatus');

function updateSummary() {
  const total = cart.reduce((sum, item) => sum + item.subtotal, 0);
  const discountPercent = parseFloat(discountInput.value) || 0;
  const discountAmount = total * (discountPercent / 100);
  const pay = parseInt(payInput.value) || 0;
  const bayarSetelahDiskon = total - discountAmount;
  const kembalian = pay - bayarSetelahDiskon;
  document.getElementById('summaryDiscount').innerText = 'Rp. ' + discountAmount.toLocaleString();
  document.getElementById('summaryBayar').innerText = 'Rp. ' + bayarSetelahDiskon.toLocaleString();
  document.getElementById('summaryKembalian').innerText = 'Rp. ' + (kembalian < 0 ? 0 : kembalian).toLocaleString();
}

function validatePayInput() {
  const bayar = parseInt(payInput.value) || 0;
  const total = cart.reduce((sum, item) => sum + item.subtotal, 0);
  const discount = total * (parseFloat(discountInput.value) || 0) / 100;
  const bayarSetelahDiskon = total - discount;
  if (bayar >= bayarSetelahDiskon) {
    payInput.classList.add('border-green-500');
    payInput.classList.remove('border-red-500');
    payStatus.textContent = 'Pembayaran cukup';
    payStatus.classList.remove('text-red-500','hidden');
    payStatus.classList.add('text-green-600');
  } else {
    payInput.classList.add('border-red-500');
    payInput.classList.remove('border-green-500');
    payStatus.textContent = 'Pembayaran kurang';
    payStatus.classList.remove('text-green-600','hidden');
    payStatus.classList.add('text-red-500');
  }
  if (payInput.value === '') {
    payInput.classList.remove('border-green-500','border-red-500');
    payStatus.classList.add('hidden');
  }
}

payInput.addEventListener('input', () => { updateSummary(); validatePayInput(); });
discountInput.addEventListener('input', () => { updateSummary(); validatePayInput(); });
</script>
@endpush
@endsection
