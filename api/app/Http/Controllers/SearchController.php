<?php

namespace App\Http\Controllers;

use App\Mouse;
use App\Location;
use App\Setup;
use App\Stage;
use App\Cheese;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function search(Request $request)
    {
        $results = array();
        if (!$request->has("mice") || empty($request->input("mice"))) {
            return ['error' => 'No mice supplied'];
        }

        $mice_names = $this->filterMouseNames(json_decode($request->input("mice")));

        $invalid_mice = array();
        $valid_mice = array();
        foreach ($mice_names as $mouse_name) {

            $mouse = Mouse::where('name', $mouse_name)->first();

            if (!isset($mouse->id)) {
                $invalid_mice[] = $mouse_name;
                continue;
            }

            // Load all relationships
            $mouse->setups;

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

    public function mouseDetails(Mouse $mouse) {
        return view('individual', [
            'main' => $mouse,
            'type' => 'mouse',
            'setups' => $mouse->setups,
            'mice' => Mouse::all(),
            'locations' => Location::all(),
            'cheeses' => Cheese::all()
        ]);
    }

    public function locationDetails(Location $location) {
        return view('individual', [
            'main' => $location,
            'type' => 'location',
            'setups' => Setup::where('location_id', $location->id)->get(),
            'mice' => Mouse::all(),
            'locations' => Location::all(),
            'cheeses' => Cheese::all()
        ]);
    }

    public function stageDetails(Stage $stage) {
        return view('individual', [
            'main' => $stage,
            'type' => 'stage',
            'setups' => Setup::where('location_id', $stage->location->id)->get(),
            'mice' => Mouse::all(),
            'locations' => Location::all(),
            'cheeses' => Cheese::all()
        ]);
    }

    public function cheeseDetails(Cheese $cheese) {
        return view('individual', [
            'main' => $cheese,
            'type' => 'cheese',
            'setups' => Setup::where('cheese_id', $cheese->id)->get(),
            'mice' => Mouse::all(),
            'locations' => Location::all(),
            'cheeses' => Cheese::all()
        ]);
    }
}
