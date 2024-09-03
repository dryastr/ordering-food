@extends('layouts.main')

@section('title', 'Daftar Menu Items')

@section('content')
    <div class="row">
        @foreach ($menuItems as $menuItem)
            <div class="col-md-4">
                <div class="card mb-4">
                    @if ($menuItem->photo)
                        <img src="{{ asset('storage/' . $menuItem->photo) }}" class="card-img-top" alt="{{ $menuItem->name }}"
                            style="height: 200px; object-fit: cover;">
                    @else
                        <img src="https://via.placeholder.com/200x150" class="card-img-top" alt="Placeholder"
                            style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $menuItem->name }}</h5>
                        <p class="card-text">{{ Str::limit($menuItem->description, 80) }}</p>
                        <p class="card-text"><strong>Kategori:</strong> {{ $menuItem->category->name }}</p>
                        <p class="card-text"><strong>Harga:</strong> Rp {{ number_format($menuItem->price, 2, ',', '.') }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                    onclick="openViewModal({{ $menuItem->id }}, '{{ addslashes($menuItem->name) }}', '{{ addslashes($menuItem->description) }}', '{{ $menuItem->category->name }}', '{{ $menuItem->price }}', '{{ $menuItem->photo }}')">Lihat
                                    Detail</button>
                                <button type="button" class="btn btn-sm btn-primary"
                                    onclick="openOrderModal({{ $menuItem->id }}, '{{ addslashes($menuItem->name) }}', '{{ $menuItem->price }}')">Pesan
                                    Sekarang</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- View Details Modal -->
    <div class="modal fade" id="viewMenuItemModal" tabindex="-1" aria-labelledby="viewMenuItemModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewMenuItemModalLabel">Detail Menu Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="viewName" class="form-label">Nama Menu</label>
                        <p id="viewName"></p>
                    </div>
                    <div class="mb-3">
                        <label for="viewDescription" class="form-label">Deskripsi</label>
                        <p id="viewDescription"></p>
                    </div>
                    <div class="mb-3">
                        <label for="viewCategory" class="form-label">Kategori</label>
                        <p id="viewCategory"></p>
                    </div>
                    <div class="mb-3">
                        <label for="viewPrice" class="form-label">Harga</label>
                        <p id="viewPrice"></p>
                    </div>
                    <div class="mb-3">
                        <label for="viewPhoto" class="form-label">Foto</label>
                        <img id="viewPhoto" src="" alt="Menu Item Photo" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Modal -->
    <div class="modal fade" id="orderMenuItemModal" tabindex="-1" aria-labelledby="orderMenuItemModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('orders-user.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderMenuItemModalLabel">Pesan Menu Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="menu_id" id="orderMenuId">
                        <div class="mb-3">
                            <label for="orderName" class="form-label">Nama Menu</label>
                            <p id="orderName"></p>
                        </div>
                        <div class="mb-3">
                            <label for="orderQty" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="orderQty" name="qty" min="1"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="orderNote" class="form-label">Catatan</label>
                            <textarea class="form-control" id="orderNote" name="note"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Pesan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openViewModal(id, name, description, category, price, photo) {
            document.getElementById('viewName').innerText = name;
            document.getElementById('viewDescription').innerText = description;
            document.getElementById('viewCategory').innerText = category;
            document.getElementById('viewPrice').innerText = 'Rp ' + parseFloat(price).toFixed(2);
            document.getElementById('viewPhoto').src = photo ? '/storage/' + photo :
                '/path/to/default/photo.png';

            var viewModal = new bootstrap.Modal(document.getElementById('viewMenuItemModal'));
            viewModal.show();
        }

        function openOrderModal(id, name, price) {
            document.getElementById('orderMenuId').value = id;
            document.getElementById('orderName').innerText = name;
            var orderModal = new bootstrap.Modal(document.getElementById('orderMenuItemModal'));
            orderModal.show();
        }
    </script>
@endpush
