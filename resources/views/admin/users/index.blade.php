@extends('layouts.admin')

@section('content')
<div class="p-6">
  <h2 class="text-2xl font-bold text-asparagus mb-6">Manajemen User</h2>

  <div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">Daftar User</h3>
    <a href="{{ route('admin.users.create') }}"
       class="bg-asparagus hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow transition duration-200">
       + Tambah User
    </a>
  </div>

  <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
    <table class="min-w-full text-sm text-left">
      <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
        <tr>
          <th class="p-4 font-semibold">No</th>
          <th class="p-4 font-semibold">Nama</th>
          <th class="p-4 font-semibold">Email</th>
          <th class="p-4 font-semibold">Role</th>
          <th class="p-4 font-semibold text-center">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @forelse($users as $user)
        <tr class="hover:bg-gray-50 transition">
          <td class="p-4">{{ $loop->iteration }}</td>
          <td class="p-4 font-medium text-gray-800">{{ $user->name }}</td>
          <td class="p-4 text-gray-600">{{ $user->email }}</td>
          <td class="p-4">
            <span class="px-3 py-1 rounded-full text-xs font-medium
              {{ $user->role === 'admin' ? 'bg-red-100 text-red-600' :
                 ($user->role === 'kasir' ? 'bg-blue-100 text-blue-600' : 'bg-green-100 text-green-600') }}">
              {{ ucfirst($user->role) }}
            </span>
          </td>
          <td class="p-4 flex items-center justify-center space-x-3">
            <a href="{{ route('admin.users.edit', $user->id) }}"
               class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus user ini?')">
              @csrf @method('DELETE')
              <button type="submit"
                      class="text-red-600 hover:text-red-800 font-medium">
                Hapus
              </button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center text-gray-500 p-6">Tidak ada user.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
