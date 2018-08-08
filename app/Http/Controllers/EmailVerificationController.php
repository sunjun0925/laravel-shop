<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Notifications\EmailVerficationNotification;
use App\Models\User;
use Cache;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    /**
     * 邮箱激活验证
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     * @throws InvalidRequestException
     */
    public function verify(Request $request)
    {
        $email = $request->input('email');
        $token = $request->input('token');
        
        if(!$email || !$token) {
            throw new InvalidRequestException('激活链接不正确');
        }
        
        if($token != Cache::get('email_verification_'.$email)) {
            throw new InvalidRequestException('激活链接不正确或已过期');
        }
        
        if(!$user = User::where('email',$email)->first()) {
            throw new InvalidRequestException('用户不存在');
        }
        
        Cache::forget('email_verification_'.$email);
        
        $user->update(['email_verified'=> true]);
        
        return view('pages.success', ['msg'=>'邮箱验证成功']);
    }
    
    /**
     * 用户手动发送邮箱验证链接
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     * @throws InvalidRequestException
     */
    public function send(Request $request)
    {
        $user = $request->user();
        
        if($user->email_verified) {
            throw new InvalidRequestException('您已经验证过邮箱了');
        }
        
        $user->notify(new EmailVerficationNotification());
        
        return view('pages.success', ['msg'=>'邮件发送成功']);
    }
}
