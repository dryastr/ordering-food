<!-- Edit Modal -->
<div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOrderModalLabel">Edit Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editOrderForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="editCodeOrder" class="form-label">Kode Order</label>
                        <input type="text" class="form-control" id="editCodeOrder" name="code_order" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="editCustomer" class="form-label">Customer</label>
                        <input type="text" class="form-control" id="editCustomer" name="customer" required>
                    </div>
                    <div class="mb-3">
                        <label for="editTableNumber" class="form-label">Nomor Meja</label>
                        <input type="text" class="form-control" id="editTableNumber" name="table_number">
                    </div>
                    <div class="mb-3">
                        <label for="editMenuId" class="form-label">Menu</label>
                        <select class="form-select" id="editMenuId" name="menu_id" required>
                            @foreach ($menuItems as $menuItem)
                                <option value="{{ $menuItem->id }}">{{ $menuItem->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editQty" class="form-label">Qty</label>
                        <input type="number" class="form-control" id="editQty" name="qty" min="1"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="editNote" class="form-label">Catatan</label>
                        <textarea class="form-control" id="editNote" name="note"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
