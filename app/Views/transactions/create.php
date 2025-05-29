<?= $this->extend('templates/header'); ?>

<?= $this->section('content'); ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        New Transaction Form
    </div>
    <div class="card-body">
        <form action="<?= base_url('transactions/save'); ?>" method="post" id="formTransaction">
            <?= csrf_field(); ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="customer_id" class="form-label">Customer <span class="text-danger">*</span></label>
                        <select class="form-select <?= ($validation->hasError('customer_id')) ? 'is-invalid' : ''; ?>" id="customer_id" name="customer_id">
                            <option value="">-- Select Customer --</option>
                            <?php foreach ($customers as $c) : ?> 
                                <option value="<?= $c['customer_id']; ?>" <?= (old('customer_id') == $c['customer_id']) ? 'selected' : ''; ?>>
                                    <?= esc($c['customer_name']); ?> (<?= esc($c['customer_phone']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('customer_id'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="payment_status" class="form-label">Payment Status</label>
                        <select class="form-select" id="payment_status" name="payment_status">
                            <option value="unpaid" <?= (old('payment_status') == 'unpaid') ? 'selected' : ''; ?>>Unpaid</option>
                            <option value="paid" <?= (old('payment_status') == 'paid') ? 'selected' : ''; ?>>Paid</option>
                        </select>
                    </div>
                </div>
            </div>

            <hr>
            <h5>Service Details</h5>
            <div id="service-items-container">
                <div class="row service-item mb-2">
                    <div class="col-md-5">
                        <label class="form-label">Service</label>
                        <select class="form-select service-select" name="service_ids[]" onchange="updatePrice(this)"> 
                            <option value="">-- Select Service --</option>
                            <?php foreach ($services as $s) : ?> 
                                <option value="<?= $s['service_id']; ?>" data-price="<?= $s['service_price']; ?>" data-unit="<?= $s['service_unit']; ?>">
                                    <?= esc($s['service_name']); ?> (Rp <?= number_format($s['service_price'],0,',','.'); ?>/<?= $s['service_unit']; ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Quantity</label>
                        <input type="number" step="0.1" class="form-control quantity-input" name="quantities[]" placeholder="0" oninput="updatePrice(this)">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Unit</label>
                        <input type="text" class="form-control unit-display" readonly>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Subtotal</label>
                        <input type="text" class="form-control subtotal-display" readonly placeholder="Rp 0">
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm remove-service-item" onclick="removeServiceItem(this)"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-success btn-sm mt-2" id="add-service-item"><i class="fas fa-plus"></i> Add Service</button>

            <hr>
            <div class="row mt-3">
                <div class="col-md-9 text-end">
                    <h4>Estimated Total Fee:</h4>
                </div>
                <div class="col-md-3">
                    <h4 id="estimated-total-fee" class="text-primary">Rp 0</h4>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Save Transaction</button>
            <a href="<?= base_url('transactions'); ?>" class="btn btn-secondary mt-3">Back</a>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const serviceItemsContainer = document.getElementById('service-items-container');
    const addServiceItemButton = document.getElementById('add-service-item');

    function createServiceItem() {
        const newItem = serviceItemsContainer.firstElementChild.cloneNode(true);
        newItem.querySelectorAll('input, select').forEach(input => {
            if (input.type === 'number' || input.classList.contains('subtotal-display') || input.classList.contains('unit-display')) {
                input.value = '';
                if (input.classList.contains('quantity-input')) input.placeholder = '0';
                if (input.classList.contains('subtotal-display')) input.placeholder = 'Rp 0';
            } else if (input.tagName === 'SELECT') {
                input.selectedIndex = 0;
            }
        });
        newItem.querySelector('.remove-service-item').addEventListener('click', function() {
            removeServiceItem(this);
        });
        serviceItemsContainer.appendChild(newItem);
        toggleRemoveButtonVisibility();
        updatePrice(newItem.querySelector('.service-select')); 
    }

    addServiceItemButton.addEventListener('click', createServiceItem);

    serviceItemsContainer.addEventListener('click', function(e) {
        if (e.target && (e.target.classList.contains('remove-service-item') || e.target.closest('.remove-service-item'))) {
            const button = e.target.closest('.remove-service-item');
            removeServiceItem(button);
        }
    });

    serviceItemsContainer.addEventListener('input', function(e) {
        if (e.target && (e.target.classList.contains('quantity-input') || e.target.classList.contains('service-select'))) {
            updatePrice(e.target);
        }
    });
    serviceItemsContainer.addEventListener('change', function(e) {
        if (e.target && e.target.classList.contains('service-select')) {
            updatePrice(e.target);
        }
    });

    toggleRemoveButtonVisibility();
    document.querySelectorAll('#service-items-container .service-item').forEach(item => {
        updatePrice(item.querySelector('.service-select'));
         item.querySelector('.remove-service-item').addEventListener('click', function() {
            removeServiceItem(this);
        });
    });
});

function toggleRemoveButtonVisibility() {
    const serviceItems = document.querySelectorAll('#service-items-container .service-item');
    serviceItems.forEach((item, index) => {
        const removeButton = item.querySelector('.remove-service-item');
        if (serviceItems.length === 1) {
            removeButton.style.display = 'none';
        } else {
            removeButton.style.display = 'block';
        }
    });
}

function removeServiceItem(button) {
    const item = button.closest('.service-item');
    if (document.querySelectorAll('#service-items-container .service-item').length > 1) {
        item.remove();
        calculateTotalEstimate();
        toggleRemoveButtonVisibility();
    } else {
        item.querySelectorAll('input, select').forEach(input => {
            if (input.type === 'number' || input.classList.contains('subtotal-display') || input.classList.contains('unit-display')) {
                input.value = '';
                if (input.classList.contains('quantity-input')) input.placeholder = '0';
                if (input.classList.contains('subtotal-display')) input.placeholder = 'Rp 0';
            } else if (input.tagName === 'SELECT') {
                input.selectedIndex = 0;
            }
        });
        calculateTotalEstimate();
    }
}

function updatePrice(element) {
    const item = element.closest('.service-item');
    const serviceSelect = item.querySelector('.service-select');
    const quantityInput = item.querySelector('.quantity-input');
    const subtotalDisplay = item.querySelector('.subtotal-display');
    const unitDisplay = item.querySelector('.unit-display');

    const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
    const price = parseFloat(selectedOption.dataset.price) || 0;
    const unit = selectedOption.dataset.unit || '';
    const quantity = parseFloat(quantityInput.value) || 0;

    unitDisplay.value = unit;
    const subtotal = price * quantity;
    subtotalDisplay.value = 'Rp ' + subtotal.toLocaleString('id-ID');

    calculateTotalEstimate();
}

function calculateTotalEstimate() {
    let totalEstimate = 0;
    document.querySelectorAll('#service-items-container .service-item').forEach(item => {
        const serviceSelect = item.querySelector('.service-select');
        const quantityInput = item.querySelector('.quantity-input');
        const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
        const price = parseFloat(selectedOption.dataset.price) || 0;
        const quantity = parseFloat(quantityInput.value) || 0;
        totalEstimate += price * quantity;
    });
    document.getElementById('estimated-total-fee').textContent = 'Rp ' + totalEstimate.toLocaleString('id-ID');
}
</script>
<?= $this->endSection(); ?>