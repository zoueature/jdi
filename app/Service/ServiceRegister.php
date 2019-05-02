<?php
/*
 | ------------------------------
 | User: Zoueature
 | Date: 2019/4/24
 | Time: 17:01
 | ------------------------------
 */

namespace App\Service;


class ServiceRegister
{
    public static function register()
    {
        return [
              //MyNamespace\MyClass::class => Closure or MyNamespace\MyClass::class
        ];
    }

    public static function single()
    {
        return [
            //MyNamespace\MyClass::class => true or false
        ];
    }
}