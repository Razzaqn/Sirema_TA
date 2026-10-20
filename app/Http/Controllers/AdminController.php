<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Industry;
use App\Models\MataKuliah;
use App\Models\MasterWilayah;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all(); // ambil data user

         return view('admin.dashboard',[
        'users' => $users,
        'jumlahMahasiswa' => User::where('role','mahasiswa')->count(),
        'jumlahPerusahaan' => Industry::count(),
        'jumlahMK' => MataKuliah::count(),
        'jumlahWilayah' => MasterWilayah::count(),
    ]);
    }


}
