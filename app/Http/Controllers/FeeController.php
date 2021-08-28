<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Department;
use App\Course;
use App\Student;
use App\Section;

class FeeController extends Controller
{
    //
    public function courses($cmpid) {
        // course classes at campus (cmpid)
        $courses = Section::select('course_id')->where(['campus_id' => $cmpid])
        ->select(['course_id', 'courses.title', 'courses.description'])
        ->join('courses', 'course_id', '=', 'courses.id')->get();
        return $courses;
        //return Student::courses($cmpid);
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
