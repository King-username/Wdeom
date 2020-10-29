<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:71:"D:\phpStudy\PHPTutorial\WWW\xnb/application/admin\view\admin\index.html";i:1573096128;s:71:"D:\phpStudy\PHPTutorial\WWW\xnb\application\admin\view\common\head.html";i:1572827942;}*/ ?>
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
<div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
          <a href=""><?php echo $nav; ?></a>
        <a>
          <cite><?php echo $title; ?></cite></a>
      </span>
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"
       href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
</div>
<div class="x-body">
    <xblock>
        <button class="layui-btn" onclick="x_admin_show('添加管理员','<?php echo url('admin/admin/add'); ?>',1000,500)"><i
                class="layui-icon">&#xe608;</i>添加管理员
        </button>
    </xblock>
    <table class="layui-table">
        <thead>
        <tr>
            <th style="text-align: center">ID</th>
            <th style="text-align: center">用户名</th>
            <th style="text-align: center">真实姓名</th>
            <th style="text-align: center">手机号</th>
            <th style="text-align: center">上级</th>
            <th style="text-align: center">公司</th>
            <th style="text-align: center">邮箱</th>
            <th style="text-align: center">省</th>
            <th style="text-align: center">市</th>
            <th style="text-align: center">乡/镇</th>
            <th style="text-align: center">状态</th>
            <th style="text-align: center">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
        <tr style="text-align: center">
            <td><?php echo $item['id']; ?></td>
            <td><?php echo $item['username']; ?></td>
            <td><?php echo $item['true_name']; ?></td>
            <td><?php echo $item['phone']; ?></td>
            <td><?php echo $item['pname']; ?></td>
            <td><?php echo $item['company']; ?></td>
            <td><?php echo $item['email']; ?></td>
            <td><?php echo $item['pro_name']; ?></td>
            <td><?php echo $item['city_name']; ?></td>
            <td><?php echo $item['area_name']; ?></td>
            <td>
                <?php if($item['status']==1): ?>
                <span style="color:#076912;">正常</span>
                <?php else: ?>
                <span style="color:#af1a11;">冻结</span>
                <?php endif; ?>
            </td>
            <td class="td-manage">
                <?php if($item['id']==1): ?>
                <button class="layui-btn layui-btn-sm layui-btn-radius layui-btn-danger">平台账号禁止操作</button>
                <?php else: ?>
                <!-- <a title="删除" onclick="member_del(this,'<?php echo $item['id']; ?>')" href="javascript:;">
                     <i class="layui-icon">&#xe640;</i>删除
                 </a>-->
                <a title="编辑" onclick="edit(this,'<?php echo $item['id']; ?>')" attr_id='' href="javascript:;">
                    <i class="layui-icon">&#xe642;</i>编辑
                </a>
                <?php if($item['status']==1): ?>
                <a title="冻结" onclick="status(this,'<?php echo $item['id']; ?>',0)" href="javascript:;">
                    <i class="layui-icon">&#xe6b1;</i>冻结</a>
                </a><?php else: ?>
                <a title="解冻" onclick="status(this,'<?php echo $item['id']; ?>',1)" href="javascript:;">
                    <i class="layui-icon">&#xe756;</i>解冻</a>
                </a><?php endif; endif; ?>
            </td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
    <div class="page">
        <div>
            <?php echo $page; ?>
        </div>
    </div>

</div>
<script>
    layui.use('laydate', function () {
        var laydate = layui.laydate;

        //执行一个laydate实例
        laydate.render({
            elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
            elem: '#end' //指定元素
        });
    });


    /*管理员-删除*/
    /* function member_del(obj,id){
         layer.confirm('您确认要删除吗？',function(index){
             //发异步删除数据
             $.ajax({
                 url:"<?php echo URL('guanli/delete'); ?>",
                 data:{"id":id},
                 type:"post",
                 dataType:'json',
                 success:function(msg){
                     if(msg==1){
                         layer.msg("删除成功！",{icon: 6},function () {
                             //获得frame索引
                             var index = parent.layer.getFrameIndex(window.name);
                             //关闭当前frame
                             parent.layer.close(index);
                             window.location.reload();//刷新父级窗口

                         });
                         return false;
                     }else{
                         layer.msg("删除失败！",{icon: 6},function () {
                             //获得frame索引
                             var index = parent.layer.getFrameIndex(window.name);
                             //关闭当前frame
                             parent.layer.close(index);
                             window.location.reload();//刷新父级窗口

                         });
                         return false;
                     }
                 }
             })

         });
     }*/
    //管理员状态
    function status(obj, id, status) {
        //发异步删除数据
        $.ajax({
            url: "<?php echo URL('admin/status'); ?>",
            data: {"id": id, "status": status},
            type: "post",
            dataType: 'json',
            success: function (res) {
                if (res.code == 1) {
                    layer.msg(res.tips, {icon: 6}, function () {
                        //获得frame索引
                        window.location.reload();//刷新父级窗口
                    });
                    return false;
                } else {
                    layer.msg(res.tips, {icon: 6}, function () {

                    });
                    return false;
                }
            }
        })
        return false;
    }

    /*管理员-修改*/
    function edit(obj, id) {
        var url = "<?php echo URL('admin/edit'); ?>?id=" + id;
        x_admin_show('修改用户', url, 1000, 600);
    }

</script>

</body>

</html>