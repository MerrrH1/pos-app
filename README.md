Aplikasi Point of Sale (POS) berbasis web yang dibangun dengan Laravel, menggunakan Livewire, Tailwind CSS, dan MariaDB. Aplikasi ini mendukung proses penjualan, pembelian, dan manajemen stok, serta memiliki sistem peran pengguna yang terpisah:

🎯 Fitur Utama

🔐 Autentikasi pengguna

🧑‍💼 Role-based access control:
- super_admin: Akses penuh ke seluruh sistem
- sales_admin: Kelola transaksi penjualan
- purchases_admin: Kelola transaksi pembelian

📦 Manajemen produk, kategori, dan satuan

🧾 Transaksi penjualan & pembelian lengkap dengan item detail

📊 Update status transaksi & manajemen pelanggan/pemasok

🖥️ UI interaktif dengan Livewire & Tailwind CSS

⚙️ Teknologi yang Digunakan
- Laravel 12
= Livewire
= Tailwind CSS
- MariaDB / MySQL
- Role Middleware Custom

Cara Jalankan:
- git clone https://github.com/MerrrH1/pos-app.git
- cd laravel-pos
- composer install
- cp .env.example .env
- php artisan key:generate
- # Sesuaikan koneksi database di .env
- php artisan migrate --seed
- php artisan serve
