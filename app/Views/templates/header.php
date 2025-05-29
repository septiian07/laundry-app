<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= esc($title ?? 'Laundry App'); ?> | Laundry App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body {
      display: flex;
      min-height: 100vh;
      flex-direction: column;
    }

    .main-content {
      flex: 1;
      display: flex;
    }

    .sidebar {
      width: 250px;
      background-color: #f8f9fa;
      padding: 15px;
      height: 100vh;
      position: sticky;
      top: 0;
    }

    .content {
      flex: 1;
      padding: 20px;
      overflow-y: auto;
    }

    .sidebar .nav-link {
      color: #333;
    }

    .sidebar .nav-link.active {
      font-weight: bold;
      color: #0d6efd;
    }
  </style>
</head>

<body>

  <div class="main-content">
    <?= $this->include('templates/sidebar'); ?>
    <div class="content">
      <div class="container-fluid">
        <?php if (isset($title)): ?>
          <h1 class="mb-4"><?= esc($title); ?></h1>
        <?php endif; ?>

        <?= $this->renderSection('content'); ?>
      </div>
    </div>
  </div> <?= $this->include('templates/footer'); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script>
    setTimeout(function () {
      let alert = document.querySelector('.alert-dismissible');
      if (alert) {
        new bootstrap.Alert(alert).close();
      }
    }, 5000);
  </script>
</body>

</html>