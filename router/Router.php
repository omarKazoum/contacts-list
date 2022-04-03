<?php

class Router
{
    static  private $instance=null;

    private function __construct()
    {

    }
    static function init(){
        if(self::$instance==null)
            self::$instance=new Router();

    }

    public static function get($path,$fun){

    }


}