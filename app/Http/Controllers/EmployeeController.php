<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Actions\Jetstream\DeleteUser;
use Illuminate\Support\Facades\Hash;

// Page qui permet d'ajouter, vor les utilisateur 
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() //liste les utilisateurs
    {
        $users =User::all();
        return view('employees.index', compact('users'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) // crée un utlisateur 
    {
        $data = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|max:500',
            'entite' => 'required',
        ]); 
        $user = new User;
        $user->name = $request->name;
        $user->password=Hash::make($request->password);
        $user->role=0;
        $user->entite=$request->entite;
        $user->email = $request->email;
        $user->save(); 
        return back()->with('message', "Le salarié a bien était ajouté !");
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('employees.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {   
        return view('employees.edit');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(User $user)
    {
        $data = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|max:500',
            'role' => 'required',
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role= $request->role;
        $user->save();
        return back()->with('message', "Les données ont bien été moifier  !");        
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
{
    $user->delete();
    return back();
}

}
