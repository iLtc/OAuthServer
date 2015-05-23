<?php
namespace Admin\Controller;
use Think\Controller;
class ApiController extends AdminController {
    public function __construct() {
        parent::__construct();

        $this->groupDb = D('api_group');
        $this->apiDb = D('api_api');
    }

    public function index(){
        $groups = $this->groupDb->order('id DESC')->select();

        $this->assign('groups', $groups);
        $this->display();
    }

    public function group(){
        $group = $this->groupDb->where(array('group_id' => I('get.group_id')))->find();
        if(!$group) $this->error('接口组不存在');

        if(IS_GET){
            $apis = $this->apiDb->where(array('group_id' => I('get.group_id')))->select();

            $this->assign('group', $group);
            $this->assign('apis', $apis);
            $this->display();
        }else{
            $group['group_title'] = I('group_title');
            $group['group_description'] = I('group_description');
            $group['group_type'] = I('group_type');
            $group['status_uri'] = I('status_uri');

            if($this->groupDb->save($group)) $this->success('修改成功');
            else $this->error('修改失败');
        }

    }

    public function group_add(){
        $group = $this->groupDb->where(array('group_id' => I('group_id')))->find();
        if($group) $this->error('group_id 已存在');

        $data = array(
            'group_id' => I('group_id'),
            'group_title' => I('group_title'),
            'group_description' => I('group_description'),
            'group_type' => I('group_type'),
            'status_uri' => I('status_uri'),
            'group_status' => 1
        );

        if($this->groupDb->add($data)) $this->success('添加成功', __APP__."/Admin/Api/group/{$data['group_id']}.html");
        else $this->error('添加失败，请重试');
    }

    public function group_status(){
        $group = $this->groupDb->where(array('group_id' => I('get.group_id')))->find();
        if(!$group) $this->error('接口组不存在');

        $group['group_status'] = ($group['group_status'] + 1) % 2;
        if($this->groupDb->save($group)) $this->success('修改成功');
        else $this->error('修改失败');
    }

    public function group_delete(){
        if($this->apiDb->where(array('group_id' => I('get.group_id')))->delete() &&
            $this->groupDb->where(array('group_id' => I('get.group_id')))->delete()) $this->success('删除成功');
        else $this->error('删除失败');
    }

    public function api_add(){
        $group = $this->groupDb->where(array('group_id' => I('get.group_id')))->find();
        if(!$group) $this->error('接口组不存在');

        $api = $this->apiDb->where(
            array(
                'group_id' => I('get.group_id'),
                'api_id' => I('api_id')
            ))->find();
        if($api) $this->error('api_id 已存在');

        $data = array(
            'api_id' => I('api_id'),
            'api_title' => I('api_title'),
            'api_uri' => I('api_uri'),
            'group_id' => $group['group_id'],
            'api_status' => 1
        );

        if($this->apiDb->add($data)) $this->success('添加成功');
        else $this->error('添加失败');
    }

    public function api_edit(){
        $group = $this->groupDb->where(array('group_id' => I('get.group_id')))->find();
        if(!$group) $this->error('接口组不存在');

        $api = $this->apiDb->where(
            array(
                'group_id' => I('get.group_id'),
                'api_id' => I('get.api_id')
            ))->find();
        if(!$api) $this->error('接口不存在');

        if(IS_GET){
            $this->assign('group', $group);
            $this->assign('api', $api);

            $this->display();
        }else{
            $api['api_title'] = I('api_title');
            $api['api_uri'] = I('api_uri');

            if($this->apiDb->save($api)) $this->success('修改成功');
            else $this->error('修改失败');
        }
    }

    public function api_status(){
        $api = $this->apiDb->where(
            array(
                'group_id' => I('get.group_id'),
                'api_id' => I('get.api_id')
            ))->find();
        if(!$api) $this->error('接口不存在');

        $api['api_status'] = ($api['api_status'] + 1) % 2;
        if($this->apiDb->save($api)) $this->success('修改成功');
        else $this->error('修改失败');
    }

    public function api_delete(){
        if($this->apiDb->where(
            array(
                'group_id' => I('get.group_id'),
                'api_id' => I('get.api_id')
            ))->delete()) $this->success('删除成功');
        else $this->error('删除失败');
    }
}