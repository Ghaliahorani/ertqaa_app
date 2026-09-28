<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    // عرض كل الطلاب
    public function index()
    {
        return Student::with('user')->get();
    }

    // عرض طالب واحد
    public function show($id)
    {
        return Student::with('user')->findOrFail($id);
    }

    // إضافة طالب جديد
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required',
            'full_name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable',
            'level' => 'required',
            'registration_date' => 'required|date'
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

        // إنشاء طالب
        $student = Student::create([
            'user_id' => $user->id,
            'level' => $request->level,
            'registration_date' => $request->registration_date
        ]);

        return response()->json([
            'message' => 'تم إضافة الطالب بنجاح',
            'student' => $student
        ]);
    }

    // تعديل طالب
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $user = $student->user;

        $user->update([
            'full_name' => $request->full_name ?? $user->full_name,
            'phone' => $request->phone ?? $user->phone,
            'email' => $request->email ?? $user->email,
        ]);

        $student->update([
            'level' => $request->level ?? $student->level,
            'registration_date' => $request->registration_date ?? $student->registration_date,
        ]);

        return response()->json([
            'message' => 'تم تعديل بيانات الطالب',
            'student' => $student
        ]);
    }

    // حذف طالب
    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        // حذف المستخدم المرتبط
        $student->user->delete();

        // حذف الطالب
        $student->delete();

        return response()->json([
            'message' => 'تم حذف الطالب بنجاح'
        ]);
    }
}
