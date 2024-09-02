@extends('layouts.main')

@section('title', 'Daftar Pengguna')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title">Daftar Pengguna</h4>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createUserModal">
                            Tambah Pengguna
                        </button>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <!-- Tabs for user roles -->
                        <ul class="nav nav-tabs" id="userRoleTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="kasir-tab" data-bs-toggle="tab" href="#kasir" role="tab"
                                    aria-controls="kasir" aria-selected="true">Kasir</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pelayan-tab" data-bs-toggle="tab" href="#pelayan" role="tab"
                                    aria-controls="pelayan" aria-selected="false">Pelayan</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="koki-tab" data-bs-toggle="tab" href="#koki" role="tab"
                                    aria-controls="koki" aria-selected="false">Koki</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-3" id="userRoleTabsContent">
                            <!-- Kasir Tab -->
                            <div class="tab-pane fade show active" id="kasir" role="tabpanel"
                                aria-labelledby="kasir-tab">
                                <div class="table-responsive">
                                    <table class="table table-xl">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>No HP</th>
                                                <th>Alamat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users->where('role.name', 'kasir') as $user)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->no_hp }}</td>
                                                    <td>{{ $user->address }}</td>
                                                    <td class="text-nowrap">
                                                        <div class="dropdown dropup">
                                                            <button class="btn btn-sm btn-secondary dropdown-toggle"
                                                                type="button" id="dropdownMenuButton-{{ $user->id }}"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="bi bi-three-dots-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu"
                                                                aria-labelledby="dropdownMenuButton-{{ $user->id }}">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                                        onclick="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->no_hp }}', '{{ $user->address }}', '{{ $user->role_id }}')">Ubah</a>
                                                                </li>
                                                                <li>
                                                                    <form action="{{ route('users.destroy', $user->id) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="dropdown-item">Hapus</button>
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

                            <!-- Pelayan Tab -->
                            <div class="tab-pane fade" id="pelayan" role="tabpanel" aria-labelledby="pelayan-tab">
                                <div class="table-responsive">
                                    <table class="table table-xl">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>No HP</th>
                                                <th>Alamat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users->where('role.name', 'pelayan') as $user)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->no_hp }}</td>
                                                    <td>{{ $user->address }}</td>
                                                    <td class="text-nowrap">
                                                        <div class="dropdown dropup">
                                                            <button class="btn btn-sm btn-secondary dropdown-toggle"
                                                                type="button" id="dropdownMenuButton-{{ $user->id }}"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="bi bi-three-dots-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu"
                                                                aria-labelledby="dropdownMenuButton-{{ $user->id }}">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                                        onclick="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->no_hp }}', '{{ $user->address }}', '{{ $user->role_id }}')">Ubah</a>
                                                                </li>
                                                                <li>
                                                                    <form action="{{ route('users.destroy', $user->id) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="dropdown-item">Hapus</button>
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

                            <!-- Koki Tab -->
                            <div class="tab-pane fade" id="koki" role="tabpanel" aria-labelledby="koki-tab">
                                <div class="table-responsive">
                                    <table class="table table-xl">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>No HP</th>
                                                <th>Alamat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users->where('role.name', 'koki') as $user)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->no_hp }}</td>
                                                    <td>{{ $user->address }}</td>
                                                    <td class="text-nowrap">
                                                        <div class="dropdown dropup">
                                                            <button class="btn btn-sm btn-secondary dropdown-toggle"
                                                                type="button"
                                                                id="dropdownMenuButton-{{ $user->id }}"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="bi bi-three-dots-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu"
                                                                aria-labelledby="dropdownMenuButton-{{ $user->id }}">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                                        onclick="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->no_hp }}', '{{ $user->address }}', '{{ $user->role_id }}')">Ubah</a>
                                                                </li>
                                                                <li>
                                                                    <form action="{{ route('users.destroy', $user->id) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="dropdown-item">Hapus</button>
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
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Tambah Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createUserForm" method="POST" action="{{ route('users.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="createName" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="createName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="createEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="createEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="createPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="createPassword" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="createNoHp" class="form-label">No HP</label>
                            <input type="text" class="form-control" id="createNoHp" name="no_hp">
                        </div>
                        <div class="mb-3">
                            <label for="createAddress" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="createAddress" name="address">
                        </div>
                        <div class="mb-3">
                            <label for="createRole" class="form-label">Role</label>
                            <select class="form-select" id="createRole" name="role_id" required>
                                <option value="" selected disabled>Pilih Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editUserId" name="id">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="editPassword" name="password">
                            <small class="form-text text-muted">*Kosongkan jika tidak ingin merubahnya</small>
                        </div>
                        <div class="mb-3">
                            <label for="editNoHp" class="form-label">No HP</label>
                            <input type="text" class="form-control" id="editNoHp" name="no_hp">
                        </div>
                        <div class="mb-3">
                            <label for="editAddress" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="editAddress" name="address">
                        </div>
                        <div class="mb-3">
                            <label for="editRole" class="form-label">Role</label>
                            <select class="form-select" id="editRole" name="role_id" required>
                                <option value="">Pilih Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    <script>
        function openEditModal(id, name, email, no_hp, address, role_id) {
            document.getElementById('editUserId').value = id;
            document.getElementById('editName').value = name;
            document.getElementById('editEmail').value = email;
            document.getElementById('editNoHp').value = no_hp;
            document.getElementById('editAddress').value = address;
            document.getElementById('editRole').value = role_id;

            // Set the form action to include the user ID
            document.getElementById('editUserForm').action = "{{ url('/users') }}/" + id;

            // Show the modal
            var myModal = new bootstrap.Modal(document.getElementById('editUserModal'));
            myModal.show();
        }
    </script>
@endpush
