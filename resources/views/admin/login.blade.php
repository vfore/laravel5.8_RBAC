<!doctype html>
<html  class="x-admin-sm">
<head>
    <meta charset="UTF-8">
    <title>后台登录</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="{{asset('admin/css/font.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/login.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/xadmin.css')}}">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
    <script src="{{asset('admin/lib/layui/layui.js')}}" charset="utf-8"></script>
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="login-bg">

<div class="login layui-anim layui-anim-up">
    <div class="message">后台登录</div>
    <div id="darkbannerwrap"></div>
    <form method="post" class="layui-form" style="position: relative">
        <input name="username" placeholder="手机号或邮箱"  type="text" lay-verify="required" class="layui-input" >
        <hr class="hr15">
        <input name="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
        <hr class="hr15">
        <input name="code" lay-verify="required" placeholder="验证码"  type="text" class="layui-input" style="width: 62%;">
        <img style="cursor: pointer;position: absolute; top: 130px; left: 220px;height: 50px" onclick="this.src='{{captcha_src('flat')}}'+Math.random()" src="{{captcha_src('flat')}}" id="captcha" alt="验证码">
        <hr class="hr15">
        <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
        <hr class="hr20" >
    </form>
</div>

<script>
    $(function  () {
        layui.use('form', function(){
            var form = layui.form;
            //监听提交
            form.on('submit(login)', function(data){
                $.ajax({
                    url: '{{asset('admin/login')}}',
                    type: 'post',
                    data: data.field,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (json) {
                        if (json.code == 200) {
                            location.href = json.url;
                        } else {
                            layer.alert(json.msg, {icon: 5});
                            $('#captcha').trigger('click');
                        }
                    }
                });
                return false;
            });
        });
    })
</script>
<!-- 底部结束 -->
</body>
</html>