<?php
import('core.Flow');
import('core.Text');
module('model.ChatMessage');
class ChatServer extends Flow
{
    static private $pid;
    
    static public function __import__(){
        self::$pid = posix_getpid();
        self::touch_pid();
    }
    static public function __shutdown__(){
		self::remove_pid();
	}
    public function models_json(){
        $object_list = C(ChatMessage)->find_all(Q::gt('id', $this->inVars('since_id', 0)), Q::order('-id'));
        echo self::models_to_jsonp(array_reverse($object_list), $this->inVars('callback', 'callback'));
        exit;
    }
    public static function models_to_jsonp($object_list, $callback="callback"){
        $result = array();
        foreach($object_list as $object){
            $result[] = $object->hash();
        }
        return $callback. '('. Text::to_json($result). ');';
    }
    public static function touch_pid(){
        touch(work_path(sprintf('%d.pid', self::$pid)));
    }
    public static function remove_pid(){
        unlink(work_path(sprintf('%d.pid', self::$pid)));
    }
}