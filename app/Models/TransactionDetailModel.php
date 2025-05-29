<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionDetailModel extends Model
{
  protected $table = 'transaction_details';
  protected $primaryKey = 'detail_id';
  protected $useAutoIncrement = true;
  protected $returnType = 'array';
  protected $allowedFields = ['transaction_id', 'service_id', 'quantity', 'subtotal'];

  public function getDetailsWithService($transaction_id)
  {
    return $this->select('transaction_details.*, services.service_name, services.service_price, services.service_unit')
      ->join('services', 'services.service_id = transaction_details.service_id')
      ->where(['transaction_details.transaction_id' => $transaction_id])
      ->findAll();
  }
}