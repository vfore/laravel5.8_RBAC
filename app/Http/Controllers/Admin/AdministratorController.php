<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AdminUser\AdministratorRequest;
use App\Models\Administrator;
use App\Models\AdminRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdministratorController extends Controller
{
    /**
     * 管理员列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $data = Administrator::where('phone', 'like', '%'. $keyword . '%')
            ->orWhere('email', 'like', '%' . $keyword . '%')
            ->orderBy('id', 'desc')
            ->select('id', 'nickname', 'phone', 'email', 'status')
            ->with('roles')
            ->paginate(15);
        return view('admin.administrator.index', compact('data', 'request', 'keyword'));
    }

    /**
     * 新增管理员视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $data = AdminRole::get()->toArray();
        return view('admin.administrator.create', compact('data'));
    }

    /**
     * 新增管理员
     * @param AdministratorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AdministratorRequest $request)
    {
        $requestData = $request->all();
        // hash加密
        $requestData['password'] = bcrypt($requestData['password']);
        // 新增用户
        $administrator = Administrator::create($requestData);
        if ($administrator) {

            $roles = AdminRole::findMany($request->admin_role_id);
            $ownRoles = $administrator->roles; // 已拥有角色
            // 获取选择中未拥有的角色
            $insertRoles = $roles->diff($ownRoles);
            // 分配用户
            foreach ($insertRoles as $role) {
                $administrator->assignRole($role);
            }

            return response()->json(['code' => 200, 'result' => 'success', 'msg' => '保存成功']);
        } else {
            return response()->json(['code' => 500, 'result' => 'fail', 'msg' => '保存失败']);
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
        $data = Administrator::where('id', $id)->first();
        $roles = AdminRole::get()->toArray();
        $ownRoles = $data->roles->toArray(); // 拥有角色
        $ownRoles = array_column($ownRoles, 'id');
        return view('admin.administrator.edit', compact('data', 'id', 'roles', 'ownRoles'));
    }

    /**
     * 修改数据处理
     * @param AdministratorRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AdministratorRequest $request, $id)
    {
       $data = $request->except(['role', 'admin_role_id']);
       if ($request->password) {
            $data['password'] = bcrypt($request->password);
       } else {
           unset($data['password']);
       }

       if (Administrator::where('id', $id)->update($data)) {
           $administrator = Administrator::where('id', $id)->first();
           $roles = AdminRole::findMany($request->admin_role_id);
           $ownRoles = $administrator->roles; // 已拥有角色
           // 获取选择中未拥有的角色
           $insertRoles = $roles->diff($ownRoles);
           // 分配用户
           foreach ($insertRoles as $role) {
               $administrator->assignRole($role);
           }

           $delRoles = $ownRoles->diff($roles);
            // 删除未选择但已有的角色
            foreach ($delRoles as $v) {
                $administrator->deleteRole($v);
            }

           return response()->json(['code' => 200, 'result' => 'success', 'msg' => '保存成功']);
       } else {
           return response()->json(['code' => 500, 'result' => 'fail', 'msg' => '保存失败']);
       }
    }

    /**
     * 删除
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if (Administrator::destroy($id)) {
            return response()->json(['code' => 200, 'msg' => '已删除']);
        } else {
            return response()->json(['code' => 500, 'msg' => '删除失败']);
        }
    }
}
