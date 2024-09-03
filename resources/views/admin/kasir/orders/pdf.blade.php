<!DOCTYPE html>
<html>

<head>
    <title>Print Orders</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Add your custom styles here */
        @media print {

            /* Styles specific to printing */
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h1 class="mb-4">Orders Report</h1>
        <table class="table table-bordered table-striped table-sm">
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
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->qty * $order->menuItem->price }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7" class="text-right font-weight-bold">Total Harga</td>
                    <td>{{ $totalPrice }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <script>
        window.onload = function() {
            window.print();
            window.onafterprint = function() {
                window.location.href = '/orders';
            };
        }
    </script>
</body>

</html>
