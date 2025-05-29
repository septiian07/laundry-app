<?= $this->extend('templates/header'); ?>

<?= $this->section('content'); ?>

<?php if (session()->getFlashdata('message')): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('message'); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('error'); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <span>Transaction Details - TRX-<?= str_pad($transaction['transaction_id'], 5, '0', STR_PAD_LEFT); ?></span>
    <div>
      <a href="<?= base_url('transactions/printReceipt/' . $transaction['transaction_id']); ?>"
        class="btn btn-sm btn-outline-secondary" target="_blank"><i class="fas fa-print"></i> Print Receipt</a>
      <a href="<?= base_url('transactions'); ?>" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-left"></i>
        Back</a>
    </div>
  </div>
  <div class="card-body">
    <div class="row mb-3">
      <div class="col-md-6">
        <h5>Customer Information</h5>
        <table class="table table-borderless table-sm">
          <tr>
            <th style="width: 150px;">Customer Name</th>
            <td>: <?= esc($transaction['customer_name'] ?? 'N/A'); ?></td>
          </tr>
          <tr>
            <th>Entry Date</th>
            <td>: <?= date('d M Y H:i', strtotime($transaction['entry_date'])); ?></td>
          </tr>
          <tr>
            <th>Completion Date</th>
            <td>:
              <?= $transaction['completion_date'] ? date('d M Y H:i', strtotime($transaction['completion_date'])) : '-'; ?>
            </td>
          </tr>
        </table>
      </div>
      <div class="col-md-6">
        <h5>Transaction Status</h5>
        <table class="table table-borderless table-sm">
          <tr>
            <th style="width: 150px;">Laundry Status</th>
            <td>:
              <span class="badge
                                <?php if ($transaction['laundry_status'] == 'processing')
                                  echo 'bg-info';
                                elseif ($transaction['laundry_status'] == 'completed')
                                  echo 'bg-primary';
                                elseif ($transaction['laundry_status'] == 'collected')
                                  echo 'bg-secondary'; ?>">
                <?= ucfirst(esc($transaction['laundry_status'])); ?>
              </span>
            </td>
          </tr>
          <tr>
            <th>Payment Status</th>
            <td>:
              <span class="badge <?= $transaction['payment_status'] == 'paid' ? 'bg-success' : 'bg-warning'; ?>">
                <?= ucfirst(esc($transaction['payment_status'])); ?>
              </span>
            </td>
          </tr>
          <tr>
            <th>Total Fee</th>
            <td>: <strong>Rp <?= number_format($transaction['total_fee'], 0, ',', '.'); ?></strong></td>
          </tr>
        </table>
      </div>
    </div>

    <h5>Laundry Items</h5>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>Service Name</th>
          <th>Unit Price</th>
          <th>Quantity</th>
          <th>Unit</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1;
        foreach ($transaction_items as $item): ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><?= esc($item['service_name']); ?></td>
            <td>Rp <?= number_format($item['service_price'], 0, ',', '.'); ?></td>
            <td><?= esc($item['quantity']); ?></td>
            <td><?= esc($item['service_unit']); ?></td>
            <td>Rp <?= number_format($item['subtotal'], 0, ',', '.'); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="5" class="text-end"><strong>Overall Total</strong></td>
          <td><strong>Rp <?= number_format($transaction['total_fee'], 0, ',', '.'); ?></strong></td>
        </tr>
      </tfoot>
    </table>

    <hr>
    <h5>Update Status</h5>
    <form action="<?= base_url('transactions/updateStatus/' . $transaction['transaction_id']); ?>" method="post">
      <?= csrf_field(); ?>
      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label for="laundry_status" class="form-label">Laundry Status</label>
            <select name="laundry_status" id="laundry_status" class="form-select">
              <option value="processing" <?= ($transaction['laundry_status'] == 'processing') ? 'selected' : ''; ?>>
                Processing</option>
              <option value="completed" <?= ($transaction['laundry_status'] == 'completed') ? 'selected' : ''; ?>>Completed
              </option>
              <option value="collected" <?= ($transaction['laundry_status'] == 'collected') ? 'selected' : ''; ?>>Collected
              </option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label for="payment_status" class="form-label">Payment Status</label>
            <select name="payment_status" id="payment_status" class="form-select">
              <option value="unpaid" <?= ($transaction['payment_status'] == 'unpaid') ? 'selected' : ''; ?>>Unpaid</option>
              <option value="paid" <?= ($transaction['payment_status'] == 'paid') ? 'selected' : ''; ?>>Paid</option>
            </select>
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Update Status</button>
    </form>

  </div>
</div>

<?= $this->endSection(); ?>