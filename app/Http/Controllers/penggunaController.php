<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class penggunaController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register()
    {
        $validator = Validator::make(request()->all(), [
            'nama' => 'required',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required',
            'foto_profil' => 'required'
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::create([
            'nama' => request('nama'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
            'foto_profil' => request('foto_profil')
        ]);

        if ($user) {
            return response()->json(['message' => 'Pendaftaran Berhasil']);
        } else {
            return response()->json(['message' => 'Pendaftaran Gagal']);
        }
    }

    public function updateAkun(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        if ($request->has('nama')) {
            $user->nama = $request->input('nama');
        }

        if ($user->save()) {
            return response()->json(['message' => 'Profil berhasil diperbarui', 'user' => $user]);
        } else {
            return response()->json(['message' => 'Gagal memperbarui profil'], 500);
        }
    }



    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth()->user()
        ]);
    }
}
