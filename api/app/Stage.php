<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{

    public $timestamps = false;
    protected $table = 'stages';

    public function location()
    {
        return $this->hasOne(Location::class);
    }
}
