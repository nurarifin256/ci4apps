<?php

namespace App\Controllers;

// cara 2

use App\Models\OrangModel;
use CodeIgniter\HTTP\Files\UploadedFile;

class Orang extends BaseController
{
    protected $OrangModel;

    public function __construct()
    {
        $this->OrangModel = new OrangModel();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_orang') ? $this->request->getVar('page_orang') : 1;

        // d($this->request->getVar('keyword'));

        $keyword = $this->request->getVar('keyword');

        if ($keyword) {
            $orang = $this->OrangModel->search($keyword);
        } else {
            $orang = $this->OrangModel;
        }

        $data = [
            'judul' => 'Daftar Orang',
            // 'orang' => $this->OrangModel->findAll()
            'orang'       => $orang->paginate(6, 'orang'),
            'pager'       => $this->OrangModel->pager,
            'currentPage' => $currentPage
        ];
        // dd($this->OrangModel->findAll());

        return view('orang/index', $data);
    }
}
