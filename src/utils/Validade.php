<?php

class Validade{
    public static function isEmail($email){
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function isPassword($password){
        return preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password);
    }

    public static function isName($name){
        return preg_match('/^[a-zA-Z\s]+$/', $name);
    }

    public static function isPhone($phone){
        return preg_match('/^\(\d{2}\)\s\d{4,5}-\d{4}$/', $phone);
    }
    public static function isDate($date){
        return preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $date);
    }
    public static function required($data){
        return !empty($data);
    }
    public static function isNumber($number){
        return is_numeric($number);
    }

}