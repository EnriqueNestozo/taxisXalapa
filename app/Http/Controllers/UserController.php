<?php

namespace App\Http\Controllers;

use App\Http\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use DB;

class UserController extends Controller
{

    public function __construct(){
        // $this->middleware('client-credential');
    }
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        return view('users.index', ['users' => $model->paginate(15)]);
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user in storage
     */
    public function store(Request $request)
    {
        try{
            $usuario = null;
            DB::beginTransaction();
            if($request->idUsuario){
                $usuario = User::find($idUsuario);
                $usuario->update($request->merge(['password' => Hash::make($request->get('password'))])->all());
                $usuario->assignRole($request->rolSelect);
            }else{
                $usuario = User::create($request->merge(['password' => Hash::make($request->get('password'))])->all());
                $usuario->assignRole($request->rolSelect);
            }
            DB::commit();
            return response()->json($usuario,201);
        }catch(\PDOException $e){
            DB::rollBack();
            return response()->json($e,500);
        }
    }

    /** NO SE USA
     * Show the form for editing the specified user
     *
     * @param  \App\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User  $user)
    {
        $hasPassword = $request->get('password');
        $user->update(
            $request->merge(['password' => Hash::make($request->get('password'))])
                ->except([$hasPassword ? '' : 'password']
        ));
        $user->turno_id = $request->turno_id;
        $user->save();

        return redirect()->route('user.index')->withStatus(__('Usuario actualizado correctamente.'));
    }

    /**
     * Remove the specified user from storage
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User  $user)
    {
        $user->removeRole($user->roles->first());
        $user->delete();

        return redirect()->route('user.index')->withStatus(__('Usuario eliminado satisfactoriamente.'));
    }

    public function getUserData(){
        $users = User::with('roles')->get();
        return view('users.index',['users' => $users]);
    }
}
