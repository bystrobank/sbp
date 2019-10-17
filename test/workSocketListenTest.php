<?php
require_once "vendor/autoload.php";
require_once "app/__autoload.php";


class Work_SocketTest extends PHPUnit_Framework_TestCase{

    /**
    * @dataProvider providerMessage
    */
    public function testRead($a) {
        $socket = new Work_Socket();
        $socket->createSocket();
        $this->assertEquals($a, $socket->listenSocket());
    }

    public function providerMessage() {
        return array(
            ['Hello world'],
            ['Hell'],
            ['Lorem ipsum dolor, sit amet consectetur adipisicing elit. Laudantium temporibus facere voluptas doloribus. Nobis, similique? Laborum dolorem cupiditate quo dolores suscipit repudiandae voluptatibus dolore fugit error nisi id consectetur aspernatur quod possimus distinctio corporis sed accusantium, quasi maxime nobis! Similique facere inventore quae asperiores laudantium cum? Autem exercitationem perspiciatis velit voluptas iste adipisci ea dolorem. Distinctio nisi, quia quibusdam vitae iusto harum sint pariatur minus sed aliquam et consequatur voluptate id quos culpa, quasi voluptas amet repudiandae similique tenetur totam eos! Quibusdam sunt exercitationem vitae rerum illo ipsam, a illum velit eos itaque culpa magni dolorem minima quis nemo sapiente quidem repudiandae fuga. Laboriosam eveniet nostrum similique, natus soluta reiciendis voluptates quisquam! Porro nam illum dolorem enim, minima vero quod quis animi est sunt fuga laboriosam, ullam a, suscipit quisquam perspiciatis harum aliquam dolorum optio in.']
        );
    }

    /**
     * @dataProvider providerKill
     */
    public function testKill($a) {
        /**
         * Два раза создаем и удаляем сокет
         */
        $sock = new Work_Socket();
        $sock->createSocket();
        $sock->listenSocket();
        $this->assertEquals($a, $sock->killSocket());
    }
    public function providerKill() {
        return array(
            [true],
            [true]
        );
    }

    /**
     * @dataProvider providerDel
     */
    public function testDel($file, $a) {
        $this->assertEquals($a, unlink($file));
    }

    public function providerDel() {
        return array(
            ['socket.sock',true],
            ['socket1.sock',true],
            ['socket2.sock', true]
        );
    }
}
