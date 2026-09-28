<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    // عرض كل المدرسين
    public function index()
    {
        return Teacher::with('user')->get();
    }

    // عرض مدرس واحد
    public function show($id)
    {
        return Teacher::with('user')->findOrFail($id);
    }

    // إضافة مدرس جديد
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required',
            'full_name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable',
            'specialization' => 'required',
            'hire_date' => 'required|date'
        ]);

        // إنشاء مستخدم
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => 'active'
        ]);

        // إنشاء مدرس
        $teacher = Teacher::create([
            'user_id' => $user->id,
            'specialization' => $request->specialization,
            'hire_date' => $request->hire_date
        ]);

        return response()->json([
            'message' => 'تم إضافة المدرس بنجاح',
            'teacher' => $teacher
        ]);
    }

    // تعديل مدرس
    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);
        $user = $teacher->user;

        $user->update([
            'full_name' => $request->full_name ?? $user->full_name,
            'phone' => $request->phone ?? $user->phone,
            'email' => $request->email ?? $user->email,
        ]);

        $teacher->update([
            'specialization' => $request->specialization ?? $teacher->specialization,
            'hire_date' => $request->hire_date ?? $teacher->hire_date,
        ]);

        return response()->json([
            'message' => 'تم تعديل بيانات المدرس',
            'teacher' => $teacher
        ]);
    }

    // حذف مدرس
    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);

        // حذف المستخدم المرتبط
        $teacher->user->delete();

        // حذف المدرس
        $teacher->delete();

        return response()->json([
            'message' => 'تم حذف المدرس بنجاح'
        ]);
    }
}

