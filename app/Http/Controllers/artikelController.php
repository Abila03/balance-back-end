<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Artikel;
use Illuminate\Support\Facades\Validator;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikel = Artikel::all();
        return response()->json($artikel);
    }

    public function show($id)
    {
        $artikel = Artikel::find($id);
        if (!$artikel) {
            return response()->json(['message' => 'Artikel not found'], 404);
        }
        return response()->json($artikel);
    }

    public function getDataByUser()
    {
        $user = Auth::user();
        $artikel = Artikel::where('id_pengguna', $user->id)->get();
        return response()->json($artikel);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'id_pengguna' => 'required',
            'isi' => 'required',
            'kategori' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $artikel = Artikel::create($request->all());
        return response()->json($artikel, 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'isi' => 'required',
            'kategori' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $artikel = Artikel::find($id);
        if (!$artikel) {
            return response()->json(['message' => 'Artikel not found'], 404);
        }

        $artikel->update($request->all());
        return response()->json($artikel);
    }

    public function destroy($id)
    {
        $artikel = Artikel::find($id);
        if (!$artikel) {
            return response()->json(['message' => 'Artikel not found'], 404);
        }
        $artikel->delete();
        return response()->json(['message' => 'Artikel deleted successfully']);
    }
}
