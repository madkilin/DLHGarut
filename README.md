<p align="center"><a href="https://dlhkabgarut.org/" target="_blank"><img src="https://dlhkabgarut.org/assets/main/img/logo2.png" width="400" alt="DLH Kabupaten Garut Logo"></a></p>

# Rancang Bangun Web Pengaduan Masalah Sampah dan Edukasi Berbasis Gamifikasi Struktural di Dinas Lingkungan Hidup Kabupaten Garut

_Aplikasi Penelitian – Dinas Lingkungan Hidup Kabupaten Garut_

## 📌 Deskripsi

Proyek ini merupakan hasil penelitian dengan judul **"Rancang Bangun Web Pengaduan Masalah Sampah dan Edukasi Berbasis Gamifikasi Struktural di Dinas Lingkungan Hidup Kabupaten Garut"**.

Aplikasi ini dibangun menggunakan **Laravel Framework** untuk menyediakan wadah pengaduan masyarakat, edukasi lingkungan, serta penerapan **elemen gamifikasi** guna meningkatkan partisipasi masyarakat.

Aplikasi dikembangkan dengan pendekatan **MVC (Model-View-Controller)** dan ditujukan untuk membantu **Dinas Lingkungan Hidup Kabupaten Garut** dalam mengelola pengaduan sampah sekaligus memberikan edukasi kepada masyarakat.

---

## 🚀 Fitur Utama

-   **Pengaduan Masyarakat**

    -   Form pengaduan dengan lokasi, lampiran foto, dan video.
    -   Status pengaduan: _terkirim, diterima, diproses, selesai, ditolak_.

-   **Manajemen Pengaduan (Admin & Petugas)**

    -   Validasi dan distribusi tugas.
    -   Upload bukti penyelesaian oleh petugas.
    -   Monitoring progress pengaduan.

-   **Edukasi Lingkungan**

    -   Artikel & materi edukasi tentang pengelolaan sampah.
    -   Sistem informasi ramah lingkungan.
    -   Dsb.

-   **Gamifikasi Struktural**

    -   Sistem poin berdasarkan aktivitas.
    -   Level pengguna sesuai akumulasi EXP.
    -   Badge (Bronze, Silver, Gold, Platinum, Diamond).
    -   Fitur reward claim untuk masyarakat yang aktif.

---

## 🛠️ Teknologi

-   **Backend**: Laravel 12.10.2, PHP 8.2.12
-   **Frontend**: Blade Template Engine, TailwindCSS
-   **Database**: MySQL/MariaDB
-   **Library**:
    -   [Leaflet.js](https://leafletjs.com/) → Peta lokasi pengaduan
    -   [Chart.js](https://www.chartjs.org/) → Visualisasi data statistik
-   **Build Tools**: Composer, NPM, Vite

---

## 📂 Struktur Direktori

```bash
├── app/ # Model, Controller, Middleware
├── bootstrap/
├── config/
├── database/ # Migration & Seeder
├── public/ # Aset publik
├── resources/
│ ├── views/ # Blade template
│ └── css, js # Asset frontend
├── routes/ # web.php & api.php
├── storage/
├── tests/
└── vendor/
```

---

## ⚙️ Instalasi & Setup

###### _Kode Sumber Web atau Proyek Web_

### 1. Clone Repository

```bash
git clone https://github.com/madkilin/DLHGarut.git
cd DLHGarut
```

### 2. Install Dependency

```bash
composer install
npm install && npm run build
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
php artisan storage:link
```

Atur koneksi database di file .env:

```makefile
APP_DEBUG=true
DB_DATABASE=dlhgarut
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Migrasi Database

```bash
php artisan migrate --seed
php artisan optimize
```

### 5. Jalankan Aplikasi

```bash
php artisan serve
npm run dev
```

Akses aplikasi melalui:
👉 http://127.0.0.1:8000

---

## 👥 Autentikasi & Role Management

-   Admin: mengelola data, memvalidasi, menugaskan, dan menyelesaikan pengaduan.
-   Petugas: menindaklanjuti pengaduan dan mengunggah bukti penyelesaian.
-   Masyarakat: membuat pengaduan, membuat artikel, membaca artikel dan mendapatkan reward.

---

## 📊 Skema Gamifikasi

-   Poin dan EXP: Diberikan sesuai aktivitas (membuat artikel, membaca artikel, dll).
-   Level: Meningkat berdasarkan akumulasi EXP.
-   Badge: Bronze → Silver → Gold → Platinum → Diamond.
-   Reward: Masyarakat dapat menukar poin dengan hadiah sesuai ketentuan.

---

## 📖 User Manual / Panduan Penggunaan Aplikasi Web

Panduan lengkap penggunaan aplikasi dapat diakses melalui tautan berikut:

🔗 [Lihat User Manual di Google Drive](https://drive.google.com/drive/folders/1O92e92y8vXNRtmTklsOBLR2ppxXUFMjh?usp=sharing)

---

## 📜 Lisensi

Proyek ini dikembangkan untuk kepentingan penelitian dan digunakan secara terbatas di Dinas Lingkungan Hidup Kabupaten Garut.

---

## ✨ Penulis

Mochammad Agus D.K.  
Skripsi 2025 – Institut Teknologi Garut  
Judul: Rancang Bangun Web Pengaduan Masalah Sampah dan Edukasi Berbasis Gamifikasi Struktural di Dinas Lingkungan Hidup Kabupaten Garut.
