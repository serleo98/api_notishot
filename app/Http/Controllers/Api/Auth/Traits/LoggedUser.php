<?php

namespace App\Http\Controllers\Api\Auth\Traits;

use App\Entities\User\User;
use App\Http\Resources\Responses\LoginClientResource;
use Carbon\Carbon;
use Illuminate\Http\Request;

trait LoggedUser
{
    protected function createToken(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->get('remember_me')) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();

        return $tokenResult;
    }
}
