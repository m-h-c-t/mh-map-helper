<?php

namespace App\Http\Controllers;

use App\Mouse;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SearchController extends Controller
{

    public function search(Request $request)
    {
        if (!$request->has("mice") || empty($request->input("mice"))) {
            return ['error' => 'No mice supplied'];
        }

        $mice_names = $this->filterMouseNames(json_decode($request->input("mice")));

        $invalid_mice = array();
        $valid_mice = array();
        foreach ($mice_names as $mouse_name) {
            $mouse_name = str_replace("’", "'", $mouse_name);

            $mouse = Mouse::where('name', $mouse_name)->first();

            if (!isset($mouse->id)) {
                $invalid_mice[] = $mouse_name;
                continue;
            }

            // Load all relationships
            $mouse->setups = $mouse->setups()->where('timestamp', '>', Carbon::now()->subMonths(10))->get();

            $valid_mice[] = $mouse;
        }

        return response()->json([
            'valid_mice' => $valid_mice,
            'invalid_mice' => $invalid_mice
        ]);
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
        $mice_names = array_map('App\Mouse::formatName', $mice_names);
        $mice_names = array_filter($mice_names);
        $mice_names = array_unique($mice_names);

        return $mice_names;
    }
}
