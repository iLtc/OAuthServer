<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><block name="title"></block> | 管理平台 | 红满堂开放平台</title>

    <link href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="http://cdn.bootcss.com/messenger/1.4.0/css/messenger.css" rel="stylesheet">
    <link href="http://cdn.bootcss.com/messenger/1.4.0/css/messenger-theme-future.css" rel="stylesheet">

    <block name="style"></block>

    <script src="http://cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
</head>
<body>

<nav class="navbar navbar-static-top navbar-default" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">管理平台</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav" id="navs">
                <li id="nav-Client"><a href="__APP__/Admin/Client/index.html">申请模块</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?=getConfig('bbs_uri')?>?<?=$worker['uid']?>" target="_blank">
                        <?=$worker['username']?>
                    </a></li>
                <li><a href="__APP__/Admin/Account/signout.html">退出</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container" id="container">
    <block name="main"></block>
</div> <!-- /container -->
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://cdn.bootcss.com/html5shiv/r29/html5.min.js"></script>
<script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<script src="http://cdn.bootcss.com/messenger/1.4.0/js/messenger.min.js"></script>
<script src="http://cdn.bootcss.com/messenger/1.4.0/js/messenger-theme-future.js"></script>
<script src="__PUBLIC__/js/admin.js"></script>
<block name="script"></block>
</body>
</html>
