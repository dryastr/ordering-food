@extends('layouts.main')

@section('title', 'Daftar Orders')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title">Daftar Orders</h4>
                        <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#createOrderModal">
                                Tambah Order
                            </button>
                            <div class="mx-2"></div>
                            <div class="d-flex align-items-center">
                                <a href="{{ route('printOrders', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
                                    class="btn btn-danger">Print PDF</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form id="filterForm" method="GET" action="{{ route('orders.index') }}">
                            <div class="d-flex align-items-center justify-content-end mb-3">
                                <div class="me-2">
                                    <label for="startDate" class="form-label">Tanggal Mulai</label>
                                    <input type="date" id="startDate" name="start_date" class="form-control"
                                        value="{{ request('start_date') }}">
                                </div>
                                <div class="me-2">
                                    <label for="endDate" class="form-label">Tanggal Akhir</label>
                                    <input type="date" id="endDate" name="end_date" class="form-control"
                                        value="{{ request('end_date') }}">
                                </div>
                                <button type="submit" class="btn btn-primary" style="margin-top: 30px;">Filter</button>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-xl">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Order</th>
                                        <th>Customer</th>
                                        <th>Nomor Meja</th>
                                        <th>Menu</th>
                                        <th>Qty</th>
                                        <th>Status</th>
                                        <th>Total Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $order->code_order }}</td>
                                            <td>{{ $order->customer }}</td>
                                            <td>{{ $order->table_number }}</td>
                                            <td>{{ $order->menuItem->name }}</td>
                                            <td>{{ $order->qty }}</td>
                                            <td>
                                                @if ($order->status == 'pending')
                                                    <span class="badge bg-danger">Pending</span>
                                                @elseif ($order->status == 'proses')
                                                    <span class="badge bg-warning">Proses</span>
                                                @else
                                                    <span class="badge bg-success">Selesai</span>
                                                @endif
                                            </td>
                                            <td>Rp {{ number_format($order->qty * $order->menuItem->price, 2) }}</td>
                                            <td class="text-nowrap">
                                                <div class="dropdown dropup">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton-{{ $order->id }}"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu"
                                                        aria-labelledby="dropdownMenuButton-{{ $order->id }}">
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                                onclick="openEditModal({{ $order->id }}, '{{ $order->code_order }}', '{{ $order->customer }}', '{{ $order->table_number }}', '{{ $order->menu_id }}', '{{ $order->qty }}', '{{ $order->note }}')">Ubah</a>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('orders.destroy', $order->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus order ini?')">
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

    @include('admin.admin.orders.partials.create')
    @include('admin.admin.orders.partials.edit')


@endsection

@push('scripts')
    <script>
        function openEditModal(id, codeOrder, customer, tableNumber, menuId, qty, note) {
            document.getElementById('editCodeOrder').value = codeOrder;
            document.getElementById('editCustomer').value = customer;
            document.getElementById('editTableNumber').value = tableNumber;
            document.getElementById('editMenuId').value = menuId;
            document.getElementById('editQty').value = qty;
            document.getElementById('editNote').value = note;
            document.getElementById('editOrderForm').action = '/orders/' + id;
            var myModal = new bootstrap.Modal(document.getElementById('editOrderModal'));
            myModal.show();
        }
    </script>
@endpush
