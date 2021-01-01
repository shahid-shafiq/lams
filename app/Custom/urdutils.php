<?php
namespace App\Custom;

class Urdutils {
  public static function name() {
    return "Urdu Utility Functions";
  }

  public static function monthUrdu($m) {
    $urnames = array(
        1 => "جنوری",
        2 => "فروری",
        3 => "مارچ",
        4 => "اپریل",
        5 => "مئی",
        6 => "جون",
        7 => "جولائی",
        8 => "اگست",
        9 => "ستمبر",
        10 => "اکتوبر",
        11 => "نومبر",
        12 => "دسمبر",
    );
    
    return $urnames[$m];
  }

  /*
  The dates are Carbon objects
  */
  public static function InfaqDescription($fd, $td) {
    if ($fd->year == $td->year) {
        if ($fd->month == $td->month) {
            $des = "انفاق برائے " . Urdutils::monthUrdu($fd->month) . " " . $fd->year;   
        } else {
            $des = " " . "انفاق " . Urdutils::monthUrdu($fd->month) . " " . "تا" . " " . Urdutils::monthUrdu($td->month) . " " . $fd->year; 
        }
    } else {
        $des = " " . "انفاق برائے ";
        $des .= " " . Urdutils::monthUrdu($fd->month) . " " . $fd->year;
        $des .= " " . "تا ";
        $des .= " " . Urdutils::monthUrdu($td->month) . " " . $td->year; 
    }
    
    return $des;
  }

  /*
  The dates are Carbon objects
  */
  public static function FeeDescription($fd, $td) {
    if ($fd->year == $td->year) {
        if ($fd->month == $td->month) {
            $des = "فیس ماہ " . Urdutils::monthUrdu($fd->month) . " " . $fd->year;   
        } else {
            $des = " " . "فیس " . Urdutils::monthUrdu($fd->month) . " " . "تا" . " " . Urdutils::monthUrdu($td->month) . " " . $fd->year; 
        }
    } else {
        $des = " " . "فیس ";
        $des .= " " . Urdutils::monthUrdu($fd->month) . " " . $fd->year;
        $des .= " " . "تا ";
        $des .= " " . Urdutils::monthUrdu($td->month) . " " . $td->year; 
    }
    
    return $des;
  }
}