<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Permission\PermissionRequest;
use App\Models\AdminPermission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    /**
     * 权限列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $data = AdminPermission::where('name', 'like', '%' . $keyword . '%')->orderBy('id', 'desc')->paginate(15);
        return view('admin.permission.index', compact('data', 'request', 'keyword'));
    }

    /**
     * 权限新增视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        if (AdminPermission::create($request->all())) {
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
     * 权限修改视图
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $data = AdminPermission::find($id);
        return view('admin.permission.edit', compact('data', 'id'));
    }

    /**
     * 权限修改处理
     * @param PermissionRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PermissionRequest $request, $id)
    {
        if (AdminPermission::where('id', $id)->update($request->all())) {
            return response()->json(['code' => 200, 'result' => 'success', 'msg' => '保存成功']);
        } else {
            return response()->json(['code' => 500, 'result' => 'fail', 'msg' => '保存失败']);
        }
    }

    /**
     * 权限删除
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if (AdminPermission::destroy($id)) {
            return response()->json(['code' => 200, 'result' => 'success', 'msg' => '已删除']);
        } else {
            return response()->json(['code' => 500, 'result' => 'fail', 'msg' => '删除失败']);
        }
    }
}
