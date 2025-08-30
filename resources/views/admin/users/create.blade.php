@extends('layouts.admin')

@section('content')
<div class="p-8 max-w-2xl mx-auto bg-white shadow-lg rounded-2xl">
  <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-3">Tambah User Baru</h2>

  <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5">
    @csrf

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
      <input type="text" name="name" class="w-full border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg px-4 py-2" required>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
      <input type="email" name="email" class="w-full border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg px-4 py-2" required>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
      <input type="password" name="password" class="w-full border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg px-4 py-2" required>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
      <input type="password" name="password_confirmation" class="w-full border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg px-4 py-2" required>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
      <select name="role" class="w-full border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 rounded-lg px-4 py-2" required>
        <option value="kasir">Kasir</option>
        <option value="admin">Admin</option>
      </select>
    </div>

    <div class="flex justify-end">
      <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded-lg shadow">
        Simpan
      </button>
    </div>
  </form>
</div>
@endsection
