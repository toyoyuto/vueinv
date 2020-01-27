<?php

namespace App\ORM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use SoftDeletes;
    
    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'staffs';

    protected $fillable = [
        'staff_cd',
        'name', 
        'email', 
    ];
}
