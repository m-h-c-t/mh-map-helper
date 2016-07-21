<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Setup extends Model
{
    public $timestamps = false;
    protected $table = 'setups';
    protected $with = ['mouse', 'location', 'cheese'];

    public function mouse()
    {
        return $this->belongsTo(Mouse::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function cheese()
    {
        return $this->belongsTo(Cheese::class);
    }
}
