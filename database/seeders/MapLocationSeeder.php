<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MapLocation;

class MapLocationSeeder extends Seeder
{
    public function run(): void
    {
        // Kosongkan tabel dulu agar tidak duplikat
        MapLocation::truncate();

        $locations = [
            // ── WISATA ALAM ──
            [
                'name' => 'Wisata Bahari Tlocor (Pulau Lusi)',
                'category' => 'alam',
                'icon' => '🌿',
                'description' => 'Ekowisata mangrove dan pulau lumpur di muara Sungai Porong.',
                'address' => 'Jl. Dermaga Tlocor, Desa Kedung Pandan, Jabon, Sidoarjo',
                'latitude' => -7.5527000,
                'longitude' => 112.8452000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Pantai Kepetingan',
                'category' => 'alam',
                'icon' => '🌿',
                'description' => 'Pantai dengan hutan mangrove lebat dan ekosistem burung bangau.',
                'address' => 'Desa Sawohan, Kec. Buduran, Sidoarjo',
                'latitude' => -7.5610000,
                'longitude' => 112.8180000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Delta Fishing',
                'category' => 'alam',
                'icon' => '🌿',
                'description' => 'Wisata pemancingan keluarga dengan konsep rekreasi outbound.',
                'address' => 'Jl. Kedung Peluk, Kec. Candi, Sidoarjo',
                'latitude' => -7.4380000,
                'longitude' => 112.7520000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Kebun Binatang Mini Sidoarjo',
                'category' => 'alam',
                'icon' => '🌿',
                'description' => 'Taman satwa mini dan rekreasi keluarga di kawasan Sidoarjo.',
                'address' => 'Jl. Raya Gempol, Kec. Porong, Sidoarjo',
                'latitude' => -7.4423000,
                'longitude' => 112.6978000,
                'status' => 'Aktif',
            ],

            // ── BUDAYA & SEJARAH ──
            [
                'name' => 'Alun-Alun Sidoarjo',
                'category' => 'budaya',
                'icon' => '🏛️',
                'description' => 'Pusat kota, ruang publik, dan tempat berkumpul warga Sidoarjo.',
                'address' => 'Jl. Sultan Agung, Sidokumpul, Sidoarjo',
                'latitude' => -7.4458000,
                'longitude' => 112.7178000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Monumen Jayandaru',
                'category' => 'budaya',
                'icon' => '🏛️',
                'description' => 'Monumen kebanggaan Sidoarjo, ikonik dengan patung udang dan bandeng.',
                'address' => 'Jl. Jenggolo No. 21, Sidokumpul, Sidoarjo',
                'latitude' => -7.4502000,
                'longitude' => 112.7165000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Museum Mpu Tantular',
                'category' => 'budaya',
                'icon' => '🏛️',
                'description' => 'Museum sejarah Jawa Timur dengan koleksi arkeologi dan geologi lengkap.',
                'address' => 'Jl. Raya Buduran, Sidoarjo',
                'latitude' => -7.4278000,
                'longitude' => 112.7235000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Kampung Batik Jetis',
                'category' => 'budaya',
                'icon' => '🏛️',
                'description' => 'Sentra pengrajin batik tulis tradisional khas Sidoarjo sejak era kerajaan.',
                'address' => 'Jl. P. Diponegoro, Lemahputro, Sidoarjo',
                'latitude' => -7.4525000,
                'longitude' => 112.7212000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Candi Pari',
                'category' => 'budaya',
                'icon' => '🏛️',
                'description' => 'Situs candi Hindu peninggalan kerajaan Majapahit abad ke-14.',
                'address' => 'Desa Candi Pari, Kec. Porong, Sidoarjo',
                'latitude' => -7.5505000,
                'longitude' => 112.7230000,
                'status' => 'Aktif',
            ],

            // ── KULINER ──
            [
                'name' => 'Sentra Kupang Lontong Pasar Larangan',
                'category' => 'kuliner',
                'icon' => '🍜',
                'description' => 'Pusat kuliner kupang lontong otentik khas Sidoarjo.',
                'address' => 'Pasar Larangan, Kec. Candi, Sidoarjo',
                'latitude' => -7.4620000,
                'longitude' => 112.7090000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Rawon Gajah Mada',
                'category' => 'kuliner',
                'icon' => '🍜',
                'description' => 'Rawon legendaris dengan kuah hitam kental yang lezat di pusat kota.',
                'address' => 'Jl. Gajah Mada, Pekauman, Sidoarjo',
                'latitude' => -7.4480000,
                'longitude' => 112.7150000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Pazkul (Pusat Kuliner Sidoarjo)',
                'category' => 'kuliner',
                'icon' => '🍜',
                'description' => 'Pusat kuliner modern bernuansa santai di komplek Kahuripan Nirwana.',
                'address' => 'Jl. Jati, Kahuripan Nirwana, Sidoarjo',
                'latitude' => -7.4385000,
                'longitude' => 112.7460000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Sentra Bandeng Asap',
                'category' => 'kuliner',
                'icon' => '🍜',
                'description' => 'Toko pusat oleh-oleh olahan ikan bandeng asap khas Sidoarjo.',
                'address' => 'Jl. Raya Sidoarjo – Surabaya, Sidoarjo',
                'latitude' => -7.4466000,
                'longitude' => 112.7310000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Makam Putri Ayu Onih (Ziarah Budaya)',
                'category' => 'budaya',
                'icon' => '🏛️',
                'description' => 'Situs ziarah budaya spiritual bersejarah di Sidoarjo.',
                'address' => 'Kec. Tanggulangin, Sidoarjo',
                'latitude' => -7.4730000,
                'longitude' => 112.7340000,
                'status' => 'Aktif',
            ],
            [
                'name' => 'Sentra Ote-Ote Porong',
                'category' => 'kuliner',
                'icon' => '🍜',
                'description' => 'Camilan gorengan ote-ote legendaris dengan isi rumput laut dan daging.',
                'address' => 'Jl. Raya Porong, Kec. Porong, Sidoarjo',
                'latitude' => -7.5380000,
                'longitude' => 112.6930000,
                'status' => 'Aktif',
            ]
        ];

        foreach ($locations as $loc) {
            MapLocation::create($loc);
        }
    }
}
