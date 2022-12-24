<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class status_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $status                                   = new Status();
        $status->id                               = 1;
        $status->name_status                      = 'Đã kích hoạt';
        $status->save();

        $status                                   = new Status();
        $status->id                               = 2;
        $status->name_status                      = 'Ngừng kích hoạt';
        $status->save();
    }
}
