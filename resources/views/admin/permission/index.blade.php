@extends('admin.layout.tabLayout')

@section('crumbs')
    <div class="x-nav">
        <span class="layui-breadcrumb">
            <a href="">首页</a>
            <a>
                <cite>权限管理</cite>
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
                            <button class="layui-btn" onclick="xadmin.open('添加','{{asset('admin/permission/create')}}?pid=0&level=1&path=0_',600,500)"><i class="layui-icon"></i>添加</button>
                        </div>
                        <form action="{{asset('admin/permission')}}">
                            <div class="layui-inline layui-show-xs-block">
                                <input type="text" name="keyword" value="{{$keyword}}" placeholder="权限名称" autocomplete="off" class="layui-input">
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
                                <th>权限名</th>
                                <th>路由</th>
                                <th>类型</th>
                                <th>操作</th>
                            </thead>
                            <tbody>
                            @foreach($data as $v)
                                <tr>
                                    <td>{{$v['id']}}</td>
                                    <td>
                                        {!! str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', mb_substr_count($v['path'], '_')) !!}|-
                                        {{$v['name']}}
                                    </td>
                                    <td>{{$v['route'] ? $v['route'] : '---'}}</td>
                                    <td>{{$typeName[$v['type']]}}</td>
                                    <td class="td-manage">
                                        <button class="layui-btn layui-btn layui-btn-xs"
                                                onclick="xadmin.open('编辑','{{asset('admin/permission/' . $v['id'] . '/edit')}}', 600, 500)" >
                                            <i class="layui-icon">&#xe642;</i>编辑
                                        </button>
                                        <button class="layui-btn layui-btn-warm layui-btn-xs"
                                                onclick="xadmin.open('添加','{{asset('admin/permission/create?pid=' . $v['id'] . '&level=' . ($v['level'] + 1) . '&path=' . $v['path'] . $v['id'] . '_')}}', 600, 500)" >
                                            <i class="layui-icon">&#xe642;</i>添加子栏目
                                        </button>
                                        <button class="layui-btn-danger layui-btn layui-btn-xs" onclick="member_del(this,'{{$v['id']}}')" href="javascript:;" >
                                            <i class="layui-icon">&#xe640;</i>删除
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
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
                    url: '{{asset('admin/permission')}}/' + id,
                    type: 'DELETE',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (json) {
                        if (json.code == 200) {
                            xadmin.father_reload();
                            // $(obj).parents("tr").remove();
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