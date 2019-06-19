@extends('admin.layout.tabLayout')

@section('crumbs')
    <div class="x-nav">
        <span class="layui-breadcrumb">
            <a href="">首页</a>
            <a>
                <cite>管理员列表</cite>
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
                            <button class="layui-btn" onclick="xadmin.open('添加','{{asset('admin/administrator/create')}}',600,500)"><i class="layui-icon"></i>添加</button>
                        </div>
                        <form action="{{asset('admin/administrator')}}">
                            <div class="layui-inline layui-show-xs-block">
                                <input type="text" name="keyword" value="{{$keyword}}" placeholder="手机/邮箱" autocomplete="off" class="layui-input">
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
                                <th>昵称</th>
                                <th>手机</th>
                                <th>邮箱</th>
                                <th>角色</th>
                                <th>状态</th>
                                <th>操作</th>
                            </thead>
                            <tbody>
                            @if($data->total() > 0)
                            @foreach(($data->toArray())['data'] as $v)
                                <tr>
                                    <td>{{$v['id']}}</td>
                                    <td>{{$v['nickname']}}</td>
                                    <td>{{$v['phone']}}</td>
                                    <td>{{$v['email']}}</td>
                                    <td>
                                        @if(!empty($v['roles']))
                                            @foreach($v['roles'] as $k => $item)
                                                @if($k < count($v['roles']) - 1)
                                                    {{$item['name'] . ','}}
                                                @else
                                                    {{$item['name']}}
                                                @endif
                                            @endforeach
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="td-status">
                                        <span class="layui-btn layui-btn-normal layui-btn-mini {{$v['status'] == 1 ? '' : 'layui-btn-disabled'}}">{{$v['status'] == 1 ? '已启用' : '已停用'}}</span>
                                    </td>
                                    <td class="td-manage">
                                        <button class="layui-btn layui-btn layui-btn-xs"
                                                onclick="xadmin.open('编辑','{{asset('admin/administrator/' . $v['id'] . '/edit')}}', 600, 500)" >
                                            <i class="layui-icon">&#xe642;</i>编辑
                                        </button>
                                        <button class="layui-btn-danger layui-btn layui-btn-xs" onclick="member_del(this,'{{$v['id']}}')" href="javascript:;" >
                                            <i class="layui-icon">&#xe640;</i>删除
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td colspan="7" align="center">暂无数据</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    @if($data['last_page'] > 1)
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
                    url: '{{asset('admin/administrator')}}/' + id,
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