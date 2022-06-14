<?php

namespace App\Services;

use App\Contracts\Dao\TeacherDaoInterface;
use App\Contracts\Services\TeacherServiceInterface;
use App\Models\Teacher;
use File;

class TeacherService implements TeacherServiceInterface
{

    private $teacherDao;

    public function __construct(TeacherDaoInterface $teacherDao)
    {
        $this->teacherDao = $teacherDao;
    }

    public function getTeachers()
    {
        return $this->teacherDao->getTeachers();
    }

    public function getTeacher($id)
    {
        return $this->teacherDao->getTeacher($id);
    }

    public function createTeacher($request, $teacherData, $courses)
    {
        $teacherData['password'] = bcrypt($teacherData['password']);
        $courses = $teacherData['courses'];
        unset($teacherData['courses']);

        $teacher = Teacher::create($teacherData);

        if ($request->hasfile('file_path')) {
            $file = $request->file('file_path');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move(public_path() . '/uploads/', $filename);
            $teacher->file_path = $filename;
        }
        $teacher->save();

        $this->teacherDao->createTeacherDeatils($teacher, $teacherData);

        $this->teacherDao->createTeacherCourse($teacher, $courses);

        return $teacher;
    }

    public function deleteTeacher($id)
    {
        $this->teacherDao->deleteTeacherCourse($teacher);
        $this->teacherDao->deleteTeacherDeatils($teacher);
        $this->teacherDao->deleteTeacher($teacher);
    }

    public function searchTeacher($request)
    {
        $name = $request->name;
        $email = $request->email;
        $gender = $request->gender;
        $isActive = $request->is_active;
        $result = $this->teacherDao->searchTeacher($request);

        return $result;
    }

    public function updateTeacher($request, $teacher, $teacherData, $courses)
    {
        $courses = $teacherData['courses'];
        unset($teacherData['courses']);
        $teacherImage = $request->file_path;
        if (isset($teacherImage)) {
            $data = $this->teacherDao->getTeacher($request->id);

            $fileName = $data['file_path'];
            if (File::exists(public_path() . '/uploads/' . $fileName)) {
                File::delete(public_path() . '/uploads/' . $fileName);
            }
            $file = $request->file('file_path');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path() . '/uploads/', $fileName); //move path to $fileName
            $teacherData['file_path'] = $fileName;
        }
        $teacher->update($teacherData);

        $this->teacherDao->updateTeacherDeatils($teacher, $teacherData);
        $this->teacherDao->updateTeacherCourse($teacher, $courses);

        return $teacher;
    }
}
