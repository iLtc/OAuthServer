<extend name="Public:template" />
<block name="title">编辑接口</block>
<block name="main">
    <form method="post" class="form-horizontal">
        <fieldset>
            <legend>编辑接口：<?=$api['api_title']?></legend>
            <div class="form-group">
                <label class="control-label col-sm-2">api_id</label>
                <div class="col-sm-4">
                    <p class="form-control-static"><?=$api['api_id']?></p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="api_title">接口名称</label>
                <div class="col-sm-4">
                    <input type="text" name="api_title" id="api_title" class="form-control" value="<?=$api['api_title']?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="api_uri">接口地址</label>
                <div class="col-sm-4">
                    <input type="text" name="api_uri" id="api_uri" class="form-control" value="<?=$api['api_uri']?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">接口状态</label>
                <div class="col-sm-4">
                    <p class="form-control-static"><a href="__APP__/Admin/Api/group/<?=$group['group_id']?>/api/<?=$api['api_id']?>/api_status.html" class="confirm" data-confirm="确定要修改接口“<?=$api['api_title']?>”的状态吗？">
                            <?php $span_class = $api['api_status'] ? 'label-success' : 'label-danger';?>
                            <span class="label <?=$span_class?>"><?=getTitle('status~'.$api['api_status']);?></span>
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