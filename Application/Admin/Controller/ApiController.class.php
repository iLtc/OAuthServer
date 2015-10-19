<?php
namespace Admin\Controller;
use Think\Controller;
class ApiController extends AdminController {
    public function __construct() {
        parent::__construct();

        $this->db = D('api');
    }

    public function index(){
        if(IS_GET){
            $apis = $this->db->order('id')->select();

            $this->assign('apis', $apis);
            $this->display();
        }else{
            $api = $this->db->where(array('api_id' => I('id')))->find();
            if($api) $this->error('接口ID已存在');
            
            $data = array(
                'api_id' => I('id'),
                'api_title' => I('title'),
                'api_type' => I('type'),
                'api_status' => 1,
                'api_secret' => randString()
            );

            $id = $this->db->add($data);
            
            $this->success('添加成功', __APP__."/Admin/Api/{$id}.html");
        }
    }

    public function edit(){
        $api = $this->db->where(array('id' => I('get.api_id')))->find();
        if(!$api) $this->error('接口不存在');

        if(IS_GET){
            $this->assign('api', $api);

            $this->display();
        }else{
            $api['api_title'] = I('api_title');
            $api['api_type'] = I('api_type');

            $this->db->save($api);
            $this->success('修改成功');
        }
    }

    public function status(){
        $api = $this->db->where(array('id' => I('api_id')))->find();
        if(!$api) $this->error('接口不存在');

        $api['api_status'] = ($api['api_status'] + 1) % 2;
        $this->db->save($api);
        $this->success('修改成功');
    }

    public function delete(){
        if($this->db->where(array('id' => I('get.api_id')))->delete()) $this->success('删除成功');
        else $this->error('删除失败');
    }
    
    public function secret(){
        $api = $this->db->where(array('id' => I('api_id')))->find();
        if(!$api) $this->error('接口不存在');
        
        $api['api_secret'] = randString();
        $this->db->save($api);
        $this->success('修改成功');
    }
}