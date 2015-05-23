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
        <div class="panel-heading" id="add_app">添加应用</div>
        <div class="panel-body">
            <form method="post" action="__APP__/Admin/Client/add.html" class="form-horizontal">
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
            <th>应用类型</th>
            <th>应用状态</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($clients as $client){?>
            <tr>
                <td><?=$client['client_id']?></td>
                <td><a href="<?=$client['client_uri']?>" target="_blank"><?=$client['client_title']?></a></td>
                <td><a href="__APP__/Admin/Client/<?=$client['client_id']?>/type.html" class="confirm" data-confirm="确定要修改应用“<?=$client['client_title']?>”的类型吗？">
                        <?php $span_class = $client['client_type'] ? 'label-success' : 'label-warning';?>
                        <span class="label <?=$span_class?>"><?=getTitle('client_type~'.$client['client_type']);?></span>
                    </a></td>
                <td><a href="__APP__/Admin/Client/<?=$client['client_id']?>/status.html" class="confirm" data-confirm="确定要修改应用“<?=$client['client_title']?>”的状态吗？">
                        <?php $span_class = $client['client_status'] ? 'label-success' : 'label-danger';?>
                        <span class="label <?=$span_class?>"><?=getTitle('status~'.$client['client_status']);?></span>
                    </a></td>
                <td><a class="btn btn-info btn-xs" href="__APP__/Admin/Client/<?=$client['client_id']?>.html">编辑</a>
                    <a class="btn btn-danger btn-xs confirm" data-confirm="确定要删除应用“<?=$client['client_title']?>”吗？" href="__APP__/Admin/Client/<?=$client['client_id']?>/delete.html">删除</a></td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</block>