<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Throwable;

/**
 * Class InvalidRequestException   用户异常处理类
 * USER  SunJun
 * TIME  10:07
 * @package App\Exceptions
 */
class InvalidRequestException extends Exception
{
    //
    public function __construct(string $message = "", int $code = 400)
    {
        parent::__construct($message, $code);
    }
    
    public function render(Request $request)
    {
        //判断是否是AJAX请求,是AJAX请求返回一个JSON数据否则返回一个错误页面
        if($request->expectsJson()) {
            return response()->json(['msg'=>$this->message], $this->code);
        }
        
        return view('pages.error', ['msg' => $this->message]);
    }
}
