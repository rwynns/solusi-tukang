<?php

namespace Database\Seeders;

use App\Models\SubJasa;
use Illuminate\Database\Seeder;

class SubJasaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subJasaData = [
            // Jasa Konstruksi Bangunan
            [
                'jasa_id' => 1,
                'nama' => 'Konstruksi rumah tinggal',
                'deskripsi' => 'Layanan pembangunan rumah tinggal dari tahap perencanaan hingga finishing. Spesifikasi: Termasuk pekerjaan pondasi, struktur, dinding, atap, plafon, lantai, dan pengecatan. Material utama: beton bertulang, bata merah/bata ringan, genteng beton/keramik. Tenaga kerja profesional dan bersertifikat. Konsultasi desain gratis. Estimasi waktu pengerjaan: 4-8 bulan (tergantung luas dan desain). Garansi struktur 1 tahun. Harga sudah termasuk biaya material dan tenaga kerja.',
                'harga' => 3000000,
                'satuan' => 'm²',
                'gambar' => null
            ],
            [
                'jasa_id' => 1,
                'nama' => 'Konstruksi gedung perkantoran',
                'deskripsi' => 'Pembangunan gedung perkantoran bertingkat dengan standar keamanan dan kenyamanan kerja. Spesifikasi: Struktur baja/beton bertulang, sistem kelistrikan dan plumbing terintegrasi, fasilitas lift (opsional), tangga darurat, ruang meeting, sistem keamanan (CCTV, alarm kebakaran), desain fasad modern dan efisien energi, sertifikat laik fungsi (opsional). Estimasi waktu pengerjaan: 6-12 bulan.',
                'harga' => 4000000,
                'satuan' => 'm²',
                'gambar' => null
            ],
            [
                'jasa_id' => 1,
                'nama' => 'Konstruksi ruko atau kios',
                'deskripsi' => 'Pembangunan ruko/kios untuk kebutuhan usaha dengan desain menarik dan fungsional. Spesifikasi: Pilihan 1-3 lantai, area parkir depan, sistem listrik dan air siap pakai, finishing eksterior dan interior sesuai permintaan, cocok untuk usaha retail, kuliner, atau kantor kecil. Estimasi waktu pengerjaan: 3-6 bulan.',
                'harga' => 3500000,
                'satuan' => 'm²',
                'gambar' => null
            ],
            [
                'jasa_id' => 1,
                'nama' => 'Konstruksi gudang dan pabrik',
                'deskripsi' => 'Pembangunan gudang dan pabrik dengan struktur kokoh dan layout efisien. Spesifikasi: Struktur baja/beton, atap galvalum, lantai beton finishing halus, sistem ventilasi dan pencahayaan alami, loading dock dan akses truk, area kantor dan ruang istirahat pekerja (opsional). Estimasi waktu pengerjaan: 4-8 bulan.',
                'harga' => 2800000,
                'satuan' => 'm²',
                'gambar' => null
            ],
            [
                'jasa_id' => 1,
                'nama' => 'Konstruksi villa/resort',
                'deskripsi' => 'Pembangunan villa/resort dengan konsep premium dan fasilitas lengkap. Spesifikasi: Desain arsitektur tropis/minimalis/modern, kolam renang pribadi (opsional), taman dan lanskap, material finishing premium, sistem smart home (opsional). Estimasi waktu pengerjaan: 6-12 bulan.',
                'harga' => 4500000,
                'satuan' => 'm²',
                'gambar' => null
            ],

            // Renovasi & Rehabilitasi
            [
                'jasa_id' => 2,
                'nama' => 'Renovasi rumah',
                'deskripsi' => 'Renovasi rumah untuk memperbaiki, memperluas, atau mempercantik hunian Anda. Spesifikasi: Perubahan layout ruangan, penambahan lantai/ruang baru, penggantian atap, plafon, lantai, pengecatan dan perbaikan dinding, konsultasi desain interior. Estimasi waktu pengerjaan: 1-3 bulan.',
                'harga' => 1000000,
                'satuan' => 'm²',
                'gambar' => null
            ],
            [
                'jasa_id' => 2,
                'nama' => 'Renovasi kantor/toko',
                'deskripsi' => 'Renovasi ruang kantor/toko untuk meningkatkan kenyamanan dan daya tarik bisnis. Spesifikasi: Desain interior modern, penataan ruang kerja dan display produk, instalasi listrik dan AC, pemasangan partisi dan plafon. Estimasi waktu pengerjaan: 1-2 bulan.',
                'harga' => 1200000,
                'satuan' => 'm²',
                'gambar' => null
            ],
            [
                'jasa_id' => 2,
                'nama' => 'Perbaikan struktur bangunan',
                'deskripsi' => 'Perbaikan dan penguatan struktur bangunan yang mengalami kerusakan. Spesifikasi: Penggantian balok/kolom rusak, injeksi beton retak, penguatan pondasi, sertifikat kelayakan struktur (opsional). Estimasi waktu pengerjaan: 1-4 minggu.',
                'harga' => 500000,
                'satuan' => 'titik',
                'gambar' => null
            ],
            [
                'jasa_id' => 2,
                'nama' => 'Pembongkaran & pembangunan ulang',
                'deskripsi' => 'Pembongkaran bangunan lama dan pembangunan ulang sesuai desain baru. Spesifikasi: Pembongkaran aman dan ramah lingkungan, pengelolaan limbah konstruksi, pembangunan ulang sesuai permintaan. Estimasi waktu pengerjaan: 2-6 bulan.',
                'harga' => 2000000,
                'satuan' => 'm²',
                'gambar' => null
            ],

            // Desain & Arsitektur
            [
                'jasa_id' => 3,
                'nama' => 'Jasa desain arsitektur 2D/3D',
                'deskripsi' => 'Pembuatan gambar desain arsitektur lengkap dalam format 2D dan 3D. Spesifikasi: Gambar denah, tampak, potongan, visualisasi 3D eksterior/interior, file digital (PDF, DWG, JPG), 2x revisi desain. Estimasi waktu pengerjaan: 1-3 minggu.',
                'harga' => 150000,
                'satuan' => 'm²',
                'gambar' => null
            ],
            [
                'jasa_id' => 3,
                'nama' => 'Jasa desain interior',
                'deskripsi' => 'Desain interior ruangan sesuai kebutuhan dan gaya Anda. Spesifikasi: Layout furniture, pemilihan warna, material, dan dekorasi, visualisasi 3D, RAB interior (opsional). Estimasi waktu pengerjaan: 1-2 minggu.',
                'harga' => 175000,
                'satuan' => 'm²',
                'gambar' => null
            ],
            [
                'jasa_id' => 3,
                'nama' => 'Jasa visualisasi/rendering',
                'deskripsi' => 'Pembuatan gambar visualisasi/rendering fotorealistik untuk presentasi proyek. Spesifikasi: Render eksterior/interior, resolusi tinggi, 2x revisi, file digital siap cetak. Estimasi waktu pengerjaan: 3-7 hari.',
                'harga' => 1500000,
                'satuan' => 'paket',
                'gambar' => null
            ],
            [
                'jasa_id' => 3,
                'nama' => 'Perencanaan site plan',
                'deskripsi' => 'Pembuatan site plan tata letak lahan dan bangunan. Spesifikasi: Denah lahan, akses jalan, parkir, taman, zonasi area publik/privat, gambar 2D dan 3D. Estimasi waktu pengerjaan: 1-2 minggu.',
                'harga' => 2000000,
                'satuan' => 'paket',
                'gambar' => null
            ],

            // Mekanikal, Elektrikal & Plumbing (MEP)
            [
                'jasa_id' => 4,
                'nama' => 'Instalasi listrik & panel',
                'deskripsi' => 'Pemasangan instalasi listrik dan panel distribusi sesuai standar SNI. Spesifikasi: Kabel NYM/NYA, panel MCB, stop kontak, saklar, lampu, sertifikat laik operasi (opsional). Estimasi waktu pengerjaan: 1-7 hari.',
                'harga' => 75000,
                'satuan' => 'titik',
                'gambar' => null
            ],
            [
                'jasa_id' => 4,
                'nama' => 'Instalasi air bersih & kotor',
                'deskripsi' => 'Pemasangan pipa air bersih dan pembuangan limbah. Spesifikasi: Pipa PVC/HDPE, kran, shower, wastafel, septic tank dan sumur resapan. Estimasi waktu pengerjaan: 1-7 hari.',
                'harga' => 65000,
                'satuan' => 'meter',
                'gambar' => null
            ],
            [
                'jasa_id' => 4,
                'nama' => 'Sistem HVAC (AC/sirkulasi udara)',
                'deskripsi' => 'Pemasangan sistem pendingin udara dan ventilasi ruangan. Spesifikasi: AC split/central, exhaust fan, ducting dan grill. Estimasi waktu pengerjaan: 1-3 hari/unit.',
                'harga' => 3000000,
                'satuan' => 'unit',
                'gambar' => null
            ],
            [
                'jasa_id' => 4,
                'nama' => 'Sistem pemadam kebakaran (fire safety)',
                'deskripsi' => 'Instalasi sistem pemadam kebakaran sesuai standar keselamatan. Spesifikasi: Sprinkler, alarm, detektor asap, fire extinguisher, panel kontrol, sertifikat instalasi (opsional). Estimasi waktu pengerjaan: 1-2 minggu.',
                'harga' => 5000000,
                'satuan' => 'sistem',
                'gambar' => null
            ],

            // Pekerjaan Sipil (ID: 5)
            [
                'jasa_id' => 5,
                'nama' => 'Pengecoran beton',
                'deskripsi' => 'Pengecoran beton untuk pondasi, kolom, balok, dan lantai. Spesifikasi: Beton K225-K350, pengerjaan manual/mixer, finishing halus/ekspos. Estimasi waktu pengerjaan: 1-3 hari/m³.',
                'harga' => 850000,
                'satuan' => 'm³',
                'gambar' => null
            ],
            [
                'jasa_id' => 5,
                'nama' => 'Pembangunan jalan dan saluran',
                'deskripsi' => 'Pembangunan jalan lingkungan dan saluran drainase. Spesifikasi: Jalan beton/paving, saluran U-ditch/beton, marka jalan (opsional). Estimasi waktu pengerjaan: 1-4 minggu.',
                'harga' => 1500000,
                'satuan' => 'm²',
                'gambar' => null
            ],
            [
                'jasa_id' => 5,
                'nama' => 'Pemasangan paving block',
                'deskripsi' => 'Pemasangan paving block untuk halaman, parkir, dan jalan setapak. Spesifikasi: Paving tebal 6-8 cm, pasir urug dan abu batu, pola pemasangan sesuai permintaan. Estimasi waktu pengerjaan: 1-3 hari/100m².',
                'harga' => 125000,
                'satuan' => 'm²',
                'gambar' => null
            ],
            [
                'jasa_id' => 5,
                'nama' => 'Pekerjaan struktur baja',
                'deskripsi' => 'Pemasangan struktur baja untuk bangunan, gudang, atau jembatan. Spesifikasi: Baja WF, H-beam, CNP, las dan baut, finishing cat anti karat. Estimasi waktu pengerjaan: 1-4 minggu.',
                'harga' => 2000000,
                'satuan' => 'ton',
                'gambar' => null
            ],

            // Finishing & Interior
            [
                'jasa_id' => 6,
                'nama' => 'Pemasangan keramik & granit',
                'deskripsi' => 'Pemasangan keramik/granit untuk lantai dan dinding. Spesifikasi: Ukuran 40x40, 60x60, 80x80 cm, nat rapi dan rata, pilihan motif dan warna. Estimasi waktu pengerjaan: 1-3 hari/50m².',
                'harga' => 100000,
                'satuan' => 'm²',
                'gambar' => null
            ],
            [
                'jasa_id' => 6,
                'nama' => 'Pengecatan interior & eksterior',
                'deskripsi' => 'Pengecatan dinding, plafon, dan eksterior bangunan. Spesifikasi: Cat tembok, cat minyak, cat eksterior, persiapan permukaan (plamir, amplas), pilihan warna bebas. Estimasi waktu pengerjaan: 1-3 hari/100m².',
                'harga' => 50000,
                'satuan' => 'm²',
                'gambar' => null
            ],
            [
                'jasa_id' => 6,
                'nama' => 'Pemasangan gypsum & plafon',
                'deskripsi' => 'Pemasangan plafon gypsum dan ornamen dekoratif. Spesifikasi: Rangka hollow galvanis, gypsum board 9mm, finishing cat/plafon motif. Estimasi waktu pengerjaan: 1-3 hari/50m².',
                'harga' => 85000,
                'satuan' => 'm²',
                'gambar' => null
            ],
            [
                'jasa_id' => 6,
                'nama' => 'Furniture custom',
                'deskripsi' => 'Pembuatan furniture custom sesuai desain dan kebutuhan. Spesifikasi: Material kayu solid, MDF, HPL, finishing duco/melamic, desain lemari, meja, kitchen set, dll. Estimasi waktu pengerjaan: 2-4 minggu/unit.',
                'harga' => 1000000,
                'satuan' => 'unit',
                'gambar' => null
            ],

            // Layanan Konsultasi
            [
                'jasa_id' => 7,
                'nama' => 'Konsultasi desain & anggaran',
                'deskripsi' => 'Konsultasi perencanaan desain dan anggaran proyek konstruksi. Spesifikasi: Diskusi kebutuhan dan konsep, estimasi biaya dan waktu, saran material dan metode kerja, laporan konsultasi tertulis. Durasi konsultasi: 1 jam/sesi.',
                'harga' => 500000,
                'satuan' => 'jam',
                'gambar' => null
            ],
            [
                'jasa_id' => 7,
                'nama' => 'Rencana Anggaran Biaya (RAB)',
                'deskripsi' => 'Penyusunan dokumen RAB detail dan akurat untuk proyek konstruksi. Spesifikasi: Rincian material, tenaga kerja, alat, dan biaya tak terduga, format Excel/PDF, estimasi waktu pengerjaan: 2-5 hari, 1x revisi.',
                'harga' => 1000000,
                'satuan' => 'dokumen',
                'gambar' => null
            ],
            [
                'jasa_id' => 7,
                'nama' => 'Pengurusan IMB/izin konstruksi',
                'deskripsi' => 'Layanan pengurusan Izin Mendirikan Bangunan (IMB) dan izin konstruksi lainnya. Spesifikasi: Konsultasi persyaratan dokumen, pengurusan ke dinas terkait, update status proses. Estimasi waktu: 2-6 minggu (tergantung daerah).',
                'harga' => 2500000,
                'satuan' => 'dokumen',
                'gambar' => null
            ],
            [
                'jasa_id' => 7,
                'nama' => 'Survey & studi kelayakan lokasi',
                'deskripsi' => 'Survey lokasi dan studi kelayakan untuk proyek konstruksi. Spesifikasi: Analisis kondisi tanah, akses, dan lingkungan, rekomendasi teknis dan finansial, laporan tertulis dan presentasi. Estimasi waktu pengerjaan: 3-7 hari.',
                'harga' => 1000000,
                'satuan' => 'paket',
                'gambar' => null
            ],
        ];

        foreach ($subJasaData as $subJasa) {
            SubJasa::create($subJasa);
        }
    }
}
