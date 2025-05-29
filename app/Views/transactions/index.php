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

<a href="<?= base_url('transactions/create'); ?>" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Create
  Transaction</a>

<div class="card">
  <div class="card-header">
    Laundry Transaction List
  </div>
  <div class="card-body">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Transaction ID</th>
          <th scope="col">Customer</th>
          <th scope="col">Entry Date</th>
          <th scope="col">Completion Date</th>
          <th scope="col">Total Fee</th>
          <th scope="col">Payment Status</th>
          <th scope="col">Laundry Status</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        <?php foreach ($transactions as $t): ?>
          <tr>
            <th scope="row"><?= $i++; ?></th>
            <td>TRX-<?= str_pad($t['transaction_id'], 5, '0', STR_PAD_LEFT); ?></td>
            <td><?= esc($t['customer_name'] ?? 'N/A'); ?></td>
            <td><?= date('d M Y H:i', strtotime($t['entry_date'])); ?></td>
            <td><?= $t['completion_date'] ? date('d M Y H:i', strtotime($t['completion_date'])) : '-'; ?></td>
            <td>Rp <?= number_format($t['total_fee'], 0, ',', '.'); ?></td>
            <td>
              <span class="badge <?= $t['payment_status'] == 'paid' ? 'bg-success' : 'bg-warning'; ?>">
                <?= ucfirst($t['payment_status']); ?>
              </span>
            </td>
            <td>
              <span class="badge
                                <?php if ($t['laundry_status'] == 'processing')
                                  echo 'bg-info';
                                elseif ($t['laundry_status'] == 'completed')
                                  echo 'bg-primary';
                                elseif ($t['laundry_status'] == 'collected')
                                  echo 'bg-secondary'; ?>">
                <?= ucfirst($t['laundry_status']); ?>
              </span>
            </td>
            <td>
              <a href="<?= base_url('transactions/show/' . $t['transaction_id']); ?>" class="btn btn-sm btn-info"><i
                  class="fas fa-eye"></i> Details</a>
              <a href="<?= base_url('transactions/printReceipt/' . $t['transaction_id']); ?>"
                class="btn btn-sm btn-secondary" target="_blank"><i class="fas fa-print"></i> Receipt</a>
              <form action="<?= base_url('transactions/delete/' . $t['transaction_id']); ?>" method="post"
                class="d-inline">
                <?= csrf_field(); ?>
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-sm btn-danger"
                  onclick="return confirm('Are you sure you want to delete this transaction?')"><i
                    class="fas fa-trash"></i> Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($transactions)): ?>
          <tr>
            <td colspan="9" class="text-center">No transaction data available.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection(); ?>