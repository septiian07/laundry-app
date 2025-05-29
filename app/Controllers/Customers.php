<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class Customers extends BaseController
{
  protected $customerModel;

  public function __construct()
  {
    $this->customerModel = new CustomerModel();
  }

  public function index()
  {
    $data = [
      'title' => 'Customer Data',
      'customers' => $this->customerModel->findAll()
    ];
    return view('customers/index', $data);
  }

  public function create()
  {
    $data = [
      'title' => 'Add New Customer',
      'validation' => \Config\Services::validation()
    ];
    return view('customers/create', $data);
  }

  public function save()
  {
    if (
      !$this->validate([
        'customer_name' => [
          'rules' => 'required',
          'errors' => [
            'required' => 'Customer name must be filled.'
          ]
        ],
        'customer_phone' => [
          'rules' => 'required|numeric',
          'errors' => [
            'required' => 'Phone number must be filled.',
            'numeric' => 'Phone number must contain only numbers.'
          ]
        ]
      ])
    ) {
      return redirect()->to('/customers/create')->withInput();
    }

    $this->customerModel->save([
      'customer_name' => $this->request->getVar('customer_name'),
      'customer_address' => $this->request->getVar('customer_address'),
      'customer_phone' => $this->request->getVar('customer_phone'),
    ]);

    session()->setFlashdata('message', 'Customer data added successfully.');
    return redirect()->to('/customers');
  }

  public function edit($id)
  {
    $data = [
      'title' => 'Edit Customer',
      'validation' => \Config\Services::validation(),
      'customer' => $this->customerModel->find($id)
    ];
    return view('customers/edit', $data);
  }

  public function update($id)
  {
    if (
      !$this->validate([
        'customer_name' => [
          'rules' => 'required',
          'errors' => [
            'required' => 'Customer name must be filled.'
          ]
        ],
        'customer_phone' => [
          'rules' => 'required|numeric',
          'errors' => [
            'required' => 'Phone number must be filled.',
            'numeric' => 'Phone number must contain only numbers.'
          ]
        ]
      ])
    ) {
      return redirect()->to('/customers/edit/' . $id)->withInput();
    }

    $this->customerModel->save([
      'customer_id' => $id,
      'customer_name' => $this->request->getVar('customer_name'),
      'customer_address' => $this->request->getVar('customer_address'),
      'customer_phone' => $this->request->getVar('customer_phone'),
    ]);

    session()->setFlashdata('message', 'Customer data updated successfully.');
    return redirect()->to('/customers');
  }

  public function delete($id)
  {
    try {
      $this->customerModel->delete($id);
      session()->setFlashdata('message', 'Customer data deleted successfully.');
    } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
      if (strpos($e->getMessage(), 'foreign key constraint fails') !== false) {
        session()->setFlashdata('error', 'Failed to delete customer. This customer still has related transactions.');
      } else {
        session()->setFlashdata('error', 'A database error occurred.');
      }
    }
    return redirect()->to('/customers');
  }
}