### swoole+websocket简易聊天室demo
`swoole`文档地址：[https://wiki.swoole.com](https://wiki.swoole.com "https://wiki.swoole.com")

首先确保`centos`服务器已经安装`swoole`环境，php7以上版本。
使用`ip addr`查看服务器ip地址，修改`index.html`中的`ws`连接地址。

运行脚本，不报错说明运行成功。

	php ws_server.php`

浏览器打开`index.html`，输入昵称，点击连接一个简单的聊天室就完成了。

[![swoole+websocket简易聊天室demo](https://raw.githubusercontent.com/code-hi/ws_im_demo/master/test/swoole_websocket_im_demo.png)](http://www.codehui.net)
