<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:71:"D:\phpStudy\PHPTutorial\WWW\xnb/application/admin\view\index\index.html";i:1572845000;s:71:"D:\phpStudy\PHPTutorial\WWW\xnb\application\admin\view\common\head.html";i:1572827942;}*/ ?>
<!DOCTYPE html>
<html>
  
  <head>
    <meta charset="UTF-8">
    <title>我的后台</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/public/static/css/font.css"> 
	<link href="/favicon.ico" type="image/x-icon" rel="shortcut icon" /> 
    <link rel="stylesheet" href="/public/static/css/xadmin.css">
    <link href="/public/static/lib/layui/css/layui.css" rel="stylesheet">
<!--    <script type="text/javascript" src="/public/static/js/jquery.min.js"></script>-->
    <script type="text/javascript" src="/public/static/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="/public/static/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/public/static/js/xadmin.js"></script>


    <!--UEditor编辑器-->
    <script type="text/javascript" charset="utf-8" src="/public/static/UEditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/public/static/UEditor/ueditor.all.min.js"> </script>

    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/css">
      #fff{
        border: red solid 1px;
      }
    </script>
  </head>
  
<body>
<!-- 顶部开始 -->
<div class="container">
    <div class="logo"><a href="">我的后台<span style="font-size: small">v1.0</span></a></div>
    <div class="left_open">
        <i title="展开左侧栏" class="iconfont">&#xe699;</i>
    </div>
    <ul class="layui-nav right" lay-filter="">
<!--        <li class="layui-nav-item to-index"><a href="#">hello</a></li>-->
        <li class="layui-nav-item">
            <a href="javascript:;"><?php echo $adminInfo['username']; ?></a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
                <dd><a href="javascript:;" onclick="banner_edit(this)" attr_id="<?php echo $adminInfo['id']; ?>">修改密码</a></dd>
                <dd><a href="<?php echo url('admin/login/logout'); ?>">退出</a></dd>
            </dl>
        </li>

    </ul>
</div>
<!-- 顶部结束 -->
<!-- 中部开始 -->
<!-- 左侧菜单开始 -->
<div class="left-nav">
    <div id="side-nav">
        <!---->
        <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>
        <ul id="nav">
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe723;</i>
                    <cite><?php echo $val['title']; ?></cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <?php if(is_array($val['son']) || $val['son'] instanceof \think\Collection || $val['son'] instanceof \think\Paginator): $i = 0; $__LIST__ = $val['son'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rss): $mod = ($i % 2 );++$i;?>
                    <li>
                        <a _href="/<?php echo $rss['name']; ?>">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite><?php echo $rss['title']; ?></cite>
                        </a>
                    </li >
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </li>
        </ul>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
</div>
<!-- <div class="x-slide_left"></div> -->
<!-- 左侧菜单结束 -->
<!-- 右侧主体开始 -->
<div class="page-content">
    <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
        <ul class="layui-tab-title">
            <li class="home"><i class="layui-icon">&#xe68e;</i>我的桌面</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <iframe src="<?php echo url('admin/index/welcome'); ?>" frameborder="0" scrolling="yes" class="x-iframe"></iframe>
            </div>
        </div>
    </div>
</div>
<div class="page-content-bg"></div>
<!-- 右侧主体结束 -->
<!-- 中部结束 -->
<!-- 底部开始 -->
<!-- 底部结束 -->
<script>
    /*管理员-密码修改*/
    function banner_edit(obj){
        var id=$(obj).attr('attr_id');
        //alert(mid);
        var url="<?php echo URL('admin/editPwd'); ?>?id="+id;
        //alert(url);
        x_admin_show('修改密码',url,1000,600)
    }
</script>

</body>
</html>