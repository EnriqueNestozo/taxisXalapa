<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AuthAPIController extends Controller
{
    private $client;
     /**
     * DefaultController constructor.
     */
    public function __construct()
    {
        $this->client = DB::table('oauth_clients')->where('id', 2)->first();
        // dd($this->client);
    }

     /**
     * @param Request $request
     * @return mixed
     */
    protected function authenticate(Request $request)
    {
        $request->request->add([
            'grant_type' => 'password',
            'username' => 'admin@taxisxalapa.com',
            'password' => Hash::make('secret'),
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'scope' => ''
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        return \Route::dispatch($proxy);
    }
}
