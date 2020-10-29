<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"D:\phpStudy\PHPTutorial\WWW\xnb/application/admin\view\index\welcome.html";i:1573118267;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>页面</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/public/static/css/font.css">
    <link rel="stylesheet" href="/public/static/css/xadmin.css">
    <script type="text/javascript" src="/public/static/js/jquery.min.js"></script>

</head>
<body>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-body ">
                    <blockquote class="layui-elem-quote">欢迎管理员：
                        <span class="x-red"><?php echo $adminInfo['username']; ?></span>！当前时间:<?php echo date("Y-m-d",time()); ?> <span id="time"></span>
                    </blockquote>
                </div>
            </div>
        </div>
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">数据统计</div>
                <div class="layui-card-body ">
                    <ul class="layui-row layui-col-space10 layui-this x-admin-carousel x-admin-backlog">
                        <li class="layui-col-md2 layui-col-xs6">
                            <a href="javascript:;" class="x-admin-backlog-body">
                                <h3>会员总数</h3>
                                <p>
                                    <cite><?php echo $userCount; ?></cite></p>
                            </a>
                        </li>
                        <li class="layui-col-md2 layui-col-xs6">
                            <a href="javascript:;" class="x-admin-backlog-body">
                                <h3>有效会员数</h3>
                                <p>
                                    <cite></cite></p>
                            </a>
                        </li>
                        <li class="layui-col-md2 layui-col-xs6">
                            <a href="javascript:;" class="x-admin-backlog-body">
                                <h3>累计完成订单数</h3>
                                <p>
                                    <cite></cite></p>
                            </a>
                        </li>
                        <li class="layui-col-md2 layui-col-xs6">
                            <a href="javascript:;" class="x-admin-backlog-body">
                                <h3>今日完成订单数</h3>
                                <p>
                                    <cite></cite></p>
                            </a>
                        </li>
                        <li class="layui-col-md2 layui-col-xs6">
                            <a href="javascript:;" class="x-admin-backlog-body">
                                <h3>当前排队人数</h3>
                                <p>
                                    <cite></cite></p>
                            </a>
                        </li>
                        <!-- <li class="layui-col-md2 layui-col-xs6">
                             <a href="javascript:;" class="x-admin-backlog-body">
                                 <h3>文章数</h3>
                                 <p>
                                     <cite>67</cite></p>
                             </a>
                         </li>
                         <li class="layui-col-md2 layui-col-xs6 ">
                             <a href="javascript:;" class="x-admin-backlog-body">
                                 <h3>文章数</h3>
                                 <p>
                                     <cite>6766</cite></p>
                             </a>
                         </li>-->
                    </ul>
                </div>
            </div>
        </div>
        <!-- <div class="layui-col-sm6 layui-col-md3">
             <div class="layui-card">
                 <div class="layui-card-header">下载
                     <span class="layui-badge layui-bg-cyan layuiadmin-badge">月</span></div>
                 <div class="layui-card-body  ">
                     <p class="layuiadmin-big-font">33,555</p>
                     <p>新下载
                         <span class="layuiadmin-span-color">10%
                                     <i class="layui-inline layui-icon layui-icon-face-smile-b"></i></span>
                     </p>
                 </div>
             </div>
         </div>
         <div class="layui-col-sm6 layui-col-md3">
             <div class="layui-card">
                 <div class="layui-card-header">下载
                     <span class="layui-badge layui-bg-cyan layuiadmin-badge">月</span></div>
                 <div class="layui-card-body ">
                     <p class="layuiadmin-big-font">33,555</p>
                     <p>新下载
                         <span class="layuiadmin-span-color">10%
                                     <i class="layui-inline layui-icon layui-icon-face-smile-b"></i></span>
                     </p>
                 </div>
             </div>
         </div>
         <div class="layui-col-sm6 layui-col-md3">
             <div class="layui-card">
                 <div class="layui-card-header">下载
                     <span class="layui-badge layui-bg-cyan layuiadmin-badge">月</span></div>
                 <div class="layui-card-body ">
                     <p class="layuiadmin-big-font">33,555</p>
                     <p>新下载
                         <span class="layuiadmin-span-color">10%
                                     <i class="layui-inline layui-icon layui-icon-face-smile-b"></i></span>
                     </p>
                 </div>
             </div>
         </div>
         <div class="layui-col-sm6 layui-col-md3">
             <div class="layui-card">
                 <div class="layui-card-header">下载
                     <span class="layui-badge layui-bg-cyan layuiadmin-badge">月</span></div>
                 <div class="layui-card-body ">
                     <p class="layuiadmin-big-font">33,555</p>
                     <p>新下载
                         <span class="layuiadmin-span-color">10%
                                     <i class="layui-inline layui-icon layui-icon-face-smile-b"></i></span>
                     </p>
                 </div>
             </div>
         </div>-->
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">系统信息</div>
                <div class="layui-card-body ">
                    <table class="layui-table">
                        <tbody>
                        <?php if(is_array($config) || $config instanceof \think\Collection || $config instanceof \think\Paginator): $i = 0; $__LIST__ = $config;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                        <tr>
                            <th><?php echo $key; ?></th>
                            <td><?php echo $v; ?></td>
                        </tr>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </table>
                </div>
            </div>
        </div>
        <!-- <div class="layui-col-md12">
             <div class="layui-card">
                 <div class="layui-card-header">开发团队</div>
                 <div class="layui-card-body ">
                     <table class="layui-table">
                         <tbody>
                         <tr>
                             <th>版权所有</th>
                             <td>xuebingsi(xuebingsi)
                                 <a href="http://x.xuebingsi.com/" target="_blank">访问官网</a></td>
                         </tr>
                         <tr>
                             <th>开发者</th>
                             <td>马志斌(113664000@qq.com)</td></tr>
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>-->
        <style id="welcome_style"></style>
        <!--<div class="layui-col-md12">
            <blockquote class="layui-elem-quote layui-quote-nm">感谢layui,百度Echarts,jquery,本系统由x-admin提供技术支持。</blockquote>
        </div>-->
    </div>
</div>
</div>
</body>
<script>
    window.onload=function(){
        setInterval(function(){
                var dateTime = new Date();
                var hours = dateTime.getHours();
                var minutes = dateTime.getMinutes();
                var seconds = dateTime.getSeconds();
                if (minutes < 10) {
                    minutes = '0'+minutes;
                }
                if (seconds < 10) {
                    seconds = '0'+seconds;
                }
                $("#time").text(hours + ":" + minutes + ":" + seconds);
            }
            ,1000)
    }
</script>
</html>
