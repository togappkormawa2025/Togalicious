@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="w-full max-w-lg bg-white shadow-lg rounded-2xl p-8">

    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
      ✏️ Edit User
    </h2>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-5">
      @csrf
      @method('PUT')

      <!-- Nama -->
      <div>
        <label class="block font-semibold text-gray-700 mb-2">Nama</label>
        <input
          type="text"
          name="name"
          value="{{ old('name', $user->name) }}"
          class="w-full border border-gray-300 px-4 py-2 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:outline-none"
          required
        >
      </div>

      <!-- Role -->
      <div>
        <label class="block font-semibold text-gray-700 mb-2">Role</label>
        <select
          name="role"
          class="w-full border border-gray-300 px-4 py-2 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:outline-none"
          required
        >
          <option value="kasir" {{ $user->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
          <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
      </div>

      <!-- Tombol -->
      <div class="flex justify-between items-center pt-4">
        <a
          href="{{ route('admin.users.index') }}"
          class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition"
        >
          Batal
        </a>
        <button
          type="submit"
          class="bg-green-600 text-white px-6 py-2 rounded-lg shadow hover:bg-green-700 transition"
        >
          Update
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
