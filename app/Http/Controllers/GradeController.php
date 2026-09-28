<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    // عرض كل العلامات
    public function index()
    {
        return Grade::with(['student.user', 'course', 'teacher.user'])->get();
    }

    // عرض علامة واحدة
    public function show($id)
    {
        return Grade::with(['student.user', 'course', 'teacher.user'])->findOrFail($id);
    }

    // إضافة علامة جديدة
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'teacher_id' => 'required|exists:teachers,id',
            'grade' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable'
        ]);

        $grade = Grade::create([
            'student_id' => $request->student_id,
            'course_id' => $request->course_id,
            'teacher_id' => $request->teacher_id,
            'grade' => $request->grade,
            'notes' => $request->notes
        ]);

        return response()->json([
            'message' => 'تم إضافة العلامة بنجاح',
            'grade' => $grade
        ]);
    }

    // تعديل علامة
    public function update(Request $request, $id)
    {
        $grade = Grade::findOrFail($id);

        $grade->update([
            'student_id' => $request->student_id ?? $grade->student_id,
            'course_id' => $request->course_id ?? $grade->course_id,
            'teacher_id' => $request->teacher_id ?? $grade->teacher_id,
            'grade' => $request->grade ?? $grade->grade,
            'notes' => $request->notes ?? $grade->notes
        ]);

        return response()->json([
            'message' => 'تم تعديل العلامة',
            'grade' => $grade
        ]);
    }

    // حذف علامة
    public function destroy($id)
    {
        $grade = Grade::findOrFail($id);
        $grade->delete();

        return response()->json([
            'message' => 'تم حذف العلامة بنجاح'
        ]);
    }
}

