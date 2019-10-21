<?php

class Work_Socket implements adaptor_Socket{
    /**
     * @var resource Если подключение удалось то хранит сокет
     *                  в противоположном случае ложь и генерирует исключение
     */
    private $socket;
    /**
     * @var integer Номер сокета к которому идет подключение
     */
    private $socketid;
    /**
     * Имя сокета 
     * @var string
     */
    private $adress = 'socket';
    /**
     * Расширение типа файла сокета
     * @var string
     */
    private $type = '.sock';


    public function __construct() {
        set_time_limit(0);		//Время выполнения скрипта не ограничено
        ob_implicit_flush();	//Включаем вывод без буферизации
    }

    /**
     * @return boolean Возращает либо true либо
     *                      генерирует исключение с кодом 450
     */
    public function createSocket($socketid) {
        // TODO: Implement createSocket() method.
        $this->socketid = $socketid;
        $this->socket = @socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$this->socket) {
            throw new Exception("text", 450);
        }
        $this->adress .= $this->socketid.$this->type;
        return true;
    }

    /**
     * Убивает сокет
     * @return boolean
     */
    public function killSocket() {
        // TODO: Implement killSocket() method.
        $this->closeListen();        
        return unlink($this->adress);
    }

    /**
     * Закрывает передачу данных на сокет
     */
    private function closeListen() {
        if (!socket_shutdown($this->socket) && !socket_close($this->socket)) {
            throw new Exception("Dont close socket", 450);
        }
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
        if (!socket_bind($this->socket, $this->adress)){
            throw new Exception('Socket not binded on '.$this->adress, 450);
        }
        socket_listen($this->socket);
        $acept = socket_accept($this->socket);
        $read = @socket_read($acept, 2048);
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
    public function writeToSocket($msg){
        // TODO: Implement writeToSocket(String $msg) method.        
        socket_connect($this->socket, $this->adress);
        $wr = socket_write($this->socket, $msg, strlen($msg));
        $this->closeListen();
        return $wr;
    }
}
