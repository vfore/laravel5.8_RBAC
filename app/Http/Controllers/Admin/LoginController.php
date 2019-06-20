<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * 登录视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.login');
    }

    /**
     * 登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            'code' => 'required|captcha',
        ], [
            'username' => '手机或邮箱不能为空',
            'password' => '密码不能为空',
            'code.required' => '验证码不能为空',
            'code.captcha' => '验证码错误'
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => '500', 'msg' => $validator->errors()->first()]);
        }

        $credentials['phone'] = $request->username;
        $credentials['password'] = $request->password;
        $credentials['status'] = 1;
        if (Auth::guard('admin')->attempt($credentials)) {
            return response()->json(['code' => 200, 'msg' => '', 'url' => route('admin.index')]);
        } else {
            unset($credentials['phone']);
            $credentials['email'] = $request->username;
            if (Auth::guard('admin')->attempt($credentials)) {
                return response()->json(['code' => 200, 'msg' => '', 'url' => route('admin.index')]);
            } else {
                return response()->json(['code' => 500, 'msg' => '用户名或密码错误']);
            }
        }

    }

    /**
     * 登出
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect(route('admin.login'));
    }
}
