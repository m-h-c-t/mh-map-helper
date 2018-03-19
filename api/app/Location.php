<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public $timestamps = false;
    protected $table = 'locations';

    public function setups()
    {
        return $this->hasMany(Setup::class);
    }

}
