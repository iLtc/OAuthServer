<extend name="Public:template" />
<block name="title">编辑应用</block>
<block name="main">
    <form method="post" class="form-horizontal">
        <fieldset>
            <legend>编辑应用：<?=$client['client_title']?></legend>
            <div class="form-group">
                <label class="control-label col-sm-2">client_id</label>
                <div class="col-sm-4">
                    <p class="form-control-static"><?=$client['client_id']?></p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">client_secret</label>
                <div class="col-sm-4">
                    <p class="form-control-static">
                        <?=$client['client_secret']?>
                        [<a href="__APP__/Admin/Client/<?=$client['client_id']?>/secret.html" class="confirm" data-confirm="确定要重置应用“<?=$client['client_title']?>”的密钥吗？">重置</a>]</p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="client_title">应用名称</label>
                <div class="col-sm-4">
                    <input type="text" name="client_title" id="client_title" class="form-control" value="<?=$client['client_title']?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="client_uri">应用地址</label>
                <div class="col-sm-4">
                    <input type="text" name="client_uri" id="client_uri" class="form-control" value="<?=$client['client_uri']?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="redirect_uri">回调地址</label>
                <div class="col-sm-4">
                    <input type="text" name="redirect_uri" id="redirect_uri" class="form-control" value="<?=$client['redirect_uri']?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">应用类型</label>
                <div class="col-sm-4">
                    <p class="form-control-static"><a href="__APP__/Admin/Client/<?=$client['client_id']?>/type.html" class="confirm" data-confirm="确定要修改应用“<?=$client['client_title']?>”的类型吗？">
                            <?php $span_class = $client['client_type'] ? 'label-success' : 'label-warning';?>
                            <span class="label <?=$span_class?>"><?=getTitle('client_type~'.$client['client_type']);?></span>
                        </a></p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">应用状态</label>
                <div class="col-sm-4">
                    <p class="form-control-static"><a href="__APP__/Admin/Client/<?=$client['client_id']?>/status.html" class="confirm" data-confirm="确定要修改应用“<?=$client['client_title']?>”的状态吗？">
                            <?php $span_class = $client['client_status'] ? 'label-success' : 'label-danger';?>
                            <span class="label <?=$span_class?>"><?=getTitle('status~'.$client['client_status']);?></span>
                        </a></p>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">修改</button>
                    <button type="reset" class="btn btn-default">重填</button>
                </div>
            </div>
        </fieldset>
    </form>
</block>