@extends('layouts.main')

@section('title', 'Daftar Orders')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title">Daftar Orders</h4>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#createOrderModal">
                            Tambah Order
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
                                                            <a class="dropdown-item"
                                                                href="{{ route('orders_kasir.print', $order->id) }}"
                                                                target="_blank">Cetak Struk</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                                onclick="openEditModal({{ $order->id }}, '{{ $order->code_order }}', '{{ $order->customer }}', '{{ $order->table_number }}', '{{ $order->menu_id }}', '{{ $order->qty }}', '{{ $order->note }}')">Ubah</a>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('orders_kasir.destroy', $order->id) }}"
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
            document.getElementById('editOrderForm').action = '/orders_kasir/' + id;
            var myModal = new bootstrap.Modal(document.getElementById('editOrderModal'));
            myModal.show();
        }
    </script>
@endpush
