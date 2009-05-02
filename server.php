<?php
declare(ticks = 1);
require dirname(__FILE__). '/__settings__.php';
import('core.Log');
// Log::disable_display();
import('Chat.ChatServer');

pcntl_signal(SIGUSR1, array(C(ChatServer), 'models_json'));
sleep(def('chat@timeout'));
