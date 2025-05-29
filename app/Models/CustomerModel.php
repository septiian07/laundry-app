<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
  protected $table = 'customers';
  protected $primaryKey = 'customer_id';
  protected $useAutoIncrement = true;
  protected $returnType = 'array';
  protected $useSoftDeletes = false;
  protected $allowedFields = ['customer_name', 'customer_address', 'customer_phone'];
}
