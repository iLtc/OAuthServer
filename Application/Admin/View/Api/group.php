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
        <div class="panel-heading" id="edit_group">修改接口组</div>
        <div class="panel-body">
            <form method="post" class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-sm-2">group_id</label>
                    <div class="col-sm-4">
                        <p class="form-control-static"><?=$group['group_id']?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="group_title">组名</label>
                    <div class="col-sm-3">
                        <input type="text" name="group_title" id="group_title" class="form-control" value="<?=$group['group_title']?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="group_description">组描述</label>
                    <div class="col-sm-3">
                        <input type="text" name="group_description" id="group_description" class="form-control" value="<?=$group['group_description']?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="group_type">组类型</label>
                    <div class="col-sm-3">
                        <select name="group_type" id="group_type" class="form-control" value="<?=$group['group_type']?>">
                            <?php for($i=0; $i<3; $i++){?>
                                <option value="<?=$i?>" <?php if($group['group_type'] == $i){?>selected<?php }?>><?=getTitle('group_type~'.$i)?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="status_uri">通信状态地址</label>
                    <div class="col-sm-3">
                        <input type="text" name="status_uri" id="status_uri" class="form-control" value="<?=$group['status_uri']?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">组状态</label>
                    <div class="col-sm-4">
                        <p class="form-control-static"><a href="__APP__/Admin/Api/group/<?=$group['group_id']?>/group_status.html" class="confirm" data-confirm="确定要修改接口组“<?=$group['group_title']?>”的状态吗？">
                                <?php $span_class = $group['group_status'] ? 'label-success' : 'label-danger';?>
                                <span class="label <?=$span_class?>"><?=getTitle('status~'.$group['group_status']);?></span>
                            </a></p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">修改</button>
                        <button type="reset" class="btn btn-default">重填</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading" id="add_api">添加接口</div>
        <div class="panel-body">
            <form method="post" action="__APP__/Admin/Api/group/<?=$group['group_id']?>/api_add.html" class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="api_title">接口名</label>
                    <div class="col-sm-3">
                        <input type="text" name="api_title" id="api_title" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="api_id">api_id</label>
                    <div class="col-sm-3">
                        <input type="text" name="api_id" id="api_id" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="api_uri">接口地址</label>
                    <div class="col-sm-3">
                        <input type="text" name="api_uri" id="api_uri" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">添加</button>
                        <button type="reset" class="btn btn-default">重填</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <legend>接口组：<?=$group['group_title']?></legend>
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>api_id</th>
            <th>接口名称</th>
            <th>接口状态</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($apis as $api){?>
            <tr>
                <td><?=$api['api_id']?></td>
                <td><?=$api['api_title']?></td>
                <td><a href="__APP__/Admin/Api/group/<?=$group['group_id']?>/api/<?=$api['api_id']?>/api_status.html" class="confirm" data-confirm="确定要修改接口“<?=$api['api_title']?>”的状态吗？">
                        <?php $span_class = $api['api_status'] ? 'label-success' : 'label-danger';?>
                        <span class="label <?=$span_class?>"><?=getTitle('status~'.$api['api_status']);?></span>
                    </a></td>
                <td><a class="btn btn-info btn-xs" href="__APP__/Admin/Api/group/<?=$group['group_id']?>/api/<?=$api['api_id']?>.html">编辑</a>
                    <a class="btn btn-danger btn-xs confirm" data-confirm="确定要删除接口“<?=$api['api_title']?>”吗？"
                       href="__APP__/Admin/Api/group/<?=$group['group_id']?>/api/<?=$api['api_id']?>/api_delete.html">删除</a></td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</block>