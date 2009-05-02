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
    echo ChatServer::models_to_jsonp($object_list, $req->inVars('callback', 'callback'));
    exit;
}

pcntl_signal(SIGUSR1, array(C(ChatServer), 'models_json'));
sleep(def('chat@timeout'));
