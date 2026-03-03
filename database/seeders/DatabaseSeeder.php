<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        DB::table('pengguna')->insert([
            'nama' => 'Admin Literasa',
            'email' => 'admin@literasa.com',
            'password' => Hash::make('password'),
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Contoh No. 123',
            'kota' => 'Jakarta',
            'kode_pos' => '12345',
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create Customer User
        DB::table('pengguna')->insert([
            'nama' => 'John Doe',
            'email' => 'customer@literasa.com',
            'password' => Hash::make('password'),
            'no_hp' => '081234567891',
            'alamat' => 'Jl. Pelanggan No. 456',
            'kota' => 'Bandung',
            'kode_pos' => '40123',
            'role' => 'pelanggan',
            'is_active' => true,
        ]);

        // Create Categories
        $categories = [
            'Fiksi',
            'Non-Fiksi',
            'Self-Development',
            'Bisnis & Ekonomi',
            'Teknologi',
            'Sains',
            'Sejarah',
            'Biografi',
            'Novel',
            'Komik'
        ];

        foreach ($categories as $cat) {
            DB::table('kategori_buku')->insert([
                'nama_kategori' => $cat,
            ]);
        }

        // Create Sample Books
        $books = [
            [
                'id_kategori' => 3,
                'judul' => 'Atomic Habits',
                'isbn' => '978-0735211292',
                'pengarang' => 'James Clear',
                'penerbit' => 'Avery',
                'deskripsi' => 'An Easy & Proven Way to Build Good Habits & Break Bad Ones',
                'harga' => 125000,
                'stok' => 50,
                'is_active' => true,
            ],
            [
                'id_kategori' => 4,
                'judul' => 'Rich Dad Poor Dad',
                'isbn' => '978-1612680194',
                'pengarang' => 'Robert Kiyosaki',
                'penerbit' => 'Plata Publishing',
                'deskripsi' => 'What the Rich Teach Their Kids About Money That the Poor and Middle Class Do Not!',
                'harga' => 98000,
                'stok' => 35,
                'is_active' => true,
            ],
            [
                'id_kategori' => 3,
                'judul' => 'The 7 Habits of Highly Effective People',
                'isbn' => '978-0743269513',
                'pengarang' => 'Stephen Covey',
                'penerbit' => 'Free Press',
                'deskripsi' => 'Powerful Lessons in Personal Change',
                'harga' => 115000,
                'stok' => 40,
                'is_active' => true,
            ],
            [
                'id_kategori' => 9,
                'judul' => 'Laskar Pelangi',
                'isbn' => '978-6021186008',
                'pengarang' => 'Andrea Hirata',
                'penerbit' => 'Bentang Pustaka',
                'deskripsi' => 'Novel tentang anak-anak di Belitung',
                'harga' => 85000,
                'stok' => 60,
                'is_active' => true,
            ],
            [
                'id_kategori' => 5,
                'judul' => 'Clean Code',
                'isbn' => '978-0132350884',
                'pengarang' => 'Robert C. Martin',
                'penerbit' => 'Prentice Hall',
                'deskripsi' => 'A Handbook of Agile Software Craftsmanship',
                'harga' => 165000,
                'stok' => 25,
                'is_active' => true,
            ],
            [
                'id_kategori' => 3,
                'judul' => 'Think and Grow Rich',
                'isbn' => '978-1585424337',
                'pengarang' => 'Napoleon Hill',
                'penerbit' => 'Tarcher',
                'deskripsi' => 'The Landmark Bestseller Now Revised and Updated',
                'harga' => 92000,
                'stok' => 45,
                'is_active' => true,
            ],
        ];

        foreach ($books as $book) {
            DB::table('buku')->insert($book);
        }
    }
}
