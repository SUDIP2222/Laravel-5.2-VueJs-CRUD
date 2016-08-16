<?php

namespace App\Http\Controllers;

use App\Event;
//use Illuminate\Http\Request;
use Request;
use App\Http\Requests;

class EventController extends Controller
{
    public function index(){
        return view('index');
    }

    public function getEvent(){
        $events=Event::all();
        return $events;
    }

    public function store(){
        //dd($request->all());
        $event=Event::create(Request::all());
        return $event;

    }
    public function delete($id){
        $event=Event::findOrFail($id);
        $event->delete();
    }

}
