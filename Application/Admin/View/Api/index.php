<extend name="Public:template" />
<block name="title">接口组管理</block>
<block name="style">
    <style>
        .panel-heading {
            cursor: pointer;
        }
    </style>
</block>
<block name="main">
    <div class="panel panel-default">
        <div class="panel-heading" id="add_group">添加接口组</div>
        <div class="panel-body">
            <form method="post" action="__APP__/Admin/Api/group_add.html" class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="group_title">组名</label>
                    <div class="col-sm-3">
                        <input type="text" name="group_title" id="group_title" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="group_id">group_id</label>
                    <div class="col-sm-3">
                        <input type="text" name="group_id" id="group_id" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="group_description">组描述</label>
                    <div class="col-sm-3">
                        <input type="text" name="group_description" id="group_description" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="group_type">组类型</label>
                    <div class="col-sm-3">
                        <select name="group_type" id="group_type" class="form-control">
                            <option value="-1">请选择……</option>
                            <?php for($i=0; $i<3; $i++){?>
                                <option value="<?=$i?>"><?=getTitle('group_type~'.$i)?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="status_uri">通信状态地址</label>
                    <div class="col-sm-3">
                        <input type="text" name="status_uri" id="status_uri" class="form-control">
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
            <th>group_id</th>
            <th>组名</th>
            <th>组类型</th>
            <th>组状态</th>
            <th>通信状态</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($groups as $group){?>
            <tr>
                <td><?=$group['group_id']?></td>
                <td><?=$group['group_title']?></td>
                <td><?=getTitle('group_type~'.$group['group_type'])?></td>
                <td><a href="__APP__/Admin/Api/group/<?=$group['group_id']?>/group_status.html" class="confirm" data-confirm="确定要修改接口组“<?=$group['group_title']?>”的状态吗？">
                        <?php $span_class = $group['group_status'] ? 'label-success' : 'label-danger';?>
                        <span class="label <?=$span_class?>"><?=getTitle('status~'.$group['group_status']);?></span>
                    </a></td>
                <td>请稍后……</td>
                <td><a class="btn btn-info btn-xs" href="__APP__/Admin/Api/group/<?=$group['group_id']?>.html">详情</a>
                    <a class="btn btn-danger btn-xs confirm" data-confirm="确定要删除接口组“<?=$group['group_title']?>”吗？"
                       href="__APP__/Admin/Api/group/<?=$group['group_id']?>/group_delete.html">删除</a></td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</block>