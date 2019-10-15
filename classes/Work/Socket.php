<?php

class Work_Socket implements adaptor_Socket{
    /**
     * @var resource Если подключение удалось то хранит сокет 
     *                  в противоположном случае ложь и генерирует исключение
     */
    private $socket;
    private $adress = 'socket';

    private function generateAdress(){
        $i = 1;
        $type = '.sock';
        while (file_exists($this->adress.$type)){
            $this->adress .= $i;
            $i++;
        }
        $this->adress .= $type;
    }

    public function __construct() {
        set_time_limit(0);		//Время выполнения скрипта не ограничено
        ob_implicit_flush();	//Включаем вывод без буферизации
    }

    /**
     * @return boolean Возращает либо true либо 
     *                      генерирует исключение с кодом 450
     */
    public function createSocket() {
        // TODO: Implement createSocket() method.
        $this->socket = @socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$this->socket) {
            throw new Exception("text", 450);
        }
        return true;
    }

    /**
     * Убивает сокет
     * @return boolean 
     */
    public function killSocket() {
        // TODO: Implement killSocket() method.
        $this->closeListen();
        unlink($this->adress);
        return true;
    }

    /**
     * Закрывает передачу данных на сокет 
     */
    private function closeListen() {
        socket_shutdown($this->socket);
        socket_close($this->socket);
        return true;
    }
    /**
     * Прослушивает сокет и возвращает данные
     * @return string Возращает данные с сокета или 
     *                  при не удаче возращает false
     */
    public function listenSocket() {
        // TODO: Implement listenSocket() method.
        /**
         * Генерирует уникальное имя сокета и привязывает его к сокету
         * Открывает прослушивание сокета до соединения
         * Считывает полученные данные из сокета и закрывает соединение
         */
        $this->generateAdress();
        socket_bind($this->socket, $this->adress);
        socket_listen($this->socket);
        $acept = socket_accept($this->socket);
        $read = @socket_read($acept, 1024);
        socket_close($acept);
        if ($read){
            return $read;
        } else {
            return false;
        }
        
    }

    /**
     * Записывает данные в сокет
     * @return integer 
     */
    public function writeToSocket($n, $msg){
        // TODO: Implement writeToSocket(String $msg) method.
        socket_connect($this->socket,$this->adress.$n.'.sock');
        $wr = socket_write($this->socket, $msg, strlen($msg));
        $this->closeListen();
        return $wr;
    }
}
