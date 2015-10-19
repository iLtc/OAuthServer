<extend name="Public:template" />
<block name="title">接口管理</block>
<block name="style">
    <style>
        .panel-heading {
            cursor: pointer;
        }
    </style>
</block>
<block name="main">
    <div class="panel panel-default">
        <div class="panel-heading" id="add_group">添加接口</div>
        <div class="panel-body">
            <form method="post" class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="title">接口名</label>
                    <div class="col-sm-3">
                        <input type="text" name="title" id="grouptitle" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="id">接口ID</label>
                    <div class="col-sm-3">
                        <input type="text" name="id" id="id" class="form-control">
                    </div>
                </div>
                <!--<div class="form-group">
                    <label class="control-label col-sm-2" for="description">接口描述</label>
                    <div class="col-sm-3">
                        <input type="text" name="description" id="description" class="form-control">
                    </div>
                </div>-->
                <div class="form-group">
                    <label class="control-label col-sm-2" for="type">接口类型</label>
                    <div class="col-sm-3">
                       <label class="radio-inline">
                           <input type="radio" name="type" id="type1" value="1"> <?=getTitle('api_type~1')?>
                       </label>
                       <label class="radio-inline">
                           <input type="radio" name="type" id="type2" value="0" checked> <?=getTitle('api_type~0')?>
                       </label>
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
            <th>接口ID</th>
            <th>接口名</th>
            <th>接口类型</th>
            <th>接口状态</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($apis as $api){?>
            <tr>
                <td><?=$api['api_id']?></td>
                <td><?=$api['api_title']?></td>
                <td><?=getTitle('api_type~'.$api['api_type'])?></td>
                <td><a href="__APP__/Admin/Api/<?=$api['id']?>/status.html" class="confirm" data-confirm="确定要修改接口“<?=$api['api_title']?>”的状态吗？">
                        <span class="label <?= $api['api_status'] ? 'label-success' : 'label-danger'?>"><?=getTitle('status~'.$api['api_status']);?></span>
                    </a></td>
                <td><a class="btn btn-info btn-xs" href="__APP__/Admin/Api/<?=$api['id']?>.html">详情</a>
                    <a class="btn btn-danger btn-xs confirm" data-confirm="确定要删除接口“<?=$api['api_title']?>”吗？"
                       href="__APP__/Admin/Api/<?=$api['id']?>/delete.html">删除</a></td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</block>