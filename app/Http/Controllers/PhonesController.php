<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Phone;

class PhonesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Phone::paginate()->getCollection();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        
        $validator = Validator::make($data, [
            'number' => 'required|max:45',
            'contact_id' => 'required|integer|min:0|exists:contacts,id',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        return Phone::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Phone::find($id);
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
        $data = json_decode($request->getContent(), true);
        
        $validator = Validator::make($data, [
            'number' => 'required|max:45',
            'contact_id' => 'required|integer|min:0|exists:contacts,id',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        $phone = Phone::findOrFail($id);
        $phone->update($data);
        
        return $phone;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $phone = Phone::findOrFail($id);
        $phone->delete();
        
        return response('', 204);
    }
}
