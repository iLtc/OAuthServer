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
        $client_id = $this->clientDb->add($data);

        $this->success('添加成功', __APP__."/Admin/Client/{$client_id}.html");
    }

    public function edit(){
        $client = $this->clientDb->where(array('client_id' => I('get.client_id')))->find();

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

    public function change(){
        $client = $this->clientDb->where(array('client_id' => I('get.client_id')))->find();
        $client['status'] = ($client['status'] + 1) % 2;
        $this->clientDb->save($client);

        $this->success('修改成功');
    }

    public function secret(){
        $client = $this->clientDb->where(array('client_id' => I('get.client_id')))->find();
        $client['client_secret'] = randString();
        $this->clientDb->save($client);

        $this->success('修改成功');
    }

    public function delete(){
        $this->clientDb->where(array('client_id' => I('get.client_id')))->delete();

        $this->success('删除成功');
    }
}