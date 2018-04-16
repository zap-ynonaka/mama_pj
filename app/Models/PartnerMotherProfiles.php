<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerMotherProfiles extends Model
{
    protected $table = 'partner_mother_profiles';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
