<?php

namespace App\Http\Controllers;

use App\Topic;
use Illuminate\Http\Request;

class AdminConfigureController extends Controller
{
    //
    public function show(){
        $topics = Topic::all();
//        echo "TOPIC PAGE";
      //  return view('topic.topic', ['topics' => $topics]);
        return view('room.configchat',['topics' => $topics]);
    }
    public function addtopic(Request $request){
        $name = $request->input('name');
        $option = new Topic();
        $option->name = $name;
        $option->save();
        //return redirect('/configchat');
        return redirect('/configchat');
    }
    public function delete(Request $request)
    {
        $id = $request->query('id');

        $topic = Topic::where('id', $id)->first();

        if ($topic !== NULL) {
            $topic->delete();
        }

        return redirect('/configchat ');
    }
    public function edit(Request $request)
    {
        $id = $request->query('id');
        $name = $request->input('name');

        $topic = Topic::where('id', $id)->first();

        if ($topic !== NULL) {
            $topic->name = $name;

            $topic->save();
        }

        return redirect('/configchat');
    }

}
