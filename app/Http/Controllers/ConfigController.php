<?php

namespace App\Http\Controllers;

use App\Cheese;
use App\Location;
use App\Mouse;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function main($message = '', $message_type = 'success')
    {
        $mice = Mouse::all();
        $locations = Location::all();
        $cheeses = Cheese::all();

        return view('config/main', [
            'message' => $message,
            'message_type' => $message_type,
            'mice' => $mice,
            'locations' => $locations,
            'cheeses' => $cheeses
        ]);
    }

    public function addMouse(Request $request)
    {
        if (!$request->has("name")) {
            return redirect('config')->with(['message' => 'Could not add mouse without name!', 'message_type' => 'error']);
        }
        $mouse = new Mouse();

        $mouse->name = strtoupper(trim($request->name));
        $mouse->name = str_replace(' MOUSE', '', $mouse->name); // TODO: using this in search too, move to mouse class

        $mouse->save();

        return redirect('config')
            ->with(['message' => 'Added mouse #' . $mouse->id . ' named: ' . $mouse->name . '!']);
    }

    public function removeMouse(Mouse $mouse)
    {

        $id = $mouse->id;
        $name = $mouse->name;

        $mouse->delete();

        return redirect('config')
            ->with(['message' => 'Removed mouse #' . $id . ' named ' . $name . '!']);
    }

    public function addLocation(Request $request)
    {
        if (!$request->has("name")) {
            return redirect('config')->with(['message' => 'Could not add location without name!', 'message_type' => 'error']);
        }
        $location = new Location();

        $location->name = strtoupper(trim($request->name));

        $location->save();

        return redirect('config')
            ->with(['message' => 'Added location #' . $location->id . ' named: ' . $location->name . '!']);
    }

    public function removeLocation(Location $location)
    {

        $id = $location->id;
        $name = $location->name;

        $location->delete();

        return redirect('config')
            ->with(['message' => 'Removed location #' . $id . ' named ' . $name . '!']);
    }

    public function addCheese(Request $request)
    {
        if (!$request->has("name")) {
            return redirect('config')->with(['message' => 'Could not add cheese without name!', 'message_type' => 'error']);
        }
        $cheese = new Cheese();

        $cheese->name = strtoupper(trim($request->name));

        $cheese->save();

        return redirect('config')
            ->with(['message' => 'Added cheese #' . $cheese->id . ' named: ' . $cheese->name . '!']);
    }

    public function removeCheese(Cheese $cheese)
    {

        $id = $cheese->id;
        $name = $cheese->name;

        $cheese->delete();

        return redirect('config')
            ->with(['message' => 'Removed cheese #' . $id . ' named ' . $name . '!']);
    }
}
