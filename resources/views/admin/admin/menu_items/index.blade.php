@extends('layouts.main')

@section('title', 'Daftar Menu Items')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title">Daftar Menu Items</h4>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#createMenuItemModal">
                            Tambah Menu Item
                        </button>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-xl pt-5">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Foto</th>
                                        <th>Nama</th>
                                        <th>Deskripsi</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($menuItems as $menuItem)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if ($menuItem->photo)
                                                    <img src="{{ asset('storage/' . $menuItem->photo) }}"
                                                        alt="{{ $menuItem->name }}" width="50">
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $menuItem->name }}</td>
                                            <td>{{ Str::limit($menuItem->description, 40) }}</td>
                                            <td>{{ $menuItem->category->name }}</td>
                                            <td>Rp {{ number_format($menuItem->price, 2, ',', '.') }}</td>
                                            <td class="text-nowrap">
                                                <div class="dropdown dropup">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton-{{ $menuItem->id }}"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu"
                                                        aria-labelledby="dropdownMenuButton-{{ $menuItem->id }}">
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                                onclick="openEditModal({{ $menuItem->id }}, '{{ addslashes($menuItem->name) }}', '{{ addslashes($menuItem->description) }}', '{{ $menuItem->category_id }}', '{{ $menuItem->price }}', '{{ $menuItem->photo }}')">Ubah</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                                onclick="openViewModal({{ $menuItem->id }}, '{{ addslashes($menuItem->name) }}', '{{ addslashes($menuItem->description) }}', '{{ $menuItem->category->name }}', '{{ $menuItem->price }}', '{{ $menuItem->photo }}')">Lihat
                                                                Detail</a>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('menu_items.destroy', $menuItem->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu item ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item">Hapus</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createMenuItemModal" tabindex="-1" aria-labelledby="createMenuItemModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="createMenuItemForm" method="POST" action="{{ route('menu_items.store') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createMenuItemModalLabel">Tambah Menu Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="createPhoto" class="form-label">Foto</label>
                            <input type="file" class="form-control" id="createPhoto" name="photo" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="createName" class="form-label">Nama Menu</label>
                            <input type="text" class="form-control" id="createName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="createDescription" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="createDescription" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="createCategory" class="form-label">Kategori</label>
                            <select class="form-select" id="createCategory" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="createPrice" class="form-label">Harga (Rp)</label>
                            <input type="number" class="form-control" id="createPrice" name="price" step="0.01"
                                min="0">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editMenuItemModal" tabindex="-1" aria-labelledby="editMenuItemModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="editMenuItemForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editMenuItemModalLabel">Edit Menu Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editMenuItemId" name="id">
                        <div class="mb-3">
                            <label for="editPhoto" class="form-label">Foto</label>
                            <input type="file" class="form-control" id="editPhoto" name="photo" accept="image/*">
                            <div id="currentPhoto" class="mt-2">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editName" class="form-label">Nama Menu</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDescription" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="editDescription" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editCategory" class="form-label">Kategori</label>
                            <select class="form-select" id="editCategory" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editPrice" class="form-label">Harga (Rp)</label>
                            <input type="number" class="form-control" id="editPrice" name="price" step="0.01"
                                min="0">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
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
@endsection

@push('scripts')
    <script>
        function openEditModal(id, name, description, category_id, price, photo) {
            document.getElementById('editMenuItemForm').action = '/menu_items/' + id;

            document.getElementById('editMenuItemId').value = id;
            document.getElementById('editName').value = name;
            document.getElementById('editDescription').value = description;
            document.getElementById('editCategory').value = category_id;
            document.getElementById('editPrice').value = price;

            if (photo) {
                document.getElementById('currentPhoto').innerHTML =
                    `<img src="{{ asset('storage') }}/${photo}" alt="${name}" width="100">`;
            } else {
                document.getElementById('currentPhoto').innerHTML = `<span class="text-muted">Tidak ada foto</span>`;
            }

            var myModal = new bootstrap.Modal(document.getElementById('editMenuItemModal'));
            myModal.show();
        }
    </script>
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
    </script>
@endpush
