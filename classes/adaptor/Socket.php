<?php
/**
 * Interface Socket
 * 
 */

interface adaptor_Socket{
    public function createSocket($socketid);
    public function listenSocket();
    public function writeToSocket($msg);
    public function killSocket();
}
