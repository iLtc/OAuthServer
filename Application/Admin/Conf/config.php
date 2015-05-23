<?php
return array(
	//'配置项'=>'配置值'
    'URL_ROUTER_ON'   => true,
    'URL_ROUTE_RULES'=>array(
        'Client/:client_id\d/:action' => array('Client/:2'),
        'Client/:client_id\d' => array('Client/edit'),

        'Api/group/:group_id/api/:api_id/:action' => array('Api/:3'),
        'Api/group/:group_id/api/:api_id' => array('Api/api_edit'),

        'Api/group/:group_id/:action' => array('Api/:2'),
        'Api/group/:group_id' => array('Api/group'),
    ),

);