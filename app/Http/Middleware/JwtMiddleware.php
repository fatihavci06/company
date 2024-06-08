<?php

namespace App\Http\Middleware;

use App\Models\Company;
use Closure;
use Defuse\Crypto\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key as JWTKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authorizationHeader = explode(' ', $request->header('Authorization'));
        $head = isset($authorizationHeader[0]) ? $authorizationHeader[0] : false;
        $jwt = isset($authorizationHeader[1]) ? $authorizationHeader[1] : false;
        if (!$head || !$jwt) {
            return response()->json([
                'status' => 0,
                'reply' => 'Invalid!'
            ],401);
        }


        try {
            $secretKey = env('JWT_TOKEN');
            Log::info($jwt);
            $decoded = JWT::decode($jwt, new JWTKey($secretKey, 'HS256'));
            $request->attributes->add(['decoded' => $decoded, 'jwt' => $jwt]);
            $request->merge(['email' => $decoded->email, 'db_name' => $decoded->db_name,'company_id'=>$decoded->company_id]);
          
          
            
            \App\Classes\DatabaseConnect::changeConnect($request->db_name);
           
            return $next($request);
        } catch (ExpiredException $e) {
            return response()->json([
                'status' => 0,
                'reply' => 'Invalid!'
            ],401);
        }
    }
}
