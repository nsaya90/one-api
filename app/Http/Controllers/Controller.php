<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function register(Request $request)
    {
        $request->validate([
            'lastname' => 'required|string',
            'firstname' => 'required|string',
            'age' => 'required|numeric|min:16',
            'phone' => 'required|numeric',
            'email' => 'required|string',
            'password' => 'required|string',
        ]);



        $user = User::create([
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'age' => $request->age,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' =>  Hash::make($request->password),
        ]);


        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => true,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);

        return response()->json(["message" => true, 'user' => $user]);
    }


    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Connexion invalide'
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => true,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        return $request->user()->currentAccessToken()->delete();
    }

    public function profile()
    {
        $user = Auth::user();
        return response()->json(['user' => $user]);
    }

    public function update(Request $request,)
    {
        $user = Auth::user();


        $user->lastname = $request->lastname;
        $user->firstname = $request->firstname;
        $user->age = $request->age;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        return response()->json(["message" => "Modifier le profil", 'user' => $user]);
    }

    // Création d'une fonction pour supprimer un profil restaurateur

    public function destroy()
    {
        $user = Auth::user();

        $user->delete();

        return response()->json(["message" => true, 'user' => $user]);
    }
}
