@extends('admin.layout.tabLayout')

@section('crumbs')
    <div class="x-nav">
        <span class="layui-breadcrumb">
            <a href="">首页</a>
            <a>
                <cite>角色管理</cite>
            </a>
        </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
            <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i>
        </a>
    </div>
@endsection

@section('content')
    <div class="layui-fluid">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-body">
                        <div class="layui-inline layui-show-xs-block">
                            <button class="layui-btn" onclick="xadmin.open('添加角色','{{asset('admin/role/create')}}',600,500)"><i class="layui-icon"></i>添加</button>
                        </div>
                        <form action="{{asset('admin/role')}}">
                            <div class="layui-inline layui-show-xs-block">
                                <input type="text" name="keyword" value="{{$keyword}}" placeholder="角色名称" autocomplete="off" class="layui-input">
                            </div>
                            <div class="layui-inline layui-show-xs-block">
                                <button class="layui-btn" type="submit" lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
                            </div>
                        </form>

                    </div>
                    <div class="layui-card-body ">
                        <table class="layui-table layui-form">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>角色</th>
                                <th>描述</th>
                                <th>排序</th>
                                <th>操作</th>
                            </thead>
                            <tbody>
                            @if($data->total() > 0)
                            @foreach($data as $v)
                                <tr>
                                    <td>{{$v['id']}}</td>
                                    <td>{{$v['name']}}</td>
                                    <td>{{$v['description']}}</td>
                                    <td>{{$v['sort']}}</td>
                                    <td class="td-manage">
                                        <button class="layui-btn layui-btn layui-btn-xs"
                                                onclick="xadmin.open('权限配置','{{asset('admin/role/' . $v['id'] . '/permission')}}', 600, 500)" >
                                            <i class="layui-icon">&#xe642;</i>权限配置
                                        </button>
                                        <button class="layui-btn layui-btn layui-btn-xs"
                                                onclick="xadmin.open('编辑','{{asset('admin/role/' . $v['id'] . '/edit')}}', 600, 500)" >
                                            <i class="layui-icon">&#xe642;</i>编辑
                                        </button>
                                        <button class="layui-btn-danger layui-btn layui-btn-xs"  onclick="member_del(this,'{{$v['id']}}')" href="javascript:;" >
                                            <i class="layui-icon">&#xe640;</i>删除
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td colspan="5" align="center">暂无数据</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    @if($data->lastPage() > 1)
                        {{$data->appends(['keyword' => $request->keyword])->links('admin.layout.page', ['data' => $data])}}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>

        /*用户-删除*/
        function member_del(obj,id){
            layer.confirm('确认要删除吗？',function(index){
                //发异步删除数据
                $.ajax({
                    url: '{{asset('admin/role')}}/' + id,
                    type: 'DELETE',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (json) {
                        if (json.code == 200) {
                            $(obj).parents("tr").remove();
                            layer.msg('已删除!',{icon:1, time:1000});
                        } else {
                            layer.msg('删除失败',{icon:6, time:1000});
                        }
                    }
                });
            });
        }

    </script>
@endsection