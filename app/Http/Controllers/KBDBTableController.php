<?php

namespace App\Http\Controllers;

use App\KBDBTableGrinder;

class KBDBTableController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(KBDBTableGrinder $table)
    {
        return view('KBDBTable')->with('table', $table);
    }

    public static function findPrevious($id)
    {
        if (!$table = KBDBTableGrinder::where('id', '<', $id)->orderBy('id', 'asc')->first()) {
            return $id;
        } else {
            return $table->id;
        }
    }

    public static function findNext($id)
    {
        if (!$table = KBDBTableGrinder::where('id', '>', $id)->orderBy('id', 'asc')->first()) {
            return $id;
        } else {
            return $table->id;
        }
    }
}
