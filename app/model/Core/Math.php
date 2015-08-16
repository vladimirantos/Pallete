<?php
namespace App\Model\Core;

/**
 * @author Vladimír Antoš
 * @version 1.0.0
 */
final class Math extends SObject{
    const PI = 3.14159265358979323846264338327950288419716939937510;

    const E = 2.71828182845904523536028747135266249775724709369996;

    const SQRT2 = M_SQRT2;

    const STD_PRECISION = 2;

    const H_PRECISION = 8;

    /**
     * @throw StaticClassException
     */
    public function __construct(){
        throw new StaticClassException(__CLASS__." is static class");
    }

    /**
     * Sečte zadané hodnoty.
     * @params int|array
     * @return int
     */
    public static function add(){
        $args = func_get_args();
        $result = 0;
        for($i = 0; $i< count($args); $i++)
        {
            if(!is_array($args[$i]))
                $result += $args[$i];
            else $result += array_sum($args[$i]);
        }
        return $result;
    }

    /**
     * Vynásobí zadané hodnoty
     * @params int|array
     * @return int
     */
    public static function multiply(){
        $args = func_get_args();
        $r = 1;
        for($i = 0; $i < count($args); $i++){
            if(!is_array($args[$i]))
                $r = $r * $args[$i];
            else $r *= forward_static_call_array(array(__CLASS__, "multiply"), $args[$i]);
        }
        return $r;
    }

    /**
     * @return float
     */
    public static function avg(){
        $args = func_get_args();
        $args = is_array($args[0]) ? $args[0] : $args;
        return self::add($args) / count($args);
    }

    /**
     * Vrací maximální hodnotu ze dvou zadaných.
     * Pokud je první parametr pole a druhý není zadán, vrací maximální hodnotu z pole.
     * @param int|array $a
     * @param int $b
     * @return int|array
     */
    public static function max($a, $b = null){
        if(is_array($a) && $b == null)
            return call_user_func_array("max", $a);
        return max($a, $b);
    }

    /**
     * Vrací minimální hodnotu ze dvou zadaných.
     * Pokud je první parametr pole a druhý není zadán, vrací minimální hodnotu z pole.
     * @param int|array $a
     * @param int $b
     * @return int|array
     */
    public static function min($a, $b = null){
        if(is_array($a) && $b == null)
            return call_user_func_array("min", $a);
        return min($a, $b);
    }

    /**
     * @param int $x
     * @return int
     */
    public static function inv($x){
        if(is_array($x))
            return array_map(function($a){return self::inv($a);}, $x);
        return $x * -1;
    }

    /**
     * @param int|array $x
     * @return int
     */
    public static function abs($x){
        if(is_array($x))
            return array_map(function($a){return self::abs($a);}, $x);
        return $x < 0 ? $x * - 1 : $x;
    }

    /**
     * Převede zadané číslo na kladné. Pokud je menší než 0, funkce vrací nulu.
     * @param int $x
     * @return int
     */
    public static function positive($x){
        return $x < 0 ? 0 : $x;
    }

    /**
     * @param $base
     * @param $exp
     * @return number
     */
    public static function pow($base, $exp){
        return pow($base, $exp);
    }

    /**
     * @param $base
     * @return number
     */
    public static function powTwo($base){
        return self::pow($base, 2);
    }

    /**
     * @param float $x
     * @return float
     */
    public static function sin($x){
        return sin($x);
    }

    /**
     * @param float $x
     * @return float
     */
    public static function cos($x){
        return cos($x);
    }

    /**
     * @param float $x
     * @return float
     */
    public static function tan($x){
        return tan($x);
    }

    /**
     * @param float $x
     * @param int $base
     * @return float
     */
    public static function log($x, $base = null){
        return log($x, $base);
    }

    /**
     * @param float $x
     * @return float
     */
    public static function ln($x){
        return self::log($x, 10);
    }

    /**
     * @param float $x
     * @return float
     */
    public static function sqrt($x){
        return sqrt($x);
    }

    /**
     * Přesnost 16 desetinných míst
     * @param float $x
     * @param int $precision
     * @return int
     */
    public static function round($x, $precision = Math::STD_PRECISION){
        return round($x, $precision);
    }

    /**
     * Zaokrouhlí na nejbližší nižší celé číslo
     * @param $x
     * @return float
     */
    public static function floor($x){
        return floor($x);
    }

    /**
     * Zaokrouhlí na nejbližší celé vyšší číslo
     * @param float $x
     * @return float
     */
    public static function ceil($x){
        return ceil($x);
    }

    /**
     * @param int $x
     * @return bool
     */
    public static function isNan($x){
        return is_nan($x);
    }

    /**
     * Vrací pole s nejmenší a největší hodnotou v zadaném poli.
     * @param array $x
     * @return array
     */
    public static function minMax(array $x){
        return [min($x), max($x)];
    }

    /**
     * Vrací pole čísel mezi $min a $max (včetně). Pokud je zadán parametr $callback,
     * vrací výsledky zadané funkce od $min do $max.
     * @param int $min
     * @param int $max
     * @return array
     * @throws ArgumentException Parametr $callback není funkce
     */
    public static function range($min, $max, $callback = null){
        $x = [];
        if($callback == null)
            for($i = $min; $i <= $max; $i++)
                $x[] = $i;
        else
            for($i = $min; $i <= $max; $i++)
                $x[] = self::polynom($callback, $i);
        return $x;
    }

    /**
     * Vrací součet čísel od $min do $max.
     * @param int $min
     * @param int $max
     * @return int
     */
    public static function sumRange($min, $max){
        $x = 0;
        for($i = $min - 1; $i <= $max; $i++)
            $x += $i;
        return $x;
    }

    /**
     * Vrací součin čísel od $min do $max.
     * @param $min
     * @param $max
     * @return int
     */
    public static function mulRange($min, $max){
        $x = 0;
        for($i = $min - 1; $i <= $max; $i++)
            $x *= $i;
        return $x;
    }

    /**
     * Zjistí hodnotu zadaného polynomu.
     * @param $callback
     * @param float $args
     * @return int|float
     * @throws ArgumentException
     */
    public static function polynom(){
        $args = func_get_args();
        $callback = $args[0];
        unset($args[0]);
        if(!is_callable($callback))
            throw new ArgumentException("Param must be a function");
        return forward_static_call_array($callback, $args);
    }

    /**
     * Vrací výsledky 2^$x.
     * @param $x
     * @return number
     */
    public static function binFunc($x){
        return Math::pow(2, $x);
    }

    /**
     * @param int $a
     * @param int $b
     * @param int $c
     * @param int $x
     * @return int
     */
    public static function quadEquation($a, $b, $c, $x){
        return $a * Math::pow($x, 2) + $b * $x + $c;
    }

    /**
     * Zjistí jestli je číslo liché
     * @param int $x
     * @return bool
     */
    public static function isOdd($x){
        return (bool)($x & 1);
    }

    /**
     * Zjistí jestli je číslo sudé.
     * @param int $x
     * @return bool
     */
    public static function isEven($x){
        return !($x & 1);
    }

    /**
     * @param float $degree
     * @return float
     */
    public static function degreeToRadians($degree){
        return $degree * (Math::PI / 180);
    }

    /**
     * @param float $radians
     * @return float
     */
    public static function radiansToDegree($radians){
        return $radians * (180 / Math::PI);
    }
}

/**
 * @author Vladimír Antoš
 * @version 1.0.0
 */
class Random extends SObject{

    /**
     * @throw StaticClassException
     */
    public function __construct(){
        throw new StaticClassException(__CLASS__." is static class");
    }

    /**
     * @return int
     */
    public static function next()
    {
        $args = func_get_args();
        if(count($args) == 2 )
            return (int)mt_rand( $args[0], $args[1] );
        elseif( count($args) == 1)
            return (int)mt_rand( 0, $args[0] );
        else
            return (int)mt_rand();
    }

    /**
     * @return float
     */
    public static function nextReal()
    {
        $args = func_get_args();
        $min = $args[0];
        $max = $args[1];
        return (float)($min + ($max - $min) * (mt_rand() / mt_getrandmax()));//return ($min+lcg_value()*(abs($max-$min)));
    }

    /**
     * @param $min
     * @param $max
     * @return double
     */
    public static function nextDouble($min, $max){
        $min /= PHP_INT_MAX;
        $max /= PHP_INT_MAX;
        return (int)self::nextReal($min, $max) * PHP_INT_MAX;
    }

    /**
     * Generuje pravděpodobnost v intervalu (0, 1)
     * @return float
     */
    public static function p(){
        return self::nextReal(0, 1);
    }
}
