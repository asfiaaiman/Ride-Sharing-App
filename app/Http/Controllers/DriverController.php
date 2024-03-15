<?php

namespace App\Http\Controllers;

use App\Http\Requests\DriverRequest;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function show(DriverRequest $request)
    {
        // Return back the user and associated Driver model
        $user = $request->user();

        // load function takes relationship as a string
        $user->load('driver');

        return $user;
    }

    public function update(DriverRequest $request)
    {
        $request->validated();

        $user = $request->user();

        $user->update($request->only('name'));

        $user->driver()->updateOrCreate($request->only([
            'year', 'make', 'model', 'color', 'license_plate'
        ]));

        $user->load('driver');

        return $user;
    }
}
