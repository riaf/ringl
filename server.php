<?php
declare(ticks = 1);
require dirname(__FILE__). '/__settings__.php';
import('core.Log');
import('core.Request');
Log::disable_display();
import('Chat.ChatServer');

header('application/x-javascript');

$req = new Request();
$object_list = C(ChatMessage)->find_all(Q::gt('id', $req->inVars('since_id', 0)), Q::order('-id'));
if(count($object_list) > 0){
    echo ChatServer::models_to_jsonp(array_reverse($object_list), $req->inVars('callback', 'callback'));
    exit;
}

$server = new ChatServer();
pcntl_signal(SIGTERM, array(&$server, 'models_json'));
pcntl_signal(SIGHUP, array(&$server, 'models_json'));
pcntl_signal(SIGUSR1, array(&$server, 'models_json'));
sleep(def('chat@timeout'));
