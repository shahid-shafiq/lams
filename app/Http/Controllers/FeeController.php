<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Department;
use App\Course;
use App\Student;

class FeeController extends Controller
{
    //
    public function courses($cmpid) {
        /*
        $courses = Student::select('course_id')->distinct()->where(['campus_id' => $cmpid])
        ->select(['course_id', 'title', 'description'])
        ->join('courses', 'students.course_id', '=', 'courses.id')->get();
        */
        return Student::courses($cmpid);
    }

    public function students($cmpid, $crsid) {
        /*
        $students = Student::select('student_name', 'student_no')
        ->where(['campus_id' => $cmpid, 'course_id' => $crsid])->get();
        return $students;
        */
        return Student::students($cmpid, $crsid);
    }
}
