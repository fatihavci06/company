<?php
namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        return response()->json(Item::all());
    }

    public function show($id)
    {
        return Item::findOrFail($id);
    }

    public function store(Request $request)
    {
        $item = Item::create($request->all());
        return response()->json($item, 201);
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        $item->update($request->all());
        return response()->json($item, 200);
    }

    public function destroy($id)
    {
        Item::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
