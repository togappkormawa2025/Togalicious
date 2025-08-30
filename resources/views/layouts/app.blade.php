<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>POS Kasir | Herbal Village</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  @stack('head')
  <style>
    .bg-asparagus { background-color: #87A96B; }
    .hover\:bg-asparagus-dark:hover { background-color: #6E8B50; }
    .text-asparagus { color: #87A96B; }
    .hover\:bg-asparagus-light:hover { background-color: #f1f7ec; }
  </style>
</head>
<body class="bg-slate-50 font-sans text-gray-800 min-h-screen flex">

<!-- Sidebar -->
<aside id="sidebar"
       class="w-64 bg-white shadow-lg h-screen hidden md:flex flex-col shrink-0 z-50">
  <!-- Logo / Brand -->
  <div class="p-6 flex items-center gap-2 font-bold text-2xl text-asparagus border-b border-gray-200">
    <i class="fa-solid fa-leaf text-xl"></i>
    <span>Herbal POS</span>
  </div>

  <!-- Navigation -->
  <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-2 text-[15px] font-medium">
    <a href="/kasir"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition
              {{ request()->is('kasir') ? 'bg-asparagus text-white shadow-md' : 'text-gray-700 hover:bg-asparagus-light hover:text-asparagus' }}">
      <i class="fa-solid fa-cash-register"></i>
      <span>Kasir</span>
    </a>

    <a href="/kasir/products"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition
              {{ request()->is('kasir/products') ? 'bg-asparagus text-white shadow-md' : 'text-gray-700 hover:bg-asparagus-light hover:text-asparagus' }}">
      <i class="fa-solid fa-box"></i>
      <span>Daftar Produk</span>
    </a>

        <a href="/kasir/reports"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition
              {{ request()->is('kasir/reports') ? 'bg-asparagus text-white shadow-md' : 'text-gray-700 hover:bg-asparagus-light hover:text-asparagus' }}">
      <i class="fa-solid fa-file-invoice-dollar"></i>
      <span>Laporan Keuangan</span>
    </a>
  </nav>

  <!-- Footer -->
  <div class="p-4 text-xs text-gray-400 border-t border-gray-200">
    © {{ date('Y') }} Herbal Village
  </div>
</aside>

<!-- Konten Utama -->
<div class="flex-1 flex flex-col min-h-screen">

  <!-- Header -->
  <header class="bg-white border-b flex items-center justify-between px-4 md:px-8 py-4 shadow-sm relative z-10">
    <div class="flex items-center gap-4">
      <!-- Tombol toggle sidebar di mobile -->
      <button id="toggleSidebar" onclick="toggleSidebar()" class="md:hidden text-gray-600 focus:outline-none">
        <i class="fa-solid fa-bars text-2xl"></i>
      </button>
      <h1 class="text-xl md:text-2xl font-bold text-asparagus">Kasir Herbal Village</h1>
    </div>

    @php $user = Auth::user(); @endphp
    <div class="relative">
      <button onclick="toggleDropdown()" class="flex items-center gap-3 focus:outline-none">
        <div class="w-11 h-11 bg-asparagus text-white rounded-full flex items-center justify-center font-semibold">
          {{ strtoupper(substr($user->name, 0, 2)) }}
        </div>
        <div class="text-left hidden sm:block">
          <div class="font-semibold text-gray-800 leading-tight">{{ $user->name }}</div>
          <div class="text-xs text-gray-500 capitalize">{{ $user->role }}</div>
        </div>
        <i class="fa-solid fa-caret-down ml-2 text-gray-500"></i>
      </button>

      <!-- Dropdown -->
      <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-52 bg-white rounded-lg shadow-lg border border-gray-100 z-50">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
            <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Logout
          </button>
        </form>
      </div>
    </div>
  </header>

  <!-- Konten halaman -->
  <main class="flex-grow p-6 md:p-8 overflow-y-auto text-base">
    @yield('content')
  </main>
</div>

<!-- Overlay untuk mobile sidebar -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden" onclick="closeSidebar()"></div>

@stack('scripts')
<script>
  function toggleDropdown() {
    const dropdown = document.getElementById('profileDropdown');
    dropdown.classList.toggle('hidden');
  }

  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    sidebar.classList.toggle('hidden');
    overlay.classList.toggle('hidden');
  }

  function closeSidebar() {
    document.getElementById('sidebar').classList.add('hidden');
    document.getElementById('overlay').classList.add('hidden');
  }

  window.addEventListener('click', function(e) {
    const button = document.querySelector('button[onclick="toggleDropdown()"]');
    const dropdown = document.getElementById('profileDropdown');
    if (!button.contains(e.target) && !dropdown.contains(e.target)) {
      dropdown.classList.add('hidden');
    }
  });
</script>

</body>
</html>
