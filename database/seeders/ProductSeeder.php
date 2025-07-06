<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Laptop HP',
                'description' => 'Laptop con procesador Intel i5 y 8GB RAM',
                'price' => 2500.00,
                'stock' => 10,
                'image' => 'hp.jpg',
                'category' => 'Tecnología',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Celular Samsung A32',
                'description' => 'Smartphone Android de gama media',
                'price' => 1200.00,
                'stock' => 25,
                'image' => 'samsung.jpg',
                'category' => 'Tecnología',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mouse Logitech',
                'description' => 'Mouse inalámbrico ergonómico',
                'price' => 75.00,
                'stock' => 50,
                'image' => 'mouse.jpg',
                'category' => 'Accesorios',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Teclado Mecánico',
                'description' => 'Teclado retroiluminado con switches rojos',
                'price' => 180.00,
                'stock' => 35,
                'image' => 'teclado.jpg',
                'category' => 'Accesorios',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Monitor LG 24"',
                'description' => 'Monitor LED full HD 24 pulgadas',
                'price' => 699.00,
                'stock' => 20,
                'image' => 'monitor.jpg',
                'category' => 'Tecnología',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Audífonos Sony',
                'description' => 'Audífonos Bluetooth con cancelación de ruido',
                'price' => 420.00,
                'stock' => 40,
                'image' => 'audifonos.jpg',
                'category' => 'Audio',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tablet Lenovo',
                'description' => 'Tablet de 10" con Android 12',
                'price' => 899.00,
                'stock' => 15,
                'image' => 'tablet.jpg',
                'category' => 'Tecnología',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Silla Gamer',
                'description' => 'Silla ergonómica con soporte lumbar y reclinable',
                'price' => 560.00,
                'stock' => 18,
                'image' => 'silla.jpg',
                'category' => 'Muebles',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Disco SSD 1TB',
                'description' => 'Almacenamiento r{aido para laptops y PCs',
                'price' => 320.00,
                'stock' => 60,
                'image' => 'ssd.jpg',
                'category' => 'Almacenamiento',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Impresora Canon',
                'description' => 'Impresora multifuncional a color',
                'price' => 480.00,
                'stock' => 12,
                'image' => 'impresora.jpg',
                'category' => 'Oficina',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
