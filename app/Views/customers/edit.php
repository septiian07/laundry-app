<?= $this->extend('templates/header'); ?>

<?= $this->section('content'); ?>

<div class="card">
  <div class="card-header">
    Edit Customer Form
  </div>
  <div class="card-body">
    <form action="<?= base_url('customers/update/' . $customer['customer_id']); ?>" method="post">
      <?= csrf_field(); ?>
      <input type="hidden" name="_method" value="PUT">
      <div class="mb-3">
        <label for="customer_name" class="form-label">Customer Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control <?= ($validation->hasError('customer_name')) ? 'is-invalid' : ''; ?>"
          id="customer_name" name="customer_name" value="<?= old('customer_name', $customer['customer_name']); ?>"
          autofocus>
        <div class="invalid-feedback">
          <?= $validation->getError('customer_name'); ?>
        </div>
      </div>
      <div class="mb-3">
        <label for="customer_address" class="form-label">Address</label>
        <textarea class="form-control" id="customer_address" name="customer_address"
          rows="3"><?= old('customer_address', $customer['customer_address']); ?></textarea>
      </div>
      <div class="mb-3">
        <label for="customer_phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
        <input type="text" class="form-control <?= ($validation->hasError('customer_phone')) ? 'is-invalid' : ''; ?>"
          id="customer_phone" name="customer_phone" value="<?= old('customer_phone', $customer['customer_phone']); ?>">
        <div class="invalid-feedback">
          <?= $validation->getError('customer_phone'); ?>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
      <a href="<?= base_url('customers'); ?>" class="btn btn-secondary">Back</a>
    </form>
  </div>
</div>

<?= $this->endSection(); ?>