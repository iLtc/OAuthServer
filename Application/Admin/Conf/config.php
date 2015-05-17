<?php
return array(
	//'配置项'=>'配置值'
    'URL_ROUTER_ON'   => true,
    'URL_ROUTE_RULES'=>array(
        'Client/:client_id\d/:action' => array('Client/:2'),
        'Client/:client_id\d' => array('Client/edit'),
    ),

);