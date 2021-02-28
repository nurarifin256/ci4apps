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
        // $komik = $this->komikModel->findAll();
        $data = [
            'judul' => 'Daftar Komik',
            'komik' => $this->komikModel->getKomik()
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

    public function detail($slug)
    {
        // echo $slug;
        // $komik = $this->komikModel->getKomik($slug);
        // var_dump($komik);
        // die();

        $data = [
            'judul' => 'Detail Komik',
            'komik' => $this->komikModel->getKomik($slug)
        ];
        // jika komik tidak ada di tabel
        if (empty($data['komik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('judul komik' . $slug . 'tidak ditemukan');
        }
        return view('komik/detail', $data);
    }

    public function create()
    {
        $data = [
            'judul' => 'Tambah Data Komik'
        ];

        return view('komik/create', $data);
    }

    public function save()
    {
        // var_dump($this->request->getVar());
        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'judul'    => $this->request->getVar('judul'),
            'slug'     => $slug,
            'penulis'  => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul'   => $this->request->getVar('sampul')
        ]);

        session()->setFlashdata('pesan', 'Data berhasil di tambahkan');

        return redirect()->to('/komik');
    }
}
