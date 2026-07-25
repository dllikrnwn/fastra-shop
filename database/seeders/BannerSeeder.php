<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $dir = storage_path('app/public/banners');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $banners = [
            [
                'title' => 'PROMO TOPUP MINGGU INI!',
                'subtitle' => 'Harga spesial untuk game populer. Jangan sampai kelewatan!',
                'bg_color' => 'accent',
                'link' => '/games',
                'filename' => 'promo-topup.png',
            ],
            [
                'title' => 'MOBILE LEGENDS MURAH',
                'subtitle' => 'Diamond ML paling murah, mulai dari Rp 1.500!',
                'bg_color' => 'yellow',
                'link' => '/games/mobile-legends',
                'filename' => 'promo-ml.png',
            ],
            [
                'title' => 'FREE FIRE TOPUP CEPAT',
                'subtitle' => 'Topup FF instant, langsung masuk ke akun!',
                'bg_color' => 'green',
                'link' => '/games/free-fire',
                'filename' => 'promo-ff.png',
            ],
            [
                'title' => 'BAYAR PAKAI QRIS',
                'subtitle' => 'Praktis, cepat, dan aman. Scan & bayar!',
                'bg_color' => 'purple',
                'link' => null,
                'filename' => 'promo-qris.png',
            ],
        ];

        $colorMap = [
            'accent' => [0, 229, 255],
            'yellow' => [255, 229, 0],
            'green'  => [0, 230, 118],
            'pink'   => [255, 107, 107],
            'purple' => [187, 134, 252],
            'orange' => [255, 145, 0],
        ];

        foreach ($banners as $i => $b) {
            $img = imagecreatetruecolor(1200, 400);
            $c = $colorMap[$b['bg_color']];

            for ($x = 0; $x < 1200; $x++) {
                for ($y = 0; $y < 400; $y++) {
                    $r = (int)($c[0] * (1 - $x / 1200) * 0.8);
                    $g = (int)($c[1] * (1 - $x / 1200) * 0.8);
                    $bl = (int)($c[2] * (1 - $x / 1200) * 0.8);
                    imagesetpixel($img, $x, $y, imagecolorallocate($img, $r, $g, $bl));
                }
            }

            $overlay = imagecolorallocatealpha($img, 0, 0, 0, 80);
            imagefilledrectangle($img, 0, 0, 1200, 400, $overlay);

            $white = imagecolorallocate($img, 255, 255, 255);
            $cyan = imagecolorallocate($img, 0, 229, 255);

            $titleWidth = imagefontwidth(5) * strlen($b['title']);
            imagestring($img, 5, (1200 - $titleWidth) / 2, 160, $b['title'], $white);

            if ($b['subtitle']) {
                $sub = strlen($b['subtitle']) > 60 ? substr($b['subtitle'], 0, 57) . '...' : $b['subtitle'];
                $subW = imagefontwidth(4) * strlen($sub);
                imagestring($img, 4, (1200 - $subW) / 2, 210, $sub, $cyan);
            }

            $brand = 'FASTRA SHOP';
            imagestring($img, 3, 1200 - imagefontwidth(3) * strlen($brand) - 20, 370, $brand, $white);

            $path = $b['filename'];
            imagepng($img, $dir . '/' . $path);
            imagedestroy($img);

            Banner::create([
                'title' => $b['title'],
                'subtitle' => $b['subtitle'],
                'image' => 'banners/' . $path,
                'link' => $b['link'],
                'bg_color' => $b['bg_color'],
                'sort_order' => $i,
                'is_active' => true,
            ]);

            $this->command->info("Banner {$i}: {$b['title']}");
        }
    }
}
