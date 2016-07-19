<?php

namespace App\Http\Controllers;

use App\Mouse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function main()
    {
        return view('main');
    }

    public function search(Request $request)
    {

        $results = array();
        if (!$request->has("mice")) {
            return view('main');
        }

        $mice_names = $this->filterMouseNames($request->input("mice"));

        if (!count($mice_names)) {
            return view('main');
        }

        $valid_mice_count = 0;
        $invalid_mice = array();
        $setups = array();
        foreach ($mice_names as $mouse_name) {

            $mouse = \App\Mouse::where('name', $mouse_name)->first();

            if (!isset($mouse->id)) {
                $invalid_mice[] = $mouse_name;
                continue;
            }
            $valid_mice_count++;

            $setups = $this->organizeMouseSetupsByLocation($mouse, $setups);
        }
        asort($invalid_mice);

        $setups = $this->sortSetups($setups);

        return view('search-results', [
            'setups' => $setups,
            'valid_mice_count' => $valid_mice_count,
            'invalid_mice' => $invalid_mice,
            'micelist' => $request->input("mice")]);
    }

    /**
     * Takes string of mouse names separated by new lines
     * Returns filtered array
     *
     * @param $mice_names
     * @return array
     */
    private function filterMouseNames($mice_names)
    {
        $mice_names = explode("\n", $mice_names);
        $mice_names = array_map('App\Mouse::formatName',$mice_names);
        $mice_names = array_filter($mice_names);
        $mice_names = array_unique($mice_names);

        return $mice_names;
    }

    private function organizeMouseSetupsByLocation($mouse, $setups)
    {
        foreach ($mouse->setups as $mouse_setup) {
            // Add location id and name
            $setups[$mouse_setup->location->name]['id'] = $mouse_setup->location->id;

            // Add stage name and id
            $stage_name = (count($mouse_setup->location->stage) ? $mouse_setup->location->stage->name : '');
            $stage_id = (count($mouse_setup->location->stage) ? $mouse_setup->location->stage->id : '');
            $setups[$mouse_setup->location->name]['stages'][$stage_name]['id'] = $stage_id;

            // Add mouse id and name
            $setups[$mouse_setup->location->name]['stages'][$stage_name]['mice'][$mouse->id]['name'] = $mouse->name;

            // Add cheese name
            $setups[$mouse_setup->location->name]['stages'][$stage_name]['mice'][$mouse->id]['cheese'][] = $mouse_setup->cheese->name;

            // TODO: add wiki links to db/entity
            // Add mouse wiki link
            $setups[$mouse_setup->location->name]['stages'][$stage_name]['mice'][$mouse->id]['link'] = $mouse->getWikiUrl();

            // Add mouse counts per location
            $setups[$mouse_setup->location->name]['mice_count'][$mouse->id] = 1;
        }
        return $setups;
    }

    private function sortSetups($setups)
    {
        // TODO: Sort iceberg stages somehow

        foreach ($setups as $location_name => $location) {
            ksort($setups[$location_name]['stages']);
            foreach ($location['stages'] as $stage_name => $stage) {
                ksort($setups[$location_name]['stages'][$stage_name]['mice']);
                foreach ($stage['mice'] as $mouse_id => $mouse) {
                    asort($setups[$location_name]['stages'][$stage_name]['mice'][$mouse_id]['cheese']);
                }
            }
        }

        // Sort location arrays by mice count
        uasort($setups, function ($a, $b) {
            return count($b['mice_count']) <=> count($a['mice_count']);
        });
        return $setups;
    }
}
