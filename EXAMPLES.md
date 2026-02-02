# Panduan & Referensi Kode - Sisfo Decode Bootcamp 2026

Dokumen ini berisi panduan, pola umum, dan contoh-contoh referensi untuk membantu Anda mengerjakan pelatihan. **Jangan langsung copy-paste!** Pahami konsepnya terlebih dahulu.

---

## 📦 1. Database Migrations

### Konsep Dasar
Migration adalah cara Laravel untuk membuat dan memodifikasi struktur database menggunakan kode PHP.

### Membuat Migration
```bash
php artisan make:migration create_nama_table_table
```

### Struktur Dasar Migration
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nama_table', function (Blueprint $table) {
            $table->id();
            // Kolom lainnya di sini
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nama_table');
    }
};
```

### Tipe-Tipe Kolom yang Sering Digunakan
```php
$table->id();                              // Primary key auto increment
$table->string('nama_kolom');              // VARCHAR (default 255)
$table->string('nama_kolom', 10);          // VARCHAR dengan panjang custom
$table->text('nama_kolom');                // TEXT untuk teks panjang
$table->integer('nama_kolom');             // Integer
$table->foreignId('nama_id');              // Foreign key (bigint unsigned)
$table->timestamps();                      // created_at & updated_at
```

### Contoh Constraint
```php
// Unique constraint
$table->string('kode')->unique();

// Foreign key dengan cascade delete
$table->foreignId('parent_id')
      ->constrained('parent_table')
      ->onDelete('cascade');
```

**💡 Tips:** Nama tabel harus **plural** dan **snake_case** (contoh: `study_programs`, `students`)

---

## 🎯 2. Eloquent Models

### Membuat Model
```bash
php artisan make:model NamaModel
```

### Struktur Dasar Model
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NamaModel extends Model
{
    // Tentukan kolom mana yang boleh di-mass assign
    protected $fillable = [
        'kolom1',
        'kolom2',
        // dst...
    ];
}
```

### Relasi Database

#### One to Many (Satu ke Banyak)
Contoh: Satu Program Studi punya banyak Mahasiswa

**Di Model Parent (StudyProgram):**
```php
use Illuminate\Database\Eloquent\Relations\HasMany;

public function students(): HasMany
{
    return $this->hasMany(Student::class);
}
```

**Di Model Child (Student):**
```php
use Illuminate\Database\Eloquent\Relations\BelongsTo;

public function studyProgram(): BelongsTo
{
    return $this->belongsTo(StudyProgram::class);
}
```

**💡 Tips:** 
- Model harus **singular** dan **PascalCase** (contoh: `StudyProgram`, `Student`)
- Relasi `hasMany` = **plural** (students)
- Relasi `belongsTo` = **singular** (studyProgram)

---

## 🔧 3. Controllers

### Membuat Resource Controller
```bash
php artisan make:controller NamaController --resource
```

### Struktur Method Resource Controller

```php
<?php

namespace App\Http\Controllers;

use App\Models\NamaModel;
use Illuminate\Http\Request;

class NamaController extends Controller
{
    // Tampilkan semua data
    public function index()
    {
        $items = NamaModel::all();
        return view('folder.index', compact('items'));
    }

    // Tampilkan form create
    public function create()
    {
        return view('folder.create');
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            // rules validasi
        ]);

        NamaModel::create($validated);

        return redirect()->route('route.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    // Tampilkan form edit
    public function edit(NamaModel $namaModel)
    {
        return view('folder.edit', compact('namaModel'));
    }

    // Update data
    public function update(Request $request, NamaModel $namaModel)
    {
        $validated = $request->validate([
            // rules validasi
        ]);

        $namaModel->update($validated);

        return redirect()->route('route.index')
            ->with('success', 'Data berhasil diupdate');
    }

    // Hapus data
    public function destroy(NamaModel $namaModel)
    {
        $namaModel->delete();

        return redirect()->route('route.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
```

### Validasi Data

#### Validasi Dasar
```php
$request->validate([
    'nama_field' => 'required|string|max:255',
    'kode' => 'required|unique:nama_table,kode',
    'foreign_id' => 'required|exists:parent_table,id',
]);
```

#### Validasi dengan Pesan Custom (Bahasa Indonesia)
```php
$request->validate([
    'nama' => 'required|string',
    'kode' => 'required|unique:table',
], [
    'nama.required' => 'Nama wajib diisi',
    'kode.required' => 'Kode wajib diisi',
    'kode.unique' => 'Kode sudah digunakan',
]);
```

#### Validasi Unique Kecuali ID Sendiri (untuk Update)
```php
'kode' => 'required|unique:table,kode,' . $model->id
```

### Loading Relasi (Eager Loading)
```php
// Ambil data dengan relasi
$students = Student::with('studyProgram')->get();

// Di view bisa akses: $student->studyProgram->name
```

---

## 🛣️ 4. Routes

### Resource Route
```php
use App\Http\Controllers\NamaController;

Route::resource('url-path', NamaController::class);
```

Route di atas otomatis membuat 7 routes:
- `GET /url-path` → index
- `GET /url-path/create` → create
- `POST /url-path` → store
- `GET /url-path/{id}` → show
- `GET /url-path/{id}/edit` → edit
- `PUT/PATCH /url-path/{id}` → update
- `DELETE /url-path/{id}` → destroy

**💡 Tips:** Gunakan URL **plural** dan **kebab-case** (contoh: `study-programs`, `students`)

---

## 🎨 5. Blade Views

### Extend Layout
Setiap view harus extend layout utama:
```blade
@extends('layouts.app')

@section('title', 'Judul Halaman')

@section('content')
    {{-- Konten di sini --}}
@endsection
```

### Menampilkan Data dari Controller
```blade
{{ $variable }}              {{-- Escaped (aman) --}}
{!! $html !!}               {{-- Unescaped (hati-hati!) --}}
```

### Looping Data
```blade
@foreach($items as $item)
    <p>{{ $item->name }}</p>
@endforeach
```

### Conditional
```blade
@if($condition)
    <p>Tampil jika true</p>
@else
    <p>Tampil jika false</p>
@endif
```

### Form POST
```blade
<form action="{{ route('route.store') }}" method="POST">
    @csrf
    <input type="text" name="nama" class="form-control">
    <button type="submit">Simpan</button>
</form>
```

### Form PUT (untuk Update)
```blade
<form action="{{ route('route.update', $item) }}" method="POST">
    @csrf
    @method('PUT')
    {{-- form fields --}}
</form>
```

### Form DELETE
```blade
<form action="{{ route('route.destroy', $item) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit">Hapus</button>
</form>
```

### Dropdown Select
```blade
<select name="foreign_id" class="form-select">
    <option value="">-- Pilih --</option>
    @foreach($items as $item)
        <option value="{{ $item->id }}">
            {{ $item->name }}
        </option>
    @endforeach
</select>
```

### Dropdown dengan Selected (untuk Edit)
```blade
@foreach($items as $item)
    <option value="{{ $item->id }}" 
            {{ old('foreign_id', $model->foreign_id) == $item->id ? 'selected' : '' }}>
        {{ $item->name }}
    </option>
@endforeach
```

### Menampilkan Error Validasi
```blade
<input type="text" 
       name="nama" 
       class="form-control @error('nama') is-invalid @enderror"
       value="{{ old('nama') }}">

@error('nama')
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
```

### Mengakses Data Relasi di View
```blade
{{-- Pastikan sudah di-load dengan eager loading --}}
<p>Program Studi: {{ $student->studyProgram->name }}</p>
```

---

## 🧪 6. Seeders (Opsional)

### Membuat Seeder
```bash
php artisan make:seeder NamaSeeder
```

### Struktur Seeder
```php
<?php

namespace Database\Seeders;

use App\Models\NamaModel;
use Illuminate\Database\Seeder;

class NamaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['field1' => 'value1', 'field2' => 'value2'],
            ['field1' => 'value3', 'field2' => 'value4'],
        ];

        foreach ($data as $item) {
            NamaModel::create($item);
        }
    }
}
```

### Menjalankan Seeder
```bash
php artisan db:seed --class=NamaSeeder
```

---

## 💡 Pola Kerja CRUD

### 1️⃣ CREATE (Tambah Data)
- Controller: method `create()` → tampilkan form
- Controller: method `store()` → validasi & simpan data
- View: form dengan `@csrf` dan `method="POST"`

### 2️⃣ READ (Tampilkan Data)
- Controller: method `index()` → ambil semua data
- View: looping dengan `@foreach` dan tampilkan dalam tabel

### 3️⃣ UPDATE (Edit Data)
- Controller: method `edit()` → tampilkan form dengan data
- Controller: method `update()` → validasi & update data
- View: form dengan `@csrf`, `@method('PUT')`, dan value dari database

### 4️⃣ DELETE (Hapus Data)
- Controller: method `destroy()` → hapus data
- View: form dengan `@csrf`, `@method('DELETE')`

---

## 🚀 Artisan Commands Penting

```bash
# Membuat files
php artisan make:migration create_table_name
php artisan make:model ModelName
php artisan make:controller ControllerName --resource
php artisan make:seeder SeederName

# Database
php artisan migrate                    # Jalankan migration
php artisan migrate:rollback           # Rollback migration terakhir
php artisan migrate:fresh              # Drop semua table & migrate ulang
php artisan migrate:fresh --seed       # + jalankan seeder

php artisan db:seed                    # Jalankan semua seeder
php artisan db:seed --class=ClassName  # Jalankan seeder tertentu

# Development
php artisan serve                      # Jalankan development server
php artisan route:list                 # Lihat semua routes
```

---

## 📋 Checklist Umum untuk Setiap Entitas

- [ ] Buat migration dengan kolom yang sesuai
- [ ] Buat model dengan `$fillable` dan relationships
- [ ] Buat controller dengan method CRUD lengkap
- [ ] Tambahkan route resource
- [ ] Buat folder views
- [ ] Buat view index (tampilkan data)
- [ ] Buat view create (form tambah)
- [ ] Buat view edit (form edit)
- [ ] Test semua fungsi CRUD

---

## 🔗 Relationships Cheat Sheet

| Relasi | Model A | Model B | Arti |
|--------|---------|---------|------|
| One to Many | `hasMany(B::class)` | `belongsTo(A::class)` | Satu A punya banyak B |
| Many to Many | `belongsToMany(B::class)` | `belongsToMany(A::class)` | Banyak A punya banyak B |
| One to One | `hasOne(B::class)` | `belongsTo(A::class)` | Satu A punya satu B |

Untuk bootcamp ini, fokus ke **One to Many** saja!

---

## ⚠️ Common Mistakes & Solutions

### Error: Class not found
**Penyebab:** Lupa import class
**Solusi:** Tambahkan `use App\Models\NamaModel;` di atas class controller

### Error: Column not found
**Penyebab:** Nama kolom di migration beda dengan yang dipakai di kode
**Solusi:** Pastikan nama kolom konsisten

### Error: Mass assignment
**Penyebab:** Kolom tidak ada di `$fillable`
**Solusi:** Tambahkan nama kolom ke array `$fillable` di model

### Data tidak muncul di dropdown
**Penyebab:** Lupa kirim data dari controller
**Solusi:** Pastikan data sudah di-`compact()` atau kirim ke view

### Relasi null/error
**Penyebab:** Lupa eager loading
**Solusi:** Gunakan `->with('namaRelasi')` saat query

---

**💡 Ingat:** Pahami konsepnya, jangan langsung copy-paste! Sesuaikan dengan kebutuhan entitas yang sedang Anda kerjakan.

**🎯 Happy Coding!**

---

## 📦 1. Migration Examples

### Study Programs Migration
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('study_programs', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('study_programs');
    }
};
```

### Students Migration
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 20)->unique();
            $table->string('name');
            $table->foreignId('study_program_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
```

---

## 🎯 2. Model Examples

### StudyProgram Model
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudyProgram extends Model
{
    protected $fillable = [
        'code',
        'name',
    ];

    /**
     * Relasi ke Students
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Relasi ke Subjects
     */
    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }
}
```

---

## 🔧 3. Controller Examples

### Method index() - Menampilkan Data
```php
public function index()
{
    $studyPrograms = StudyProgram::orderBy('code')->get();
    return view('study-programs.index', compact('studyPrograms'));
}
```

### Method create() - Form Tambah
```php
public function create()
{
    return view('study-programs.create');
}
```

### Method store() - Simpan Data Baru
```php
public function store(Request $request)
{
    $validated = $request->validate([
        'code' => 'required|string|max:10|unique:study_programs,code',
        'name' => 'required|string|max:255',
    ], [
        'code.required' => 'Kode program studi wajib diisi',
        'code.unique' => 'Kode program studi sudah digunakan',
        'name.required' => 'Nama program studi wajib diisi',
    ]);

    StudyProgram::create($validated);

    return redirect()
        ->route('study-programs.index')
        ->with('success', 'Program studi berhasil ditambahkan!');
}
```

### Method edit() - Form Edit
```php
public function edit(StudyProgram $studyProgram)
{
    return view('study-programs.edit', compact('studyProgram'));
}
```

### Method update() - Update Data
```php
public function update(Request $request, StudyProgram $studyProgram)
{
    $validated = $request->validate([
        'code' => 'required|string|max:10|unique:study_programs,code,' . $studyProgram->id,
        'name' => 'required|string|max:255',
    ], [
        'code.required' => 'Kode program studi wajib diisi',
        'code.unique' => 'Kode program studi sudah digunakan',
        'name.required' => 'Nama program studi wajib diisi',
    ]);

    $studyProgram->update($validated);

    return redirect()
        ->route('study-programs.index')
        ->with('success', 'Program studi berhasil diupdate!');
}
```

### Method destroy() - Hapus Data
```php
public function destroy(StudyProgram $studyProgram)
{
    try {
        $studyProgram->delete();
        return redirect()
            ->route('study-programs.index')
            ->with('success', 'Program studi berhasil dihapus!');
    } catch (\Exception $e) {
        return redirect()
            ->route('study-programs.index')
            ->with('error', 'Gagal menghapus program studi. Mungkin masih ada data terkait.');
    }
}
```

### Contoh dengan Eager Loading (untuk relasi)
```php
public function index()
{
    // Load data mahasiswa dengan relasi studyProgram
    $students = Student::with('studyProgram')->get();
    return view('students.index', compact('students'));
}
```

---

## 🛣️ 4. Routes Example

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudyProgramController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;

Route::get('/', function () {
    return view('pages.home');
});

// Resource Routes for CRUD
Route::resource('study-programs', StudyProgramController::class);
Route::resource('students', StudentController::class);
Route::resource('subjects', SubjectController::class);
```

---

## 🎨 5. View Examples

### Struktur Dasar View
```blade
@extends('layouts.app')

@section('title', 'Judul Halaman')

@section('content')
    {{-- Konten di sini --}}
@endsection
```

### Page Header
```blade
<div class="page-header">
    <h1><i class="bi bi-people-fill me-2"></i>Daftar Mahasiswa</h1>
</div>
```

### Card dengan Header dan Button
```blade
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Data Mahasiswa</span>
        <a href="{{ route('students.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-1"></i>Tambah Mahasiswa
        </a>
    </div>
    <div class="card-body">
        {{-- Isi card --}}
    </div>
</div>
```

### Tabel dengan Relasi
```blade
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Program Studi</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $index => $student)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $student->nim }}</td>
                <td>{{ $student->name }}</td>
                <td>
                    {{-- Akses data relasi --}}
                    <span class="badge bg-info">
                        {{ $student->studyProgram->name }}
                    </span>
                </td>
                <td class="text-center">
                    {{-- Button aksi --}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
```

### Button Edit dan Delete
```blade
{{-- Button Edit --}}
<a href="{{ route('students.edit', $student) }}" 
   class="btn btn-warning btn-sm">
    <i class="bi bi-pencil-square"></i> Edit
</a>

{{-- Form Delete dengan Konfirmasi --}}
<form id="delete-{{ $student->id }}" 
      action="{{ route('students.destroy', $student) }}" 
      method="POST" 
      class="d-inline">
    @csrf
    @method('DELETE')
    <button type="button" 
            onclick="confirmDelete('delete-{{ $student->id }}')" 
            class="btn btn-danger btn-sm">
        <i class="bi bi-trash"></i> Hapus
    </button>
</form>
```

### Kondisional Jika Data Kosong
```blade
@if($students->count() > 0)
    {{-- Tampilkan tabel --}}
@else
    <div class="alert alert-info">
        Belum ada data mahasiswa. 
        <a href="{{ route('students.create') }}">Tambah sekarang</a>
    </div>
@endif
```

### Input Field dengan Error Handling
```blade
<div class="mb-3">
    <label for="nim" class="form-label">NIM <span class="text-danger">*</span></label>
    <input type="text" 
           class="form-control @error('nim') is-invalid @enderror" 
           id="nim" 
           name="nim" 
           value="{{ old('nim') }}"
           required>
    @error('nim')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
```

### Dropdown Select dengan Old Value
```blade
<div class="mb-3">
    <label for="study_program_id" class="form-label">
        Program Studi <span class="text-danger">*</span>
    </label>
    <select name="study_program_id" 
            id="study_program_id" 
            class="form-select @error('study_program_id') is-invalid @enderror" 
            required>
        <option value="">-- Pilih Program Studi --</option>
        @foreach($studyPrograms as $program)
            <option value="{{ $program->id }}" 
                    {{ old('study_program_id') == $program->id ? 'selected' : '' }}>
                {{ $program->code }} - {{ $program->name }}
            </option>
        @endforeach
    </select>
    @error('study_program_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
```

### Button Submit dan Batal
```blade
<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save me-1"></i>Simpan
    </button>
    <a href="{{ route('students.index') }}" class="btn btn-secondary">
        <i class="bi bi-x-circle me-1"></i>Batal
    </a>
</div>
```

### Edit Form dengan Dropdown (selected)
```blade
<select name="study_program_id" class="form-select" required>
    <option value="">-- Pilih Program Studi --</option>
    @foreach($studyPrograms as $program)
        <option value="{{ $program->id }}" 
                {{ old('study_program_id', $student->study_program_id) == $program->id ? 'selected' : '' }}>
            {{ $program->code }} - {{ $program->name }}
        </option>
    @endforeach
</select>
```

---

## 🧪 6. Seeder Example

```php
<?php

namespace Database\Seeders;

use App\Models\StudyProgram;
use Illuminate\Database\Seeder;

class StudyProgramSeeder extends Seeder
{
    public function run(): void
    {
        $programs = [
            ['code' => 'TI', 'name' => 'Teknik Informatika'],
            ['code' => 'SI', 'name' => 'Sistem Informasi'],
            ['code' => 'IF', 'name' => 'Informatika'],
            ['code' => 'TE', 'name' => 'Teknik Elektro'],
        ];

        foreach ($programs as $program) {
            StudyProgram::create($program);
        }
    }
}
```

Jangan lupa panggil di `DatabaseSeeder.php`:
```php
public function run(): void
{
    $this->call([
        StudyProgramSeeder::class,
        // StudentSeeder::class,
        // SubjectSeeder::class,
    ]);
}
```

---

## 💡 Tips & Tricks

### 1. Membuat Migration
```bash
php artisan make:migration create_study_programs_table
```

### 2. Membuat Model
```bash
php artisan make:model StudyProgram
```

### 3. Membuat Controller Resource
```bash
php artisan make:controller StudyProgramController --resource
```

### 4. Membuat Seeder
```bash
php artisan make:seeder StudyProgramSeeder
```

### 5. Menjalankan Migration
```bash
php artisan migrate
```

### 6. Menjalankan Seeder
```bash
php artisan db:seed --class=StudyProgramSeeder
```

### 7. Rollback Migration
```bash
php artisan migrate:rollback
```

### 8. Fresh Migration (hapus semua & migrate ulang)
```bash
php artisan migrate:fresh --seed
```

---

**Happy Coding! 🚀**
