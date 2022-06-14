<?php

namespace App\Dao;

use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Teacher;
use App\Contracts\Dao\TeacherDaoInterface;

class TeacherDao implements TeacherDaoInterface
{
    public function getTeachers()
    {
        return Teacher::paginate(5);
    }

    public function getTeacher($id)
    {
        return Teacher::findOrFail($id);
    }

    public function updateTeacher($request, $teacher, $teacherData)
    {
        $courses = $teacherData['courses'];
        unset($teacherData['courses']);

        $teacherImage = $request->file_path;

        if (isset($teacherImage)) {
            $data = Teacher::where('id', $request->id)->first();

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

        $teacher->detail()->update([
            'mother_name' => $teacherData['mother_name'],
            'father_name' => $teacherData['father_name'],
            'hobby' => $teacherData['hobby'],
        ]);

        $teacher->courses()->detach();
        $teacher->courses()->attach($courses);

        return $teacher;
    }

    public function createTeacher($request,  $teacherData)
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
        $teacher->detail()->create([
            'mother_name' => $teacherData['mother_name'],
            'father_name' => $teacherData['father_name'],
            'hobby' => $teacherData['hobby'],
        ]);

        $teacher->courses()->attach($courses);

        return $teacher;
    }

    public function deleteTeacher($id)
    {
        $teacher = getTeacher($id);
        $teacher->courses()->detach();
        $teacher->detail()->delete();
        $teacher->delete();
    }

    public function searchTeacher($request)
    {
        $name = $request->name;
        $email = $request->email;
        $gender = $request->gender;
        $isActive = $request->is_active;
        $result = Teacher::query()
            ->select('teacher.*', DB::raw('count(course_id) as total_courses'))
            ->leftJoin('teacher_course', 'teacher.id', '=', 'teacher_course.teacher_id')
            ->when($name, function ($q, $name) {
                $q->where('teacher_name', 'LIKE', '%' . $name . '%');
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
            ->groupBy('teacher.id')
            ->orderby('id')
            ->get();

        return $result;
    }

    public function profileEditTeacher($request, $teacher, $teacherData)
    {
        $courses = $teacherData['courses'];
        unset($teacherData['courses']);

        $teacherImage = $request->file_path;

        if (isset($teacherImage)) {
            $data = Teacher::where('id', $request->id)->first();

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

        $teacher->detail()->update([
            'mother_name' => $teacherData['mother_name'],
            'father_name' => $teacherData['father_name'],
            'hobby' => $teacherData['hobby'],
        ]);

        $teacher->courses()->detach();
        $teacher->courses()->attach($courses);

        return $teacher;
    }

    public function profileDeleteTeacher($teacher)
    {
        $teacher->courses()->detach();
        $teacher->detail()->delete();
        $teacher->delete();
    }

}
