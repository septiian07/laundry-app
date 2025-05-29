<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
  protected $table = 'transactions';
  protected $primaryKey = 'transaction_id';
  protected $useAutoIncrement = true;
  protected $returnType = 'array';
  protected $allowedFields = ['customer_id', 'entry_date', 'completion_date', 'total_fee', 'payment_status', 'laundry_status'];

  public function getTransactionsWithCustomer($id = false, $limit = null)
  {
    $builder = $this->select('transactions.*, customers.customer_name')
      ->join('customers', 'customers.customer_id = transactions.customer_id', 'left')
      ->orderBy('transactions.entry_date', 'DESC');

    if ($id !== false) {
      return $builder->where(['transactions.transaction_id' => $id])->first();
    }

    if ($limit !== null && is_numeric($limit)) {
      $builder->limit($limit);
    }

    return $builder->findAll();
  }
}
