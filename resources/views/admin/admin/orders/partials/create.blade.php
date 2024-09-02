<!-- Create Modal -->
<div class="modal fade" id="createOrderModal" tabindex="-1" aria-labelledby="createOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createOrderModalLabel">Tambah Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('orders.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="code_order" class="form-label">Kode Order</label>
                        <input type="text" class="form-control" id="code_order" name="code_order"
                            value="{{ $codeOrder }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="customer" class="form-label">Customer</label>
                        <input type="text" class="form-control" id="customer" name="customer" required>
                    </div>
                    <div class="mb-3">
                        <label for="table_number" class="form-label">Nomor Meja</label>
                        <input type="text" class="form-control" id="table_number" name="table_number">
                    </div>
                    <div class="mb-3">
                        <label for="menu_id" class="form-label">Menu</label>
                        <select class="form-select" id="menu_id" name="menu_id" required>
                            <option value="" selected disabled>Pilih Menu</option>
                            @foreach ($menuItems as $menuItem)
                                <option value="{{ $menuItem->id }}">{{ $menuItem->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="qty" class="form-label">Qty</label>
                        <input type="number" class="form-control" id="qty" name="qty" min="1"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Catatan</label>
                        <textarea class="form-control" id="note" name="note"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
