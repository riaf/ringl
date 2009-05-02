<?php
import('core.Flow');
import('core.Text');
import('core.File');
module('model.ChatMessage');
class Chat extends Flow
{
    private static $static_flag = false;
    
    public static function __shutdown__(){
        self::send_sig();
    }
    public function models(){
        $paginator = new Paginator(50, $this->inVars('page', 1));
        $object_list = C(ChatMessage)->find_all(Q::order('-id'), $paginator);
        $this->vars('object_list', array_reverse($object_list));
        $since_id = 0;
        foreach($object_list as $object) $since_id = ($object->id() > $since_id)? $object->id(): $since_id;
        $this->vars('since_id', $since_id);
        return $this;
    }
    public function say(){
        if($this->isPost()){
            $message = new ChatMessage();
            $message->set_model($this->vars());
            $message->save();
            C($message)->commit();
            self::$static_flag = true;
        }
        exit;
    }
    private static function send_sig(){
        if(self::$static_flag == false) {
            return ;
        }
        $pids = self::get_pids();
        foreach($pids as $pid){
            posix_kill($pid, SIGUSR1);
        }
    }
    private static function get_pids(){
        $pids = array();
        $files = File::ls(work_path());
        foreach($files as $file){
            if($file->ext() == '.pid'){
                $pids[] = intval($file->oname());
            }
        }
        return $pids;
    }
}