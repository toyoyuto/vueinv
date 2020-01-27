<?php

namespace App\ORM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes;
    
    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'stores';

    protected $fillable = [
        'name', 
    ];
}
