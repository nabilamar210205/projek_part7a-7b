<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Menampilkan semua data student (dengan pagination).
     */
    public function index()
    {
        $students = Student::paginate(10);

        return response()->json([
            'status'  => true,
            'message' => 'Data student berhasil diambil',
            'data'    => $students,
        ], 200);
    }

    /**
     * Menyimpan data student baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim'           => 'required|string|unique:students,nim',
            'nama'          => 'required|string',
            'prodi'         => 'required|string',
            'tanggal_lahir' => 'required|date',
            'email'         => 'nullable|email',
            'alamat'        => 'nullable|string',
        ]);

        $student = Student::create($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Data student berhasil ditambahkan',
            'data'    => $student,
        ], 201);
    }

    /**
     * Menampilkan detail satu student.
     */
    public function show(string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'status'  => false,
                'message' => 'Data student tidak ditemukan',
                'data'    => null,
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Detail data student',
            'data'    => $student,
        ], 200);
    }

    /**
     * Mengupdate data student.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'status'  => false,
                'message' => 'Data student tidak ditemukan',
                'data'    => null,
            ], 404);
        }

        $validated = $request->validate([
            'nim'           => 'required|string|unique:students,nim,' . $id,
            'nama'          => 'required|string',
            'prodi'         => 'required|string',
            'tanggal_lahir' => 'required|date',
            'email'         => 'nullable|email',
            'alamat'        => 'nullable|string',
        ]);

        $student->update($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Data student berhasil diupdate',
            'data'    => $student,
        ], 200);
    }

    /**
     * Menghapus data student.
     */
    public function destroy(string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'status'  => false,
                'message' => 'Data student tidak ditemukan',
                'data'    => null,
            ], 404);
        }

        $student->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Data student berhasil dihapus',
            'data'    => $student,
        ], 200);
    }
}
