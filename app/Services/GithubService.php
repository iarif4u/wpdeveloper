<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GithubService
{

    /**
     * @throws \Exception
     */
    public static function fetchUserInfo($userName)
    {
        $url = "https://api.github.com/users/{$userName}";
        $response = Http::get($url);
        if ($response->successful()){
            return  $response->object();
        }
        throw new \Exception("Username doesn't match");

    }

    /**
     * @throws \Exception
     */
    public static function fetchUserRepo($userName)
    {
        $url = "https://api.github.com/users/{$userName}/repos";
        $response = Http::get($url);
        if ($response->successful()){
            return  $response->object();
        }
        throw new \Exception("Username doesn't match");
    }
}
