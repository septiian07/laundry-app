<nav class="sidebar">
  <h4 class="mb-3">LaundryApp</h4>
  <ul class="nav flex-column">
    <li class="nav-item">
      <a class="nav-link <?= (uri_string() == 'dashboard' || uri_string() == '') ? 'active' : ''; ?>"
        href="<?= base_url('dashboard'); ?>">
        <i class="fas fa-tachometer-alt"></i> Dashboard
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?= (strpos(uri_string(), 'customers') === 0) ? 'active' : ''; ?>"
        href="<?= base_url('customers'); ?>">
        <i class="fas fa-users"></i> Customers
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?= (strpos(uri_string(), 'services') === 0) ? 'active' : ''; ?>"
        href="<?= base_url('services'); ?>">
        <i class="fas fa-tshirt"></i> Services
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?= (strpos(uri_string(), 'transactions') === 0) ? 'active' : ''; ?>"
        href="<?= base_url('transactions'); ?>">
        <i class="fas fa-cash-register"></i> Transactions
      </a>
    </li>
  </ul>
</nav>