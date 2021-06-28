<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Traits\zoommeetingTrait;


class ZoomController extends Controller
{
    use zoommeetingTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('zoom.show');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('zoom.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'topic'         => 'required|string',
            'duration'      => 'required|numeric',
            'start_time'    => 'required',
            'agenda'        => 'required|string|nullable',
        ]);
        
        return $this->createmeeting($request->only('topic','duration','start_time','agenda'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $request->validate([
            'id'            => 'required',
        ]);
        return $this->getmeeting($request->id);
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('zoom.edit');
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
        $request->validate([
            'topic'         => 'required|string',
            'duration'      => 'required|numeric',
            'start_time'    => 'required',
            'agenda'        => 'required|string|nullable',
            'id'            => 'required',
        ]);

        return $this->updatemeeting($request->id, $request->only('topic','duration','start_time','agenda'));
       
    }

    public function delete(Request $request)
    {
        return view('zoom.delete');
    }


    
    public function destroy(Request $request)
    {
        $request->validate([
            'id'            => 'required',
        ]);
        $this->deletemeeting($request->id);
    }
}
