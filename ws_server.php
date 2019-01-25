<?php
// 创建websocket服务器对象，监听0.0.0.0:9502端口
$ws = new swoole_websocket_server("0.0.0.0", 9502);
// 用户信息
$List = [];

//监听WebSocket连接打开事件
$ws->on('open', function ($ws, $request) use (&$List) {
    echo $request->fd . ":open\n";  // 终端日志
});

//监听WebSocket消息事件
$ws->on('message', function ($ws, $frame) use (&$List) {
	$data = json_decode($frame->data, true);
	switch ($data['type']) {
		case 'login':
		    // 添加用户信息
			$List[$frame->fd] = ['name'=>$data['data'] ?: $frame->fd];
			// 终端日志
			echo $frame->fd . '-' . $List[$frame->fd]['name'] . ":access\n"; 
			// 推送消息
			pushMessage($ws, $List[$frame->fd]['name'] . "加入了房间");			
			break;
		case 'message':
			// 终端日志
			echo $frame->fd . '-' . $List[$frame->fd]['name'] . ":message:" . $frame->data . "\n";
			// 推送消息
			pushMessage($ws, $List[$frame->fd]['name'] . '说:' . $data['data']);
			break;		
		default:
			var_dump($List[$frame->fd]['name'], $data);
			break;
	}
    
});

//监听WebSocket连接关闭事件
$ws->on('close', function ($ws, $fd) use (&$List){
    echo $fd . ":close\n";  // 终端日志
    $name = $List[$fd]['name']; 
    unset($List[$fd]); 
    pushMessage($ws, $fd . '-' . $name . "离开了房间");
    
});

$ws->start();

//推送消息
function pushMessage($ws, $val) {
	foreach ($GLOBALS['List'] as $fd => $v) {
    	$ws->push($fd, $val);
    }
}