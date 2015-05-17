<extend name="Public:template" />
<block name="title">应用管理</block>
<block name="style">
    <style>
        .panel-heading {
            cursor: pointer;
        }
    </style>
</block>
<block name="main">
    <div class="panel panel-default">
        <div class="panel-heading">添加应用</div>
        <div class="panel-body">
            <form method="post" action="add.html" class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="client_title">应用名称</label>
                    <div class="col-sm-3">
                        <input type="text" name="client_title" id="client_title" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="client_uri">应用地址</label>
                    <div class="col-sm-3">
                        <input type="text" name="client_uri" id="client_uri" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="redirect_uri">回调地址</label>
                    <div class="col-sm-3">
                        <input type="text" name="redirect_uri" id="redirect_uri" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">提交</button>
                        <button type="reset" class="btn btn-default">重填</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <hr>
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>client_id</th>
            <th>应用名称</th>
            <th>应用状态</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($clients as $client){?>
            <tr>
                <td><?=$client['client_id']?></td>
                <td><a href="<?=$client['client_uri']?>" target="_blank"><?=$client['client_title']?></a></td>
                <td>
                    <a href="__APP__/Admin/Client/<?=$client['client_id']?>/change.html" class="confirm" data-confirm="确定要修改应用“<?=$client['client_title']?>”的状态吗？">
                        <?php if($client['status']){?>
                            <span class="label label-success">生产</span>
                        <?php }else{?>
                            <span class="label label-warning">开发</span>
                        <?php }?>
                    </a>
                </td>
                <td><a class="btn btn-info btn-xs" href="__APP__/Admin/Client/<?=$client['client_id']?>.html">编辑</a>
                    <a class="btn btn-danger btn-xs confirm" data-confirm="确定要删除应用“<?=$client['client_title']?>”吗？" href="__APP__/Admin/Client/<?=$client['client_id']?>/delete.html">删除</a></td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</block>
<block name="script">
    <script>
        $(".panel-body").css('display', 'none');
        $(".panel-heading").click(function(){
            $(".panel-body").slideToggle();
        });
    </script>
</block>