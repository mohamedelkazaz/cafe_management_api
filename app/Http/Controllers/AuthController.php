<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    // دالة تسجيل الدخول
    public function login(Request $request)
    {
        // التحقق من صحة البيانات المدخلة
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        try {
            $credentials = $request->only('email', 'password');

            // محاولة تسجيل الدخول والحصول على توكن
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // إرجاع التوكن وبيانات المستخدم
            return response()->json([
                'token' => $token,
                'user' => JWTAuth::user()
            ]);
        } catch (JWTException $e) {
            // في حالة حدوث خطأ في إنشاء التوكن
            return response()->json(['error' => 'Could not create token'], 500);
        }
    }

    // دالة لإرجاع بيانات المستخدم الحالي
    public function me()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    // دالة تسجيل الخروج (إبطال التوكن)
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'Successfully logged out']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to logout'], 500);
        }
    }
}
