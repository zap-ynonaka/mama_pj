<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    public $timestamps = false;
    protected $table = 'menus';

    public function corners()
    {
        return $this->belongsTo(Corners::class);
    }

    public function categories()
    {
        return $this->belongsTo(Categories::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tags::class);
    }


}
