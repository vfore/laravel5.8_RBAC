<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AdminUser\AdministratorRequest;
use App\Models\Administrator;
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
        $data = Administrator::where('phone', 'like', '%'. $keyword . '%')->orderBy('id', 'desc')->paginate(15);
        return view('admin.administrator.index', compact('data', 'request', 'keyword'));
    }

    /**
     * 新增管理员视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.administrator.create');
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
        if (Administrator::create($requestData)) {
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
        return view('admin.administrator.edit', compact('data', 'id'));
    }

    /**
     * 修改数据处理
     * @param AdministratorRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AdministratorRequest $request, $id)
    {
       $data = $request->except('role');
       if ($request->password) {
            $data['password'] = bcrypt($request->password);
       } else {
           unset($data['password']);
       }
       if (Administrator::where('id', $id)->update($data)) {
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
