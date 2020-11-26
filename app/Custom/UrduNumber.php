<?php
namespace App\Custom;
/**
 * UrduNumber is a class that converts numeric input into urdu words.
 *
 * @package    UrduNumer
 * @author     M. Shahid Shafiq <jeremy@jeremydorn.com>
 * @copyright  2013 Shahid Shafiq
 * @version    1.0.0
 */

/**
 * Description of UrduNumber
 *
 * @author SShafiq
 */
class UrduNumber {

    public static $urdu = [
            "صفر",
            "ایک",
            "دو",
            "تین",
            "چار",
            "پانچ",
            "چھ",
            "سات",
            "آٹھ",
            "نو",
            "دس",
            "گیارہ",
            "بارہ",
            "تیرہ",
            "چودہ",
            "پندرہ",
            "سولہ",
            "سترہ",
            "اٹھارہ",
            "انیس",
            "بیس",
            "اکیس",
            "بائیس",
            "تئیس",
            "چویس",
            "پچیس",
            "چھبیس",
            "ستائیس",
            "اٹھائیس",
            "انتیس",
            "تیس",
            "اکتیس",
            "بتیس",
            "تینتیس",
            "چونتیس",
            "پینتیس",
            "چھتیس",
            "سینتیس",
            "اڑتیس",
            "انتالیس",
            "چالیس",
            "اکتالیس",
            "بیالیس",
            "تینتالیس",
            "چوالیس",
            "پینتالیس",
            "چھیالیس",
            "سینتالیس",
            "اڑتالیس",
            "انچاس",
            "پچاس",
            "اکیاون",
            "باون",
            "ترپن",
            "چون",
            "پچپن",
            "چھپن",
            "ستاون",
            "اٹھاون",
            "انسٹھ",
            "ساٹھ",
            "اکسٹھ",
            "باسٹھ",
            "تریسٹھ",
            "چونسٹھ",
            "پینسٹھ",
            "چھیاسٹھ",
            "سڑسٹھ",
            "اڑسٹھ",
            "انہتر",
            "ستر",
            "اکہتر",
            "بہتر",
            "تہتر",
            "چوہتر",
            "پچھتر",
            "چھہتر",
            "ستتر",
            "اٹھہتر",
            "اناسی",
            "اسی",
            "اکیاسی",
            "بیاسی",
            "تراسی",
            "چوراسی",
            "پچاسی",
            "چھیاسی",
            "ستاسی",
            "اٹھاسی",
            "نواسی",
            "نوے",
            "اکیانوے",
            "بیانوے",
            "ترانوے",
            "چورانوے",
            "پچانوے",
            "چھیانوے",
            "ستانوے",
            "اٹھانوے",
            "نناوے",
            "سو",

            "ہزار",
            "لاکھ",
            "کروڑ",
            "ارب",
            "کھرب",
            "نیل",
            "پدم"
    ];
	
    const HUNDRED = 100;
    const THOUSAND = self::HUNDRED+1;
    const LAKH = self::THOUSAND+1;
    const KAROR = self::LAKH+1;
    const AREB = self::KAROR+1;
    const KHAREB = self::AREB+1;
    const NEEL = self::KHAREB+1;
    const PADAM = self::NEEL+1;
    const SANKH = self::PADAM+1;
    
    const MAX_VALUE = PHP_INT_MAX; //10000000000000;
	
    private static $limits = [
        100,			// so 
        1000, 			// hazar
        100000, 		// lakh
        10000000, 		// karor
        1000000000, 		// areb
        100000000000, 		// khareb
        10000000000000,         // neel
        1000000000000000,	// padam
        100000000000000000	// sankh
    ];
	
	
    const LIMIT_HUNDRED = 0;
    const LIMIT_THOUSAND = self::LIMIT_HUNDRED+1;
    const LIMIT_LAKH = self::LIMIT_THOUSAND+1;
    const LIMIT_KAROR = self::LIMIT_LAKH+1;
    const LIMIT_AREB = self::LIMIT_KAROR+1;
    const LIMIT_KHAREB = self::LIMIT_AREB+1;
    const LIMIT_NEEL = self::LIMIT_KHAREB+1;
    const LIMIT_PADAM = self::LIMIT_NEEL+1;
    const LIMIT_SANKH = self::LIMIT_PADAM+1;
		
    public static function getUrdu($val) {
        if ((gettype($val) == "integer") || (gettype($val) == "double")) {
            // must be positive
            if ($val < 0) {
                $neg = "منفی";
                $num = UrduNumber::getUrdu(abs($val));
                return $neg . " " . $num; 
            }

            //echo "integer or double";
            if ($val < 100000000000000000 ) { //self::MAX_VALUE 
                if ($val <= self::$limits[self::LIMIT_HUNDRED]) {
                    return self::getUrduDec($val);
                } else if ($val < self::$limits[self::LIMIT_THOUSAND])
                    return self::getUrduHundred($val);
                else if ($val < self::$limits[self::LIMIT_LAKH]) {
                    return self::getUrduThousand($val);
                } else if ($val < self::$limits[self::LIMIT_KAROR])
                    return self::getUrduLakh($val);
                else if ($val < self::$limits[self::LIMIT_AREB]) {
                    return self::getUrduKaror($val);
                } else if ($val < self::$limits[self::LIMIT_KHAREB]) {
                    return self::getUrduAreb($val);
                }

                //else if ($val < limits[LIMIT_NEEL]) return UrduKhareb($val);
                //else if ($val < limits[LIMIT_PADAM]) return UrduNeel($val);
                //else if ($val < limits[LIMIT_SANKH]) return UrduPadam($val);
                //else return UrduSankh($val);
                else {
                    return self::getUrduKhareb($val);
                }
            }
        } else if (gettype($val) == 'string') {
            //echo gettype($val);
            return UrduNumber::getUrdu(floatval($val));
        }
        
        
        return (string)$val;
    }
    
    public static function showLimits() {
        foreach(self::$limits as $lim) {
            echo gettype($lim) . " ==> " . $lim . "\n";
        }
    }
    
    public static function getUrduFloat($val) {
        if (gettype($val) == "float") {
            if ($val < self::$limits[self::LIMIT_KAROR]) {
                // use integer method
                return self::getUrdu(intval($val));
            } else {
                
            }
        }
        
        return (string)$val;
    }
	
    // number range 1 .. 100
    private static function getUrduDec($val) {
        if ($val <= self::$limits[self::LIMIT_HUNDRED]) return self::$urdu[(int)$val];
        return String.valueOf($val); 
    }

    // numbers range 101..1000
    private static function getUrduHundred($val) {
        if ($val < self::$limits[self::LIMIT_THOUSAND]) {
            $factor = self::$limits[self::LIMIT_HUNDRED];
            $h = (int)($val / $factor);
            $d = (int)($val % $factor);

            $sh = self::$urdu[$h];
            $sd = $d > 0 ? self::$urdu[$d] : "";

            $res = $sh." ".self::$urdu[self::HUNDRED]." ".$sd;
            return $res;
        }
        return String.valueOf($val);
    }

	// numbers range 1001..100000
	private static function getUrduThousand($val) {
            if ($val < self::$limits[self::LIMIT_LAKH]) {
                    $factor = self::$limits[self::LIMIT_THOUSAND];
                    $t = (int)($val / $factor);
                    $h = (int)($val % $factor);

                    $st = self::$urdu[$t];
                    $sh = $h > 0 ? self::getUrdu($h) : "";

                    $res = $st." ".self::$urdu[self::THOUSAND]." ".$sh;
                    return $res;
            }
            return String.valueOf($val);
	}
	
	private static function getUrduLakh($val) {
		if ($val < self::$limits[self::LIMIT_KAROR]) {
			$factor = self::$limits[self::LIMIT_LAKH];
			$h = (int)($val / $factor);
			$d = (int)($val % $factor);
			
			$st = self::getUrdu($h);
			$sh = $d > 0 ? self::getUrdu($d) : "";
			
			$res = $st." ".self::$urdu[self::LAKH]." ".$sh;
			return $res;
		}
		return String.valueOf($val);
	}

	private static function getUrduKaror($val) {
		if ($val < self::$limits[self::LIMIT_AREB]) {
			$factor = self::$limits[self::LIMIT_KAROR];
			$h = (int)($val / $factor);
			$d = (int)($val % $factor);
			
			$st = self::getUrdu($h);
			$sh = $d > 0 ? self::getUrdu($d) : "";
			
			$res = $st." ".self::$urdu[self::KAROR]." ".$sh;
			return $res;
		}
		return String.valueOf($val);
	}
	
	private static function getUrduAreb($val) {
		if ($val < self::$limits[self::LIMIT_KHAREB]) {
			$factor = self::$limits[self::LIMIT_AREB];
                        
			//$h = (int)($val / $factor);
			//$d = (int)($val % $factor);
                        $h = ($val / $factor);
			$d = fmod($val,$factor);
                        
			$st = self::getUrdu($h);
			$sh = $d > 0 ? self::getUrdu($d) : "";
			
			$res = $st." ".self::$urdu[self::AREB]." ".$sh;
			return $res;
		}
		return String.valueOf($val);
	}
	
	private static function getUrduKhareb($val) {
		$factor = self::$limits[self::LIMIT_KHAREB];
		$h = ($val / $factor);
		$d = fmod($val,$factor);
		
                echo "\n";
                echo strval($val)."\n";
                echo $val."\n";
                echo "AA ".$h."--".$d;
                        
		$st = self::getUrdu($h);
		$sh = $d > 0 ? self::getUrdu($d) : "";
		
		$res = $st." ".self::$urdu[self::KHAREB]." ".$sh;
		return $res;
	}
	
	public static function getUrduIndex($i) {
		if ($i < self::$urdu.length) {
                    return self::$urdu[$i];
                } else {
                    return "عرر";
                }
	}
}