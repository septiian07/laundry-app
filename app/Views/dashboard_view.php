<?= $this->extend('templates/header'); ?>

<?= $this->section('content'); ?>

<div class="row">
  <div class="col-md-3 mb-4">
    <div class="card text-white bg-primary">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h5 class="card-title mb-0">Customers</h5>
            <p class="card-text fs-4"><?= $total_customers; ?></p>
          </div>
          <i class="fas fa-users fa-3x opacity-50"></i>
        </div>
      </div>
      <a href="<?= base_url('customers') ?>" class="card-footer text-white text-decoration-none">
        View Details <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  <div class="col-md-3 mb-4">
    <div class="card text-white bg-success">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h5 class="card-title mb-0">Services</h5>
            <p class="card-text fs-4"><?= $total_services; ?></p>
          </div>
          <i class="fas fa-tshirt fa-3x opacity-50"></i>
        </div>
      </div>
      <a href="<?= base_url('services') ?>" class="card-footer text-white text-decoration-none">
        View Details <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  <div class="col-md-3 mb-4">
    <div class="card text-white bg-info">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h5 class="card-title mb-0">Laundry Processing</h5>
            <p class="card-text fs-4"><?= $total_transactions_processing; ?></p>
          </div>
          <i class="fas fa-spinner fa-3x opacity-50"></i>
        </div>
      </div>
      <a href="<?= base_url('transactions') ?>" class="card-footer text-white text-decoration-none">
        View Details <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  <div class="col-md-3 mb-4">
    <div class="card text-white bg-warning">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h5 class="card-title mb-0">Laundry Completed</h5>
            <p class="card-text fs-4"><?= $total_transactions_completed; ?></p>
          </div>
          <i class="fas fa-check-circle fa-3x opacity-50"></i>
        </div>
      </div>
      <a href="<?= base_url('transactions?status=completed') ?>" class="card-footer text-white text-decoration-none">
        View Details <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <i class="fas fa-chart-line"></i> Today's Revenue (Paid)
      </div>
      <div class="card-body">
        <h3 class="text-success">Rp <?= number_format($todays_revenue, 0, ',', '.'); ?></h3>
      </div>
    </div>
  </div>
</div>

<div class="row mt-4">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <i class="fas fa-history"></i> 5 Recent Transactions
      </div>
      <div class="card-body">
        <?php if (!empty($recent_transactions)): ?>
          <table class="table table-sm table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Entry Date</th>
                <th>Total</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($recent_transactions as $trx): ?>
                <tr>
                  <td><a
                      href="<?= base_url('transactions/show/' . $trx['transaction_id']); ?>">TRX-<?= str_pad($trx['transaction_id'], 5, '0', STR_PAD_LEFT); ?></a>
                  </td>
                  <td><?= esc($trx['customer_name'] ?? 'N/A'); ?></td>
                  <td><?= date('d M Y H:i', strtotime($trx['entry_date'])); ?></td>
                  <td>Rp <?= number_format($trx['total_fee'], 0, ',', '.'); ?></td>
                  <td>
                    <span
                      class="badge <?= $trx['laundry_status'] == 'processing' ? 'bg-info' : ($trx['laundry_status'] == 'completed' ? 'bg-primary' : 'bg-secondary'); ?>">
                      <?= ucfirst($trx['laundry_status']); ?>
                    </span>
                    <span class="badge <?= $trx['payment_status'] == 'paid' ? 'bg-success' : 'bg-warning'; ?>">
                      <?= ucfirst($trx['payment_status']); ?>
                    </span>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
          <p class="text-center">No recent transactions today.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>