<?php
import('db.Dao');

class ChatMessage extends Dao
{
    protected $___database___ = 'chat';
    protected $___table___ = 'message';
    static protected $__id__ = "type=serial";
    static protected $__name__ = "type=string,require=true,length=50";
    static protected $__description__ = "type=text,require=true";
    static protected $__create_date__ = "type=timestamp";
    protected $id;
    protected $name;
    protected $description;
    protected $create_date;
    
    protected function __init__(){
        $this->create_date = time();
    }
}