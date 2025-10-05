<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first(); // Pastikan ada minimal 1 user

        $articles = [
            [
                'title' => "Pentingnya Membuang Sampah pada Tempatnya",
                'banner' => "banners/DtHPBwwnqH04PCkzbL2eDXp9cl2S2ccHqOCNqjB1.jpg",
                'description' => "
                    <p><b>Kebersihan lingkungan</b> dimulai dari hal sederhana: membuang sampah pada tempatnya.</p>
                    <p>Dengan membiasakan diri, kita dapat mengurangi <i>polusi</i> dan menjaga kenyamanan bersama.</p>
                    <img src='/storage/banners/DtHPBwwnqH04PCkzbL2eDXp9cl2S2ccHqOCNqjB1.jpg' alt='Sampah di tempat sampah' class='rounded-md my-3'>
                ",
            ],
            [
                'title' => "Dampak Sampah Plastik bagi Lingkungan",
                'banner' => "banners/plastik.jpg",
                'description' => "
                    <p>Sampah plastik membutuhkan waktu <b>ratusan tahun</b> untuk terurai.</p>
                    <ul>
                        <li>Mencemari laut</li>
                        <li>Mengganggu rantai makanan</li>
                        <li>Membahayakan hewan dan manusia</li>
                    </ul>
                ",
            ],
            [
                'title' => "Gerakan Bersih Sungai",
                'banner' => "banners/DtHPBwwnqH04PCkzbL2eDXp9cl2S2ccHqOCNqjB1.jpg",
                'description' => "
                    <p><b>Aksi bersih sungai</b> merupakan salah satu bentuk kepedulian masyarakat terhadap lingkungan.</p>
                    <p>Banyak komunitas yang melakukan <i>gotong royong</i> setiap akhir pekan.</p>
                ",
            ],
            [
                'title' => "Pengelolaan Sampah Rumah Tangga",
                'banner' => "banners/DtHPBwwnqH04PCkzbL2eDXp9cl2S2ccHqOCNqjB1.jpg",
                'description' => "
                    <p>Setiap rumah bisa mulai <b>memilah sampah</b> organik dan anorganik.</p>
                    <p>Sampah organik bisa diolah menjadi <i>kompos</i> yang bermanfaat untuk tanaman.</p>
                ",
            ],
            [
                'title' => "Bank Sampah: Solusi Kreatif",
                'banner' => "banners/DtHPBwwnqH04PCkzbL2eDXp9cl2S2ccHqOCNqjB1.jpg",
                'description' => "
                    <p><b>Bank sampah</b> memungkinkan masyarakat menukar sampah dengan tabungan.</p>
                    <p>Ini bukan hanya mengurangi sampah, tetapi juga meningkatkan <i>kesadaran finansial</i>.</p>
                ",
            ],
            [
                'title' => "Edukasi Kebersihan untuk Anak",
                'banner' => "banners/DtHPBwwnqH04PCkzbL2eDXp9cl2S2ccHqOCNqjB1.jpg",
                'description' => "
                    <p>Anak-anak perlu dikenalkan sejak dini pada <b>pentingnya menjaga kebersihan</b>.</p>
                    <p>Metode belajar bisa melalui <i>permainan edukatif</i> dan praktek langsung.</p>
                ",
            ],
            [
                'title' => "Mengurangi Sampah dengan 3R",
                'banner' => "banners/DtHPBwwnqH04PCkzbL2eDXp9cl2S2ccHqOCNqjB1.jpg",
                'description' => "
                    <p><b>Reduce, Reuse, Recycle</b> adalah kunci mengurangi jumlah sampah.</p>
                    <ul>
                        <li>Kurangi penggunaan plastik sekali pakai</li>
                        <li>Gunakan ulang barang yang masih layak</li>
                        <li>Daur ulang untuk barang baru</li>
                    </ul>
                ",
            ],
            [
                'title' => "Kerja Bakti Membersihkan Lingkungan",
                'banner' => "banners/DtHPBwwnqH04PCkzbL2eDXp9cl2S2ccHqOCNqjB1.jpg",
                'description' => "
                    <p><b>Gotong royong</b> membersihkan lingkungan bukan hanya membuat area lebih bersih, tetapi juga mempererat tali persaudaraan.</p>
                ",
            ],
            [
                'title' => "Bahaya Sampah Elektronik",
                'banner' => "banners/DtHPBwwnqH04PCkzbL2eDXp9cl2S2ccHqOCNqjB1.jpg",
                'description' => "
                    <p><b>Sampah elektronik</b> mengandung bahan berbahaya seperti merkuri dan timbal.</p>
                    <p>Pengelolaan khusus sangat diperlukan agar tidak merusak <i>ekosistem</i>.</p>
                ",
            ],
            [
                'title' => "Sampah Menjadi Energi",
                'banner' => "banners/DtHPBwwnqH04PCkzbL2eDXp9cl2S2ccHqOCNqjB1.jpg",
                'description' => "
                    <p>Teknologi modern memungkinkan <b>sampah diolah menjadi energi listrik</b>.</p>
                    <p>Ini menjadi solusi cerdas untuk <i>dua masalah sekaligus</i>: sampah dan kebutuhan energi.</p>
                ",
            ],
        ];

        foreach ($articles as $index => $data) {
            Article::create([
                'title' => $data['title'],
                'slug' => Str::slug($data['title']) . '-' . ($index + 1),
                'user_id' => $user->id,
                'banner' => $data['banner'],
                'description' => $data['description'],
            ]);
        }
    }
}
