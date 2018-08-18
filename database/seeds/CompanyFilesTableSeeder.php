<?php

use Illuminate\Database\Seeder;
use App\CompanyFile;

class CompanyFilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CompanyFile::create([
            'serial' => "9912345678",
            'number' => 4,
            'status' => "active"
        ])->save();
    }
}
