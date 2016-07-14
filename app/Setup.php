<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class Setup extends Model
{
    /**
     * Gets setups by given mouse name
     * Returns array with location -> mouse -> cheese
     *
     * @param $mouse_name
     */
    public static function getByMouse($mouse_name) {
        global $db;
//        $this->name = '';
//        $this->id = '';
//        $locations = array();
//        $cheeses = array();
//        $this->is_valid = false;
        $setups = array();

        if (empty($mouse_name)) {
            return array();
        }

        $mouse_name = str_replace(' MOUSE', '', $mouse_name);
//        $this->name = $mouse_name;

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
            // Add location id and name
            $setups[$row->location]['id'] = $row->location_id;

            // Add stage name
            $stage = (!empty($row->stage)) ? $row->stage : '';
//                $setups[$row->location]['stage'][] = $row->stage;

            // Add mouse id and name
            $setups[$row->location]['stages'][$stage]['mice'][$row->mouse_id]['name'] = $mouse_name;
            // TODO: add wiki links to db

            // Add cheese name
            $setups[$row->location]['stages'][$stage]['mice'][$row->mouse_id]['cheese'][] = $row->cheese;

            // Add mouse wiki link
            $mouse_wiki_url = str_replace(' ', '_', ucwords(strtolower($mouse_name)));
            $mouse_wiki_url = (substr($mouse_name, -5, 5) === 'MOUSE' ? $mouse_wiki_url : $mouse_wiki_url . '_Mouse');
            $mouse_wiki_url = 'http://mhwiki.hitgrab.com/wiki/index.php/' . $mouse_wiki_url;
            $setups[$row->location]['stages'][$stage]['mice'][$row->mouse_id]['link'] = $mouse_wiki_url;

            $setups[$row->location]['mice_count'][$row->mouse_id] = 1;
        }
        return $setups;
    }
}
