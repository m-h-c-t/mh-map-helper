<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{

    public $timestamps = false;
    protected $table = 'stages';

    public function setups()
    {
        return $this->hasMany(Setup::class);
    }
}
