<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\ServiceModel;
use App\Models\TransactionModel;

class Dashboard extends BaseController
{
  public function index()
  {
    $customerModel = new CustomerModel();
    $serviceModel = new ServiceModel();
    $transactionModel = new TransactionModel();

    $data = [
      'title' => 'Dashboard',
      'total_customers' => $customerModel->countAllResults(),
      'total_services' => $serviceModel->countAllResults(),
      'total_transactions_processing' => $transactionModel->where('laundry_status', 'processing')->countAllResults(),
      'total_transactions_completed' => $transactionModel->where('laundry_status', 'completed')->countAllResults(),
      'todays_revenue' => $transactionModel
        ->selectSum('total_fee', 'total')
        ->where('DATE(entry_date)', date('Y-m-d'))
        ->where('payment_status', 'paid')
        ->get()->getRow()->total ?? 0,
      'recent_transactions' => $transactionModel->getTransactionsWithCustomer(false, 5)
    ];

    return view('dashboard_view', $data);
  }
}