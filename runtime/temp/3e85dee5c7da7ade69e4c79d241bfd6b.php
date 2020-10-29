<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"D:\phpStudy\PHPTutorial\WWW\xnb/application/admin\view\login\index.html";i:1572827942;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>平台后台登录</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="/public/static/css/font.css">
    <link rel="stylesheet" href="/public/static/css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="/public/static/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/public/static/js/xadmin.js"></script>

</head>
<body class="login-bg">

<div class="login layui-anim layui-anim-up">
    <div class="message">我的后台<span style="font-size: small">平台</span>登录</div>
    <div id="darkbannerwrap"></div>

    <form method="post" class="layui-form" action="javascript:;" enctype="multipart/form-data">
        <input name="username" placeholder="平台账号" type="text" lay-verify="required" class="layui-input">

        <hr class="hr15">
        <input name="password" lay-verify="required" placeholder="密码" type="password" class="layui-input">
        <hr class="hr15">
        <!-- <input name="key"  placeholder="登录验证码"  type="text" class="layui-input"> -->
        <hr class="hr15">
        <input class="input-text size-L" type="text" placeholder="验证码" lay-verify="" name="code" value=""
               style="width:195px;">
        <div style="position:absolute;bottom:115px;right:30px;"><img src="<?php echo captcha_src(); ?>" alt="验证码" id="vcode"
                                                                     onclick=" this.src='<?php echo captcha_src(); ?>?'+Math.random();">
        </div>

        <hr class="hr15">

        <button class="layui-btn" lay-filter="check" lay-submit="" style="width:100%;">
            登录
        </button>
        <hr class="hr20">
    </form>
</div>

<script>
    layui.use(['form', 'layer'], function () {
        $ = layui.jquery;
        var form = layui.form
            , layer = layui.layer;
        //管理员登录
        form.on('submit(check)', function (data) {
            var vcode = document.getElementById('vcode')
            //console.log(data);
            //var url="";
            $.ajax({
                type: "post",
                async: false,
                url: "<?php echo url('admin/login/checkLogin'); ?>",
                data: data.field,
                success: function (msg) {
                    if (msg.code == 1) {
                        layer.msg(msg.tips, {icon: 1, time: 1000});
                        setTimeout(function () {
                            window.location.href = "<?php echo url('admin/index/index'); ?>";
                        }, 1000);

                    } else {
                        layer.msg(msg.tips);
                        vcode.src = '<?php echo captcha_src(); ?>?' + Math.random();

                    }
                }
            });

        });
    });
</script>


<!-- 底部结束 -->

</body>
</html>