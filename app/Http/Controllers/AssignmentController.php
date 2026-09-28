<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    // عرض كل الواجبات
    public function index()
    {
        return Assignment::with(['course', 'teacher.user', 'student.user'])->get();
    }

    // عرض واجب واحد
    public function show($id)
    {
        return Assignment::with(['course', 'teacher.user', 'student.user'])->findOrFail($id);
    }

    // إضافة واجب جديد
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'teacher_id' => 'required|exists:teachers,id',
            'student_id' => 'required|exists:students,id',
            'title' => 'required',
            'description' => 'nullable',
            'due_date' => 'required|date'
        ]);

        $assignment = Assignment::create([
            'course_id' => $request->course_id,
            'teacher_id' => $request->teacher_id,
            'student_id' => $request->student_id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date
        ]);

        return response()->json([
            'message' => 'تم إضافة الواجب بنجاح',
            'assignment' => $assignment
        ]);
    }

    // تعديل واجب
    public function update(Request $request, $id)
    {
        $assignment = Assignment::findOrFail($id);

        $assignment->update([
            'course_id' => $request->course_id ?? $assignment->course_id,
            'teacher_id' => $request->teacher_id ?? $assignment->teacher_id,
            'student_id' => $request->student_id ?? $assignment->student_id,
            'title' => $request->title ?? $assignment->title,
            'description' => $request->description ?? $assignment->description,
            'due_date' => $request->due_date ?? $assignment->due_date
        ]);

        return response()->json([
            'message' => 'تم تعديل الواجب',
            'assignment' => $assignment
        ]);
    }

    // حذف واجب
    public function destroy($id)
    {
        $assignment = Assignment::findOrFail($id);
        $assignment->delete();

        return response()->json([
            'message' => 'تم حذف الواجب بنجاح'
        ]);
    }
}

