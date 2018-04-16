<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    public $timestamps = false;
    protected $table = 'categories';

    public function menus()
    {
        return $this->hasMany('Menus::class');
    }

}
