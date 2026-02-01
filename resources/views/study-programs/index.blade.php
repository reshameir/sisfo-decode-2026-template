@extends('layouts.app')

@section('title', 'Daftar Program Studi')

@section('content')
    <div class="page-header">
        <h1>
            <i class="bi bi-book-fill me-2"></i>
            Daftar Program Studi
        </h1>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="bi bi-table me-2"></i>Data Program Studi</span>
            <a href="{{ route('study-programs.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i>Tambah Program Studi
            </a>
        </div>
        <div class="card-body">
            @if($studyPrograms->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 15%">Kode</th>
                                <th style="width: 55%">Nama Program Studi</th>
                                <th style="width: 25%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($studyPrograms as $index => $program)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $program->code }}</span>
                                    </td>
                                    <td>{{ $program->name }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('study-programs.edit', $program) }}" 
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square me-1"></i>Edit
                                        </a>
                                        
                                        <form id="delete-form-{{ $program->id }}" 
                                              action="{{ route('study-programs.destroy', $program) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    onclick="confirmDelete('delete-form-{{ $program->id }}')" 
                                                    class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash me-1"></i>Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    Belum ada data program studi. 
                    <a href="{{ route('study-programs.create') }}" class="alert-link">Tambah data</a> sekarang.
                </div>
            @endif
        </div>
    </div>
@endsection
