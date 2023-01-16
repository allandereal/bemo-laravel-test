<?php

namespace Database\Seeders;

use App\Models\Column;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColumnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Column::factory(4)->hasCards(8)->create();
        Column::factory(1)->hasCards(2)->create(['deleted_at' => now()]);
    }
}
