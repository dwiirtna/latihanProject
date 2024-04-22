<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\MUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tableName = (new MUser)->getTable();
        if(Schema::hasTable($tableName)){
            $rowCount = MUser::count();
            if($rowCount > 0){
                MUser::truncate();
            }
        }

        $scheme = [
        [
            'nama'   => "DWI",
            'nik'    => "MSIB02014",
            'telp'   => "22312",
            'alamat' => "DEPOK",

            'created_by' => "SEEDER",
            'created_at' => Carbon::now(),
            'updated_at' => null,
            'updated_by' => null,
            'deleted_by' => null,
            'deleted_at' => null,
        ] 

        ];
        MUser::insert($scheme);
    }
}