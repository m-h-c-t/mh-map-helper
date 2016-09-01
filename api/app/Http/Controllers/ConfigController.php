<?php

namespace App\Http\Controllers;

use App\Cheese;
use App\Location;
use App\Mouse;
use App\Setup;
use App\Stage;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function main($message = '', $message_type = 'success')
    {
        return view('config/main', [
            'message' => $message,
            'message_type' => $message_type,
            'mice' => Mouse::all(),
            'locations' => Location::all(),
            'cheeses' => Cheese::all(),
            'stages' => Stage::all(),
            'setups' => Setup::all()
        ]);
    }

    public function mouseDetails(Mouse $mouse)
    {
        return view('config/individual', [
            'main' => $mouse,
            'type' => 'mouse',
            'setups' => $mouse->setups,
            'mice' => Mouse::all(),
            'locations' => Location::all(),
            'cheeses' => Cheese::all()
        ]);
    }

    public function addMouse(Request $request)
    {
        if (!$request->has("name")) {
            return redirect('config')->with(['message' => 'Could not add mouse without name!', 'message_type' => 'error']);
        }
        $mouse = new Mouse();

        $mouse->name = $mouse->formatName($request->name);

        $mouse->save();

        return back()
            ->with(['message' => 'Added mouse #' . $mouse->id . ' named: ' . $mouse->name . '!']);
    }

    public function removeMouse(Mouse $mouse)
    {

        $id = $mouse->id;
        $name = $mouse->name;

        $mouse->delete();

        return back()
            ->with(['message' => 'Removed mouse #' . $id . ' named ' . $name . '!']);
    }

    public function updateMouseWikiUrl(Mouse $mouse, Request $request)
    {
        if (!$request->has("wiki_url")) {
            return redirect('config')->with(['message' => 'Could not update without url!', 'message_type' => 'error']);
        }

        $mouse->wiki_url = $request->wiki_url;

        $mouse->save();

        return back()
            ->with(['message' => 'Updated mouse #' . $mouse->id . ' named: ' . $mouse->name . ' with wiki url: ' . $mouse->wiki_url . '!']);
    }

    public function updateMouseHTID(Mouse $mouse, Request $request)
    {
        if (!$request->has("ht_id")) {
            return redirect('config')->with(['message' => 'Could not update without id!', 'message_type' => 'error']);
        }

        $mouse->ht_id = $request->ht_id;

        $mouse->save();

        return back()
            ->with(['message' => 'Updated mouse #' . $mouse->id . ' named: ' . $mouse->name . ' with HT ID: ' . $mouse->ht_id . '!']);
    }

    public function locationDetails(Location $location)
    {
        return view('config/individual', [
            'main' => $location,
            'type' => 'location',
            'setups' => Setup::where('location_id', $location->id)->get(),
            'mice' => Mouse::all(),
            'locations' => Location::all(),
            'cheeses' => Cheese::all()
        ]);
    }

    public function addLocation(Request $request)
    {
        if (!$request->has("name")) {
            return redirect('config')->with(['message' => 'Could not add location without name!', 'message_type' => 'error']);
        }
        $location = new Location();

        $location->name = strtoupper(trim($request->name));

        if ($request->has("stage_id") && is_numeric($request->stage_id)) {
            $location->stage_id = $request->stage_id;
        }

        $location->save();

        return back()
            ->with(['message' => 'Added location #' . $location->id . ' named: ' . $location->name . '!']);
    }

    public function removeLocation(Location $location)
    {

        $id = $location->id;
        $name = $location->name;

        $location->delete();

        return back()
            ->with(['message' => 'Removed location #' . $id . ' named ' . $name . '!']);
    }

    public function cheeseDetails(Cheese $cheese)
    {
        return view('config/individual', [
            'main' => $cheese,
            'type' => 'cheese',
            'setups' => Setup::where('cheese_id', $cheese->id)->get(),
            'mice' => Mouse::all(),
            'locations' => Location::all(),
            'cheeses' => Cheese::all()
        ]);
    }

    public function addCheese(Request $request)
    {
        if (!$request->has("name")) {
            return redirect('config')->with(['message' => 'Could not add cheese without name!', 'message_type' => 'error']);
        }
        $cheese = new Cheese();

        $cheese->name = strtoupper(trim($request->name));

        $cheese->save();

        return back()
            ->with(['message' => 'Added cheese #' . $cheese->id . ' named: ' . $cheese->name . '!']);
    }

    public function removeCheese(Cheese $cheese)
    {

        $id = $cheese->id;
        $name = $cheese->name;

        $cheese->delete();

        return back()
            ->with(['message' => 'Removed cheese #' . $id . ' named ' . $name . '!']);
    }

    public function stageDetails(Stage $stage)
    {
        return view('config/individual', [
            'main' => $stage,
            'type' => 'stage',
            'setups' => Setup::where('location_id', $stage->location->id)->get(),
            'mice' => Mouse::all(),
            'locations' => Location::all(),
            'cheeses' => Cheese::all()
        ]);
    }

    public function addStage(Request $request)
    {
        if (!$request->has("name")) {
            return redirect('config')->with(['message' => 'Could not add stage without name!', 'message_type' => 'error']);
        }
        $stage = new Stage();

        $stage->name = strtoupper(trim($request->name));

        $stage->save();

        return back()
            ->with(['message' => 'Added stage #' . $stage->id . ' named: ' . $stage->name . '!']);
    }

    public function removeStage(Stage $stage)
    {

        $id = $stage->id;
        $name = $stage->name;

        $stage->delete();

        return back()
            ->with(['message' => 'Removed stage #' . $id . ' named ' . $name . '!']);
    }

    public function addSetup(Request $request)
    {
        $setup = new Setup();
        $setup->location_id = $request->location;
        $setup->mouse_id = $request->mouse;
        $setup->cheese_id = $request->cheese;
        $setup->save();

        return back()
            ->with(['message' => 'Added setup #' . $setup->id
                . ' Location: ' . $setup->location->name
                . ' Mouse: ' . $setup->mouse->name
                . ' Cheese: ' . $setup->cheese->name
                . '!']);
    }

    public function removeSetup(Setup $setup)
    {

        $id = $setup->id;
        $location = $setup->location->name;
        $mouse = $setup->mouse->name;
        $cheese = $setup->cheese->name;

        $setup->delete();

        return back()
            ->with(['message' => 'Removed setup #' . $id
                . ' Location: ' . $location
                . ' Mouse: ' . $mouse
                . ' Cheese: ' . $cheese
                . '!']);
    }

    public function updateMiceWikiUrls()
    {
        $mice_updated = Mouse::updateWikiUrls();
        return back()->with(['message' => 'Updated ' . $mice_updated . ' mice!']);
    }
}
