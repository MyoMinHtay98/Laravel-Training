<?php

namespace App\Services;

use App\Contracts\Dao\StudentDaoInterface;
use App\Contracts\Services\StudentServiceInterface;
use App\Models\Student;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentService implements StudentServiceInterface
{

    private $studentDao;

    public function __construct(StudentDaoInterface $studentDao)
    {
        $this->studentDao = $studentDao;
    }

    public function getStudents()
    {
        return $this->studentDao->getStudents();
    }

    public function getStudent($id)
    {
        return $this->studentDao->getStudent($id);
    }

    public function updatePasswordStudent($request)
    {
        return $this->studentDao->updatePasswordStudent($request);
    }

    public function createStudent($request, $studentData, $courses)
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

        $this->studentDao->createStudentDeatils($student, $studentData);

        $this->studentDao->createStudentCourse($student, $courses);

        return $student;
    }

    public function deleteStudent($student)
    {
        $this->studentDao->deleteStudentDeatils($student);
        $this->studentDao->deleteStudentCourse($student);
        $this->studentDao->deleteStudent($student);
    }

    public function searchStudent($request)
    {
        $result = $this->studentDao->searchStudent($request);

        return $result;
    }

    public function updateStudent($request, $student, $studentData, $courses)
    {
        $courses = $studentData['courses'];
        unset($studentData['courses']);
        $studentImage = $request->file_path;
        if (isset($studentImage)) {
            $data = $this->studentDao->getStudent($request->id);

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

        $this->studentDao->updateStudentDetails($student, $studentData);
        $this->studentDao->updateStudentCourse($student, $courses);

        return $student;
    }

    public function checkPassword($request)
    {
        $data = $request->all();
        $student = Student::findOrFail($data['id']);

        if (!Hash::check($data['oldPassword'], $student->password)) {
            return false;
        }
        $this->studentDao->checkPassword($request);
        return true;
    }
}
