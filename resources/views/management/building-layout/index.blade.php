@extends('layouts.app')

@section('title', 'Denah Gedung')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Denah Gedung</h4>
                </div>

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="buildingLayoutTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active"
                                id="floor1-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#floor1"
                                type="button"
                                role="tab"
                                aria-controls="floor1"
                                aria-selected="true">
                            <i class="mdi mdi-floor-plan"></i> Lantai 1
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link"
                                id="floor2-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#floor2"
                                type="button"
                                role="tab"
                                aria-controls="floor2"
                                aria-selected="false">
                            <i class="mdi mdi-floor-plan"></i> Lantai 2
                        </button>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content mt-3" id="buildingLayoutTabContent">
                    <!-- Lantai 1 Tab -->
                    <div class="tab-pane fade show active"
                         id="floor1"
                         role="tabpanel"
                         aria-labelledby="floor1-tab">
                        <div class="text-center">
                            <h5 class="mb-3">Peta Ruangan Lantai 1</h5>
                            <div class="building-layout-container">
                                <img src="{{ asset('images/PETA RUANGAN LANTAI 1.jpg') }}"
                                     alt="Denah Lantai 1"
                                     class="img-fluid rounded shadow-sm"
                                     style="max-width: 100%; height: auto;">
                            </div>
                        </div>

                        <!-- List Ruangan Lantai 1 -->
                        <div class="mt-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0"><i class="mdi mdi-door"></i> Daftar Ruangan Lantai 1</h5>
                                <div class="search-box" style="width: 300px;">
                                    <input type="text"
                                           class="form-control form-control-sm room-search"
                                           data-floor="1"
                                           placeholder="Cari ruangan..."
                                           id="searchFloor1">
                                </div>
                            </div>
                            <div class="row" id="roomListFloor1">
                                @foreach($lantai1Rooms as $room)
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="card room-card" style="cursor: pointer;" onclick="showRoomAssets({{ $room->id }}, '{{ addslashes($room->name) }}')">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1 fw-bold">{{ $room->name }}</h6>
                                                    <small class="text-muted">{{ $room->room_code }}</small>
                                                </div>
                                                <div>
                                                    <span class="badge bg-primary">
                                                        {{ $room->assets_count }}
                                                        <i class="mdi mdi-package-variant"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Lantai 2 Tab -->
                    <div class="tab-pane fade"
                         id="floor2"
                         role="tabpanel"
                         aria-labelledby="floor2-tab">
                        <div class="text-center">
                            <h5 class="mb-3">Peta Ruangan Lantai 2</h5>
                            <div class="building-layout-container">
                                <img src="{{ asset('images/PETA RUANGAN LANTAI 2.jpg') }}"
                                     alt="Denah Lantai 2"
                                     class="img-fluid rounded shadow-sm"
                                     style="max-width: 100%; height: auto;">
                            </div>
                        </div>

                        <!-- List Ruangan Lantai 2 -->
                        <div class="mt-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0"><i class="mdi mdi-door"></i> Daftar Ruangan Lantai 2</h5>
                                <div class="search-box" style="width: 300px;">
                                    <input type="text"
                                           class="form-control form-control-sm room-search"
                                           data-floor="2"
                                           placeholder="Cari ruangan..."
                                           id="searchFloor2">
                                </div>
                            </div>
                            <div class="row" id="roomListFloor2">
                                @foreach($lantai2Rooms as $room)
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="card room-card" style="cursor: pointer;" onclick="showRoomAssets({{ $room->id }}, '{{ addslashes($room->name) }}')">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1 fw-bold">{{ $room->name }}</h6>
                                                    <small class="text-muted">{{ $room->room_code }}</small>
                                                </div>
                                                <div>
                                                    <span class="badge bg-primary">
                                                        {{ $room->assets_count }}
                                                        <i class="mdi mdi-package-variant"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal untuk menampilkan asset di ruangan -->
<div class="modal fade" id="roomAssetsModal" tabindex="-1" aria-labelledby="roomAssetsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="roomAssetsModalLabel">
                    <i class="mdi mdi-package-variant"></i> Asset di <span id="modalRoomName"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="assetLoadingSpinner" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Memuat data asset...</p>
                </div>
                <div id="assetListContainer" style="display: none;">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kode Asset</th>
                                    <th>Nama Asset</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Owner</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody id="assetTableBody">
                                <!-- Will be filled by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="noAssetMessage" style="display: none;" class="text-center py-5">
                    <i class="mdi mdi-alert-circle-outline" style="font-size: 48px; color: #999;"></i>
                    <p class="text-muted mt-2">Tidak ada asset di ruangan ini</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .building-layout-container {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        display: inline-block;
        max-width: 100%;
    }

    .building-layout-container img {
        border: 2px solid #dee2e6;
        cursor: zoom-in;
        transition: transform 0.3s ease;
    }

    .building-layout-container img:hover {
        transform: scale(1.02);
    }

    .nav-tabs .nav-link {
        color: #495057;
        font-weight: 500;
    }

    .nav-tabs .nav-link.active {
        color: #0d6efd;
        font-weight: 600;
    }

    .nav-tabs .nav-link i {
        font-size: 1.1rem;
        margin-right: 5px;
    }

    .room-card {
        transition: all 0.3s ease;
        border: 1px solid #dee2e6;
    }

    .room-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border-color: #0d6efd;
    }

    .room-card h6 {
        font-size: 0.9rem;
    }

    .room-card small {
        font-size: 0.75rem;
    }

    .room-card .badge {
        font-size: 0.8rem;
    }
</style>
@endpush

@push('scripts')
<script>
    // Add click to zoom functionality for images
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('.building-layout-container img');

        images.forEach(img => {
            img.addEventListener('click', function() {
                // Open image in new tab for full view
                window.open(this.src, '_blank');
            });
        });

        // Room search functionality
        const searchFloor1 = document.getElementById('searchFloor1');
        const searchFloor2 = document.getElementById('searchFloor2');

        if (searchFloor1) {
            searchFloor1.addEventListener('keyup', function() {
                filterRooms(this.value, 'roomListFloor1');
            });
        }

        if (searchFloor2) {
            searchFloor2.addEventListener('keyup', function() {
                filterRooms(this.value, 'roomListFloor2');
            });
        }
    });

    // Filter rooms by search query
    function filterRooms(query, containerID) {
        const container = document.getElementById(containerID);
        const roomCards = container.querySelectorAll('.col-md-3');
        const searchTerm = query.toLowerCase().trim();

        let visibleCount = 0;

        roomCards.forEach(card => {
            const roomName = card.querySelector('h6').textContent.toLowerCase();
            const roomCode = card.querySelector('small').textContent.toLowerCase();

            if (roomName.includes(searchTerm) || roomCode.includes(searchTerm)) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Show "no results" message if needed
        let noResultsMsg = container.querySelector('.no-results-message');

        if (visibleCount === 0 && searchTerm !== '') {
            if (!noResultsMsg) {
                noResultsMsg = document.createElement('div');
                noResultsMsg.className = 'col-12 no-results-message text-center py-4';
                noResultsMsg.innerHTML = `
                    <i class="mdi mdi-magnify" style="font-size: 48px; color: #ccc;"></i>
                    <p class="text-muted mt-2">Tidak ditemukan ruangan yang cocok dengan pencarian</p>
                `;
                container.appendChild(noResultsMsg);
            }
            noResultsMsg.style.display = 'block';
        } else if (noResultsMsg) {
            noResultsMsg.style.display = 'none';
        }
    }

    // Function to show room assets
    function showRoomAssets(roomId, roomName) {
        // Set room name in modal
        document.getElementById('modalRoomName').textContent = roomName;

        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('roomAssetsModal'));
        modal.show();

        // Show loading spinner
        document.getElementById('assetLoadingSpinner').style.display = 'block';
        document.getElementById('assetListContainer').style.display = 'none';
        document.getElementById('noAssetMessage').style.display = 'none';

        // Fetch assets for this room
        fetch(`/api/rooms/${roomId}/assets`)
            .then(response => response.json())
            .then(data => {
                // Hide loading spinner
                document.getElementById('assetLoadingSpinner').style.display = 'none';

                if (data.assets && data.assets.length > 0) {
                    // Show asset list
                    document.getElementById('assetListContainer').style.display = 'block';

                    // Populate table
                    const tbody = document.getElementById('assetTableBody');
                    tbody.innerHTML = '';

                    data.assets.forEach(asset => {
                        const statusBadge = getStatusBadge(asset.status);
                        const formattedValue = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            minimumFractionDigits: 0
                        }).format(asset.value);

                        const row = `
                            <tr>
                                <td><strong>${asset.asset_code}</strong></td>
                                <td>${asset.name}</td>
                                <td><span class="badge bg-info">${asset.category ? asset.category.name : '-'}</span></td>
                                <td>${statusBadge}</td>
                                <td>${asset.owner}</td>
                                <td>${formattedValue}</td>
                            </tr>
                        `;
                        tbody.innerHTML += row;
                    });
                } else {
                    // Show no assets message
                    document.getElementById('noAssetMessage').style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error fetching assets:', error);
                document.getElementById('assetLoadingSpinner').style.display = 'none';
                document.getElementById('noAssetMessage').style.display = 'block';
                document.getElementById('noAssetMessage').innerHTML = `
                    <i class="mdi mdi-alert-circle-outline" style="font-size: 48px; color: #dc3545;"></i>
                    <p class="text-danger mt-2">Terjadi kesalahan saat memuat data</p>
                `;
            });
    }

    // Function to get status badge
    function getStatusBadge(status) {
        const statusMap = {
            'aktif': '<span class="badge bg-success">Aktif</span>',
            'non-aktif': '<span class="badge bg-dark">Non-Aktif</span>',
            'dalam_perbaikan': '<span class="badge bg-warning">Dalam Perbaikan</span>',
            'rusak': '<span class="badge bg-danger">Rusak</span>'
        };
        return statusMap[status] || `<span class="badge bg-dark">${status}</span>`;
    }
</script>
@endpush
