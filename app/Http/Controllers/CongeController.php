<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DayOf;
use DB;
use Mail;

class CongeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() // lister les day_ofs de tout le monde en fonction du nom d'utilisateur 
    {
        $users = User::where('role','=',0)->get();         
        //$day_ofs= day_of::all();
        $day_ofs=DB::table('day_ofs')
        ->join('users','users.id','=','day_ofs.user_id') 
        ->select ('day_ofs.id','day_ofs.user_id','users.name','day_ofs.start','day_ofs.end','day_ofs.type','day_ofs.number_day','day_ofs.number_hour','day_ofs.state2','day_ofs.details')->get();

        return view('dayofs.index', compact('day_ofs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dayofs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) // Créer un congé
    {
        $day_of = new DayOf;
        $day_of->user_id =$request->user_id;
        $day_of->start = $request->start;
        $day_of->end = $request->end;
        $day_of->type=$request->type;
        $day_of->number_day = $request->number_day;
        $day_of->number_hour = $request->number_hour;
        $day_of->state2="En cours";
        $day_of->save();
        //Mail::to('sergio@balizenn.com')->send(new day_of);
        
        return back()->with('message', "La demande a bien été envoyé !");
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
    
    public function edit($day_of)
    {   
        $day_of=DayOf::find($day_of);
        return view('dayofs.edit', compact('day_of'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request,$day_of) // Valider un day_of
    {
        $day_of=DayOf::find($day_of);
        $day_of->user_id =$request->user_id;
        $day_of->state2=$request->state2;
        $day_of->save();
        return back()->with('message', "Les modifications ont bien été apportées!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
