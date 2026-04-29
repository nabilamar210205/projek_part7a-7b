# 📚 API Student — Sistem Terdistribusi (Part 4–6)

Aplikasi CRUD Student menggunakan **Laravel** yang terdiri dari **API Server** dan **API Client** dalam satu project.

## 📌 Deskripsi

| Part | Topik | Keterangan |
|------|-------|------------|
| **Part 4** | API Server | CRUD Student dengan response JSON, validasi, dan format response standar |
| **Part 5** | API Client | Mengonsumsi API menggunakan **GuzzleHTTP**, menampilkan data di Blade view |
| **Part 6** | Pagination | Pagination dari API Server ditampilkan di Client, link diperbaiki, nomor urut berlanjut |

## 🏗️ Arsitektur

```
┌─────────────────────┐         ┌──────────────────────┐
│   API Client :8001  │         │   API Server :8000   │
│                     │         │                      │
│  Browser ──► Web    │ Guzzle  │  API Routes ──► DB   │
│  Routes ──► Blade   │────────►│  (JSON Response)     │
│  Views              │  HTTP   │                      │
└─────────────────────┘         └──────────────────────┘
```

- **Port 8000** → API Server (menyediakan endpoint REST API dalam format JSON)
- **Port 8001** → API Client (mengonsumsi API via Guzzle, menampilkan Blade view ke browser)

## 📋 Fitur

- ✅ **CRUD Student** — Create, Read, Update, Delete
- ✅ **Validasi** — NIM (unique), nama, prodi (wajib), email (valid), tanggal_lahir (date)
- ✅ **Response JSON** — Format standar: `status`, `message`, `data`
- ✅ **Pagination** — 10 data per halaman, nomor urut berlanjut antar halaman
- ✅ **Alert Messages** — Pesan sukses, error, dan validasi
- ✅ **Konfirmasi Delete** — Dialog konfirmasi sebelum menghapus data

## 🗂️ Struktur Project

```
api-project-part-4-6/
├── app/
│   ├── Http/Controllers/
│   │   ├── Api/
│   │   │   └── StudentController.php    ← API Server (CRUD + Validasi)
│   │   └── StudentController.php        ← API Client (Guzzle)
│   └── Models/
│       └── Student.php                  ← Model Student
├── database/
│   ├── migrations/
│   │   └── 2024_01_01_000001_create_students_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── StudentSeeder.php            ← 15 data dummy
├── resources/views/student/
│   ├── index.blade.php                  ← Tabel + Form + Pagination
│   └── edit.blade.php                   ← Form Edit
├── routes/
│   ├── api.php                          ← Route API (apiResource)
│   └── web.php                          ← Route Client
├── bootstrap/
│   └── app.php                          ← Register API routes
└── .env                                 ← Konfigurasi database
```

## 🔧 Teknologi

- **Laravel 13** — Framework PHP
- **MySQL** — Database
- **GuzzleHTTP** — HTTP Client untuk consume API
- **Bootstrap 5** — CSS Framework untuk tampilan
- **Faker** — Generate data dummy

## 🚀 Cara Menjalankan

### 1. Clone & Install Dependencies

```bash
composer install
```

### 2. Konfigurasi Environment

Salin file `.env.example` ke `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=api_student_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 3. Buat Database

Buat database `api_student_db` di **phpMyAdmin** atau via terminal:

```sql
CREATE DATABASE api_student_db;
```

### 4. Jalankan Migration & Seeder

```bash
php artisan migrate
php artisan db:seed
```

### 5. Jalankan Server

Buka **2 terminal** secara bersamaan:

```bash
# Terminal 1 — API Server (port 8000)
php artisan serve --port=8000

# Terminal 2 — API Client (port 8001)
php artisan serve --port=8001
```

### 6. Buka di Browser

| Halaman | URL |
|---------|-----|
| **API Client** (tampilan utama) | [http://localhost:8001/student](http://localhost:8001/student) |
| **API Server** (raw JSON) | [http://localhost:8000/api/student](http://localhost:8000/api/student) |

## 📡 API Endpoints

| Method | Endpoint | Keterangan |
|--------|----------|------------|
| `GET` | `/api/student` | Ambil semua data (paginated) |
| `GET` | `/api/student/{id}` | Detail satu student |
| `POST` | `/api/student` | Tambah student baru |
| `PUT` | `/api/student/{id}` | Update data student |
| `DELETE` | `/api/student/{id}` | Hapus student |

### Contoh Response

```json
{
    "status": true,
    "message": "Data student berhasil diambil",
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "nim": "8056622148",
                "nama": "Kani Yulianti",
                "prodi": "Teknik Informatika",
                "tanggal_lahir": "2004-01-27",
                "email": "sadina.sihotang@example.com",
                "alamat": "Dk. Achmad Yani No. 33, Lubuklinggau"
            }
        ],
        "last_page": 2,
        "per_page": 10,
        "total": 15
    }
}
```

## 🧪 Testing dengan Postman

1. Buka **Postman**
2. Set Header: `Accept: application/json`
3. Test endpoint:

| Test | Method | URL | Body (form-data) |
|------|--------|-----|-------------------|
| List semua | GET | `http://localhost:8000/api/student` | — |
| Detail | GET | `http://localhost:8000/api/student/1` | — |
| Tambah | POST | `http://localhost:8000/api/student` | `nim`, `nama`, `prodi`, `tanggal_lahir`, `email`, `alamat` |
| Update | PUT | `http://localhost:8000/api/student/1` | Field yang ingin diupdate |
| Hapus | DELETE | `http://localhost:8000/api/student/1` | — |

## 📝 Field Student

| Field | Tipe | Keterangan |
|-------|------|------------|
| `id` | integer | Auto increment |
| `nim` | string | **Wajib**, unique |
| `nama` | string | **Wajib** |
| `prodi` | string | **Wajib** |
| `tanggal_lahir` | date | **Wajib**, format: `YYYY-MM-DD` |
| `email` | string | Opsional, harus valid |
| `alamat` | text | Opsional |

## 📄 Lisensi

Project ini dibuat untuk keperluan tugas mata kuliah **Sistem Terdistribusi**.
