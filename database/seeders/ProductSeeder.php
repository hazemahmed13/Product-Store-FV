<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Samsung Galaxy S24',
                'description' => 'أحدث هاتف ذكي من سامسونج مع كاميرا عالية الجودة وأداء ممتاز',
                'price' => 25000.00,
                'stock_quantity' => 50,
                'code' => 'SAM-S24-001',
                'model' => 'Galaxy S24',
                'image' => 'products/samsung-s24.jpg',
            ],
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'هاتف آيفون الجديد مع معالج A17 Pro وكاميرا احترافية',
                'price' => 35000.00,
                'stock_quantity' => 30,
                'code' => 'APL-IP15-001',
                'model' => 'iPhone 15 Pro',
                'image' => 'products/iphone-15-pro.jpg',
            ],
            [
                'name' => 'MacBook Air M3',
                'description' => 'لابتوب خفيف وقوي مع معالج Apple M3 للأداء الاستثنائي',
                'price' => 45000.00,
                'stock_quantity' => 20,
                'code' => 'APL-MBA-M3',
                'model' => 'MacBook Air',
                'image' => 'products/macbook-air-m3.jpg',
            ],
            [
                'name' => 'Dell XPS 13',
                'description' => 'لابتوب أنيق ومحمول مع شاشة عالية الدقة ومعالج Intel Core i7',
                'price' => 38000.00,
                'stock_quantity' => 25,
                'code' => 'DEL-XPS-13',
                'model' => 'XPS 13',
                'image' => 'products/dell-xps-13.jpg',
            ],
            [
                'name' => 'Sony WH-1000XM5',
                'description' => 'سماعات لاسلكية مع إلغاء الضوضاء الذكي وجودة صوت استثنائية',
                'price' => 8500.00,
                'stock_quantity' => 100,
                'code' => 'SNY-WH-1000',
                'model' => 'WH-1000XM5',
                'image' => 'products/sony-headphones.jpg',
            ],
            [
                'name' => 'iPad Pro 12.9"',
                'description' => 'تابلت احترافي مع شاشة Liquid Retina XDR ومعالج M2',
                'price' => 28000.00,
                'stock_quantity' => 40,
                'code' => 'APL-IPD-PRO',
                'model' => 'iPad Pro',
                'image' => 'products/ipad-pro.jpg',
            ],
            [
                'name' => 'Samsung 55" QLED TV',
                'description' => 'تلفزيون ذكي بتقنية QLED وجودة 4K مع HDR',
                'price' => 22000.00,
                'stock_quantity' => 15,
                'code' => 'SAM-TV-55Q',
                'model' => 'QLED 55"',
                'image' => 'products/samsung-tv.jpg',
            ],
            [
                'name' => 'Nintendo Switch OLED',
                'description' => 'جهاز ألعاب محمول مع شاشة OLED ملونة وألعاب متنوعة',
                'price' => 12000.00,
                'stock_quantity' => 60,
                'code' => 'NIN-SW-OLED',
                'model' => 'Switch OLED',
                'image' => 'products/nintendo-switch.jpg',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
