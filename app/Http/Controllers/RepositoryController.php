<?php

namespace App\Http\Controllers;

use App\Jobs\DownloadAvatarJob;
use App\Models\Repository;
use App\Models\User;
use App\Services\GithubService;
use Illuminate\Http\Request;

class RepositoryController extends Controller
{
    public function getUserInfo(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string'
        ]);

        $user = User::with('repositories')->where(['username' => $request->username])->first();
        if (!$user) {
            try {
                $user = $this->getRemoteUser($request->username);
                dispatch(new DownloadAvatarJob($user));
            } catch (\Exception $exception) {
                $message = "{$request->username} not found";
                return view('welcome', compact('message'));
            }
        }
        $user->load(['repositories']);

        return view('welcome', compact('user'));
    }

    private function getRemoteUser($userName)
    {
        $userInfo = GithubService::fetchUserInfo($userName);
        $repositories = GithubService::fetchUserRepo($userName);
        $repoList = [];
        foreach ($repositories as $repo) {
            $repoList[] = new Repository(['full_name' => $repo->full_name]);
        }
        $user = User::create([
            'username' => $userInfo->login,
            'name' => $userInfo->name,
            'avatar' => $userInfo->avatar_url,
        ]);
        $user->repositories()->saveMany($repoList);
        return $user;
    }

}
