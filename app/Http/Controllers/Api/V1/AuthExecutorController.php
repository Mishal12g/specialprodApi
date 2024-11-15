<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Executor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthExecutorController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|phone|max:255|unique:executors',
            'password' => 'required|string|min:8',
        ]);

        $executor = Executor::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $token = $executor->createToken('Executor_token')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|phone',
            'password' => 'required|string',
        ]);

        $executor = Executor::where('phone', $request->phone)->first();

        if (!$executor || !Hash::check($request->password, $executor->password)) {
            throw ValidationException::withMessages([
                'phone' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $executor->createToken('Executor_token')->plainTextToken;

        return response()->json(['token' => $token, 'executor' => $executor,], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out'], 200);
    }
}
