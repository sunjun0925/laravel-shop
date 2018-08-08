<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

/**
 * Class InternalException   系统内部错误异常类
 * USER  SunJun
 * TIME  10:27
 * @package App\Exceptions
 */
class InternalException extends Exception
{
    /**
     * 用户错误消息提示
     * @var
     */
    protected $msgForUser = '';
    
    
    public function __construct(string $message = "",string $msgForUser = "系统内部错误", int $code = 500)
    {
        
        parent::__construct($message, $code);
        
        $this->msgForUser = "系统内部错误";
        
    }
    
    public function render(Request $request)
    {
        
        if($request->expectsJson()) {
            
            return response()->json(['msg'=>$this->msgForUser], $this->code);
            
        }
        
        return view('pages.error', ['msg' => $this->msgForUser]);
    }
}
