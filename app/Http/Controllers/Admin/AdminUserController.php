<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AdminUser\StoreAdminUser;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminUserController extends Controller
{
    /**
     * 管理员列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $data = AdminUser::where('phone', 'like', '%'. $keyword . '%')->orderBy('id', 'desc')->paginate(15);
        return view('admin.admin_user.list', compact('data', 'request', 'keyword'));
    }

    /**
     * 新增管理员视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.admin_user.create');
    }

    /**
     * 新增管理员
     * @param StoreAdminUser $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAdminUser $request)
    {
        $requestData = $request->all();
        // hash加密
        $requestData['password'] = bcrypt($requestData['password']);
        if (AdminUser::create($requestData)) {
            return response()->json(['code' => 200, 'result' => 'success', 'msg' => '新增成功']);
        } else {
            return response()->json(['code' => 500, 'result' => 'fail', 'msg' => '新增失败']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 修改页
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $data = AdminUser::where('id', $id)->first();
        return view('admin.admin_user.edit', compact('data', 'id'));
    }

    /**
     * 修改数据处理
     * @param StoreAdminUser $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreAdminUser $request, $id)
    {
       $data = $request->except('role');
       if ($request->password) {
            $data['password'] = bcrypt($request->password);
       } else {
           unset($data['password']);
       }
       if (AdminUser::where('id', $id)->update($data)) {
           return response()->json(['code' => 200, 'result' => 'success', 'msg' => '修改成功']);
       } else {
           return response()->json(['code' => 500, 'result' => 'fail', 'msg' => '修改失败']);
       }
    }

    /**
     * 删除
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if (AdminUser::destroy($id)) {
            return response()->json(['code' => 200, 'msg' => '已删除']);
        } else {
            return response()->json(['code' => 500, 'msg' => '删除失败']);
        }
    }
}
