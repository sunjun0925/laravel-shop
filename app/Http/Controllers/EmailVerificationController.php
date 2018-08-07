<?php

namespace App\Http\Controllers;

use App\Notifications\EmailVerficationNotification;
use Exception;
use App\Models\User;
use Cache;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    //邮箱激活链接验证
    public function verify(Request $request)
    {
        $email = $request->input('email');
        $token = $request->input('token');
        
        if(!$email || !$token) {
            throw new Exception('激活链接不正确');
        }
        
        if($token != Cache::get('email_verification_'.$email)) {
            throw new Exception('激活链接不正确或已过期');
        }
        
        if(!$user = User::where('email',$email)->first()) {
            throw new Exception('用户不存在');
        }
        
        Cache::forget('email_verification_'.$email);
        
        $user->update(['email_verified'=> true]);
        
        return view('pages.success', ['msg'=>'邮箱验证成功']);
    }
    
    public function send(Request $request)
    {
        $user = $request->user();
        
        if($user->email_verified) {
            throw new Exception('邮箱已激活');
        }
        
        $user->notify(new EmailVerficationNotification());
        
        return view('pages.success', ['msg'=>'邮件发送成功']);
    }
}
