<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Http\Requests\TicketUpdateRequest;
use Illuminate\Http\Request;
use App\Mail\Contact;
use Illuminate\Support\Str;
use Mail;   
use DB;

// Cette classe permet de génerer des tickets pour les utilisateurs 
class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() // page principal avec le formulaire 
    {   
        $users = User::where('role','=',0)->get(); // les admin (role=1) n'apparaissent pas sur la liste       
        $tickets= Ticket::all();
        return view('tickets.index', compact('users'));
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
    public function store(Request $request) // Fonction qui permet de créer des tickets restaurants
    {
        $users = User::where('role','=',0)->get();    
        foreach($users as $user)
        { 
            if($user->role==0)

                {
                    $isExist=Ticket::where('user_id',$user->id)->where('month',"=",$request[$user->id.'_month'])->get(); // Si un ticket exite déja pour ce mois et cet utilisateur renvoie un bool 1 
                   
                    if  (count($isExist)==0) // si il n'ya pas de ticket qui correspondent a ce mois et cet utilisateur rentrer le ticket
                        {
                            $ticket = new Ticket;
                            $ticket->user_id =$user->id;
                            $ticket->quantity = $request[$user->id.'_quantity'];
                            $ticket->month = $request[$user->id.'_month'];
                            $ticket->token=Str::random(40);
                            $ticket->save();
                            Mail::to([$user->email])->send(new Contact);    
                        }
                }
            }
        if (count($isExist)==0)
        {
            return back()->with('success','Tout les tickets ont bien été ajouter');
        }
        else 
        {
            return back()->with('error','Vérifier la date de vos tickets');
        }

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AddTicket  $addTicket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $Ticket)
    {
        return view('tickets.show'); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AddTicket  $addTicket
     * @return \Illuminate\Http\Response
     */
    public function edit($Ticket) // Retourne le formulaire qui permet de modifier le ticket 
    {


        foreach($users as $users)
            {
                $ticket->user_id =$ticket->user_id;
                $ticket->quantity = $request->quantity;
                $ticket->updated_at=$request->updated_at;
                $ticket->month = $request->mounth;
                $ticket->state = $request->state;
                $ticket->save();
            }    
        return view('tickets.index', compact('users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AddTicket  $addTicket
     * @return \Illuminate\Http\Response
     */
    public function update(TicketUpdateRequest $request) // Modifie le ticket
    {

         
        foreach($users as $user)
            {        
                $ticket->user_id =$request->user_id;
                $ticket->quantity = $request->quantity;
                $ticket->month = $request->mounth;
                $ticket->state=$request->state;
                $ticket->save();
            }
        return back()->with('message', "Les tickets ont bien été changer  !");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AddTicket  $addTicket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $Ticket)
    {
        //
    }
}



