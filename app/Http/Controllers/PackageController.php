<?php

namespace App\Http\Controllers;

use App\Http\Requests\PackageRequest;
use App\Models\Package;
use App\Services\PackageService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $packageService;

    public function __construct(PackageService $packageService)
    {
        $this->packageService = $packageService;
    }
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $packages = Package::query()
                ->when($search, function ($query, $search) {
                    return $query->where('name', 'like', '%' . $search . '%');
                })->with('prices') 
                ->paginate($request->input('per_page', 10));
            
            return response()->json($packages);
        } catch (QueryException $e) {
            return response()->json(['message' => 'İşlem başarısız oldu: ' . $e->getMessage()], 500);
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
    public function store(PackageRequest $request)
    {
        try{
            $this->packageService->createData($request);
            return response()->json(['message' => 'Kayıt Başarılı'], 200);

        }catch(Exception $e){
            return response()->json(['message' => 'İşlem başarısız oldu: ' . $e->getMessage()], 500);
        }
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->packageService->getDataById($id);
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
    public function update(PackageRequest $request, string $id)
    {
        
        try {
            Package::findOrFail($id);
            $this->packageService->updateData($id, $request);
            return response()->json(['message' => 'Kayıt Başarılı'], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'Package not found'], 404);
        } catch (QueryException $e) {
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
            $package = Package::findOrFail($id);
            $this->packageService->deleteData($package);
            return response()->json(['message' => 'Kayıt Başarılı'], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'Package not found'], 404);
        } catch (QueryException $e) {
            return response()->json(['message' => 'İşlem başarısız oldu: ' . $e->getMessage()], 500);
        }
       
    }
}
