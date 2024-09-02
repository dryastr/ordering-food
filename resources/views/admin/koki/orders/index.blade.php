@extends('layouts.main')

@section('title', 'Daftar Pesanan')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title">Daftar Pesanan</h4>
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
                                                            <form
                                                                action="{{ route('list-orders.updateStatus', $order->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="status" value="proses">
                                                                <button type="submit" class="dropdown-item">Proses</button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form
                                                                action="{{ route('list-orders.updateStatus', $order->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="status" value="selesai">
                                                                <button type="submit"
                                                                    class="dropdown-item">Selesai</button>
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


@endsection

@push('scripts')
@endpush
