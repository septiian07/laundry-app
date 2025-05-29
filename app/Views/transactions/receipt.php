<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?= esc($title); ?> - TRX-<?= str_pad($transaction['transaction_id'], 5, '0', STR_PAD_LEFT); ?></title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 10px;
      font-size: 12px;
    }

    .container {
      width: 300px;
      margin: auto;
    }

    .header {
      text-align: center;
      margin-bottom: 10px;
    }

    .header h3,
    .header p {
      margin: 0;
    }

    .transaction-details,
    .item-details {
      margin-bottom: 10px;
    }

    .transaction-details table,
    .item-details table {
      width: 100%;
      border-collapse: collapse;
    }

    .transaction-details th,
    .transaction-details td,
    .item-details th,
    .item-details td {
      padding: 3px 0;
    }

    .item-details th,
    .item-details td {
      border-bottom: 1px dashed #ccc;
    }

    .item-details thead th {
      border-bottom: 1px solid #000;
      text-align: left;
    }

    .text-right {
      text-align: right;
    }

    .total {
      font-weight: bold;
    }

    .footer {
      text-align: center;
      margin-top: 15px;
      font-size: 10px;
    }

    hr.dashed {
      border-top: 1px dashed #000;
      margin: 5px 0;
    }

    @media print {
      body {
        margin: 0;
        padding: 0;
      }

      .container {
        width: 100%;
        margin: 0;
      }

      .btn-print {
        display: none;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h3><?= esc($laundry_name); ?></h3>
      <p><?= esc($laundry_address); ?></p>
      <p>Phone: <?= esc($laundry_phone); ?></p>
      <hr class="dashed">
      <p><strong>TRANSACTION RECEIPT</strong></p>
    </div>

    <div class="transaction-details">
      <table>
        <tr>
          <td>Transaction No.</td>
          <td class="text-right">: TRX-<?= str_pad($transaction['transaction_id'], 5, '0', STR_PAD_LEFT); ?></td>
        </tr>
        <tr>
          <td>Entry Date</td>
          <td class="text-right">: <?= date('d/m/Y H:i', strtotime($transaction['entry_date'])); ?></td>
        </tr>
        <?php if ($transaction['completion_date']): ?>
          <tr>
            <td>Completion Date</td>
            <td class="text-right">: <?= date('d/m/Y H:i', strtotime($transaction['completion_date'])); ?></td>
          </tr>
        <?php endif; ?>
        <tr>
          <td>Customer</td>
          <td class="text-right">: <?= esc($transaction['customer_name'] ?? 'General'); ?></td>
        </tr>
      </table>
    </div>
    <hr class="dashed">

    <div class="item-details">
      <table>
        <thead>
          <tr>
            <th>Service</th>
            <th class="text-right">Qty</th>
            <th class="text-right">Price</th>
            <th class="text-right">Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($transaction_items as $item): ?>
            <tr>
              <td><?= esc($item['service_name']); ?></td>
              <td class="text-right"><?= esc($item['quantity']); ?>   <?= esc($item['service_unit']); ?></td>
              <td class="text-right"><?= number_format($item['service_price'], 0, ',', '.'); ?></td>
              <td class="text-right"><?= number_format($item['subtotal'], 0, ',', '.'); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <hr class="dashed">

    <div class="transaction-details total">
      <table>
        <tr>
          <td><strong>TOTAL PAYMENT</strong></td>
          <td class="text-right"><strong>Rp <?= number_format($transaction['total_fee'], 0, ',', '.'); ?></strong></td>
        </tr>
        <tr>
          <td>Payment Status</td>
          <td class="text-right"><?= ucfirst(esc($transaction['payment_status'])); ?></td>
        </tr>
      </table>
    </div>
    <hr class="dashed">

    <div class="footer">
      <p>Thank you for your visit.</p>
      <p>--- Fast and Clean Laundry Service ---</p>
    </div>

    <button class="btn-print" onclick="window.print()"
      style="margin-top: 20px; width: 100%; padding: 10px; background-color: #4CAF50; color: white; border: none; cursor: pointer;">Print
      Receipt</button>
  </div>
</body>

</html>