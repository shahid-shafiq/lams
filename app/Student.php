<?php

namespace App;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public static function courses($cmpid) {
        $courses = Student::select('course_id')->distinct()->where(['campus_id' => $cmpid])
        ->select(['course_id', 'title', 'description'])
        ->join('courses', 'students.course_id', '=', 'courses.id')->get();
        return $courses;
    }

    public static function students($cmpid, $crsid) {
        $students = Student::select('student_name', 'student_no')
        ->where(['campus_id' => $cmpid, 'course_id' => $crsid])->get();
        return $students;
    }
}
