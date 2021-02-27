<?php

namespace App\Controllers;

// cara 2
use App\Models\KomikModel;

class Komik extends BaseController
{
    protected $komikModel;
    public function __construct()
    {
        $this->komikModel = new KomikModel();
    }

    public function index()
    {
        $komik = $this->komikModel->findAll();
        $data = [
            'judul' => 'Daftar Komik',
            'komik' => $komik
        ];

        // cara konek db tanpa model
        // $db = \Config\Database::connect();
        // $komik = $db->query("SELECT * FROM komik")->getResultArray();
        // var_dump($komik);
        // die();

        // cara 1
        // $komikModel = new \App\Models\KomikModel();

        // cara 2
        // $komikModel = new KomikModel();

        return view('komik/index', $data);
    }
}
