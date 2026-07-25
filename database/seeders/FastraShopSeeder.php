<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\GameCategory;
use App\Models\Game;
use App\Models\Denomination;
use Illuminate\Support\Facades\Hash;

class FastraShopSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@fastra.shop',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'User Demo',
            'email' => 'user@fastra.shop',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $mobile = GameCategory::create(['name' => 'Mobile', 'slug' => 'mobile', 'icon' => 'smartphone', 'sort_order' => 1]);
        $pc = GameCategory::create(['name' => 'PC', 'slug' => 'pc', 'icon' => 'monitor', 'sort_order' => 2]);
        $console = GameCategory::create(['name' => 'Console', 'slug' => 'console', 'icon' => 'gamepad', 'sort_order' => 3]);

        $games = [
            ['category_id' => $mobile->id, 'name' => 'Mobile Legends', 'slug' => 'mobile-legends', 'is_featured' => true, 'sort_order' => 1],
            ['category_id' => $mobile->id, 'name' => 'Free Fire', 'slug' => 'free-fire', 'is_featured' => true, 'sort_order' => 2],
            ['category_id' => $mobile->id, 'name' => 'PUBG Mobile', 'slug' => 'pubg-mobile', 'is_featured' => true, 'sort_order' => 3],
            ['category_id' => $mobile->id, 'name' => 'Genshin Impact', 'slug' => 'genshin-impact', 'is_featured' => true, 'sort_order' => 4],
            ['category_id' => $mobile->id, 'name' => 'Roblox', 'slug' => 'robux', 'is_featured' => true, 'sort_order' => 5, 'has_custom_amount' => true],
            ['category_id' => $mobile->id, 'name' => 'Arena of Valor', 'slug' => 'arena-of-valor', 'is_featured' => true, 'sort_order' => 6],
            ['category_id' => $mobile->id, 'name' => 'Call of Duty Mobile', 'slug' => 'cod-mobile', 'sort_order' => 7],
            ['category_id' => $mobile->id, 'name' => 'Clash of Clans', 'slug' => 'clash-of-clans', 'sort_order' => 8],
            ['category_id' => $mobile->id, 'name' => 'Clash Royale', 'slug' => 'clash-royale', 'sort_order' => 9],
            ['category_id' => $mobile->id, 'name' => 'Valorant Mobile', 'slug' => 'valorant-mobile', 'sort_order' => 10],
            ['category_id' => $pc->id, 'name' => 'Steam Wallet', 'slug' => 'steam-wallet', 'is_featured' => true, 'sort_order' => 1],
            ['category_id' => $pc->id, 'name' => 'Garena Shell', 'slug' => 'garena-shell', 'sort_order' => 2],
            ['category_id' => $pc->id, 'name' => 'Valorant', 'slug' => 'valorant', 'is_featured' => true, 'sort_order' => 3],
            ['category_id' => $pc->id, 'name' => 'League of Legends', 'slug' => 'league-of-legends', 'sort_order' => 4],
            ['category_id' => $pc->id, 'name' => 'Point Blank', 'slug' => 'point-blank', 'sort_order' => 5],
            ['category_id' => $console->id, 'name' => 'PlayStation Store', 'slug' => 'playstation-store', 'sort_order' => 1],
            ['category_id' => $console->id, 'name' => 'Nintendo eShop', 'slug' => 'nintendo-eshop', 'sort_order' => 2],
            ['category_id' => $console->id, 'name' => 'Xbox Game Pass', 'slug' => 'xbox-game-pass', 'sort_order' => 3],
        ];

        foreach ($games as $g) {
            Game::create($g);
        }

        $denominations = [
            'mobile-legends' => [
                ['name' => '86 Diamond', 'nominal' => '86 Diamond', 'price' => 20000, 'sort_order' => 1],
                ['name' => '172 Diamond', 'nominal' => '172 Diamond', 'price' => 35000, 'sort_order' => 2],
                ['name' => '283 Diamond', 'nominal' => '283 Diamond', 'price' => 50000, 'sort_order' => 3],
                ['name' => '568 Diamond', 'nominal' => '568 Diamond', 'price' => 95000, 'sort_order' => 4],
                ['name' => '879 Diamond', 'nominal' => '879 Diamond', 'price' => 145000, 'sort_order' => 5],
                ['name' => '1640 Diamond', 'nominal' => '1640 Diamond', 'price' => 265000, 'sort_order' => 6],
                ['name' => '2964 Diamond', 'nominal' => '2964 Diamond', 'price' => 475000, 'sort_order' => 7],
            ],
            'free-fire' => [
                ['name' => '110 Diamond', 'nominal' => '110 Diamond', 'price' => 16000, 'sort_order' => 1],
                ['name' => '343 Diamond', 'nominal' => '343 Diamond', 'price' => 45000, 'sort_order' => 2],
                ['name' => '706 Diamond', 'nominal' => '706 Diamond', 'price' => 87000, 'sort_order' => 3],
                ['name' => '1450 Diamond', 'nominal' => '1450 Diamond', 'price' => 165000, 'sort_order' => 4],
                ['name' => '2180 Diamond', 'nominal' => '2180 Diamond', 'price' => 245000, 'sort_order' => 5],
            ],
            'pubg-mobile' => [
                ['name' => '60 UC', 'nominal' => '60 UC', 'price' => 15000, 'sort_order' => 1],
                ['name' => '325 UC', 'nominal' => '325 UC', 'price' => 65000, 'sort_order' => 2],
                ['name' => '660 UC', 'nominal' => '660 UC', 'price' => 125000, 'sort_order' => 3],
                ['name' => '1800 UC', 'nominal' => '1800 UC', 'price' => 330000, 'sort_order' => 4],
            ],
            'genshin-impact' => [
                ['name' => '60 Genesis Crystal', 'nominal' => '60 GC', 'price' => 15000, 'sort_order' => 1],
                ['name' => '300 Genesis Crystal', 'nominal' => '300 GC', 'price' => 65000, 'sort_order' => 2],
                ['name' => '980 Genesis Crystal', 'nominal' => '980 GC', 'price' => 195000, 'sort_order' => 3],
                ['name' => '1980 Genesis Crystal', 'nominal' => '1980 GC', 'price' => 375000, 'sort_order' => 4],
                ['name' => '3280 Genesis Crystal', 'nominal' => '3280 GC', 'price' => 615000, 'sort_order' => 5],
            ],
            'roblox' => [
                ['name' => '5 Robux', 'nominal' => '5 Robux', 'price' => 2500, 'sort_order' => 1],
                ['name' => '10 Robux', 'nominal' => '10 Robux', 'price' => 5000, 'sort_order' => 2],
                ['name' => '15 Robux', 'nominal' => '15 Robux', 'price' => 7500, 'sort_order' => 3],
                ['name' => '20 Robux', 'nominal' => '20 Robux', 'price' => 10000, 'sort_order' => 4],
                ['name' => '25 Robux', 'nominal' => '25 Robux', 'price' => 11500, 'sort_order' => 5],
                ['name' => '30 Robux', 'nominal' => '30 Robux', 'price' => 13500, 'sort_order' => 6],
                ['name' => '35 Robux', 'nominal' => '35 Robux', 'price' => 15400, 'sort_order' => 7],
                ['name' => '40 Robux', 'nominal' => '40 Robux', 'price' => 17200, 'sort_order' => 8],
                ['name' => '45 Robux', 'nominal' => '45 Robux', 'price' => 18900, 'sort_order' => 9],
                ['name' => '50 Robux', 'nominal' => '50 Robux', 'price' => 20500, 'sort_order' => 10],
                ['name' => '55 Robux', 'nominal' => '55 Robux', 'price' => 22000, 'sort_order' => 11],
                ['name' => '60 Robux', 'nominal' => '60 Robux', 'price' => 23400, 'sort_order' => 12],
                ['name' => '65 Robux', 'nominal' => '65 Robux', 'price' => 24700, 'sort_order' => 13],
                ['name' => '70 Robux', 'nominal' => '70 Robux', 'price' => 25900, 'sort_order' => 14],
                ['name' => '75 Robux', 'nominal' => '75 Robux', 'price' => 27000, 'sort_order' => 15],
                ['name' => '80 Robux', 'nominal' => '80 Robux', 'price' => 28000, 'sort_order' => 16],
                ['name' => '90 Robux', 'nominal' => '90 Robux', 'price' => 30600, 'sort_order' => 17],
                ['name' => '100 Robux', 'nominal' => '100 Robux', 'price' => 34000, 'sort_order' => 18],
                ['name' => '250 Robux', 'nominal' => '250 Robux', 'price' => 80000, 'sort_order' => 19],
                ['name' => '500 Robux', 'nominal' => '500 Robux', 'price' => 150000, 'sort_order' => 20],
                ['name' => '750 Robux', 'nominal' => '750 Robux', 'price' => 225000, 'sort_order' => 21],
                ['name' => '10000 Robux', 'nominal' => '10000 Robux', 'price' => 300000, 'sort_order' => 22],
            ],
            'steam-wallet' => [
                ['name' => 'Rp 50.000', 'nominal' => 'Rp 50.000', 'price' => 50000, 'sort_order' => 1],
                ['name' => 'Rp 100.000', 'nominal' => 'Rp 100.000', 'price' => 100000, 'sort_order' => 2],
                ['name' => 'Rp 150.000', 'nominal' => 'Rp 150.000', 'price' => 150000, 'sort_order' => 3],
                ['name' => 'Rp 300.000', 'nominal' => 'Rp 300.000', 'price' => 300000, 'sort_order' => 4],
                ['name' => 'Rp 500.000', 'nominal' => 'Rp 500.000', 'price' => 500000, 'sort_order' => 5],
            ],
            'valorant' => [
                ['name' => '100 VP', 'nominal' => '100 VP', 'price' => 15000, 'sort_order' => 1],
                ['name' => '205 VP', 'nominal' => '205 VP', 'price' => 30000, 'sort_order' => 2],
                ['name' => '535 VP', 'nominal' => '535 VP', 'price' => 75000, 'sort_order' => 3],
                ['name' => '1100 VP', 'nominal' => '1100 VP', 'price' => 145000, 'sort_order' => 4],
                ['name' => '2375 VP', 'nominal' => '2375 VP', 'price' => 295000, 'sort_order' => 5],
            ],
        ];

        foreach ($denominations as $gameSlug => $ds) {
            $game = Game::where('slug', $gameSlug)->first();
            if ($game) {
                foreach ($ds as $d) {
                    $game->denominations()->create($d);
                }
            }
        }
    }
}
