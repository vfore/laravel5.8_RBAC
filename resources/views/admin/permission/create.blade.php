@extends('admin.layout.tabLayout')

@section('content')
    <div class="layui-fluid">
        <div class="layui-row">
            <form class="layui-form">
                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        <span class="x-red">*</span>权限名
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="name" name="name" required="" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="phone" class="layui-form-label">
                        <span class="x-red">*</span>路由
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="route" name="route" required=""  autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span class="x-red">*</span>类型</label>
                    <div class="layui-input-block">
                        <input type="radio" name="type" value="1" lay-skin="primary" title="菜单" checked>
                        <input type="radio" name="type" value="2" lay-skin="primary" title="tab" >
                        <input type="radio" name="type" value="3" lay-skin="primary" title="按钮" >
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="phone" class="layui-form-label">
                        排序
                    </label>
                    <div class="layui-input-inline">
                        <input type="text"  name="sort" value="50" required="" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label"></label>
                    <button class="layui-btn" lay-filter="add" lay-submit="">
                        保存
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        layui.use(['form', 'layer'],
            function () {
                $ = layui.jquery;
                var form = layui.form, layer = layui.layer;

                //监听提交
                form.on('submit(add)',
                    function (data) {
                        var csrf_token = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            url: '{{asset("admin/permission")}}',
                            type: 'post',
                            data: data.field,
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': csrf_token,
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
                                    layer.alert("新增失败", {icon: 5});
                                }
                            },
                            error: function (json) {
                                layer.alert(json.responseJSON.msg, {icon: 5});
                            }
                        });
                        return false;
                    });

            });
    </script>
@endsection