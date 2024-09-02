@extends('layouts.main')

@section('title', 'Daftar Gaji Karyawan')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title">Daftar Gaji Karyawan</h4>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#createSalaryModal">
                            Tambah Gaji
                        </button>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-xl">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Karyawan</th>
                                        <th>Jumlah</th>
                                        <th>Tanggal Pembayaran</th>
                                        <th>Catatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($salaries as $salary)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $salary->user->name }}</td>
                                            <td>{{ $salary->amount }}</td>
                                            <td>{{ $salary->payment_date }}</td>
                                            <td>{{ $salary->notes }}</td>
                                            <td class="text-nowrap">
                                                <div class="dropdown dropup">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton-{{ $salary->id }}"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu"
                                                        aria-labelledby="dropdownMenuButton-{{ $salary->id }}">
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                                onclick="openEditModal({{ $salary->id }}, '{{ $salary->user_id }}', '{{ $salary->amount }}', '{{ $salary->payment_date }}', '{{ $salary->notes }}')">Ubah</a>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('salaries.destroy', $salary->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus gaji ini?')">
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
    <div class="modal fade" id="createSalaryModal" tabindex="-1" aria-labelledby="createSalaryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createSalaryModalLabel">Tambah Gaji</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createSalaryForm" method="POST" action="{{ route('salaries.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="createUser" class="form-label">Karyawan</label>
                            <select class="form-control" id="createUser" name="user_id" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="createAmount" class="form-label">Jumlah Gaji</label>
                            <input type="number" step="0.01" class="form-control" id="createAmount" name="amount"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="createPaymentDate" class="form-label">Tanggal Pembayaran</label>
                            <input type="date" class="form-control" id="createPaymentDate" name="payment_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="createNotes" class="form-label">Catatan</label>
                            <textarea class="form-control" id="createNotes" name="notes"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editSalaryModal" tabindex="-1" aria-labelledby="editSalaryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSalaryModalLabel">Edit Gaji</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editSalaryForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editSalaryId" name="id">
                        <div class="mb-3">
                            <label for="editUser" class="form-label">Karyawan</label>
                            <select class="form-control" id="editUser" name="user_id" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editAmount" class="form-label">Jumlah Gaji</label>
                            <input type="number" step="0.01" class="form-control" id="editAmount" name="amount"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editPaymentDate" class="form-label">Tanggal Pembayaran</label>
                            <input type="date" class="form-control" id="editPaymentDate" name="payment_date"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editNotes" class="form-label">Catatan</label>
                            <textarea class="form-control" id="editNotes" name="notes"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    <script>
        function openEditModal(id, userId, amount, paymentDate, notes) {
            document.getElementById('editSalaryId').value = id;
            document.getElementById('editUser').value = userId;
            document.getElementById('editAmount').value = amount;
            document.getElementById('editPaymentDate').value = paymentDate;
            document.getElementById('editNotes').value = notes;

            document.getElementById('editSalaryForm').action = '/salaries/' + id;
            var editSalaryModal = new bootstrap.Modal(document.getElementById('editSalaryModal'));
            editSalaryModal.show();
        }
    </script>
@endpush
