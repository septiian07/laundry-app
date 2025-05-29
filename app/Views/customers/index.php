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


<a href="<?= base_url('customers/create'); ?>" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Add Customer</a>

<div class="card">
  <div class="card-header">
    Customer List
  </div>
  <div class="card-body">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Customer Name</th>
          <th scope="col">Address</th>
          <th scope="col">Phone</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        <?php foreach ($customers as $c): ?>
          <tr>
            <th scope="row"><?= $i++; ?></th>
            <td><?= esc($c['customer_name']); ?></td>
            <td><?= esc($c['customer_address']); ?></td>
            <td><?= esc($c['customer_phone']); ?></td>
            <td>
              <a href="<?= base_url('customers/edit/' . $c['customer_id']); ?>" class="btn btn-sm btn-warning"><i
                  class="fas fa-edit"></i> Edit</a>
              <form action="<?= base_url('customers/delete/' . $c['customer_id']); ?>" method="post" class="d-inline">
                <?= csrf_field(); ?>
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-sm btn-danger"
                  onclick="return confirm('Are you sure you want to delete this customer?')"><i class="fas fa-trash"></i>
                  Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($customers)): ?>
          <tr>
            <td colspan="5" class="text-center">No customer data available.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection(); ?>