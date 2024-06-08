<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Company;
use App\Models\User;
use App\Models\UserRole;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthenticationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request)
    {
        
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user=User::select('company_id','id')->where('email',$request->email)->first();
            $role=UserRole::where('user_id',$user->id)->first();
            $company=Company::where('authorized_person_id',$user->id)->first();
            Log::info($request->password);
            $expireDate = time() + 60 * 60 * 1;
            $token = JWT::encode([
                'email' => $request->email,
                'db_name' => $company->db_name,
                'company_id' => $company->id,
                'role' => $role->id,
                'exp' => $expireDate
            ], env('JWT_TOKEN'), 'HS256');

            return response()->json(['token' => $token, 'expire_date' => $expireDate]);
        } else {
            return response()->json(['message' => 'Invalid User'], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request  $request)
    {
        return User::where('company_id',$request->company_id)->get();
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
