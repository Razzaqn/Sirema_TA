<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MataKuliah;
use App\Models\MataKuliahBidang;

class MataKuliahBidangSeeder extends Seeder
{
    public function run(): void
    {
        $mapping = [

            // ==========================================
            // SEMESTER 1
            // ==========================================

            'Sistem Operasi' => [
                'Administrator Sistem & Jaringan Komputer',
            ],

            'Jaringan Komputer' => [
                'Administrator Sistem & Jaringan Komputer',
            ],

            'Arsitektur dan Organisasi Komputer' => [
                'Administrator Sistem & Jaringan Komputer',
            ],

            'Algoritma dan Pemrograman' => [
                'Web Developer',
                'Mobile App Developer',
            ],

            'Desain Grafis' => [
                'Web Developer',
                'Mobile App Developer',
            ],


            // ==========================================
            // SEMESTER 2
            // ==========================================

            'Interaksi Manusia dan Komputer' => [
                'Web Developer',
                'Mobile App Developer',
            ],

            'Struktur Data' => [
                'Web Developer',
                'Mobile App Developer',
            ],

            'Proyek 1' => [
                'Web Developer',
            ],

            'Pemrograman Web' => [
                'Web Developer',
            ],

            'Basis Data' => [
                'Administrator Basis Data',
            ],

            'Jaringan Komputer Lanjut' => [
                'Administrator Sistem & Jaringan Komputer',
            ],


            // ==========================================
            // SEMESTER 3
            // ==========================================

            'Internet of Things' => [
                'Administrator Sistem & Jaringan Komputer',
            ],

            'Pemrograman Berorientasi Objek' => [
                'Web Developer',
                'Mobile App Developer',
            ],

            'Pemrograman Web Lanjut' => [
                'Web Developer',
            ],

            'Proyek 2' => [
                'Web Developer',
            ],

            'Administrasi Sistem dan Jaringan Komputer' => [
                'Administrator Sistem & Jaringan Komputer',
            ],
        ];


        foreach ($mapping as $namaMataKuliah => $bidangList) {

            $mataKuliah = MataKuliah::where(
                'nama',
                $namaMataKuliah
            )->first();

            if (!$mataKuliah) {

                $this->command->warn(
                    "Mata kuliah tidak ditemukan: {$namaMataKuliah}"
                );

                continue;
            }

            foreach ($bidangList as $bidang) {

                MataKuliahBidang::firstOrCreate([
                    'mata_kuliah_id' => $mataKuliah->id,
                    'bidang' => $bidang,
                ]);
            }

            $this->command->info(
                "Berhasil dipetakan: {$namaMataKuliah}"
            );
        }
    }
}
