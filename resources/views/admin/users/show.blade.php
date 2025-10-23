@extends('layouts.app')

@section('title', 'Detail Pengguna')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Detail Pengguna</h4>
                    <div>
                        @if(auth()->user()->hasPermission('edit-users'))
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">
                            <i class="mdi mdi-pencil"></i> Edit
                        </a>
                        @endif
                        <a href="{{ route('users.index') }}" class="btn btn-sm btn-light">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td width="200"><strong>ID</strong></td>
                                    <td>{{ $user->id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nama</strong></td>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email</strong></td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Role</strong></td>
                                    <td>
                                        @forelse($user->roles as $role)
                                            <span class="badge bg-primary me-1">{{ $role->name }}</span>
                                        @empty
                                            <span class="text-muted">Belum memiliki role</span>
                                        @endforelse
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Permissions</strong></td>
                                    <td>
                                        @php
                                            $permissions = $user->getAllPermissions();
                                        @endphp
                                        @forelse($permissions as $permission)
                                            <span class="badge bg-success me-1 mb-1">{{ $permission->name }}</span>
                                        @empty
                                            <span class="text-muted">Belum memiliki permission</span>
                                        @endforelse
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Dibuat</strong></td>
                                    <td>{{ $user->created_at->format('d F Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Terakhir Diupdate</strong></td>
                                    <td>{{ $user->updated_at->format('d F Y, H:i') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                @if(auth()->user()->hasPermission('delete-users') && $user->id !== auth()->id())
                <hr>
                <div class="mt-3">
                    <h5 class="text-danger">Danger Zone</h5>
                    <p class="text-muted">Tindakan ini tidak dapat dibatalkan</p>
                    <form action="{{ route('users.destroy', $user) }}"
                          method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="mdi mdi-delete"></i> Hapus User
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
