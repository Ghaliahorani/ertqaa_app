<?php

namespace App\Http\Controllers;

use App\Models\StudentNote;
use Illuminate\Http\Request;


class NoteController extends Controller
{
    // عرض كل الملاحظات
    public function index()
    {
        return StudentNote::with(['student.user', 'teacher.user', 'course'])->get();
    }

    // عرض ملاحظة واحدة
    public function show($id)
    {
        return StudentNote::with(['student.user', 'teacher.user', 'course'])->findOrFail($id);
    }

    // إضافة ملاحظة جديدة
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'teacher_id' => 'required|exists:teachers,id',
            'course_id' => 'required|exists:courses,id',
            'note' => 'required',
            'date' => 'required|date'
        ]);

        $note = StudentNote::create([
            'student_id' => $request->student_id,
            'teacher_id' => $request->teacher_id,
            'course_id' => $request->course_id,
            'note' => $request->note,
            'date' => $request->date
        ]);

        return response()->json([
            'message' => 'تم إضافة الملاحظة بنجاح',
            'note' => $note
        ]);
    }

    // تعديل ملاحظة
    public function update(Request $request, $id)
    {
        $note = StudentNote::findOrFail($id);

        $note->update([
            'student_id' => $request->student_id ?? $note->student_id,
            'teacher_id' => $request->teacher_id ?? $note->teacher_id,
            'course_id' => $request->course_id ?? $note->course_id,
            'note' => $request->note ?? $note->note,
            'date' => $request->date ?? $note->date
        ]);

        return response()->json([
            'message' => 'تم تعديل الملاحظة',
            'note' => $note
        ]);
    }

    // حذف ملاحظة
    public function destroy($id)
    {
        $note = StudentNote::findOrFail($id);
        $note->delete();

        return response()->json([
            'message' => 'تم حذف الملاحظة بنجاح'
        ]);
    }
}
