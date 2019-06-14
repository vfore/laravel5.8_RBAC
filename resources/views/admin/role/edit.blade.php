@extends('admin.layout.tabLayout')

@section('content')
    <div class="layui-fluid">
        <div class="layui-row">
            <form action="" method="post" class="layui-form layui-form-pane">
                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        <span class="x-red">*</span>角色名
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="name" name="name" required="" value="{{$data->name}}" lay-verify="name" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        排序
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="sort" name="sort" value="{{$data->sort}}" required="" lay-verify="name" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label for="desc" class="layui-form-label">
                        描述
                    </label>
                    <div class="layui-input-block">
                        <textarea placeholder="请输入内容" id="description" name="description" class="layui-textarea">{{$data->description}}</textarea>
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">
                        拥有权限
                    </label>
                    {{--<table  class="layui-table layui-input-block">--}}
                        {{--<tbody>--}}
                        {{--<tr>--}}
                            {{--<td>--}}
                                {{--<input type="checkbox" name="like1[write]" lay-skin="primary" lay-filter="father" title="用户管理">--}}
                            {{--</td>--}}
                            {{--<td>--}}
                                {{--<div class="layui-input-block">--}}
                                    {{--<input name="id[]" lay-skin="primary" type="checkbox" title="用户停用" value="2">--}}
                                    {{--<input name="id[]" lay-skin="primary" type="checkbox" value="2" title="用户删除">--}}
                                    {{--<input name="id[]" lay-skin="primary" type="checkbox" value="2" title="用户修改">--}}
                                    {{--<input name="id[]" lay-skin="primary" type="checkbox" value="2" title="用户改密">--}}
                                    {{--<input name="id[]" lay-skin="primary" type="checkbox" value="2" title="用户列表">--}}
                                    {{--<input name="id[]" lay-skin="primary" type="checkbox" value="2" title="用户改密">--}}
                                    {{--<input name="id[]" lay-skin="primary" type="checkbox" value="2" title="用户列表">--}}
                                    {{--<input name="id[]" lay-skin="primary" type="checkbox" value="2" title="用户改密">--}}
                                    {{--<input name="id[]" lay-skin="primary" type="checkbox" value="2" title="用户列表">--}}
                                {{--</div>--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>--}}

                                {{--<input name="id[]" lay-skin="primary" type="checkbox" value="2" title="文章管理" lay-filter="father">--}}
                            {{--</td>--}}
                            {{--<td>--}}
                                {{--<div class="layui-input-block">--}}
                                    {{--<input name="id[]" lay-skin="primary" type="checkbox" value="2" title="文章添加">--}}
                                    {{--<input name="id[]" lay-skin="primary" type="checkbox" value="2" title="文章删除">--}}
                                    {{--<input name="id[]" lay-skin="primary" type="checkbox" value="2" title="文章修改">--}}
                                    {{--<input name="id[]" lay-skin="primary" type="checkbox" value="2" title="文章改密">--}}
                                    {{--<input name="id[]" lay-skin="primary" type="checkbox" value="2" title="文章列表">--}}
                                {{--</div>--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                        {{--</tbody>--}}
                    {{--</table>--}}
                </div>

                <div class="layui-form-item">
                    <button class="layui-btn" lay-submit="" lay-filter="add">保存</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        layui.use(['form','layer'], function(){
            $ = layui.jquery;
            var form = layui.form
                ,layer = layui.layer;

            //自定义验证规则
            form.verify({
                name: function(value){
                    if(value.length == ''){
                        return '角色名不能为空';
                    }
                }
            });

            //监听提交
            form.on('submit(add)', function(data){
                console.log(data.field);
                //发异步，把数据提交给php
                $.ajax({
                    url: '{{asset("admin/role/" . $id)}}',
                    type: 'PUT',
                    data: data.field,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (json) {
                        if (json.code == 200) {
                            layer.alert(json.msg, {icon: 6}, function () {
                                //关闭当前frame
                                xadmin.close();
                                // 可以对父窗口进行刷新
                                xadmin.father_reload();
                            });
                        } else {
                            layer.alert("保存失败", {icon: 5});
                        }
                    },
                    error: function (json) {
                        layer.alert(json.responseJSON.msg, {icon: 5});
                    }
                });
                return false;
            });


            form.on('checkbox(father)', function(data){

                if(data.elem.checked){
                    $(data.elem).parent().siblings('td').find('input').prop("checked", true);
                    form.render();
                }else{
                    $(data.elem).parent().siblings('td').find('input').prop("checked", false);
                    form.render();
                }
            });
        });
    </script>
@endsection