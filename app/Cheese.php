<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cheese extends Model
{
//    public $name = '';

    public $timestamps = false;
    protected $table = 'cheeses';

    public function setups()
    {
        return $this->hasMany(Setup::class);
    }
}
