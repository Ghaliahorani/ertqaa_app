<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    // عرض كل الجلسات
    public function index()
    {
        return Session::with(['course', 'teacher.user'])->get();
    }

    // عرض جلسة واحدة
    public function show($id)
    {
        return Session::with(['course', 'teacher.user'])->findOrFail($id);
    }

    // إضافة جلسة جديدة
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'teacher_id' => 'required|exists:teachers,id',
            'date' => 'required|date',
            'time' => 'required',
            'description' => 'nullable'
        ]);

        $session = Session::create([
            'course_id' => $request->course_id,
            'teacher_id' => $request->teacher_id,
            'date' => $request->date,
            'time' => $request->time,
            'description' => $request->description
        ]);

        return response()->json([
            'message' => 'تم إضافة الجلسة بنجاح',
            'session' => $session
        ]);
    }

    // تعديل جلسة
    public function update(Request $request, $id)
    {
        $session = Session::findOrFail($id);

        $session->update([
            'course_id' => $request->course_id ?? $session->course_id,
            'teacher_id' => $request->teacher_id ?? $session->teacher_id,
            'date' => $request->date ?? $session->date,
            'time' => $request->time ?? $session->time,
            'description' => $request->description ?? $session->description
        ]);

        return response()->json([
            'message' => 'تم تعديل الجلسة',
            'session' => $session
        ]);
    }

    // حذف جلسة
    public function destroy($id)
    {
        $session = Session::findOrFail($id);
        $session->delete();

        return response()->json([
            'message' => 'تم حذف الجلسة بنجاح'
        ]);
    }
}

