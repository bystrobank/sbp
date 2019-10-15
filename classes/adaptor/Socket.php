<?php
/**
 * Interface Socket
 * 
 */

interface adaptor_Socket{
    public function createSocket();
    public function listenSocket();
    public function writeToSocket($n, $msg);
    public function killSocket();
}
