<?php

// Controlleur pour voir les tickets 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use DB;
use PDF;
use date;


class PrivateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() // page pricipal, lister les tickets de chaque utilisateur
    {
        $tickets=DB::table('tickets')
        ->join('users','users.id','=','tickets.user_id') 
        ->select ('tickets.id','tickets.user_id','users.name','tickets.month','tickets.quantity','tickets.state')-> simplePaginate(10);
         
        $users = User::all();     
        return view('privates.index', compact('tickets'));
    }
     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Ticket $ticket, Request $request) // fonction qui génere la facture des tickets en PDF
    {         
       $parametre =$request->all();
       if ($request->hasFile('image')) 
        {
            if($request->file('image')->isValid()) 
                {
                    try {
                            $file = $request->file('image');
                            $image = base64_encode(file_get_contents($request->file('images/signature.jpg')));
                            echo $image;
                         }
                            catch (FileNotFoundException $e) 
                                  {
                                     echo "catch";
                                  }
                }
        }
        $dompdf = new pdf(array('enable_remote' => true));
        $pdf= PDF::loadView('privates.show',compact('ticket') )->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->download('facturesTR.pdf');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function show($ticket) // Voir le pdf qu'on veut génerer
    {
        $ticket=Ticket::find($ticket);
        //dd($ticket->user->name);
        $tickets=DB::table('tickets')
        ->join('users','users.id','=','ticket->user_id') 
        ->select ('users.name');
        return view('privates.show', compact('ticket'));            
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($ticket) // Formulaire pour modifier ou valider le tickets 
    {
        $ticket=Ticket::find($ticket);
        if ($ticket->state==1)
         {
            return redirect('/privates');
         }
        return view('privates.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function update(Request $request, $ticket) // Fonction qui permet de modifier le ticket
   {
        $ticket=Ticket::find($ticket);
        $data = $request->validate([
        'quantity' => 'required|max:2',
        ]);
        $ticket->quantity = $request->quantity;
        $ticket->month = $request->month;
        $ticket->validate=$request->validate;
        $ticket->user_id=$request->user_id;
        $ticket->token=$request->token;
        $ticket->state = $request->has('state');
        $ticket->save();
        return back()->with('message', "La ticket a bien été modifiée !");        
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
