<?php

namespace App\Http\Controllers;

use App\Setup;
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
            $mouse_setups = Setup::getByMouse($mouse_name);

            if (!empty($mouse_setups)) {
                $setups = array_replace_recursive($setups, $mouse_setups);
                $valid_mice_count++;
            } else {
                $invalid_mice[] = $mouse_name;
            }
        }
        asort($invalid_mice);

        $setups = $this->sortSetups($setups);
//            Log::debug('1');

//        $mouse = new Mouse();
//        $unique_mice = array();
//        foreach ($mice_names as $mouse_name) {
//            $mouse->retrieve($mouse_name);
//            if (!$mouse->is_valid)
//                $invalid_mice[] = (array) $mouse;
//            else if (!array_key_exists($mouse->id, $valid_mice))
//                $valid_mice[$mouse->id] = (array) $mouse;
//        }

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
        $mice_names = array_map('trim', $mice_names);
        $mice_names = array_filter($mice_names);
        $mice_names = array_map('strtoupper', $mice_names);
        $mice_names = array_unique($mice_names);

        return $mice_names;
    }

    private function sortSetups($setups)
    {
        // TODO: Sort cheese arrays by name
        // TODO: Sort iceberg stages somehow

        foreach ($setups as $location_name => $location) {
            ksort($setups[$location_name]['stages']);//, [$this, 'sortByName']);
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
