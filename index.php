<?php
require dirname(__FILE__). '/__settings__.php';
import('core.Flow');
import('core.Lib');
import('generic.module.JsOneTimeTicketFilter');
import('Chat');

$flow = new Flow();
$flow->handler(array(
    '^/archives' => 'class=Chat,method=models,template=archive.html',
    '^/get_messages' => 'class=Chat,method=models_json_pool',
    '^/say' => 'class=Chat,method=say',
    '' => 'class=Chat,method=models,template=index.html',
));
$flow->output();