@extends('layouts.app')

@section('title', 'Log Pemeliharaan')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Log Pemeliharaan</h4>
                    @if(auth()->user()->hasPermission('create-maintenance-logs'))
                    <a href="{{ route('maintenance-logs.create') }}" class="btn btn-primary btn-sm">
                        <i class="mdi mdi-plus"></i> Tambah Log
                    </a>
                    @endif
                </div>

                <!-- Filter Form -->
                <form method="GET" action="{{ route('maintenance-logs.index') }}" class="mb-3">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <input type="text"
                                   name="search"
                                   class="form-control form-control-sm"
                                   placeholder="Cari aset, teknisi..."
                                   value="{{ $search ?? '' }}">
                        </div>

                        <div class="col-md-2">
                            <select name="asset_id" class="form-select form-select-sm">
                                <option value="">Semua Aset</option>
                                @foreach($assets as $asset)
                                <option value="{{ $asset->id }}" {{ ($assetId ?? '') == $asset->id ? 'selected' : '' }}>
                                    {{ $asset->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <input type="date"
                                   name="date_from"
                                   class="form-control form-control-sm"
                                   placeholder="Dari"
                                   value="{{ $dateFrom ?? '' }}">
                        </div>

                        <div class="col-md-2">
                            <input type="date"
                                   name="date_to"
                                   class="form-control form-control-sm"
                                   placeholder="Sampai"
                                   value="{{ $dateTo ?? '' }}">
                        </div>

                        <div class="col-md-3">
                            <button class="btn btn-primary btn-sm" type="submit">
                                <i class="mdi mdi-magnify"></i> Cari
                            </button>
                            @if(!empty($search) || !empty($assetId) || !empty($dateFrom) || !empty($dateTo))
                            <a href="{{ route('maintenance-logs.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="mdi mdi-refresh"></i> Reset
                            </a>
                            @endif
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="20%">Aset</th>
                                <th width="15%">Tanggal</th>
                                <th width="15%">Dilakukan Oleh</th>
                                <th width="30%">Hasil</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                            <tr>
                                <td>{{ $logs->firstItem() + $loop->index }}</td>
                                <td>
                                    <strong>{{ $log->asset->name }}</strong><br>
                                    <small class="text-muted">{{ $log->asset->asset_code }}</small>
                                </td>
                                <td>{{ $log->date_performed->format('d/m/Y H:i') }}</td>
                                <td>{{ $log->performed_by }}</td>
                                <td>
                                    <small class="text-muted">
                                        {{ $log->result ? Str::limit($log->result, 50) : '-' }}
                                    </small>
                                </td>
                                <td>
                                    @if(auth()->user()->hasPermission('view-maintenance-logs'))
                                    <a href="{{ route('maintenance-logs.show', $log) }}"
                                       class="btn btn-sm btn-info me-1"
                                       title="Detail">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    @endif

                                    @if(auth()->user()->hasPermission('update-maintenance-logs'))
                                    <a href="{{ route('maintenance-logs.edit', $log) }}"
                                       class="btn btn-sm btn-warning me-1"
                                       title="Edit">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    @endif

                                    @if(auth()->user()->hasPermission('delete-maintenance-logs'))
                                    <form action="{{ route('maintenance-logs.destroy', $log) }}"
                                          method="POST"
                                          class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="btn btn-sm btn-danger"
                                                title="Hapus"
                                                onclick="confirmDelete(this, 'Yakin ingin menghapus log ini?')">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    <div class="py-4">
                                        <i class="mdi mdi-file-document-outline" style="font-size: 48px; color: #ccc;"></i>
                                        <p class="text-muted mb-0 mt-2">Tidak ada log pemeliharaan.</p>
                                        @if(auth()->user()->hasPermission('create-maintenance-logs'))
                                        <a href="{{ route('maintenance-logs.create') }}" class="btn btn-sm btn-primary mt-2">
                                            <i class="mdi mdi-plus"></i> Tambah Log
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($logs->hasPages())
                <div class="mt-3">
                    {{ $logs->links('vendor.pagination.custom') }}
                </div>
                @endif

                <div class="mt-2">
                    <small class="text-muted">
                        Menampilkan {{ $logs->firstItem() ?? 0 }} - {{ $logs->lastItem() ?? 0 }}
                        dari {{ $logs->total() }} log
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Confirm delete function using toast
    function confirmDelete(button, message) {
        const form = button.closest('form');
        showConfirmToast(
            message,
            function() {
                form.submit();
            },
            'Konfirmasi Hapus',
            'Ya, Hapus'
        );
    }
</script>
@endpush
