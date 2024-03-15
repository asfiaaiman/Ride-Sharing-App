<?php

namespace App\Http\Controllers;

use App\Events\TripAccepted;
use App\Events\TripEnded;
use App\Events\TripLocationUpdated;
use App\Events\TripStarted;
use App\Http\Requests\TripAcceptRequest;
use App\Http\Requests\TripEndRequest;
use App\Http\Requests\TripLocationRequest;
use App\Http\Requests\TripRequest;
use App\Http\Requests\TripStartRequest;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function store(TripRequest $request)
    {
        $request->validated();

        return $request->user()->trips()->create($request->only([
            'origin', 'destination', 'destination_name'
        ]));
    }

    public function show(TripRequest $request, Trip $trip)
    {
        // Is the trip associated with authenticated user?

        if($trip->user->id === $request->user->id)
        {
            return $trip;
        }

        if($trip->driver && $request->user()->driver)
        {
            if($trip->driver->id && $request->user()->driver->id)
            {
                return $trip;
            }
        }
        return response()->json(['message' => 'Cannot find this trip', 404]);
    }

    public function accept(TripAcceptRequest $request, Trip $trip)
    {
        // A drivers accepts a trip
        $trip->update([
            'driver_id' => $request->user()->id,
            'driver_location' => $request->driver_location,
        ]);

        $trip->load('driver.user');

        TripAccepted::dispatch($trip, $request->user());

        return $trip;
    }

    public function start(TripStartRequest $request, Trip $trip)
    {
        // A driver has started the trip

        $trip->update([
            'is_started' => true,
        ]);

        $trip->load('driver.user');

        TripStarted::dispatch($trip, $request->user());

        return $trip;
    }

    public function end(TripEndRequest $request, Trip $trip)
    {
        // A driver has ended the trip

        $trip->update([
            'is_complete' => true,
        ]);

        $trip->load('driver.user');

        TripEnded::dispatch($trip, $request->user());

        return $trip;
    }

    public function location(TripLocationRequest $request, Trip $trip)
    {
        // Update the driver's current location

        $trip->update([
            'driver_location' => $request->driver_location,
        ]);

        $trip->load('driver.user');

        TripLocationUpdated::dispatch($trip, $request->user());

        return $trip;
    }
}
