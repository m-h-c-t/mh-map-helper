<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cheese extends Model
{

    public $timestamps = false;
    protected $table = 'cheeses';

    public function setups()
    {
        return $this->hasMany(Setup::class);
    }

    public static function formatName($name) {
        $name = trim($name);
        $name = str_ireplace(' CHEESE', '', $name);
        return $name;
    }
}
