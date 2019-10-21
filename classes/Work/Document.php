<?php

class Work_Document implements adaptor_Document{
    /**
     * @var string
     */
    public $type_socket = '';

    /**
     * Ожидание документа
     */
    public function wait_document(){
        // TODO: Implement wait_document() method.
        #$this->type_socket->writeToSocket($_REQUEST['number']);
        //просто так ее лучше удалить
        #sleep(2);
        if ($read = $this->type_socket->listenSocket()){
            $this->type_socket->killSocket();
            return $read;
        } else {
            return false;
        }
    }

    /**
     * Отправка готового документа
     */
    public function send_document($socketId) {
        $this->type_socket = new Work_Socket();
        if ($this->type_socket->createSocket($socketId)){
            return $this->wait_document();
        }
    }
}