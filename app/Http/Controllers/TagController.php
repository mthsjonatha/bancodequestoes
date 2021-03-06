<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Tag;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::all()->load('questions');
        return response()->json($tags);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::find($id);
        $tag->questions()->detach();
        $tag->delete();
        return response()->json($tag);
    }

    public function listQuestion(Request $request)
    {
        $plucked = collect($request->all())->pluck('id');
        $tags = Tag::find($plucked->toArray())->load('questions');
        $questions = collect();
        foreach ($tags as $index => $tag) { 
            $questions->push($tag->questions->pluck('id'));  
        }
        $total_questions = $questions->collapse()->unique();
        return response()->json($total_questions->flatten()->toArray());
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $tags = Tag::where('text', 'LIKE', '%'.$query.'%')->get();
        return  response()->json($tags);
    }
}
