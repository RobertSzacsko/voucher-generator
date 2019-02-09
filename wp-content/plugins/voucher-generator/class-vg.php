<?php

class VG
{
    private static $instance = null;

    private function __construct()
    {

    }

    public static function get_instance()
    {
        if (self::$instance === null)
        {
            self::$instance = new VG();
        }
 
        return self::$instance;
    }
}