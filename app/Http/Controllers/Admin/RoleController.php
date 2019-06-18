<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Role\RoleRequest;
use App\Models\AdminPermission;
use App\Models\AdminRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * 角色管理
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $data = AdminRole::where('name', 'like', '%'. $keyword . '%')->orderBy('id', 'desc')->paginate(15);
        return view('admin.role.index', compact('data', 'request', 'keyword'));
    }

    /**
     * 角色新增视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.role.create');
    }

    /**
     * 角色新增处理
     * @param RoleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RoleRequest $request, AdminRole $role)
    {
        if (AdminRole::create($request->all())) {
            return response()->json(['code' => 200, 'result' => 'success', 'msg' => '保存成功']);
        } else {
            return response()->json(['code' => 500, 'result' => 'fail', 'msg' => '保存失败']);
        }
    }

    /**
     * 权限配置视图
     * @param AdminRole $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function permission(AdminRole $role)
    {
        $data = AdminPermission::where('pid', 0)->with('children')->get()->toArray();

        foreach ($data as &$v) {
            $_tmpArr = [];
            if (empty($v['children'])) {
                continue;
            }

            foreach ($v['children'] as $key => $item) {
                $children = AdminPermission::where('pid', $item['id'])->get()->toArray();
                array_unshift($children, $item);
                $_tmpArr = array_merge($_tmpArr,$children);
            }
            $v['children'] = $_tmpArr;
        }
        $ownPermission = $role->permissions->toArray();
        $ownPermission = array_column($ownPermission, 'id');
        return view('admin.role.permission', compact('data', 'ownPermission', 'role'));
    }

    /**
     * 权限配置处理
     * @param Request $request
     * @param AdminRole $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function permissionConfiguration(Request $request, AdminRole $role)
    {
        $permissionData = AdminPermission::findMany($request->admin_permission_id);
        $permissions = $role->permissions;
        $insertData = $permissionData->diff($permissions);
        foreach ($insertData as $v) {
            $role->grantPermission($v);
        }
        $delData = $permissions->diff($permissionData);
        foreach ($delData as $v) {
            $role->deletePermission($v);
        }
        return response()->json(['code' => 200, 'result' => 'success', 'msg' => '保存成功']);
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
     * 角色编辑视图
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $data = AdminRole::where('id', $id)->first();
        return view('admin.role.edit')->with(['data' => $data, 'id' => $id]);
    }

    /**
     * 角色编辑处理
     * @param RoleRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RoleRequest $request, $id)
    {

        if (AdminRole::where('id', $id)->update($request->all())) {
            return response()->json(['code' => 200, 'result' => 'success', 'msg' => '保存成功']);
        } else {
            return response()->json(['code' => 500, 'result' => 'fail', 'msg' => '保存失败']);
        }
    }

    /**
     * 删除角色
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if (AdminRole::destroy($id)) {
            return response()->json(['code' => 200, 'result' => 'success', 'msg' => '已删除']);
        } else {
            return response()->json(['code' => 500, 'result' => 'fail', 'msg' => '删除失败']);
        }
    }
}
