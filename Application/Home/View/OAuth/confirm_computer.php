<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>应用授权 | 红满堂开放平台</title>

    <!-- Le styles -->
    <link href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap-theme.min.css" rel="stylesheet">

    <style>
        h3 {font-weight: normal;}
        #scopes {
            color: gray;
        }
        #scope-title {
            position: relative;
            top: 10px;
        }
    </style>
    <script src="http://cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
</head>

<body>
<header class="navbar navbar-default">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">红满堂社区开放平台</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?=getConfig('bbs_uri')?>?<?=$account['uid']?>" target="_blank">
                            <?=$account['username']?>
                        </a></li>
                    <!--<li><a href="#">管理我的授权</a></li>
                    <li><a href="#">这是什么？</a></li>-->
                </ul>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</header>
<div class="container">
    <form method="post">
        <div class="well col-md-6 col-md-offset-3">
            <h3>授权 <strong><a href="<?=$client_uri?>" target="_blank"><?=$client_title?></a></strong> 访问你的红满堂社区帐号</h3>
            <div class="form-group" id="scopes">
                <label id="scope-title">该应用将同时拥有以下权限</label>
                <div class="checkbox disabled">
                    <label>
                        <input type="checkbox" disabled>
                        获取您的基本信息
                    </label>
                </div>
                <!--<div class="checkbox">
                    <label>
                        <input type="checkbox" value="" checked>
                        其他……
                    </label>
                </div>-->
            </div>
            <div class="form-group col-md-14">
                <input class="btn btn-danger" type="submit" name="action" value="授权">
                <input class="btn btn-default" type="submit" name="action" value="拒绝">
            </div>
        </div>
        <?php foreach($_GET as $i => $v){?>
            <input type="hidden" name="<?=$i?>" value="<?=$v?>">
        <?php }?>
    </form>
</div> <!-- /container -->
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://cdn.bootcss.com/html5shiv/r29/html5.min.js"></script>
<script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</body>
</html>