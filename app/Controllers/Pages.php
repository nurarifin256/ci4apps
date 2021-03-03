<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        // $faker = \Faker\Factory::create();
        // dd($faker->name());
        $data = [
            'judul' => 'Home | Arifin',
            'tes'   => ['satu', 'dua', 'tiga']
        ];
        // echo view('pages/home', $data);
        return view('pages/home', $data);
    }

    public function about()
    {
        $data = [
            'judul' => 'About Me',
        ];

        // cara tanpa templates
        // echo view('layout/header', $data);
        // echo view('pages/about');
        // echo view('layout/footer');

        // cara pake templates
        return view('pages/about', $data);
    }

    public function contact()
    {
        $data = [
            'judul'     => 'Contact Us',
            'alamat'    => [
                [
                    'tipe'      => 'rumah',
                    'alamat'    => 'jln. garobog',
                    'kota'      => 'bogor'
                ],
                [
                    'tipe'      => 'kantor',
                    'alamat'    => 'jln. garobog',
                    'kota'      => 'tangerang'
                ]
            ],
        ];

        return view('pages/contact', $data);
    }
}
