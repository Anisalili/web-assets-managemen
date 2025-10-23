@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Profil Saya</h4>
                <p class="card-description">Informasi akun Anda</p>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Nama:</strong></label>
                            <p>{{ auth()->user()->name }}</p>
                        </div>

                        <div class="form-group">
                            <label><strong>Email:</strong></label>
                            <p>{{ auth()->user()->email }}</p>
                        </div>

                        <div class="form-group">
                            <label><strong>Role:</strong></label>
                            <div>
                                @forelse(auth()->user()->roles as $role)
                                    <span class="badge bg-primary me-1">{{ $role->name }}</span>
                                @empty
                                    <span class="text-muted">Belum memiliki role</span>
                                @endforelse
                            </div>
                        </div>

                        <div class="form-group">
                            <label><strong>Permissions:</strong></label>
                            <div>
                                @forelse(auth()->user()->getAllPermissions() as $permission)
                                    <span class="badge bg-success me-1 mb-1">{{ $permission->name }}</span>
                                @empty
                                    <span class="text-muted">Belum memiliki permission</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
