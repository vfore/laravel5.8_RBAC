<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
