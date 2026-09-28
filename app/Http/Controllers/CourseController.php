<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // عرض كل المواد
    public function index()
    {
        return Course::with('teacher.user')->get();
    }

    // عرض مادة واحدة
    public function show($id)
    {
        return Course::with('teacher.user')->findOrFail($id);
    }

    // إضافة مادة جديدة
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'teacher_id' => 'required|exists:teachers,id'
        ]);

        $course = Course::create([
            'name' => $request->name,
            'description' => $request->description,
            'teacher_id' => $request->teacher_id
        ]);

        return response()->json([
            'message' => 'تم إضافة المادة بنجاح',
            'course' => $course
        ]);
    }

    // تعديل مادة
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $course->update([
            'name' => $request->name ?? $course->name,
            'description' => $request->description ?? $course->description,
            'teacher_id' => $request->teacher_id ?? $course->teacher_id
        ]);

        return response()->json([
            'message' => 'تم تعديل المادة',
            'course' => $course
        ]);
    }

    // حذف مادة
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return response()->json([
            'message' => 'تم حذف المادة بنجاح'
        ]);
    }
}

