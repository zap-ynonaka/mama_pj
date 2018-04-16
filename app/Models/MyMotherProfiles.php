<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MyMotherProfiles extends Model
{
    protected $table = 'my_mother_profiles';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
