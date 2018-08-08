<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAddressRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use App\Models\UserAddress;

class UserAddressesController extends Controller
{
    /**
     * 收货地址列表
     * @param Request $request
     * @return  view
     */
    public function index(Request $request)
    {
        return view('user_addresses.index', [
            'addresses' => $request->user()->addresses
        ]);
    }
    
    /**
     * 用户新增收货地址页面
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('user_addresses.create_and_edit', ['address' => new UserAddress()]);
    }
    
    /**
     * 保存用户新增收货地址
     * @param UserAddressRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserAddressRequest $request)
    {
        $request->user()->addresses()->create($request->only([
            'province',
            'city',
            'district',
            'address',
            'zip',
            'contact_name',
            'contact_phone',
        ]));
        
        return redirect()->route('user_addresses.index');
    }
    
    /**
     * 收货地址修改页面
     * @param UserAddress $user_address
     * @return \Illuminate\View\View
     */
    public function edit(UserAddress $user_address)
    {
        $this->authorize('own', $user_address);
        
        return view('user_addresses.create_and_edit', ['address' => $user_address]);
    }
    
    /**
     * 收货地址修改提交
     * @param UserAddress $user_address
     * @param UserAddressRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserAddress $user_address, UserAddressRequest $request)
    {
        $this->authorize('own', $user_address);
        
        $user_address->update($request->only([
            'province',
            'city',
            'district',
            'address',
            'zip',
            'contact_name',
            'contact_phone',
        ]));
        
        return redirect()->route('user_addresses.index');
    }
    
    public function destroy(UserAddress $user_address)
    {
        $this->authorize('own', $user_address);
        
        $user_address->delete();
        
        return [];
    }
    
    
}
