<?php

/**
 * Created by PhpStorm.
 * User: SunJun
 * Date: 2018/8/7
 * Time: 11:50
 */


//将路由名称转换成CSS类名称
function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}