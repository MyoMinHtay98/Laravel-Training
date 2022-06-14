<?php

namespace App\Dao;

use App\Contracts\Dao\StudentDaoInterface;
use App\Models\Student;
use File;

class StudentDao implements StudentDaoInterface
{
    public function getStudents()
    {
        return Student::paginate(5);
    }

    public function getStudent($id)
    {
        return Student::findOrFail($id);
    }

    public function updateStudent($request, $student, $studentData)
    {
        $courses = $studentData['courses'];
        unset($studentData['courses']);

        $studentImage = $request->file_path;

        if (isset($studentImage)) {
            $data = Student::where('id', $request->id)->first();

            $fileName = $data['file_path'];
            if (File::exists(public_path() . '/uploads/' . $fileName)) {
                File::delete(public_path() . '/uploads/' . $fileName);
            }
            $file = $request->file('file_path');
            $fileName = $file->getClientOriginalName(); 
            $file->move(public_path() . '/uploads/', $fileName); //move path to $fileName
            $studentData['file_path'] = $fileName;
        }
        $student->update($studentData);

        $student->detail()->update([
            'mother_name' => $studentData['mother_name'],
            'father_name' => $studentData['father_name'],
            'hobby' => $studentData['hobby'],
        ]);

        $student->courses()->detach();
        $student->courses()->attach($courses);

        return $student;
    }

    public function createStudent($request,  $studentData)
    {
        $studentData['password'] = bcrypt($studentData['password']);
        $courses = $studentData['courses'];
        unset($studentData['courses']);

        $student = Student::create($studentData);

        if ($request->hasfile('file_path')) {
            $file = $request->file('file_path');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move(public_path() . '/uploads/', $filename);
            $student->file_path = $filename;
        }
        $student->save();
        $student->detail()->create([
            'mother_name' => $studentData['mother_name'],
            'father_name' => $studentData['father_name'],
            'hobby' => $studentData['hobby'],
        ]);

        $student->courses()->attach($courses);

        return $student;
    }

    public function deleteStudent($id)
    {
        $student = getStudent($id);
        $student->courses()->detach();
        $student->detail()->delete();
        $student->delete();
    }

    public function searchStudent($request)
    {
        $name = $request->name;
        $email = $request->email;
        $gender = $request->gender;
        $isActive = $request->is_active;
        $result = Student::query()
            ->select('student.*', DB::raw('count(course_id) as total_courses'))
            ->leftJoin('student_course', 'student.id', '=', 'student_course.student_id')
            ->when($name, function ($q, $name) {
                $q->where('student_name', 'LIKE', '%' . $name . '%');
            })
            ->when($email, function ($q, $email) {
                $q->where('email', 'LIKE', '%' . $email . '%');
            })
            ->when($gender, function ($q, $gender) {
                $q->where('gender', $gender);
            })
            ->when($isActive, function ($q, $isActive) {
                $q->whereIn('is_active', $isActive);
            })
            ->groupBy('student.id')
            ->orderby('id')
            ->get();

        return $result;
    }

    public function profileEditStudent($request, $student, $studentData)
    {
        $courses = $studentData['courses'];
        unset($studentData['courses']);

        $studentImage = $request->file_path;

        if (isset($studentImage)) {
            $data = Student::where('id', $request->id)->first();

            $fileName = $data['file_path'];
            if (File::exists(public_path() . '/uploads/' . $fileName)) {
                File::delete(public_path() . '/uploads/' . $fileName);
            }
            $file = $request->file('file_path');
            $fileName = $file->getClientOriginalName(); 
            $file->move(public_path() . '/uploads/', $fileName); //move path to $fileName
            $studentData['file_path'] = $fileName;
        }
        $student->update($studentData);

        $student->detail()->update([
            'mother_name' => $studentData['mother_name'],
            'father_name' => $studentData['father_name'],
            'hobby' => $studentData['hobby'],
        ]);

        $student->courses()->detach();
        $student->courses()->attach($courses);

        return $student;
    }

    public function profileDeleteStudent($student)
    {
        $student->courses()->detach();
        $student->detail()->delete();
        $student->delete();
    }
}
