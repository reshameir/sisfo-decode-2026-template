@extends('layouts.app')

@section('title', 'Home - Sisfo')

@section('content')
    <div class="page-header text-center">
        <h1>
            <i class="bi bi-mortarboard-fill me-2"></i>
            Selamat Datang di Sistem Informasi Mahasiswa
        </h1>
        <p class="lead text-muted mt-3">Sistem Informasi Mahasiswa - Sisfo Decode 2026</p>
    </div>

    <div class="row mt-5">
        <!-- Study Programs Card -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-book-fill" style="font-size: 3rem; color: var(--primary-color);"></i>
                    </div>
                    <h5 class="card-title">Program Studi</h5>
                    <p class="card-text text-muted">Kelola data program studi yang tersedia di kampus</p>
                    <a href="{{ url('/study-programs') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-right-circle me-1"></i>Lihat Data
                    </a>
                </div>
            </div>
        </div>

        <!-- Students Card -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-people-fill" style="font-size: 3rem; color: var(--secondary-color);"></i>
                    </div>
                    <h5 class="card-title">Mahasiswa</h5>
                    <p class="card-text text-muted">Kelola data mahasiswa dan informasi akademiknya</p>
                    <a href="{{ url('/students') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-right-circle me-1"></i>Lihat Data
                    </a>
                </div>
            </div>
        </div>

        <!-- Subjects Card -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-journal-text" style="font-size: 3rem; color: var(--info-color);"></i>
                    </div>
                    <h5 class="card-title">Mata Kuliah</h5>
                    <p class="card-text text-muted">Kelola data mata kuliah per program studi</p>
                    <a href="{{ url('/subjects') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-right-circle me-1"></i>Lihat Data
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics (Optional - can be implemented later) -->
    <div class="row mt-4">
        <div class="col-md-4 mb-3">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <h3 class="text-primary mb-0">
                        <i class="bi bi-book me-2"></i>
                        {{ 0 }} {{-- Will be replaced with actual count --}}
                    </h3>
                    <p class="text-muted mb-0">Program Studi</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <h3 class="text-success mb-0">
                        <i class="bi bi-people me-2"></i>
                        {{ 0 }} {{-- Will be replaced with actual count --}}
                    </h3>
                    <p class="text-muted mb-0">Mahasiswa</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <h3 class="text-info mb-0">
                        <i class="bi bi-journal-text me-2"></i>
                        {{ 0 }} {{-- Will be replaced with actual count --}}
                    </h3>
                    <p class="text-muted mb-0">Mata Kuliah</p>
                </div>
            </div>
        </div>
    </div>
@endsection
