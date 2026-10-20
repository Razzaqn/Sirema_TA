@extends('layouts.admin')
@section('content')
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard Admin
    </h2>
</x-slot>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">

            <div class="bg-white rounded-2xl shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Mahasiswa</p>
                        <h2 class="text-3xl font-bold text-blue-600">
                            {{ $jumlahMahasiswa }}
                        </h2>
                    </div>

                    <div class="bg-blue-100 p-3 rounded-xl">
                        👨‍🎓
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Perusahaan</p>
                        <h2 class="text-3xl font-bold text-green-600">
                            {{ $jumlahPerusahaan }}
                        </h2>
                    </div>

                    <div class="bg-green-100 p-3 rounded-xl">
                        🏢
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Mata Kuliah</p>
                        <h2 class="text-3xl font-bold text-purple-600">
                            {{ $jumlahMK }}
                        </h2>
                    </div>

                    <div class="bg-purple-100 p-3 rounded-xl">
                        📚
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Wilayah</p>
                        <h2 class="text-3xl font-bold text-red-600">
                            {{ $jumlahWilayah }}
                        </h2>
                    </div>


                </div>
            </div>

        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
            <div class="p-6 text-gray-900">

                <div class="flex justify-between items-center mb-6">

                    <div>

                        <h2 class="text-2xl font-bold">

                            Pengguna Terbaru

                        </h2>

                        <p class="text-gray-500">

                            Daftar akun yang terdaftar pada sistem.

                        </p>

                    </div>

                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="px-5 py-3 text-left">Pengguna</th>
                                <th class="px-5 py-3 text-left">Email</th>
                                <th class="px-5 py-3 text-center">Role</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($users as $user)

                            <tr class="border-b hover:bg-gray-50">

                                <td class="px-5 py-4">

                                    <div class="flex items-center gap-3">

                                        <img src="{{ $user->photo ? asset('storage/'.$user->photo) : asset('public/images/default.jpg') }}"
                                            class="w-11 h-11 rounded-full object-cover">

                                        <div>

                                            <div class="font-semibold">
                                                {{ $user->name }}
                                            </div>

                                            <div class="text-sm text-gray-500">
                                                ID : {{ $user->id }}
                                            </div>

                                        </div>

                                    </div>

                                </td>

                                <td class="px-5 py-4">

                                    {{ $user->email }}

                                </td>

                                <td class="px-5 py-4 text-center">

                                    @if($user->role=='admin')

                                    <span
                                        class="px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-semibold">

                                        Admin

                                    </span>

                                    @else

                                    <span
                                        class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">

                                        Mahasiswa

                                    </span>

                                    @endif

                                </td>

                            </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
