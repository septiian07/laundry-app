<?= $this->extend('templates/header'); ?>

<?= $this->section('content'); ?>

<div class="card">
  <div class="card-header">
    Add New Service Form
  </div>
  <div class="card-body">
    <form action="<?= base_url('services/save'); ?>" method="post">
      <?= csrf_field(); ?>
      <div class="mb-3">
        <label for="service_name" class="form-label">Service Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control <?= ($validation->hasError('service_name')) ? 'is-invalid' : ''; ?>"
          id="service_name" name="service_name" value="<?= old('service_name'); ?>" autofocus>
        <div class="invalid-feedback">
          <?= $validation->getError('service_name'); ?>
        </div>
      </div>
      <div class="mb-3">
        <label for="service_price" class="form-label">Price <span class="text-danger">*</span></label>
        <input type="number" step="0.01"
          class="form-control <?= ($validation->hasError('service_price')) ? 'is-invalid' : ''; ?>" id="service_price"
          name="service_price" value="<?= old('service_price'); ?>">
        <div class="invalid-feedback">
          <?= $validation->getError('service_price'); ?>
        </div>
      </div>
      <div class="mb-3">
        <label for="service_unit" class="form-label">Unit (Kg/Pcs/etc) <span class="text-danger">*</span></label>
        <input type="text" class="form-control <?= ($validation->hasError('service_unit')) ? 'is-invalid' : ''; ?>"
          id="service_unit" name="service_unit" value="<?= old('service_unit'); ?>">
        <div class="invalid-feedback">
          <?= $validation->getError('service_unit'); ?>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Save</button>
      <a href="<?= base_url('services'); ?>" class="btn btn-secondary">Back</a>
    </form>
  </div>
</div>

<?= $this->endSection(); ?>