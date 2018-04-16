<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Corners extends Model
{
    public $timestamps = false;
    protected $table = 'corners';

    public function menus()
    {
        return $this->hasMany('Menus::class');
    }

}
