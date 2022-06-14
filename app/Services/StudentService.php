<?php

namespace App\Services;

use App\Contracts\Dao\StudentDaoInterface;
use App\Contracts\Services\StudentServiceInterface;
use App\Models\Student;
use File;

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

    public function deleteStudent($id)
    {
        $this->studentDao->deleteStudentCourse($student);
        $this->studentDao->deleteStudentDeatils($student);
        $this->studentDao->deleteStudent($student);
    }

    public function searchStudent($request)
    {
        $name = $request->name;
        $email = $request->email;
        $gender = $request->gender;
        $isActive = $request->is_active;
        $result = $this->studentDao->searchStudent($request);

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

        $this->studentDao->profileEditStudentDeatils($student, $studentData);

        $this->studentDao->profileEditStudentCourse($student);

        return $student;
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

        $this->studentDao->updateStudentDeatils($student, $studentData);
        $this->studentDao->updateStudentCourse($student, $courses);

        return $student;
    }
}
