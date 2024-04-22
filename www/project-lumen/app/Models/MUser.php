<?php
namespace App\Models;

use DateTimeInterface;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class MUser extends Model
{

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'm_user';

    protected $fillable = [
    'nama',
    'nik',
    'telp',
    'alamat',

    'created_by',
    'created_at',
    'updated_at',
    'updated_by',
    'deleted_by',
    'deleted_at',

    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    public function getData($paginate = 5)
    {
        // //$data = DB::select(' 
        // SELECT * FROM '.$this->table.' where nikawa='."'aaa'".'');
        
        //$data = DB::select(DB::raw('
        //SELECT * FROM '.$this->table.'
                //'));
         $data = MUser::orderBy('id', 'ASC')->paginate($paginate);
        return $data;
    }

}