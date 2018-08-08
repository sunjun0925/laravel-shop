<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    //批量赋值白名单
    protected $fillable = [
        'province',
        'city',
        'district',
        'address',
        'zip',
        'contact_name',
        'contact_phone',
        'last_used_at',
    ];
    
    protected $dates = ['last_used_at'];
    
    /**
     * 关联关系是一对多（一个 User 可以有多个 UserAddress，一个 UserAddress 只能属于一个 User）
     */
    public function user()
    {
        $this->belongsTo(User::class);
    }
    
    /**
     * @return string  获取完整的地址
     */
    public function getFullAddressAttribute()
    {
        return "{$this->province}{$this->city}{$this->district}{$this->address}";
    }
}
