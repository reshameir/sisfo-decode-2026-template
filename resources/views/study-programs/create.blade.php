@extends('layouts.app')

@section('title', 'Tambah Program Studi')

@section('content')
    <div class="page-header">
        <h1>
            <i class="bi bi-plus-circle me-2"></i>
            Tambah Program Studi
        </h1>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-pencil-square me-2"></i>Form Tambah Program Studi
                </div>
                <div class="card-body">
                    <form action="{{ route('study-programs.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="code" class="form-label">
                                Kode Program Studi <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('code') is-invalid @enderror" 
                                   id="code" 
                                   name="code" 
                                   value="{{ old('code') }}"
                                   placeholder="Contoh: TI, SI, IF"
                                   required>
                            @error('code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <small class="text-muted">Kode unik untuk program studi (maksimal 10 karakter)</small>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Nama Program Studi <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   placeholder="Contoh: Teknik Informatika"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>Simpan
                            </button>
                            <a href="{{ route('study-programs.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bi bi-info-circle me-1"></i>Petunjuk
                    </h6>
                    <ul class="small mb-0">
                        <li>Field bertanda <span class="text-danger">*</span> wajib diisi</li>
                        <li>Kode program studi harus unik</li>
                        <li>Gunakan kode singkat dan mudah diingat</li>
                        <li>Nama program studi harus lengkap dan jelas</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
