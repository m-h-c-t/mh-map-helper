<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

//require_once "__FILE__/../db/db.php";

class Mouse extends Model
{
    public $timestamps = false;

    public $wiki_url;

    protected $table = 'mice';

    public function getWikiUrl()
    {
        if (empty($this->wiki_url)) {
            $this->wiki_url = str_replace(' ', '_', ucwords(strtolower($this->name)));
            $this->wiki_url = (substr($this->name, -5, 5) === 'MOUSE' ? $this->wiki_url : $this->wiki_url . '_Mouse');
            $this->wiki_url = 'http://mhwiki.hitgrab.com/wiki/index.php/' . $this->wiki_url;
        }
        return $this->wiki_url;
    }

    public function setups()
    {
        return $this->hasMany(Setup::class);
    }
}
