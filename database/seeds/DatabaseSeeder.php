<?php

use Illuminate\Database\Seeder;
use App\CompanyFile;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CompanyFilesTableSeeder::class);
    }
}
