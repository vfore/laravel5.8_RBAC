@extends('admin.layout.tabLayout')

@section('content')
    <div class="layui-fluid">
        <div class="layui-row">
            <form action="" method="post" class="layui-form layui-form-pane">
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">
                        权限配置
                    </label>
                    <table class="layui-table layui-input-block">
                        <tbody>
                        @foreach($data as $v)
                            <tr>
                                <td>
                                    <input type="checkbox" name="admin_permission_id[]" value="{{$v['id']}}"
                                           lay-skin="primary" lay-filter="father" title="{{$v['name']}}" {{in_array($v['id'], $ownPermission) ? 'checked' : ''}}>
                                </td>
                                <td>
                                    <div class="layui-input-block">
                                        @foreach($v['children'] as $item)
                                            {{--{{dump($item)}}--}}
                                            <input name="admin_permission_id[]" lay-skin="primary" type="checkbox"
                                                   title="{{$item['name']}}" value={{$item['id']}} {{in_array($item['id'], $ownPermission) ? 'checked' : ''}}>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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
        layui.use(['form', 'layer'], function () {
            $ = layui.jquery;
            var form = layui.form
                , layer = layui.layer;

            //自定义验证规则
            form.verify({
                name: function (value) {
                    if (value.length == '') {
                        return '角色名不能为空';
                    }
                }
            });

            //监听提交
            form.on('submit(add)', function (data) {
                console.log(data);
                //发异步，把数据提交给php
                $.ajax({
                    url: '{{asset("admin/role/$role->id/permission")}}',
                    type: 'post',
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


            form.on('checkbox(father)', function (data) {

                if (data.elem.checked) {
                    $(data.elem).parent().siblings('td').find('input').prop("checked", true);
                    form.render();
                } else {
                    $(data.elem).parent().siblings('td').find('input').prop("checked", false);
                    form.render();
                }
            });
        });
    </script>
@endsection