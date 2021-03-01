<?php

namespace App\Controllers;

// cara 2
use App\Models\KomikModel;
use CodeIgniter\HTTP\Files\UploadedFile;

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
        // session(); cara 1, cara 2 taruh session di base controller
        $data = [
            'judul' => 'Tambah Data Komik',
            'validation' => \Config\Services::validation()
        ];

        return view('komik/create', $data);
    }

    public function save()
    {
        // validasi input
        if (!$this->validate([
            'judul' => [
                'rules'  => 'required|is_unique[komik.judul]',
                'errors' => [
                    'required'  => '{field} komik harus diisi',
                    'is_unique' => '{field} komik sudah ada'
                ]
            ],
            'penulis' => [
                'rules'  => 'required',
                'errors' => [
                    'required'  => '{field} komik harus diisi'
                ]
            ],
            'penerbit' => [
                'rules'  => 'required',
                'errors' => [
                    'required'  => '{field} komik harus diisi'
                ]
            ],
            'sampul' => [
                'rules'  => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'ukuran file harus di bawah 1 mb',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in'  => 'Yang anda pilih bukan gambar'
                ]
            ]
        ])) {
            // $validation = \Config\Services::validation();
            // var_dump($validation);
            // die();
            // return redirect()->to('/komik/create')->withInput()->with('validation', $validation);
            return redirect()->to('/komik/create')->withInput();
        }

        // ambil gambar
        $fileSampul = $this->request->getFile('sampul');
        // var_dump($fileSampul);
        // die();

        // apakah tidak ada gambar yg di pilih
        if ($fileSampul->getError() == 4) {
            $namaSampul = 'default.png';
        } else {
            // cara 2
            // generate nama sampul random
            $namaSampul = $fileSampul->getRandomName();
            // pindahkan file ke folder img
            $fileSampul->move('img', $namaSampul);
        }

        // pindahkan file ke folder img
        // $fileSampul->move('img'); cara 1



        // ambil nama file cara 1
        // $namaSampul = $fileSampul->getName();

        // var_dump($this->request->getVar());
        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'judul'    => $this->request->getVar('judul'),
            'slug'     => $slug,
            'penulis'  => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul'   => $namaSampul
        ]);

        session()->setFlashdata('pesan', 'Data berhasil di tambahkan');

        return redirect()->to('/komik');
    }

    public function delete($id)
    {
        // cari gambar berdasarkan id
        $komik = $this->komikModel->find($id);

        // cek jika file gambar nya default
        if ($komik['sampul'] != 'default.png') {
            // hapus gambar
            unlink('img/' . $komik['sampul']);
        }

        $this->komikModel->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil di hapus');
        return redirect()->to('/komik');
    }

    public function edit($slug)
    {
        $data = [
            'judul'      => 'Edit Data Komik',
            'validation' => \Config\Services::validation(),
            'komik'      => $this->komikModel->getKomik($slug)
        ];

        return view('komik/edit', $data);
    }

    public function update($id)
    {
        // cek judul
        $komikLama = $this->komikModel->getKomik($this->request->getVar('slug'));

        if ($komikLama['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[komik.judul]';
        }

        if (!$this->validate([
            'judul' => [
                'rules'  => $rule_judul,
                'errors' => [
                    'required'  => '{field} komik harus diisi',
                    'is_unique' => '{field} komik sudah ada'
                ]
            ],
            'penulis' => [
                'rules'  => 'required',
                'errors' => [
                    'required'  => '{field} komik harus diisi'
                ]
            ],
            'penerbit' => [
                'rules'  => 'required',
                'errors' => [
                    'required'  => '{field} komik harus diisi'
                ]
            ],
            'sampul' => [
                'rules'  => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'ukuran file harus di bawah 1 mb',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in'  => 'Yang anda pilih bukan gambar'
                ]
            ]
        ])) {
            // $validation = \Config\Services::validation();
            // var_dump($validation);
            // die();

            // return redirect()->to('/komik/edit/' . $this->request->getvar('slug'))->withInput()->with('validation', $validation);
            return redirect()->to('/komik/edit/' . $this->request->getvar('slug'))->withInput();
        }

        $fileSampul = $this->request->getFile('sampul');

        // cek gambar, apakah tetap gambar lama
        if ($fileSampul->getError() == 4) {
            $namaSampul = $this->request->getVar('sampulLama');
        } else {
            // generate nama file random
            $namaSampul = $fileSampul->getRandomName();
            // pindahkan gambar
            $fileSampul->move('img', $namaSampul);
            // hapus gambar lama
            unlink('img/' . $this->request->getVar('sampulLama'));
        }

        // var_dump($this->request->getVar());
        // die();
        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'id'       => $id,
            'judul'    => $this->request->getVar('judul'),
            'slug'     => $slug,
            'penulis'  => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul'   => $namaSampul
        ]);

        session()->setFlashdata('pesan', 'Data berhasil di ubah');

        return redirect()->to('/komik');
    }
}
