<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'user_id',
    'registered_by',
    'father_name',
    'father_mobile',
    'father_job',
    'mother_name',
    'mother_mobile',
    'mother_job',
    'address',
    'ideal_community_opinion',
])]
class ParentProfile extends Model
{

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
