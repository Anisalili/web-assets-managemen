@extends('layouts.app')

@section('title', 'Detail Aset')

@section('content')
<div class="row">
    <div class="col-md-10 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Detail Aset</h4>
                    <div>
                        @if(auth()->user()->hasPermission('update-assets'))
                        <a href="{{ route('assets.edit', $asset) }}" class="btn btn-warning btn-sm">
                            <i class="mdi mdi-pencil"></i> Edit
                        </a>
                        @endif
                        <a href="{{ route('assets.index') }}" class="btn btn-light btn-sm">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Kode Aset</th>
                                <td><strong class="text-primary">{{ $asset->asset_code }}</strong></td>
                            </tr>
                            <tr>
                                <th>Nama Aset</th>
                                <td><strong>{{ $asset->name }}</strong></td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td><span class="badge bg-secondary">{{ $asset->category->name }}</span></td>
                            </tr>
                            <tr>
                                <th>Lokasi</th>
                                <td>
                                    @if($asset->room)
                                        @if($asset->room->building)
                                            {{ $asset->room->building->name }} - {{ $asset->room->name }}
                                        @else
                                            {{ $asset->room->name }}
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($asset->status == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif($asset->status == 'non-aktif')
                                        <span class="badge bg-secondary">Non-aktif</span>
                                    @elseif($asset->status == 'dalam_perbaikan')
                                        <span class="badge bg-warning">Dalam Perbaikan</span>
                                    @else
                                        <span class="badge bg-danger">Rusak</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Pemilik</th>
                                <td>{{ $asset->owner ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Pembelian</th>
                                <td>{{ $asset->purchase_date ? $asset->purchase_date->format('d M Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Nilai Beli</th>
                                <td>
                                    @if($asset->value)
                                        Rp {{ number_format($asset->value, 0, ',', '.') }}
                                        @if($asset->value > 500)
                                            <span class="badge bg-success ms-2">Aktiva</span>
                                        @else
                                            <span class="badge bg-info ms-2">Pasif</span>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Dibuat Pada</th>
                                <td>{{ $asset->created_at->format('d M Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Terakhir Diupdate</th>
                                <td>{{ $asset->updated_at->format('d M Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($asset->notes)
                <div class="mt-3">
                    <h5>Catatan</h5>
                    <p class="text-muted">{{ $asset->notes }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Status History -->
@if($asset->statusHistory->count() > 0)
<div class="row mt-3">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Riwayat Status & Lokasi ({{ $asset->statusHistory->count() }} record)</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="15%">Tanggal</th>
                                <th width="15%">Status Lama</th>
                                <th width="15%">Status Baru</th>
                                <th width="15%">Lokasi Lama</th>
                                <th width="15%">Lokasi Baru</th>
                                <th width="10%">Diubah Oleh</th>
                                <th width="10%">Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asset->statusHistory->sortByDesc('change_date') as $index => $history)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><small>{{ $history->change_date->format('d M Y H:i') }}</small></td>
                                <td>
                                    @if($history->previous_status)
                                        <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $history->previous_status)) }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ ucfirst(str_replace('_', ' ', $history->new_status)) }}</span>
                                </td>
                                <td>
                                    @if($history->previousRoom)
                                        <small>{{ $history->previousRoom->name }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($history->newRoom)
                                        <small>{{ $history->newRoom->name }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td><small>{{ $history->changed_by }}</small></td>
                                <td><small class="text-muted">{{ $history->notes ?? '-' }}</small></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
