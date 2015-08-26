<?php
namespace App\Model;

/**
 * Class Languages
 * @author Vladimír Antoš
 * @version 1.0
 * @package App\Model
 */
class Languages
{
    const CS = 'cs';
    const EN = 'en';
    const DE = 'de';

    public static function toArray(){
        return [self::CS => self::CS, self::DE => self::DE, self::EN => self::EN];
    }
}