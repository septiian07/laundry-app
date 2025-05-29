<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\CustomerModel;
use App\Models\ServiceModel;
use App\Models\TransactionDetailModel;

class Transactions extends BaseController
{
  protected $transactionModel;
  protected $customerModel;
  protected $serviceModel;
  protected $transactionDetailModel;

  public function __construct()
  {
    $this->transactionModel = new TransactionModel();
    $this->customerModel = new CustomerModel();
    $this->serviceModel = new ServiceModel();
    $this->transactionDetailModel = new TransactionDetailModel();
  }

  public function index()
  {
    $data = [
      'title' => 'Transaction Data',
      'transactions' => $this->transactionModel->getTransactionsWithCustomer()
    ];
    return view('transactions/index', $data);
  }

  public function create()
  {
    $data = [
      'title' => 'Create New Transaction',
      'customers' => $this->customerModel->findAll(),
      'services' => $this->serviceModel->findAll(),
      'validation' => \Config\Services::validation()
    ];
    return view('transactions/create', $data);
  }

  public function save()
  {
    if (
      !$this->validate([
        'customer_id' => 'required',
        'service_ids' => 'required',
        'quantities' => 'required'
      ])
    ) {
      return redirect()->to('/transactions/create')->withInput();
    }

    $db = \Config\Database::connect();
    $db->transStart();

    $transactionId = $this->transactionModel->insert([
      'customer_id' => $this->request->getVar('customer_id'),
      'entry_date' => date('Y-m-d H:i:s'),
      'payment_status' => $this->request->getVar('payment_status') ?? 'unpaid',
      'laundry_status' => 'processing',
      'total_fee' => 0,
    ], true);

    $overallTotalFee = 0;
    $serviceIds = $this->request->getVar('service_ids');
    $quantities = $this->request->getVar('quantities');

    if (is_array($serviceIds) && is_array($quantities) && count($serviceIds) === count($quantities)) {
      for ($i = 0; $i < count($serviceIds); $i++) {
        $serviceId = $serviceIds[$i];
        $quantity = $quantities[$i];

        if (empty($serviceId) || empty($quantity) || $quantity <= 0) {
          continue;
        }

        $serviceData = $this->serviceModel->find($serviceId);
        if ($serviceData) {
          $subtotal = $serviceData['service_price'] * $quantity;
          $this->transactionDetailModel->insert([
            'transaction_id' => $transactionId,
            'service_id' => $serviceId,
            'quantity' => $quantity,
            'subtotal' => $subtotal
          ]);
          $overallTotalFee += $subtotal;
        }
      }
    }

    $this->transactionModel->update($transactionId, ['total_fee' => $overallTotalFee]);

    $db->transComplete();

    if ($db->transStatus() === false) {
      session()->setFlashdata('error', 'Failed to save transaction. A database error occurred.');
      return redirect()->to('/transactions/create')->withInput();
    }

    session()->setFlashdata('message', 'Transaction added successfully.');
    return redirect()->to('/transactions');
  }

  public function show($transaction_id)
  {
    $transaction = $this->transactionModel->getTransactionsWithCustomer($transaction_id);
    if (empty($transaction)) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Transaction not found: ' . $transaction_id);
    }

    $data = [
      'title' => 'Transaction Details',
      'transaction' => $transaction,
      'transaction_items' => $this->transactionDetailModel->getDetailsWithService($transaction_id)
    ];
    return view('transactions/show', $data);
  }

  public function updateStatus($transaction_id)
  {
    $laundryStatus = $this->request->getVar('laundry_status');
    $paymentStatus = $this->request->getVar('payment_status');
    $dataUpdate = [];

    if ($laundryStatus) {
      $dataUpdate['laundry_status'] = $laundryStatus;
      if ($laundryStatus == 'completed' && empty($this->transactionModel->find($transaction_id)['completion_date'])) {
        $dataUpdate['completion_date'] = date('Y-m-d H:i:s');
      }
    }
    if ($paymentStatus) {
      $dataUpdate['payment_status'] = $paymentStatus;
    }

    if (!empty($dataUpdate)) {
      $this->transactionModel->update($transaction_id, $dataUpdate);
      session()->setFlashdata('message', 'Transaction status updated successfully.');
    } else {
      session()->setFlashdata('error', 'No status was changed.');
    }
    return redirect()->to('/transactions/show/' . $transaction_id);
  }

  public function delete($transaction_id)
  {
    try {
      $this->transactionModel->delete($transaction_id);
      session()->setFlashdata('message', 'Transaction deleted successfully.');
    } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
      session()->setFlashdata('error', 'Failed to delete transaction: ' . $e->getMessage());
    }
    return redirect()->to('/transactions');
  }

  public function printReceipt($transaction_id)
  {
    $transaction = $this->transactionModel->getTransactionsWithCustomer($transaction_id);
    if (empty($transaction)) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Transaction not found: ' . $transaction_id);
    }

    $data = [
      'title' => 'Transaction Receipt',
      'transaction' => $transaction,
      'transaction_items' => $this->transactionDetailModel->getDetailsWithService($transaction_id),
      'laundry_name' => 'IF22 Laundry',
      'laundry_address' => 'Cimahi',
      'laundry_phone' => '081122334455'
    ];
    return view('transactions/receipt', $data);
  }
}