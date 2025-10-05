<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'name' => 'Espresso',
                'description' => 'Espresso adalah minuman kopi yang dibuat dengan mengekstraksi biji kopi yang digiling halus menggunakan tekanan tinggi. Hasilnya adalah minuman kopi yang kuat, pekat, dan memiliki cita rasa yang kaya.',
                'price' => 12000,
                'category_id' => 1,
                'image' => '/images/espresso.png',
                'is_best_seller' => false,
            ],
            [
                'name' => 'Americano',
                'description' => 'Americano adalah minuman kopi yang dibuat dengan menambahkan air panas ke dalam espresso. Hasilnya adalah minuman kopi yang lebih ringan dan memiliki cita rasa yang lebih halus dibandingkan dengan espresso murni.',
                'price' => 16000,
                'category_id' => 1,
                'image' => '/images/americano.png',
                'is_best_seller' => true,
            ],
            [
                'name' => 'V60',
                'description' => 'V60 adalah metode penyeduhan kopi yang menggunakan alat berbentuk kerucut dengan lubang di bagian bawahnya. Kopi diseduh dengan menuangkan air panas secara perlahan di atas bubuk kopi yang ditempatkan di dalam alat tersebut, menghasilkan minuman kopi yang bersih dan memiliki cita rasa yang kompleks.',
                'price' => 22000,
                'category_id' => 1,
                'image' => '/images/v60.png',
                'is_best_seller' => false,
            ],
            [
                'name' => 'Javanese',
                'description' => 'Javanese adalah minuman kopi tradisional Indonesia yang terbuat dari campuran kopi, gula merah, dan rempah-rempah seperti kayu manis dan cengkeh. Minuman ini biasanya disajikan dalam keadaan panas dan memiliki cita rasa yang manis dan kaya rempah.',
                'price' => 24000,
                'category_id' => 1,
                'image' => '/images/javanese.png',
                'is_best_seller' => true,
            ],
            [
                'name' => 'Sanger Panas',
                'description' => 'Sanger adalah minuman kopi khas Indonesia yang terbuat dari campuran kopi, susu kental manis, dan es batu. Minuman ini biasanya disajikan dalam keadaan dingin dan memiliki cita rasa yang manis dan creamy.',
                'price' => 14000,
                'category_id' => 1,
                'image' => '/images/sanger-panas.png',
                'is_best_seller' => false,
            ],
            [
                'name' => 'Sanger Dingin',
                'description' => 'Sanger adalah minuman kopi khas Indonesia yang terbuat dari campuran kopi, susu kental manis, dan es batu. Minuman ini biasanya disajikan dalam keadaan dingin dan memiliki cita rasa yang manis dan creamy.',
                'price' => 16000,
                'category_id' => 1,
                'image' => '/images/sanger-dingin.png',
                'is_best_seller' => true,
            ],
            [
                'name' => 'Kampoeng',
                'description' => 'Kampoeng adalah minuman kopi tradisional Indonesia yang terbuat dari campuran kopi, gula merah, dan rempah-rempah seperti kayu manis dan cengkeh. Minuman ini biasanya disajikan dalam keadaan panas dan memiliki cita rasa yang manis dan kaya rempah.',
                'price' => 18000,
                'category_id' => 1,
                'image' => '/images/kampoeng.png',
                'is_best_seller' => false,
            ],
            [
                'name' => 'Tubruk',
                'description' => 'Tubruk adalah metode penyeduhan kopi tradisional Indonesia yang melibatkan pencampuran bubuk kopi langsung dengan air panas dalam cangkir atau gelas. Minuman ini biasanya disajikan dalam keadaan panas dan memiliki cita rasa yang kuat dan pekat.',
                'price' => 10000,
                'category_id' => 1,
                'image' => '/images/tubruk.png',
                'is_best_seller' => true,
            ],
            [
                'name' => 'TS Coffee',
                'description' => 'TS Coffee adalah minuman kopi yang terbuat dari campuran kopi, susu kental manis, dan es batu. Minuman ini biasanya disajikan dalam keadaan dingin dan memiliki cita rasa yang manis dan creamy.',
                'price' => 18000,
                'category_id' => 1,
                'image' => '/images/ts-coffee.png',
                'is_best_seller' => false,
            ],
            [
                'name' => 'Milo Susu Panas',
                'description' => 'Milo Susu adalah minuman cokelat yang terbuat dari campuran bubuk Milo, susu kental manis. Minuman ini biasanya disajikan dalam keadaan dingin dan memiliki cita rasa yang manis dan creamy.',
                'price' => 8000,
                'category_id' => 2,
                'image' => '/images/milo-susu-panas.png',
                'is_best_seller' => true,
            ],
            [
                'name' => 'Milo Susu Dingin',
                'description' => 'Milo Susu adalah minuman cokelat yang terbuat dari campuran bubuk Milo, susu kental manis, dan es batu. Minuman ini biasanya disajikan dalam keadaan dingin dan memiliki cita rasa yang manis dan creamy.',
                'price' => 10000,
                'category_id' => 2,
                'image' => '/images/milo-susu-dingin.png',
                'is_best_seller' => false,
            ],
            [
                'name' => 'Coklat Susu Panas',
                'description' => 'Coklat Susu adalah minuman cokelat yang terbuat dari campuran bubuk cokelat, susu kental manis. Minuman ini biasanya disajikan dalam keadaan dingin dan memiliki cita rasa yang manis dan creamy.',
                'price' => 8000,
                'category_id' => 2,
                'image' => '/images/coklat-susu-panas.png',
                'is_best_seller' => true,
            ],
            [
                'name' => 'Coklat Susu Dingin',
                'description' => 'Coklat Susu adalah minuman cokelat yang terbuat dari campuran bubuk cokelat, susu kental manis, dan es batu. Minuman ini biasanya disajikan dalam keadaan dingin dan memiliki cita rasa yang manis dan creamy.',
                'price' => 10000,
                'category_id' => 2,
                'image' => '/images/coklat-susu-dingin.png',
                'is_best_seller' => false,
            ],
            [
                'name' => 'Coklat Susu Avocado Panas',
                'description' => 'Coklat Susu Avocado adalah minuman cokelat yang terbuat dari campuran bubuk cokelat, susu kental manis, dan alpukat. Minuman ini biasanya disajikan dalam keadaan dingin dan memiliki cita rasa yang manis dan creamy.',
                'price' => 10000,
                'category_id' => 2,
                'image' => '/images/coklat-susu-avocado-panas.png',
                'is_best_seller' => true,
            ],
            [
                'name' => 'Coklat Susu Avocado Dingin',
                'description' => 'Coklat Susu Avocado adalah minuman cokelat yang terbuat dari campuran bubuk cokelat, susu kental manis, alpukat, dan es batu. Minuman ini biasanya disajikan dalam keadaan dingin dan memiliki cita rasa yang manis dan creamy.',
                'price' => 12000,
                'category_id' => 2,
                'image' => '/images/coklat-susu-avocado-dingin.png',
                'is_best_seller' => false,
            ],
            [
                'name' => 'Milcoksu Panas',
                'description' => 'Milcoksu adalah minuman cokelat yang terbuat dari campuran bubuk Milo, susu kental manis. Minuman ini biasanya disajikan dalam keadaan dingin dan memiliki cita rasa yang manis dan creamy.',
                'price' => 10000,
                'category_id' => 2,
                'image' => '/images/milcoksu-panas.png',
                'is_best_seller' => true,
            ],
            [
                'name' => 'Milcoksu Dingin',
                'description' => 'Milcoksu adalah minuman cokelat yang terbuat dari campuran bubuk Milo, susu kental manis, dan es batu. Minuman ini biasanya disajikan dalam keadaan dingin dan memiliki cita rasa yang manis dan creamy.',
                'price' => 12000,
                'category_id' => 2,
                'image' => '/images/milcoksu-dingin.png',
                'is_best_seller' => false,
            ],
            [
                'name' => 'Lemon Tea Panas',
                'description' => 'Lemon Tea adalah minuman teh yang terbuat dari campuran teh, irisan lemon, dan gula. Minuman ini biasanya disajikan dalam keadaan panas dan memiliki cita rasa yang segar dan sedikit asam.',
                'price' => 10000,
                'category_id' => 2,
                'image' => '/images/lemon-tea-panas.png',
                'is_best_seller' => true,
            ],
            [
                'name' => 'Lemon Tea Dingin',
                'description' => 'Lemon Tea adalah minuman teh yang terbuat dari campuran teh, irisan lemon, gula, dan es batu. Minuman ini biasanya disajikan dalam keadaan dingin dan memiliki cita rasa yang segar dan sedikit asam.',
                'price' => 12000,
                'category_id' => 2,
                'image' => '/images/lemon-tea-dingin.png',
                'is_best_seller' => false,
            ],
            [
                'name' => 'Lemon S Panas',
                'description' => 'Lemon S adalah minuman teh yang terbuat dari campuran teh, irisan lemon, dan gula. Minuman ini biasanya disajikan dalam keadaan panas dan memiliki cita rasa yang segar dan sedikit asam.',
                'price' => 10000,
                'category_id' => 2,
                'image' => '/images/lemon-s-panas.png',
                'is_best_seller' => true,
            ],
            [
                'name' => 'Lemon S Dingin',
                'description' => 'Lemon S adalah minuman teh yang terbuat dari campuran teh, irisan lemon, gula, dan es batu. Minuman ini biasanya disajikan dalam keadaan dingin dan memiliki cita rasa yang segar dan sedikit asam.',
                'price' => 12000,
                'category_id' => 2,
                'image' => '/images/lemon-s-dingin.png',
                'is_best_seller' => false,
            ],
            [
                'name' => 'Blue Ocean',
                'description' => 'Blue Ocean adalah minuman teh yang terbuat dari campuran teh, sirup blue curacao, dan es batu. Minuman ini biasanya disajikan dalam keadaan dingin dan memiliki cita rasa yang segar dan sedikit asam.',
                'price' => 15000,
                'category_id' => 2,
                'image' => '/images/blue-ocean.png',
                'is_best_seller' => true,
            ],
            [
                'name' => 'Red Ocean',
                'description' => 'Red Ocean adalah minuman teh yang terbuat dari campuran teh, sirup grenadine, dan es batu. Minuman ini biasanya disajikan dalam keadaan dingin dan memiliki cita rasa yang segar dan sedikit asam.',
                'price' => 15000,
                'category_id' => 2,
                'image' => '/images/red-ocean.png',
                'is_best_seller' => false,
            ],
            [
                'name' => 'Lychee Tea',
                'description' => 'Lychee Tea adalah minuman teh yang terbuat dari campuran teh, sirup leci, dan es batu. Minuman ini biasanya disajikan dalam keadaan dingin dan memiliki cita rasa yang segar dan manis.',
                'price' => 14000,
                'category_id' => 2,
                'image' => '/images/lychee-tea.png',
                'is_best_seller' => true,
            ],
            [
                'name' => 'Ginger',
                'description' => 'Ginger adalah minuman teh yang terbuat dari campuran teh, jahe segar, dan gula. Minuman ini biasanya disajikan dalam keadaan panas dan memiliki cita rasa yang hangat dan sedikit pedas.',
                'price' => 12000,
                'category_id' => 2,
                'image' => '/images/ginger.png',
                'is_best_seller' => false,
            ]
        ];

        foreach($menus as $menu) {
            \App\Models\Menu::create($menu);
        }
    }
}
