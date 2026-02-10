<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Manajemen User - WBS RSUD Blambangan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-slate-100 text-slate-900">
    <div class="min-h-screen flex flex-col">
        <!-- HEADER -->
        <header class="border-b border-slate-200 bg-white/90 backdrop-blur shadow-sm">
            <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="https://rsudblambangan.id/images/navbar/Logo.png" alt="Logo RSUD Blambangan"
                        class="h-10 w-10 object-contain">
                    <div>
                        <h1 class="text-xl font-semibold text-slate-900">Manajemen User</h1>
                        <p class="text-xs text-slate-500">Kelola akun administrator WBS</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('wbs.index') }}" class="text-sm text-slate-600 hover:text-blue-600 mr-4">Kembali
                        ke Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="text-sm font-medium text-red-600 hover:text-red-700">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <main class="flex-1 py-8">
            <div class="max-w-6xl mx-auto px-4">

                @if (session('success'))
                    <div
                        class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50">
                        <h2 class="text-lg font-semibold text-slate-800">Daftar Pengguna</h2>
                        <a href="{{ route('users.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Tambah User Baru
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-slate-800">
                            <thead class="bg-slate-100 border-b border-slate-200 text-xs uppercase text-slate-500">
                                <tr>
                                    <th class="px-6 py-3">Nama</th>
                                    <th class="px-6 py-3">Email</th>
                                    <th class="px-6 py-3">Role</th>
                                    <th class="px-6 py-3">Terdaftar</th>
                                    <th class="px-6 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($users as $user)
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-6 py-4 font-medium">{{ $user->name }}</td>
                                        <td class="px-6 py-4 text-slate-600">{{ $user->email }}</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->role === 'superadmin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-slate-500 text-xs">
                                            {{ $user->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-6 py-4 text-right space-x-2">
                                            <a href="{{ route('users.edit', $user) }}"
                                                class="text-blue-600 hover:text-blue-900 font-medium">Edit</a>
                                            @if ($user->id !== auth()->id())
                                                <form action="{{ route('users.destroy', $user) }}" method="POST"
                                                    class="inline-block"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900 font-medium ml-2">Hapus</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
