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
            // Jasa Konstruksi Bangunan (ID: 1)
            [
                'jasa_id' => 1,
                'nama' => 'Konstruksi rumah tinggal',
                'deskripsi' => 'Pembangunan rumah tinggal dari awal hingga selesai. Kami tangani semua tahap konstruksi mulai dari pondasi hingga finishing dengan kualitas terbaik dan sesuai kebutuhan Anda.',
                'harga' => 500000,
                'gambar' => null
            ],
            [
                'jasa_id' => 1,
                'nama' => 'Konstruksi gedung perkantoran',
                'deskripsi' => 'Konstruksi gedung perkantoran dengan standar profesional. Kami utamakan kualitas material, ketepatan waktu, dan kemudahan akses serta efisiensi ruang untuk operasional bisnis Anda.',
                'harga' => 1500000,
                'gambar' => null
            ],
            [
                'jasa_id' => 1,
                'nama' => 'Konstruksi ruko atau kios',
                'deskripsi' => 'Pembangunan ruko atau kios untuk kebutuhan bisnis dan komersial. Desain yang menarik dan struktural yang kokoh untuk mendukung aktivitas bisnis Anda dalam jangka panjang.',
                'harga' => 750000,
                'gambar' => null
            ],
            [
                'jasa_id' => 1,
                'nama' => 'Konstruksi gudang dan pabrik',
                'deskripsi' => 'Konstruksi gudang dan pabrik sesuai kebutuhan industri. Kami perhatikan aspek efisiensi, keamanan, dan alur kerja untuk mendukung produktivitas operasional perusahaan Anda.',
                'harga' => 2000000,
                'gambar' => null
            ],
            [
                'jasa_id' => 1,
                'nama' => 'Konstruksi villa/resort',
                'deskripsi' => 'Pembangunan villa dan resort dengan sentuhan estetika dan kenyamanan premium. Kami hadirkan suasana yang mewah dan nyaman dengan memperhatikan detail arsitektur dan lanskap sekitar.',
                'harga' => 2500000,
                'gambar' => null
            ],

            // Renovasi & Rehabilitasi (ID: 2)
            [
                'jasa_id' => 2,
                'nama' => 'Renovasi rumah',
                'deskripsi' => 'Layanan renovasi rumah untuk peningkatan kualitas dan fungsi hunian. Kami tangani perubahan layout, pembaharuan tampilan, hingga perbaikan struktur sesuai kebutuhan Anda.',
                'harga' => 2500000,
                'gambar' => null
            ],
            [
                'jasa_id' => 2,
                'nama' => 'Renovasi kantor/toko',
                'deskripsi' => 'Renovasi ruang kantor atau toko untuk meningkatkan produktivitas dan daya tarik bisnis. Desain modern dan fungsional untuk menciptakan suasana kerja yang nyaman dan profesional.',
                'harga' => 3500000,
                'gambar' => null
            ],
            [
                'jasa_id' => 2,
                'nama' => 'Perbaikan struktur bangunan',
                'deskripsi' => 'Perbaikan dan penguatan struktur bangunan yang mengalami kerusakan. Kami pastikan bangunan Anda kembali aman dan kokoh dengan teknologi rehabilitasi struktur terkini.',
                'harga' => 4500000,
                'gambar' => null
            ],
            [
                'jasa_id' => 2,
                'nama' => 'Pembongkaran & pembangunan ulang',
                'deskripsi' => 'Layanan pembongkaran dan pembangunan ulang untuk bangunan yang sudah tidak layak. Proses yang rapi, aman, dan cepat dengan memperhatikan dampak lingkungan sekitar.',
                'harga' => 6000000,
                'gambar' => null
            ],

            // Desain & Arsitektur (ID: 3)
            [
                'jasa_id' => 3,
                'nama' => 'Jasa desain arsitektur 2D/3D',
                'deskripsi' => 'Pembuatan desain arsitektur dalam format 2D dan 3D. Visualisasi jelas dan detail untuk memudahkan Anda memahami konsep bangunan yang akan direalisasikan.',
                'harga' => 150000,
                'gambar' => null
            ],
            [
                'jasa_id' => 3,
                'nama' => 'Jasa desain interior',
                'deskripsi' => 'Desain interior yang menggabungkan estetika dan fungsionalitas. Kami ciptakan ruangan yang nyaman, efisien, dan mencerminkan karakter penggunanya dengan sentuhan profesional.',
                'harga' => 1200000,
                'gambar' => null
            ],
            [
                'jasa_id' => 3,
                'nama' => 'Jasa visualisasi/rendering',
                'deskripsi' => 'Layanan visualisasi dan rendering untuk melihat hasil akhir proyek sebelum dibangun. Gambar fotorealistik berkualitas tinggi untuk presentasi atau kebutuhan marketing.',
                'harga' => 50000,
                'gambar' => null
            ],
            [
                'jasa_id' => 3,
                'nama' => 'Perencanaan site plan',
                'deskripsi' => 'Perencanaan tata letak lahan dan bangunan secara menyeluruh. Kami optimalkan penggunaan lahan dengan memperhatikan aspek aksesibilitas, keamanan, dan lingkungan.',
                'harga' => 80000,
                'gambar' => null
            ],

            // Mekanikal, Elektrikal & Plumbing (MEP) (ID: 4)
            [
                'jasa_id' => 4,
                'nama' => 'Instalasi listrik & panel',
                'deskripsi' => 'Pemasangan sistem kelistrikan dan panel yang aman dan efisien. Dikerjakan oleh tenaga ahli bersertifikat dengan standar keselamatan tertinggi dan material berkualitas.',
                'harga' => 750000,
                'gambar' => null
            ],
            [
                'jasa_id' => 4,
                'nama' => 'Instalasi air bersih & kotor',
                'deskripsi' => 'Instalasi sistem perpipaan untuk air bersih dan air kotor/limbah. Perencanaan matang untuk menjamin aliran lancar, higienis, dan bebas masalah jangka panjang.',
                'harga' => 850000,
                'gambar' => null
            ],
            [
                'jasa_id' => 4,
                'nama' => 'Sistem HVAC (AC/sirkulasi udara)',
                'deskripsi' => 'Pemasangan sistem pendingin udara dan ventilasi untuk kenyamanan ruangan. Solusi hemat energi dengan performa optimal untuk berbagai jenis dan ukuran ruangan.',
                'harga' => 1250000,
                'gambar' => null
            ],
            [
                'jasa_id' => 4,
                'nama' => 'Sistem pemadam kebakaran (fire safety)',
                'deskripsi' => 'Instalasi sistem keamanan dan pemadam kebakaran sesuai standar keselamatan. Termasuk sprinkler, alarm, detektor asap, dan peralatan pemadam portabel.',
                'harga' => 1500000,
                'gambar' => null
            ],

            // Pekerjaan Sipil (ID: 5)
            [
                'jasa_id' => 5,
                'nama' => 'Pengecoran beton',
                'deskripsi' => 'Pekerjaan pengecoran beton untuk pondasi, kolom, balok, dan lantai. Kualitas campuran dan teknik pengerjaan terbaik untuk hasil yang kuat dan tahan lama.',
                'harga' => 600000,
                'gambar' => null
            ],
            [
                'jasa_id' => 5,
                'nama' => 'Pembangunan jalan dan saluran',
                'deskripsi' => 'Konstruksi jalan dan sistem drainase dengan standar teknis yang tepat. Fokus pada daya tahan, kemudahan perawatan, dan fungsi optimal di segala cuaca.',
                'harga' => 350000,
                'gambar' => null
            ],
            [
                'jasa_id' => 5,
                'nama' => 'Pemasangan paving block',
                'deskripsi' => 'Pemasangan paving block untuk area parkir, halaman, dan jalan setapak. Material berkualitas dengan pola pemasangan rapi dan estetik untuk keindahan dan daya tahan.',
                'harga' => 35000,
                'gambar' => null
            ],
            [
                'jasa_id' => 5,
                'nama' => 'Pekerjaan struktur baja',
                'deskripsi' => 'Konstruksi dan pemasangan struktur baja untuk berbagai kebutuhan. Kokoh, presisi, dan efisien untuk bangunan industri, jembatan, atau elemen arsitektural.',
                'harga' => 4000000,
                'gambar' => null
            ],

            // Finishing & Interior (ID: 6)
            [
                'jasa_id' => 6,
                'nama' => 'Pemasangan keramik & granit',
                'deskripsi' => 'Pemasangan keramik dan granit untuk lantai dan dinding dengan hasil rapi dan presisi. Berbagai pilihan pola dan metode pemasangan sesuai desain yang diinginkan.',
                'harga' => 450000,
                'gambar' => null
            ],
            [
                'jasa_id' => 6,
                'nama' => 'Pengecatan interior & eksterior',
                'deskripsi' => 'Jasa pengecatan profesional untuk interior dan eksterior bangunan. Hasil halus dan merata dengan pilihan cat berkualitas yang tahan lama dan mudah dibersihkan.',
                'harga' => 300000,
                'gambar' => null
            ],
            [
                'jasa_id' => 6,
                'nama' => 'Pemasangan gypsum & plafon',
                'deskripsi' => 'Instalasi plafon gypsum dengan berbagai model dan finishing. Termasuk desain drop ceiling, aksen lampu, dan ornamen dekoratif sesuai gaya interior yang diinginkan.',
                'harga' => 550000,
                'gambar' => null
            ],
            [
                'jasa_id' => 6,
                'nama' => 'Furniture custom',
                'deskripsi' => 'Pembuatan furniture custom sesuai desain dan kebutuhan spesifik. Dikerjakan oleh tukang kayu berpengalaman dengan material pilihan dan detail finishing yang sempurna.',
                'harga' => 700000,
                'gambar' => null
            ],

            // Layanan Konsultasi (ID: 7)
            [
                'jasa_id' => 7,
                'nama' => 'Konsultasi desain & anggaran',
                'deskripsi' => 'Layanan konsultasi untuk perencanaan desain dan penganggaran proyek. Solusi efektif dan efisien untuk mewujudkan ide Anda dengan biaya yang optimal.',
                'harga' => 200000,
                'gambar' => null
            ],
            [
                'jasa_id' => 7,
                'nama' => 'Rencana Anggaran Biaya (RAB)',
                'deskripsi' => 'Penyusunan rencana anggaran biaya secara detail dan akurat. Mencakup material, tenaga kerja, peralatan, dan biaya tidak terduga untuk perencanaan finansial proyek yang tepat.',
                'harga' => 300000,
                'gambar' => null
            ],
            [
                'jasa_id' => 7,
                'nama' => 'Pengurusan IMB/izin konstruksi',
                'deskripsi' => 'Bantuan pengurusan Izin Mendirikan Bangunan (IMB) dan perizinan konstruksi lainnya. Proses yang cepat dan tepat dengan pemahaman regulasi terkini.',
                'harga' => 500000,
                'gambar' => null
            ],
            [
                'jasa_id' => 7,
                'nama' => 'Survey & studi kelayakan lokasi',
                'deskripsi' => 'Jasa survey lokasi dan analisis kelayakan untuk proyek konstruksi. Evaluasi menyeluruh tentang kondisi tanah, aksesibilitas, dan faktor lingkungan lainnya.',
                'harga' => 400000,
                'gambar' => null
            ],
        ];

        foreach ($subJasaData as $subJasa) {
            SubJasa::create($subJasa);
        }
    }
}
