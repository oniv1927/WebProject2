<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Kategori Utama
        $categories = [
            [
                'slug' => 'wisata-alam',
                'name' => 'Wisata Alam',
                'icon' => '🌿',
                'image' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?q=80&w=800&auto=format&fit=crop',
                'description' => 'Jelajahi keindahan hutan mangrove, pantai, dan sungai Delta Brantas.',
            ],
            [
                'slug' => 'kuliner',
                'name' => 'Kuliner',
                'icon' => '🍜',
                'image' => 'https://images.unsplash.com/photo-1569056676629-40ca8060a1c8?q=80&w=800&auto=format&fit=crop',
                'description' => 'Nikmati cita rasa otentik kuliner khas Sidoarjo yang melegenda.',
            ],
            [
                'slug' => 'budaya',
                'name' => 'Budaya',
                'icon' => '🎭',
                'image' => 'https://images.unsplash.com/photo-1528181304800-259b08848526?q=80&w=800&auto=format&fit=crop',
                'description' => 'Kenali warisan budaya dan tradisi lokal Delta Brantas.',
            ],
            [
                'slug' => 'sejarah',
                'name' => 'Sejarah',
                'icon' => '🏛️',
                'image' => 'https://images.unsplash.com/photo-1590123715937-e59c0b60c5c7?q=80&w=800&auto=format&fit=crop',
                'description' => 'Susuri situs bersejarah peninggalan era Majapahit di Sidoarjo.',
            ],
        ];

        foreach ($categories as $cat) {
            \App\Models\Category::create($cat);
        }

        // Destinasi (Alam, Budaya, Sejarah)
        $wisataAlam = \App\Models\Category::where('slug', 'wisata-alam')->first()->id;
        $budaya = \App\Models\Category::where('slug', 'budaya')->first()->id;
        $sejarah = \App\Models\Category::where('slug', 'sejarah')->first()->id;

        $destinations = [
            // Alam
            ['category_id' => $wisataAlam, 'slug' => 'wisata-bahari-tlocor', 'name' => 'Wisata Bahari Tlocor', 'image' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?q=80&w=800&auto=format&fit=crop', 'badge' => 'Unggulan', 'location' => 'Tlocor, Sidoarjo', 'rating' => 4.9, 'description' => 'Kawasan wisata bahari dengan pemandangan alam memukau, habitat burung migran, dan jalur mangrove yang eksotis.', 'is_featured' => true],
            ['category_id' => $wisataAlam, 'slug' => 'pulau-lusi', 'name' => 'Pulau Lusi', 'image' => 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?q=80&w=800&auto=format&fit=crop', 'badge' => 'Populer', 'location' => 'Delta Brantas, Sidoarjo', 'rating' => 4.7, 'description' => 'Pulau hasil sedimentasi lumpur yang menjadi habitat burung migran dan ekosistem unik di muara Brantas.', 'is_featured' => false],
            ['category_id' => $wisataAlam, 'slug' => 'mangrove-kedungpandan', 'name' => 'Mangrove Kedungpandan', 'image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?q=80&w=800&auto=format&fit=crop', 'badge' => 'Eksotis', 'location' => 'Kedungpandan, Sidoarjo', 'rating' => 4.6, 'description' => 'Hutan mangrove lebat dengan jalur trekking yang menenangkan dan pemandangan sungai yang indah.', 'is_featured' => false],
            // Budaya
            ['category_id' => $budaya, 'slug' => 'batik-sidoarjo', 'name' => 'Batik Sidoarjo', 'image' => 'https://images.unsplash.com/photo-1528181304800-259b08848526?q=80&w=800&auto=format&fit=crop', 'badge' => 'Warisan', 'location' => 'Sidoarjo, Jawa Timur', 'rating' => 4.8, 'description' => 'Motif batik khas dengan corak udang dan bandeng yang menjadi identitas kota Sidoarjo.', 'is_featured' => true],
            ['category_id' => $budaya, 'slug' => 'wayang-kulit', 'name' => 'Wayang Kulit', 'image' => 'https://images.unsplash.com/photo-1596402184320-4174ca1817e0?q=80&w=800&auto=format&fit=crop', 'badge' => 'Seni', 'location' => 'Sidoarjo, Jawa Timur', 'rating' => 4.7, 'description' => 'Seni pertunjukan wayang kulit yang masih aktif di beberapa desa budaya Sidoarjo.', 'is_featured' => false],
            // Sejarah
            ['category_id' => $sejarah, 'slug' => 'candi-pari', 'name' => 'Candi Pari', 'image' => 'https://images.unsplash.com/photo-1470770841497-7b3202ee5da8?q=80&w=800&auto=format&fit=crop', 'badge' => 'Majapahit', 'location' => 'Pari, Sidoarjo', 'rating' => 4.7, 'description' => 'Candi peninggalan Majapahit yang menyimpan sejarah panjang kerajaan Nusantara.', 'is_featured' => true],
              ['category_id' => $sejarah, 'slug' => 'candi-trowulan', 'name' => 'Candi Trowulan', 'image' => 'https://images.unsplash.com/photo-1590123715937-e59c0b60c5c7?q=80&w=800&auto=format&fit=crop', 'badge' => 'Majapahit', 'location' => 'Trowulan, Sidoarjo', 'rating' => 4.6, 'description' => 'Kompleks candi peninggalan Kerajaan Majapahit dengan arsitektur yang megah.', 'is_featured' => false],
        ];

        foreach ($destinations as $dest) {
            \App\Models\Destination::create($dest);
        }

        // Kuliner
        $culinaries = [
            ['slug' => 'kupang-lontong', 'name' => 'Kupang Lontong', 'category_type' => 'Makanan', 'image' => 'https://images.unsplash.com/photo-1569056676629-40ca8060a1c8?q=80&w=800&auto=format&fit=crop', 'badge' => 'Legendaris', 'location' => 'Sidoarjo Kota', 'rating' => 4.9, 'description' => 'Hidangan khas Sidoarjo dari kerang kecil dengan kuah segar, lontong, dan petis.', 'is_featured' => true],
            ['slug' => 'petis-udang-sidoarjo', 'name' => 'Petis Udang Sidoarjo', 'category_type' => 'Bumbu', 'image' => 'https://images.unsplash.com/photo-1563379926898-0571a8a67e34?q=80&w=800&auto=format&fit=crop', 'badge' => 'Oleh-oleh', 'location' => 'Gedangan, Sidoarjo', 'rating' => 4.7, 'description' => 'Bumbu khas yang terbuat dari udang, pendamping sempurna untuk berbagai hidangan laut.', 'is_featured' => false],
            ['slug' => 'bandeng-asap', 'name' => 'Bandeng Asap', 'category_type' => 'Makanan', 'image' => 'https://images.unsplash.com/photo-1455619452474-d2be8b1e70cd?q=80&w=800&auto=format&fit=crop', 'badge' => 'Favorit', 'location' => 'Porong, Sidoarjo', 'rating' => 4.6, 'description' => 'Ikan bandeng yang diasap dengan teknik tradisional, menghasilkan cita rasa smoky yang khas.', 'is_featured' => false],
        ];

        foreach ($culinaries as $cul) {
            \App\Models\Culinary::create($cul);
        }

        // Artikel
        $articles = [
            ['slug' => 'festival-budaya-delta-brantas-2026', 'title' => 'Festival Budaya Delta Brantas 2026 Resmi Dibuka', 'image' => 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=800&auto=format&fit=crop', 'published_at' => '2026-06-15', 'excerpt' => 'Festival tahunan yang menampilkan seni, budaya, dan kuliner khas Sidoarjo kembali digelar dengan konsep yang lebih meriah.', 'status' => 'Publikasi'],
            ['slug' => 'revitalisasi-hutan-mangrove', 'title' => 'Revitalisasi Hutan Mangrove Wonorejo Rampung', 'image' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?q=80&w=800&auto=format&fit=crop', 'published_at' => '2026-06-10', 'excerpt' => 'Program konservasi berhasil memperluas area mangrove dan menambah jalur trekking baru untuk wisatawan.', 'status' => 'Publikasi'],
            ['slug' => 'umkm-kuliner-sertifikasi-halal', 'title' => '10 UMKM Kuliner Sidoarjo Raih Sertifikasi Halal', 'image' => 'https://images.unsplash.com/photo-1528181304800-259b08848526?q=80&w=800&auto=format&fit=crop', 'published_at' => '2026-06-05', 'excerpt' => 'Pemerintah daerah mendukung pelaku usaha kuliner dalam memperoleh sertifikasi halal.', 'status' => 'Draft'],
        ];

        foreach ($articles as $art) {
            \App\Models\Article::create($art);
        }
    }
}
