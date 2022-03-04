<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function init()
    {
        $ufee = \Ufee\Amo\Oauthapi::setInstance([
            'domain' => env('AMO_DOMAIN'),
            'client_id' => env('AMO_CLIENT_ID'),
            'client_secret' => env('AMO_CLIENT_SECRET'),
            'redirect_uri' => env('AMO_REDIRECT_URI'),
        ]);

        try {
            $ufee = \Ufee\Amo\Oauthapi::getInstance(env('AMO_CLIENT_ID'));

            $ufee->account->toArray();

        } catch (\Exception $exception) {

            $ufee->fetchAccessToken(env('AMO_CODE'));
        }

        return $ufee;
    }
}
