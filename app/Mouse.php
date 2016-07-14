<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//require_once "__FILE__/../db/db.php";
use DB;

class Mouse extends Model
{
    public $name = '';
    public $id = '';
    public $mouse_wiki_url = '';
    public $locations = array();
    public $cheeses = array();
    public $is_valid = false;

    public function retrieve($mouse_name) {
        global $db;
        $this->name = '';
        $this->id = '';
        $this->locations = array();
        $this->cheeses = array();
        $this->is_valid = false;

        if (empty($mouse_name)) {
            return;
        }

        $mouse_name = str_replace(' MOUSE', '', $mouse_name);
        $this->name = $mouse_name;

        $result = DB::table('mice as m')
                    ->join('setups as s', 's.mice_id', '=', 'm.id')
                    ->join('cheeses as c', 'c.id', '=', 's.cheeses_id')
                    ->join('locations as l', 'l.id', '=', 's.locations_id')
                    ->leftJoin('stages as st', 'st.id', '=', 'l.stages_id')
                    ->select(
                        'm.id as mouse_id',
                        'l.id as location_id',
                        'l.name as location',
                        'st.name as stage',
                        'c.id as cheese_id',
                        'c.name as cheese')
                    ->where('m.name', 'like', $mouse_name)
                    ->get();

        foreach ($result as $row) {
            $this->id = $row->mouse_id;
            $mouse_wiki_url = str_replace(' ', '_', ucwords(strtolower($mouse_name)));
            $this->mouse_wiki_url = (substr($mouse_name, -5, 5) === 'MOUSE' ? $mouse_wiki_url : $mouse_wiki_url . '_Mouse');
            $this->mouse_wiki_url = 'http://mhwiki.hitgrab.com/wiki/index.php/' . $this->mouse_wiki_url;
            $this->locations[$row->location_id] = array('name' => $row->location, 'stage' => $row->stage);
            $this->cheeses[$row->cheese_id] = $row->cheese;
            $this->is_valid = true;
        }
    }
}
