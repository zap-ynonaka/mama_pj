<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerProfiles extends Model
{
    protected $table = 'partner_profiles';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
