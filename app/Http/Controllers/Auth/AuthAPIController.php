<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth AS AUTHF; 
use App\Http\Models\User;
use Carbon\Carbon;

class AuthAPIController extends Controller
{
    private $client;
    public $successStatus = 200;
     /**
     * DefaultController constructor.
     */
    public function __construct()
    {
        $this->client = DB::table('oauth_clients')->where('id', 1)->first();
        // dd($this->client);
    }

     /**
     * @param Request $request
     * @return mixed
     */
    protected function authenticate(Request $request)
    {
        // if(Auth::attempt(['email' => 'admin@taxisxalapa.com', 'password' => Hash::make('secret')])){ 
        //     $user = Auth::user(); 
        //     $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        //     return response()->json(['success' => $success], $this-> successStatus); 
        // } 
        // else{ 
        //     return response()->json(['error'=>'Unauthorised'], 401); 
        // }
        // dd($this->client);
        // $request->request->add([
        //     'grant_type' => 'password',
        //     'username' => 'admin@taxisxalapa.com',
        //     'password' => Hash::make('secret'),
        //     'client_id' => $this->client->id,
        //     'client_secret' => $this->client->secret,
        //     'scope' => ''
        // ]);

        // $proxy = Request::create(
        //     'oauth/token',
        //     'POST'
        // );

        // return \Route::dispatch($proxy);


        // $request->validate([
        //     'email'       => 'required|string|email',
        //     'password'    => 'required|string',
        //     'remember_me' => 'boolean',
        // ]);
        // $credentials = request(['email', 'password']);
        if (!AuthF::attempt(['email' => 'admin@taxisxalapa.com', 'password' => 'secret'])) {
            return response()->json([
                'message' => 'Unauthorized'], 401);
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $token->save();
        // dd($tokenResult->accessToken);
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type'   => 'Bearer',
            'expires_at'   => Carbon::parse(
                $tokenResult->token->expires_at)
                    ->toDateTimeString(),
        ]);


        // $user = User::where('email', 'admin@taxisxalapa.com')->first();

        // if ($user) {

        //     if (Hash::check('secret', $user->password)) {
        //         $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        //         $response = ['token' => $token];
        //         return response($response, 200);
        //     } else {
        //         $response = "Password missmatch";
        //         return response($response, 422);
        //     }

        // } else {
        //     $response = 'User does not exist';
        //     return response($response, 422);
        // }
    }

    public function login(Request $request){
        $request->validate([
            'email'       => 'required|string|email',
            'password'    => 'required|string',
            'remember_me' => 'boolean',
        ]);
        if (!AuthF::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'message' => 'No autorizado'], 401);
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $token->save();
        return response()->json([
            'id_user' => $user->id,
            'access_token' => $tokenResult->accessToken,
            'token_type'   => 'Bearer',
            'expires_at'   => Carbon::parse(
                $tokenResult->token->expires_at)
                    ->toDateTimeString(),
        ]);
    }

    public function signup(Request $request){
        
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);
        $user = new User([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $user->save();
        return response()->json([
            'message' => 'Successfully created user!'], 201);
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json(['message' => 
            'Successfully logged out']);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

}
