<?php

namespace Database\Seeders;

use App\Models\Jasa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class JasaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jasaData = [
            [
                'nama' => 'Jasa Konstruksi Bangunan',
                'deskripsi' => 'Layanan konstruksi profesional untuk berbagai kebutuhan: rumah tinggal, gedung perkantoran, ruko, gudang, pabrik, hingga villa dan resort.',
                'slug' => 'jasa-konstruksi-bangunan',
                'gambar' => 'jasa/1.png'
            ],
            [
                'nama' => 'Renovasi & Rehabilitasi',
                'deskripsi' => 'Layanan renovasi profesional untuk berbagai kebutuhan: perbaikan struktur, perluasan ruangan, pembaruan fasad, modernisasi interior, penggantian material, hingga rehabilitasi total bangunan.',
                'slug' => 'renovasi-dan-rehabilitasi',
                'gambar' => 'jasa/2.png'
            ],
            [
                'nama' => 'Desain & Arsitektur',
                'deskripsi' => 'Layanan desain profesional untuk berbagai kebutuhan: konsep bangunan, perencanaan ruang, gambar kerja, visualisasi 3D, detail konstruksi, hingga dokumen izin mendirikan bangunan.',
                'slug' => 'desain-dan-arsitektur',
                'gambar' => 'jasa/3.png'
            ],
            [
                'nama' => 'Mekanikal, Elektrikal & Plumbing (MEP)',
                'deskripsi' => 'Layanan teknis profesional untuk berbagai kebutuhan: instalasi listrik, sistem pendingin, jaringan air, panel kontrol, sistem kebakaran, hingga otomasi bangunan modern.',
                'slug' => 'mekanikal-elektrikal-dan-plumbing',
                'gambar' => 'jasa/4.png'
            ],
            [
                'nama' => 'Pekerjaan Sipil',
                'deskripsi' => 'Layanan sipil profesional untuk berbagai kebutuhan: fondasi bangunan, struktur beton, jalan akses, drainase lingkungan, perkuatan tanah, hingga konstruksi penahan longsor.',
                'slug' => 'pekerjaan-sipil',
                'gambar' => 'jasa/5.png'
            ],
            [
                'nama' => 'Finishing & Interior',
                'deskripsi' => 'Layanan finishing profesional untuk berbagai kebutuhan: pengecatan dinding, pemasangan lantai, plafon dekoratif, partisi ruangan, furnitur built-in, hingga dekorasi estetik ruangan.',
                'slug' => 'finishing-dan-interior',
                'gambar' => 'jasa/6.png'
            ],
            [
                'nama' => 'Layanan Konsultasi',
                'deskripsi' => 'Layanan konsultasi profesional untuk berbagai kebutuhan: perencanaan proyek, estimasi biaya, pemilihan material, analisis struktur, efisiensi energi, hingga manajemen konstruksi.',
                'slug' => 'layanan-konsultasi',
                'gambar' => 'jasa/7.png'
            ],
        ];

        // Create the jasa records
        foreach ($jasaData as $jasa) {
            Jasa::create($jasa);
        }
    }
}
