<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceModel extends Model
{
  protected $table = 'services';
  protected $primaryKey = 'service_id';
  protected $useAutoIncrement = true;
  protected $returnType = 'array';
  protected $allowedFields = ['service_name', 'service_price', 'service_unit'];
}
