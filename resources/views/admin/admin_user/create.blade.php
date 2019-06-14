@extends('admin.layout.tabLayout')

@section('content')
    <div class="layui-fluid">
        <div class="layui-row">
            <form class="layui-form">
                <div class="layui-form-item">
                    <label for="nickname" class="layui-form-label">
                        <span class="x-red">*</span>昵称
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="nickname" name="nickname" required="" lay-verify="nickname"
                               autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>至少2个字符
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="phone" class="layui-form-label">
                        <span class="x-red">*</span>手机
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="phone" name="phone" required="" lay-verify="phone" autocomplete="off"
                               class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>将会成为您的登录名
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="L_email" class="layui-form-label">
                        <span class="x-red">*</span>邮箱
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_email" name="email" required="" lay-verify="email" autocomplete="off"
                               class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>将会成为您的登录名
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span class="x-red">*</span>状态</label>
                    <div class="layui-input-block">
                        <input type="radio" name="status" value="1" lay-skin="primary" title="启用" checked>
                        <input type="radio" name="status" value="0" lay-skin="primary" title="注销" >
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span class="x-red">*</span>角色</label>
                    <div class="layui-input-block">
                        <input type="radio" name="role" value="1" lay-skin="primary" title="超级管理员" checked="">
                        <input type="radio" name="role" value="1" lay-skin="primary" title="超级管理员" checked="">
                        <input type="radio" name="role" value="1" lay-skin="primary" title="超级管理员" checked="">
                        <input type="radio" name="role" value="1" lay-skin="primary" title="超级管理员" checked="">
                        <input type="radio" name="role" value="1" lay-skin="primary" title="超级管理员" checked="">
                        <input type="radio" name="role" value="1" lay-skin="primary" title="超级管理员" checked="">
                        <input type="radio" name="role" value="1" lay-skin="primary" title="超级管理员" checked="">
                        <input type="radio" name="role" value="1" lay-skin="primary" title="超级管理员" checked="">
                        <input type="radio" name="role" lay-skin="primary" title="编辑人员">
                        <input type="radio" name="role" lay-skin="primary" title="宣传人员" checked="">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="L_pass" class="layui-form-label">
                        <span class="x-red">*</span>密码
                    </label>
                    <div class="layui-input-inline">
                        <input type="password" id="L_pass" name="password" required="" lay-verify="pass"
                               autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        6到20个字符
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label">
                    </label>
                    <button class="layui-btn" lay-filter="add" lay-submit="">
                        新增
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

                //自定义验证规则
                form.verify({
                    nickname: function (value) {
                        if (value.length < 2) {
                            return '昵称至少得2个字符';
                        }
                    },
                    pass: [/(.+){6,12}$/, '密码必须6到20位'],
                });

                //监听提交
                form.on('submit(add)',
                    function (data) {
                        var csrf_token = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            url: '{{asset("admin/adminUser")}}',
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