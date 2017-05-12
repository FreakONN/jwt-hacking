<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersEditRequest;
use App\Http\Requests\UsersRequest;
use App\Photo;
use App\User;
use App\Role;
use Illuminate\Http\Request;

use App\Http\Requests;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //izvlačimo iz baze parametre name, id te ih pretvaramo u array, all ih sve stavlja van
        $roles = Role::lists('name','id')->all();
        //$roles = Role::pluck('name','id')->all();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        /*REQUEST
        $requests represents all the data that you're sending from,let's say,a form, if you have a form, and you press submit,
        if it is form of method POST,then also the HTTP request will be of POST also.
        TYPE HINTING
        And by type hinting it in your method, like public function store(Request $request), laravel behind scenes automatically injects it by the service container ,
        so your $request holds all the data from the HTTP request that you sent to that method.

        Long story short,all that you need to know is that $requests hold all the
        data from a particular request that you're sending to that particular method.*/

        if(trim($request->password) == ''){
            $input = $request->except('password');
        } else{
            $input = $request->all();
            $input['password'] = bcrypt($request->password);
        }

        if($file = $request->file('photo_id')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file'=>$name]);
            $input['photo_id'] = $photo->id;
        }
        User::create($input);
        return redirect('/admin/users');
//        return $request->all();

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //return view('/admin/users/show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::lists('name', 'id')->all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersEditRequest $request, $id)
    {
        //sličan storeu!!!

        //pronađi korisnika
        $user = User::findOrFail($id);

        //detektiraj slike korisnika

        $input = $request->all(); //zatraži sve od korisnika s $id-om

        if($file = $request->file('photo_id')){ //checking for the file
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name); //pomakni podatak u folder
            $photo = Photo::create(['file'=>$name]);
            $input['photo_id'] = $photo->id;
        }
        $user->update($input);
        return redirect('/admin/users');
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
