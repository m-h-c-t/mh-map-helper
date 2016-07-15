<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public $timestamps = false;
//    public $name = '';
    protected $table = 'locations';

    public function setups()
    {
        return $this->hasMany(Setup::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
}
