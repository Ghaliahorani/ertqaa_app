<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // عرض كل سجلات الحضور
    public function index()
    {
        return Attendance::with(['student.user', 'session.course', 'session.teacher.user'])->get();
    }

    // عرض سجل واحد
    public function show($id)
    {
        return Attendance::with(['student.user', 'session.course', 'session.teacher.user'])->findOrFail($id);
    }

    // إضافة سجل حضور جديد
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'session_id' => 'required|exists:sessions,id',
            'status' => 'required|in:present,absent,late',
            'date' => 'required|date'
        ]);

        $attendance = Attendance::create([
            'student_id' => $request->student_id,
            'session_id' => $request->session_id,
            'status' => $request->status,
            'date' => $request->date
        ]);

        return response()->json([
            'message' => 'تم تسجيل الحضور بنجاح',
            'attendance' => $attendance
        ]);
    }

    // تعديل سجل حضور
    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        $attendance->update([
            'student_id' => $request->student_id ?? $attendance->student_id,
            'session_id' => $request->session_id ?? $attendance->session_id,
            'status' => $request->status ?? $attendance->status,
            'date' => $request->date ?? $attendance->date
        ]);

        return response()->json([
            'message' => 'تم تعديل سجل الحضور',
            'attendance' => $attendance
        ]);
    }

    // حذف سجل حضور
    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return response()->json([
            'message' => 'تم حذف سجل الحضور بنجاح'
        ]);
    }
}
