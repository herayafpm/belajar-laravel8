<?php

namespace App\Http\Middleware;

use App\Models\RequestLog as ModelsRequestLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Token;
use \Lcobucci\JWT\Parser;
class RequestLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $user = Auth::user();
        if($user){
            $ipAddress = $request->ip();
            $userAgent = $request->header('User-Agent');
            $username = $user->username;
            $name = $user->name;
            $statusCode = $response->getStatusCode();
            $message = $response->getData()->message ?? "";
            $token = $request->header('Authorization') ?? $response->getData()->data->token;
            $token = explode(" ",$token)[1];
            $tokenId= (new Parser())->parse($token)->getClaim('jti');
            ModelsRequestLog::create([
                'username' => $username,
                'name' => $name,
                'ip_address' => $ipAddress,
                'status_code' => $statusCode,
                'message' => $message,
                'user_agent' => $userAgent,
                'token' => $tokenId
            ]);
        }
        return $response;
    }
}
