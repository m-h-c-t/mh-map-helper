<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Mouse extends Model
{
    public $timestamps = false;

    protected $table = 'mice';

    public function setups()
    {
        return $this->hasMany(Setup::class);
    }

    public static function formatName($name) {
        $name = strtoupper(trim($name));
        $name = str_replace(' MOUSE', '', $name);
        return $name;
    }

    public static function updateWikiUrls() {
        $counter = 0;
        foreach ( Mouse::all() as $one_mouse ){
            if (empty($one_mouse->wiki_url)) {
                $one_mouse->wiki_url = str_replace(' ', '_', ucwords(strtolower($one_mouse->name)));
                $one_mouse->wiki_url = (substr($one_mouse->name, -5, 5) === 'MOUSE' ? $one_mouse->wiki_url : $one_mouse->wiki_url . '_Mouse');
                $one_mouse->wiki_url = 'http://mhwiki.hitgrab.com/wiki/index.php/' . $one_mouse->wiki_url;
                $one_mouse->save();
                $counter++;
            }
        }
        return $counter;
    }
}
