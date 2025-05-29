<?php

namespace App\Controllers;

use App\Models\ServiceModel;

class Services extends BaseController
{
  protected $serviceModel;

  public function __construct()
  {
    $this->serviceModel = new ServiceModel();
  }

  public function index()
  {
    $data = [
      'title' => 'Service Data',
      'services' => $this->serviceModel->findAll()
    ];
    return view('services/index', $data);
  }

  public function create()
  {
    $data = [
      'title' => 'Add New Service',
      'validation' => \Config\Services::validation()
    ];
    return view('services/create', $data);
  }

  public function save()
  {
    if (
      !$this->validate([
        'service_name' => 'required',
        'service_price' => 'required|numeric',
        'service_unit' => 'required'
      ])
    ) {
      return redirect()->to('/services/create')->withInput();
    }

    $this->serviceModel->save([
      'service_name' => $this->request->getVar('service_name'),
      'service_price' => $this->request->getVar('service_price'),
      'service_unit' => $this->request->getVar('service_unit'),
    ]);

    session()->setFlashdata('message', 'Service added successfully.');
    return redirect()->to('/services');
  }

  public function edit($id)
  {
    $data = [
      'title' => 'Edit Service',
      'validation' => \Config\Services::validation(),
      'service' => $this->serviceModel->find($id)
    ];
    return view('services/edit', $data);
  }

  public function update($id)
  {
    if (
      !$this->validate([
        'service_name' => 'required',
        'service_price' => 'required|numeric',
        'service_unit' => 'required'
      ])
    ) {
      return redirect()->to('/services/edit/' . $id)->withInput();
    }

    $this->serviceModel->save([
      'service_id' => $id,
      'service_name' => $this->request->getVar('service_name'),
      'service_price' => $this->request->getVar('service_price'),
      'service_unit' => $this->request->getVar('service_unit'),
    ]);

    session()->setFlashdata('message', 'Service updated successfully.');
    return redirect()->to('/services');
  }

  public function delete($id)
  {
    try {
      $this->serviceModel->delete($id);
      session()->setFlashdata('message', 'Service deleted successfully.');
    } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
      if (strpos($e->getMessage(), 'foreign key constraint fails') !== false) {
        session()->setFlashdata('error', 'Failed to delete service. This service is still used in transactions.');
      } else {
        session()->setFlashdata('error', 'A database error occurred.');
      }
    }
    return redirect()->to('/services');
  }
}