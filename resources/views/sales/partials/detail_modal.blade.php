<div class="modal fade" id="saleDetailModal" tabindex="-1" aria-labelledby="saleDetailModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <input type="hidden" name="sale_id" id="modalSaleId">
                <h5 class="modal-title">SI Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Products</h6>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Rate</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody id="sale-detail-body">
                            <tr>
                                <td colspan="4" class="text-center">No details found</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
                <h6>Payments</h6>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Account</th>
                                <th>Payment Term</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sale-receipt-body">
                            <tr>
                                <td colspan="4" class="text-center">No payments found</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
