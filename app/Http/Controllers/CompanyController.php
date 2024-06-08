<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Jobs\CreateDatabaseJob;
use App\Models\Company;
use App\Models\User;
use Exception;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $searchTerm = $request->company_name;

        $query = Company::with('authorizedPerson');
        if (!empty($searchTerm)) {
            $query->where('company_name', 'like', '%' . $searchTerm . '%');
        }

        $perPage = $request->input('per_page', 10);
        $companies = $query->paginate($perPage);
        return response()->json($companies);
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
    public function store(CompanyRequest $request)
    {

        $databaseName = 'company';
        try {
            // Kullanıcı oluşturma işlemi
            $userId = DB::table("$databaseName.users")->insertGetId([
                'name' => $request->person_name,
                'email' => $request->company_email,
                'password' => bcrypt(123456),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Şirket oluşturma işlemi
            $dynamicDB = 'company_' . preg_replace('/[^A-Za-z0-9]/', '', $request->company_name);
            $company=DB::table("$databaseName.companies")->insert([
                'company_name' => $request->company_name,
                'phone' => $request->phone,
                'address' => $request->address,
                'tax_number' => $request->tax_number,
                'db_name' => $dynamicDB,
                'authorized_person_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            CreateDatabaseJob::dispatch($dynamicDB);

            return response()->json(['message' => 'Kullanıcı ve Şirket başarıyla oluşturuldu'], 200);
        } catch (\Exception $e) {

            return response()->json(['message' => 'İşlem başarısız oldu: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $company = Company::with('authorizedPerson')->find($id);
        return response()->json(['data' => $company]);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        Log::info(json_encode($request->all()));
        DB::beginTransaction();
        try {
            $databaseName = 'company';
            DB::table("$databaseName.users")
                ->where('id', $request->user_id)  // Güncellemek istediğiniz kaydın ID'sini burada belirtiyorsunuz
                ->update([
                    'name' => $request->person_name,
                    'email' => $request->company_email,
                    'updated_at' => now(),
                ]);
            DB::table("$databaseName.companies")->where('id', $id)->update([
                'company_name' => $request->company_name,
                'phone' => $request->phone,
                'address' => $request->address,
                'tax_number' => $request->tax_number,
                'authorized_person_id' => $request->user_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return response()->json(['message' => 'Kullanıcı ve Şirket başarıyla düzenlendi'], 200);
        } catch (\Exception $e) {

            return response()->json(['message' => 'İşlem başarısız oldu: ' . $e->getMessage()], 500);
        }
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Company::find($id)->delete();
            return response()->json(['message' => 'Başarılı olarak silindi']);
        } catch (Exception $e) {
            return response()->json(['message' => 'Hata']);
        }
        //
    }
}
