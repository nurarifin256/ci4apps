<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class OrangSeeder extends Seeder
{
    public function run()
    {
        // $data = [
        //     [
        //         'nama'   => 'nur arifin',
        //         'alamat' => 'garobog',
        //         'created_at' => Time::now('Asia/Jakarta'),
        //         'updated_at' => Time::now('Asia/Jakarta')
        //     ],
        //     [
        //         'nama'   => 'boki',
        //         'alamat' => 'tenjo',
        //         'created_at' => Time::now('Asia/Jakarta'),
        //         'updated_at' => Time::now('Asia/Jakarta')
        //     ]
        // ];

        $faker = \Faker\Factory::create('id_ID');

        // cara kalo data nya cuma 1 pake faker
        // $data = [
        //     'nama'       => $faker->name,
        //     'alamat'     => $faker->address,
        //     'created_at' => Time::createFromTimestamp($faker->unixTime()),
        //     'updated_at' => Time::now('Asia/Jakarta')
        // ];

        // cara kalo data nya banyak pake faker
        for ($i = 0; $i < 100; $i++) {
            $data = [
                'nama'       => $faker->name,
                'alamat'     => $faker->address,
                'created_at' => Time::createFromTimestamp($faker->unixTime()),
                'updated_at' => Time::now('Asia/Jakarta')
            ];
            $this->db->table('orang')->insert($data);
        }

        // Simple Queries
        // $this->db->query("INSERT INTO orang (nama, alamat, created_at, updated_at) VALUES(:nama:, :alamat:, :created_at:, :updated_at:)", $data);

        // Using Query Builder untuk 1 data
        // $this->db->table('orang')->insert($data);

        // langsung banyak data
        // $this->db->table('orang')->insertBatch($data);
    }
}
