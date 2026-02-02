# Sisfo Decode Bootcamp 2026

Template project Laravel untuk pembuatan sistem CRUD sederhana.

## 🗂️ Quick Links
- [Cara Pull & Setup Project](#-cara-pull--setup-project)
- [TODO List](#-todo-list---implementasi-crud)
- [Panduan & Referensi Kode (EXAMPLES.md)](./EXAMPLES.md)
- [Resources & Documentation](#-resources--documentation)

## 📋 Misi Penugasan

**Membuat sistem CRUD sederhana untuk mengelola data Mahasiswa**

### Struktur Data

1. **Study Programs (Program Studi)**
   - `id` - Primary Key
   - `name` - Nama Program Studi (contoh: "Teknik Informatika")
   - `code` - Kode Program Studi (contoh: "TI")

2. **Students (Mahasiswa)**
   - `id` - Primary Key
   - `name` - Nama Mahasiswa
   - `nim` - Nomor Induk Mahasiswa
   - `study_program_id` - Foreign Key ke Study Programs

3. **Subjects (Mata Kuliah)**
   - `id` - Primary Key
   - `name` - Nama Mata Kuliah (contoh: "Pemrograman Web")
   - `code` - Kode Mata Kuliah (contoh: "PWE101")
   - `study_program_id` - Foreign Key ke Study Programs

---

## 🚀 Cara Pull & Setup Project

### Prasyarat

Pastikan Anda sudah menginstall software berikut:
- **PHP** >= 8.2
- **Composer** (Dependency Manager untuk PHP)
- **Node.js** >= 18 & **npm** (untuk mengelola dependencies frontend)
- **MySQL** atau **MariaDB** (Database)
- **Git** (untuk version control)

### Langkah 1: Clone Repository

```bash
git clone https://github.com/reshameir/sisfo-decode-2026-template.git
cd sisfo-decode-2026-template
```

### Langkah 2: Install Dependencies PHP

```bash
composer install
```

### Langkah 3: Install Dependencies Node.js

```bash
npm install
```

### Langkah 4: Setup Environment File

1. Copy file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```

2. Generate Application Key:
   ```bash
   php artisan key:generate
   ```

3. Edit file `.env` dan sesuaikan konfigurasi database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sisfo_decode
   DB_USERNAME=root
   
### Langkah 5: Buat Database

Buat database baru di PhpMyAdmin dengan nama sesuai yang Anda set di `.env` (contoh: `sisfo_decode`):

### Langkah 6: Jalankan Migration

```bash
php artisan migrate
```

### Langkah 7: Jalankan Server Development

Buka terminal baru, lalu jalankan Laravel development server:

```bash
composer run dev
```

Aplikasi akan berjalan di: `http://localhost:8000`

---

## ✅ TODO List - Implementasi CRUD

Berikut adalah checklist tugas yang harus diselesaikan:

### 📦 1. Database & Models

- [ ] **Buat Migration untuk Study Programs**
  - File: `database/migrations/xxxx_create_study_programs_table.php`
  - Kolom: `id`, `name`, `code`, `timestamps`

- [ ] **Buat Migration untuk Students**
  - File: `database/migrations/xxxx_create_students_table.php`
  - Kolom: `id`, `name`, `nim`, `study_program_id`, `timestamps`
  - Tambahkan foreign key constraint ke `study_programs.id`

- [ ] **Buat Migration untuk Subjects**
  - File: `database/migrations/xxxx_create_subjects_table.php`
  - Kolom: `id`, `name`, `code`, `study_program_id`, `timestamps`
  - Tambahkan foreign key constraint ke `study_programs.id`

- [ ] **Buat Model StudyProgram**
  - File: `app/Models/StudyProgram.php`
  - Definisikan `$fillable` properties
  - Definisikan relationship: `hasMany` students & subjects

- [ ] **Buat Model Student**
  - File: `app/Models/Student.php`
  - Definisikan `$fillable` properties
  - Definisikan relationship: `belongsTo` study program

- [ ] **Buat Model Subject**
  - File: `app/Models/Subject.php`
  - Definisikan `$fillable` properties
  - Definisikan relationship: `belongsTo` study program

### 🎯 2. Controllers

- [ ] **Buat StudyProgramController**
  - File: `app/Http/Controllers/StudyProgramController.php`
  - Implementasi method: `index`, `create`, `store`, `edit`, `update`, `destroy`

- [ ] **Buat StudentController**
  - File: `app/Http/Controllers/StudentController.php`
  - Implementasi method: `index`, `create`, `store`, `edit`, `update`, `destroy`
  - Load relationship study program di method `index` dan `edit`

- [ ] **Buat SubjectController**
  - File: `app/Http/Controllers/SubjectController.php`
  - Implementasi method: `index`, `create`, `store`, `edit`, `update`, `destroy`
  - Load relationship study program di method `index` dan `edit`

### 🛣️ 3. Routes

- [ ] **Tambahkan Resource Routes**
  - File: `routes/web.php`
  - Tambahkan route resource untuk Study Programs
  - Tambahkan route resource untuk Students
  - Tambahkan route resource untuk Subjects

### 🎨 4. Views (Blade Templates)

**Template Layout sudah tersedia!** 
Template project ini sudah dilengkapi dengan layout siap pakai di `resources/views/layouts/app.blade.php` yang sudah include:
- ✅ Bootstrap 5 CSS & JS
- ✅ Navbar dengan navigasi ke semua menu
- ✅ Flash message untuk notifikasi (success, error, warning, info)
- ✅ Styling modern dan responsif
- ✅ Footer
- ✅ JavaScript untuk konfirmasi delete

**Contoh Views sudah tersedia!**
Template ini juga sudah dilengkapi dengan contoh views untuk **Study Programs** sebagai referensi:
- ✅ `resources/views/pages/home.blade.php` - Homepage
- ✅ `resources/views/study-programs/index.blade.php` - Contoh halaman index/daftar
- ✅ `resources/views/study-programs/create.blade.php` - Contoh form tambah data
- ✅ `resources/views/study-programs/edit.blade.php` - Contoh form edit data

**Struktur Folder Views:**
```
resources/views/
├── layouts/
│   └── app.blade.php          # Layout utama (Navbar, Footer, Flash messages)
├── pages/
│   └── home.blade.php         # Halaman home
├── study-programs/            # Folder untuk Study Programs (contoh)
│   ├── index.blade.php        # Daftar program studi
│   ├── create.blade.php       # Form tambah
│   └── edit.blade.php         # Form edit
├── students/                  # TODO: Buat folder ini untuk Students
│   └── ...                    # index, create, edit
└── subjects/                  # TODO: Buat folder ini untuk Subjects
    └── ...                    # index, create, edit
```

**Cara Menggunakan Layout:**
Setiap view yang Anda buat harus extend layout `app.blade.php`:

```blade
@extends('layouts.app')

@section('title', 'Judul Halaman')

@section('content')
    {{-- Konten halaman Anda di sini --}}
@endsection
```

#### Study Programs
- [ ] **Index - Daftar Program Studi** (`resources/views/study-programs/index.blade.php`)
  - Extend layout: `@extends('layouts.app')`
  - Tampilkan tabel dengan kolom: No, Kode, Nama, Aksi (Edit, Hapus)
  - Tambahkan tombol "Tambah Program Studi"
  - Gunakan class Bootstrap untuk styling (`.table`, `.btn`, `.card`)
  
  **Contoh struktur:**
  ```blade
  @extends('layouts.app')
  
  @section('title', 'Daftar Program Studi')
  
  @section('content')
      <div class="page-header">
          <h1><i class="bi bi-book-fill me-2"></i>Daftar Program Studi</h1>
      </div>
      
      <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
              <span>Data Program Studi</span>
              <a href="{{ route('study-programs.create') }}" class="btn btn-primary btn-sm">
                  <i class="bi bi-plus-circle me-1"></i>Tambah Program Studi
              </a>
          </div>
          <div class="card-body">
              <table class="table table-striped">
                  {{-- Tabel Anda di sini --}}
              </table>
          </div>
      </div>
  @endsection
  ```

- [ ] **Create - Form Tambah Program Studi** (`resources/views/study-programs/create.blade.php`)
  - Extend layout: `@extends('layouts.app')`
  - Form dengan input: name, code
  - Tombol Submit dan Batal
  - Gunakan class `.form-control`, `.form-label` untuk input
  
  **Contoh form:**
  ```blade
  <form action="{{ route('study-programs.store') }}" method="POST">
      @csrf
      <div class="mb-3">
          <label class="form-label">Nama Program Studi</label>
          <input type="text" name="name" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="{{ route('study-programs.index') }}" class="btn btn-secondary">Batal</a>
  </form>
  ```

- [ ] **Edit - Form Edit Program Studi** (`resources/views/study-programs/edit.blade.php`)
  - Extend layout: `@extends('layouts.app')`
  - Form dengan input: name, code (sudah terisi data menggunakan `value="{{ $studyProgram->name }}"`)
  - Tombol Update dan Batal
  - Gunakan `@method('PUT')` untuk update

#### Students
- [ ] **Index - Daftar Mahasiswa** (`resources/views/students/index.blade.php`)
  - Extend layout: `@extends('layouts.app')`
  - Tampilkan tabel: No, NIM, Nama, Program Studi, Aksi
  - Tambahkan tombol "Tambah Mahasiswa"
  - Relasi: Tampilkan nama program studi dengan `{{ $student->studyProgram->name }}`

- [ ] **Create - Form Tambah Mahasiswa** (`resources/views/students/create.blade.php`)
  - Extend layout: `@extends('layouts.app')`
  - Form dengan input: name, nim, study_program_id (dropdown menggunakan `<select>`)
  - Tombol Submit dan Batal
  
  **Contoh dropdown:**
  ```blade
  <select name="study_program_id" class="form-select" required>
      <option value="">Pilih Program Studi</option>
      @foreach($studyPrograms as $program)
          <option value="{{ $program->id }}">{{ $program->name }}</option>
      @endforeach
  </select>
  ```

- [ ] **Edit - Form Edit Mahasiswa** (`resources/views/students/edit.blade.php`)
  - Extend layout: `@extends('layouts.app')`
  - Form dengan input: name, nim, study_program_id (dropdown, sudah terisi menggunakan `selected`)
  - Tombol Update dan Batal

#### Subjects
- [ ] **Index - Daftar Mata Kuliah** (`resources/views/subjects/index.blade.php`)
  - Extend layout: `@extends('layouts.app')`
  - Tampilkan tabel: No, Kode, Nama, Program Studi, Aksi
  - Tambahkan tombol "Tambah Mata Kuliah"

- [ ] **Create - Form Tambah Mata Kuliah** (`resources/views/subjects/create.blade.php`)
  - Extend layout: `@extends('layouts.app')`
  - Form dengan input: name, code, study_program_id (dropdown)
  - Tombol Submit dan Batal

- [ ] **Edit - Form Edit Mata Kuliah** (`resources/views/subjects/edit.blade.php`)
  - Extend layout: `@extends('layouts.app')`
  - Form dengan input: name, code, study_program_id (dropdown, sudah terisi)
  - Tombol Update dan Batal

**Catatan Penting untuk Views:**
- 🔹 Semua view harus extend layout: `@extends('layouts.app')`
- 🔹 Gunakan `@section('content')` untuk konten utama
- 🔹 Gunakan `@section('title', 'Judul')` untuk mengubah judul halaman
- 🔹 Untuk form delete, gunakan fungsi `confirmDelete()` yang sudah tersedia di layout
  ```blade
  <form id="delete-form-{{ $item->id }}" action="{{ route('route.destroy', $item) }}" method="POST" class="d-inline">
      @csrf
      @method('DELETE')
      <button type="button" onclick="confirmDelete('delete-form-{{ $item->id }}')" class="btn btn-danger btn-sm">
          <i class="bi bi-trash me-1"></i>Hapus
      </button>
  </form>
  ```

### 🔧 5. Validasi & Fitur Tambahan

- [ ] **Validasi Input di Controllers**
  - Study Programs: `name` required, `code` required & unique
  - Students: `name` required, `nim` required & unique, `study_program_id` required & exists
  - Subjects: `name` required, `code` required, `study_program_id` required & exists

- [ ] **Flash Messages**
  - Tambahkan pesan sukses/error setelah create, update, delete
  - Tampilkan di view menggunakan session flash

- [ ] **Konfirmasi Delete**
  - Tambahkan JavaScript confirmation sebelum hapus data

- [ ] **Styling dengan Bootstrap/Tailwind**
  - Rapikan tampilan menggunakan CSS framework

### 🧪 6. Testing (Opsional)

- [ ] **Buat Seeder untuk Data Dummy**
  - File: `database/seeders/StudyProgramSeeder.php`
  - File: `database/seeders/StudentSeeder.php`
  - File: `database/seeders/SubjectSeeder.php`

- [ ] **Test CRUD Functionality**
  - Test Create, Read, Update, Delete untuk masing-masing entitas
  - Pastikan relationship berfungsi dengan baik

---

## 📚 Resources & Documentation

- [Laravel Documentation](https://laravel.com/docs)
- [Laravel Eloquent ORM](https://laravel.com/docs/eloquent)
- [Laravel Migrations](https://laravel.com/docs/migrations)
- [Laravel Validation](https://laravel.com/docs/validation)
- [Laravel Routing](https://laravel.com/docs/routing)
- [Bootstrap 5 Documentation](https://getbootstrap.com/docs/5.3)
- [Bootstrap Icons](https://icons.getbootstrap.com/)

---

## 💡 Tips Mengerjakan Penugasan Sisfo Decode 2026

1. **Mulai dari yang sederhana**
   - Selesaikan Study Programs terlebih dahulu (sudah ada contohnya)
   - Lalu kerjakan Students dan Subjects dengan pola yang sama

2. **Gunakan contoh yang sudah ada**
   - Lihat file di `resources/views/study-programs/` sebagai referensi
   - Copy & modifikasi sesuai kebutuhan (jangan lupa ganti nama variabel!)
   - Cek `EXAMPLES.md` untuk panduan dan pola kode

3. **Jalankan migration bertahap**
   - Buat dan test satu migration sebelum lanjut ke berikutnya
   - Gunakan `php artisan migrate:fresh` jika ada error

4. **Test setiap fitur**
   - Test Create → bisa tambah data?
   - Test Read → data muncul?
   - Test Update → data berubah?
   - Test Delete → data terhapus?

5. **Manfaatkan error messages**
   - Laravel memberikan error yang jelas, baca dengan teliti
   - Cek browser console untuk error JavaScript
   - Cek terminal untuk error PHP

6. **Ikuti naming convention Laravel**
   - Model: Singular, PascalCase (`Student`, `StudyProgram`)
   - Table: Plural, snake_case (`students`, `study_programs`)
   - Controller: Singular + Controller (`StudentController`)
   - View folder: Plural, kebab-case (`students`, `study-programs`)

7. **Commit progress secara berkala**
   ```bash
   git add .
   git commit -m "Menyelesaikan CRUD Study Programs"
   ```

---

## 🤝 Kontribusi

Jika menemukan bug atau ingin menambahkan fitur, silakan buat pull request atau issue di repository ini.

---

## 📝 Lisensi

Project ini menggunakan lisensi MIT. Silakan gunakan untuk keperluan pembelajaran.

---

**Selamat mengerjakan penugasan Sisfo Decode 2026! 🎉**
