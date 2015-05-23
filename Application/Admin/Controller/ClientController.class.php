<?php
namespace Admin\Controller;
use Think\Controller;
class ClientController extends AdminController {
    public function __construct() {
        parent::__construct();

        $this->clientDb = D('oauth_clients');
    }

    public function index(){
        $clients = $this->clientDb->order('client_id DESC')->select();

        $this->assign('clients', $clients);
        $this->display();
    }

    public function add(){
        $data = array(
            'client_title' => I('client_title'),
            'client_uri' => I('client_uri'),
            'redirect_uri' => I('redirect_uri'),
            'create_time' => time(),
            'client_secret' => randString()
        );
        if($client_id = $this->clientDb->add($data)){
            $this->success('添加成功', __APP__."/Admin/Client/{$client_id}.html");
        }else $this->error('添加失败，请重试');
    }

    public function edit(){
        $client = $this->clientDb->where(array('client_id' => I('get.client_id')))->find();
        if(!$client) $this->error('应用不存在');

        if(IS_GET){
            $this->assign('client', $client);
            $this->display();
        }else{
            $client['client_title'] = I('client_title');
            $client['client_uri'] = I('client_uri');
            $client['redirect_uri'] = I('redirect_uri');
            $this->clientDb->save($client);

            $this->success('修改成功');
        }
    }

    public function type(){
        $client = $this->clientDb->where(array('client_id' => I('get.client_id')))->find();
        if(!$client) $this->error('应用不存在');

        $client['client_type'] = ($client['client_type'] + 1) % 2;
        if($this->clientDb->save($client)) $this->success('修改成功');
        else $this->error('修改失败');
    }

    public function status(){
        $client = $this->clientDb->where(array('client_id' => I('get.client_id')))->find();
        if(!$client) $this->error('应用不存在');

        $client['client_status'] = ($client['client_status'] + 1) % 2;
        if($this->clientDb->save($client)) $this->success('修改成功');
        else $this->error('修改失败');
    }

    public function secret(){
        $client = $this->clientDb->where(array('client_id' => I('get.client_id')))->find();
        if(!$client) $this->error('应用不存在');

        $client['client_secret'] = randString();
        if($this->clientDb->save($client)) $this->success('修改成功');
        else $this->error('修改失败');
    }

    public function delete(){
        if($this->clientDb->where(array('client_id' => I('get.client_id')))->delete()) $this->success('删除成功');
        else $this->error('删除失败');
    }
}