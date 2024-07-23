<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PasienModel;

class PasienController extends BaseController
{
    protected $pasienModel;

    public function __construct()
    {
        $this->pasienModel = new PasienModel();
    }

    public function index()
    {
        $items = $this->pasienModel->findAll();
        return $this->response->setJSON($items);
    }

    public function show($id = null)
    {
        $data = $this->pasienModel->find($id);
        if ($data) {
            return $this->response->setJSON($data);
        }
        return $this->response->setStatusCode(404)->setJSON(['error' => 'Item not found']);
    }

    public function create()
    {
        $data = $this->request->getPost();
        if ($this->pasienModel->insert($data)) {
            return $this->response->setStatusCode(201)->setJSON($data);
        }
        return $this->response->setStatusCode(400)->setJSON(['error' => 'Failed to create item']);
    }   

    public function update($id = null)
    {
    $data = $this->request->getJSON(true);


    log_message('debug', 'Data received for update: ' . json_encode($data));

    if (empty($data)) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON(['error' => 'No data to update']);
    }

    if ($this->pasienModel->update($id, $data)) {
        return $this->response
            ->setStatusCode(200)
            ->setJSON(['message' => 'Data berhasil diperbarui', 'data' => $data]);
    }


    return $this->response
        ->setStatusCode(404)
        ->setJSON(['error' => 'Item not found']);
    }


    public function delete($id = null)
    {
        if ($this->pasienModel->delete($id)) {
            return $this->response
                ->setStatusCode(200)
                ->setJSON(['message' => 'Data berhasil dihapus']);
        }
        return $this->response
            ->setStatusCode(404)
            ->setJSON(['error' => 'Item not found']);
    }

    public function patch($id = null)
    {
      
        $data = $this->request->getJSON(true);

        log_message('debug', 'Data received for patch: ' . json_encode($data));

     
        if (empty($data)) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON(['error' => 'No data to update']);
        }

    
        if ($this->pasienModel->update($id, $data)) {
            return $this->response
                ->setStatusCode(200)
                ->setJSON(['message' => 'Data berhasil diperbarui', 'data' => $data]);
        }

        return $this->response
            ->setStatusCode(404)
            ->setJSON(['error' => 'Item not found']);
    }


    public function options($id = null)
    {
    $allowedMethods = ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'];
    
    if ($id !== null) {
      
        $data = $this->pasienModel->find($id);
        if ($data) {
            return $this->response
                ->setStatusCode(200)
                ->setHeader('Allow', implode(', ', $allowedMethods))
                ->setHeader('Content-Type', 'application/json')
                ->setJSON(['message' => 'Allowed methods: ' . implode(', ', $allowedMethods)]);
        }
        return $this->response
            ->setStatusCode(404)
            ->setHeader('Allow', implode(', ', $allowedMethods))
            ->setHeader('Content-Type', 'application/json')
            ->setJSON(['error' => 'Item not found']);
    }

    return $this->response
        ->setStatusCode(200)
        ->setHeader('Allow', implode(', ', $allowedMethods))
        ->setHeader('Content-Type', 'application/json')
        ->setJSON(['message' => 'Allowed methods: ' . implode(', ', $allowedMethods)]);
    }  

}
