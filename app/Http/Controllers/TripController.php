<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trip;
use App\User;
use File;
use Illuminate\Support\Facades\Auth;


class TripController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $trips = Trip::orderBy('created_at', 'desc')->get(['id', 'title', 'trip_date', 'trip_duration', 'image', 'user_id']);
        $user = Auth::check() ? Auth::user()->name : 'Anonymous';
        $userTrips = [];
        foreach($trips as $trip) {
            if(Auth::user()->id == $trip['user_id']) {
                $userTrips[] = $trip;
            }
        }
        $userTrips = collect($userTrips);

        return response()
            ->json([
               'trips' => $trips,
                'userTrips' => $userTrips,
                'user' => $user
            ]);
    }

    public function create()
    {
        $form = Trip::form();
        return response()
            ->json([
                'form' => $form
            ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'trip_date' => 'required|date',
            'trip_duration' => 'required|numeric',
            'description' => 'required|max:65535',
            'image' => 'required|image'
        ]);

        if(!$request->hasFile('image') && !$request->file('image')->isValid()) {
            return abort(404, 'Image not uploaded!');
        }

        $filename = $this->getFileName($request->image);
        $request->image->move(base_path('public/images'), $filename);

        $trip = new Trip($request->only('title', 'trip_date', 'trip_duration', 'description'));
        $trip->image = $filename;

        $request->user()->trips()->save($trip);

        return response()
            ->json([
                'saved' => true,
                'id' => $trip->id,
                'message' => 'You have successfully created trip!'
            ]);
    }

    private function getFileName($file)
    {
        return str_random(32) . '.' . $file->extension();
    }

    public function show($id) {
        $trip = Trip::with('user')->findOrFail($id);

        return response()
            ->json([
                'trip' => $trip
        ]);
    }

    public function edit($id, Request $request)
    {
        $form = $request->user()->trips()
            ->findOrFail($id, ['id', 'title', 'trip_date', 'trip_duration', 'description', 'image']);

        return response()
            ->json([
                'form' => $form
            ]);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'trip_date' => 'required|date',
            'trip_duration' => 'required|numeric',
            'description' => 'required|max:65535'
        ]);

        $trip = $request->user()->trips()->findOrFail($id);
        $trip->title = $request->title;
        $trip->trip_date = $request->trip_date;
        $trip->trip_duration = $request->trip_duration;
        $trip->description = $request->description;

        if ($request->hasfile('image') && $request->file('image')->isValid()) {
            $filename = $this->getFileName($request->image);
            $request->image->move(base_path('/public/images'), $filename);

            // remove old image
            File::delete(base_path('/public/images/'.$trip->image));
            $trip->image = $filename;

            $trip->save();
        }

        return response()
            ->json([
                'saved' => true,
                'id' => $trip->id,
                'message' => 'You have successfully updated trip!'
            ]);
    }

    public function destroy($id, Request $request)
    {
        $trip = $request->user()->trips()->findOrFail($id);

        // remove image
        File::delete(base_path('/public/images/'.$trip->image));

        $trip->delete();

        return response()
            ->json([
                'deleted' => true
            ]);
    }
}
