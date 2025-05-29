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

<a href="<?= base_url('services/create'); ?>" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Add Service</a>

<div class="card">
  <div class="card-header">
    Service List
  </div>
  <div class="card-body">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Service Name</th>
          <th scope="col">Price</th>
          <th scope="col">Unit</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        <?php foreach ($services as $s): ?>
          <tr>
            <th scope="row"><?= $i++; ?></th>
            <td><?= esc($s['service_name']); ?></td>
            <td>Rp <?= number_format($s['service_price'], 0, ',', '.'); ?></td>
            <td><?= esc($s['service_unit']); ?></td>
            <td>
              <a href="<?= base_url('services/edit/' . $s['service_id']); ?>" class="btn btn-sm btn-warning"><i
                  class="fas fa-edit"></i> Edit</a>
              <form action="<?= base_url('services/delete/' . $s['service_id']); ?>" method="post" class="d-inline">
                <?= csrf_field(); ?>
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-sm btn-danger"
                  onclick="return confirm('Are you sure you want to delete this service?')"><i class="fas fa-trash"></i>
                  Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($services)): ?>
          <tr>
            <td colspan="5" class="text-center">No service data available.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection(); ?>