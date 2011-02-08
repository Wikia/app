<?php
/**
* Tokyo Tyrant network API for PHP
* 
* Copyright (c) 2009 Bertrand Mansion <bmansion@mamasam.com>
* 
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
* 
* The above copyright notice and this permission notice shall be included in
* all copies or substantial portions of the Software.
* 
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
* THE SOFTWARE.
* 
* @package    Tyrant
* @author     Bertrand Mansion <bmansion@mamasam.com>
* @license    http://www.opensource.org/licenses/mit-license.php MIT License
* @link       http://mamasam.indefero.net/p/tyrant/
*/

/**
* Factory for Tokyo Tyrant connections
*
* @package    Tyrant
* @author     Bertrand Mansion <bmansion@mamasam.com>
*/
class Tyrant
{
    /**
    * Scripting extension option for record locking
    */
    const XOLCKREC = 1;

    /**
    * scripting extension option for global locking
    */
    const XOLCKGLB = 2;

    /**
    * Misc function option for omission of the update log
    */
    const MONOULOG = 1;

    /**
    * Restore function option for consistency checking
    */
    const ROCHKCON = 1;

    /**
    * Keeps track of the connection objects
    * Makes it possible to easily reuse a connection.
    * @var  array
    */
    protected static $connections = array();

    /**
    * Current connection object
    * @var object
    */
    protected static $connection;

    /**
    * Opens a connection to a Tokyo Tyrant server
    * <code>
    * try {
    *     $tt = Tyrant::connect('localhost', 1978);
    * } catch (Tyrant_Exception $e) {
    *     echo $e->getMessage();
    * }
    * </code>
    *
    * @param    string  Server hostname or IP address
    * @param    string  Server port
    * @param    string  Optional existing connection id
    * @return   object  Database connection
    */
    public static function connect($host = 'localhost', $port = '1978', $id = 0)
    {
        $id = implode(':', array($host, $port, $id));
        
        // Check if connection already exists
        
        if (isset(self::$connections[$id])) {
            $connection =& self::$connections[$id];
            return $connection;
        }

        // Start a new connection

        $ip = gethostbyname($host);
        $addr = ip2long($ip);
        if (empty($addr)) {
            throw new Tyrant_Exception("Host not found");
        }
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (!is_resource($socket)){
            throw new Tyrant_Exception("Connection refused");
        }
        if (!socket_connect($socket, $addr, $port)) {
            throw new Tyrant_Exception("Connection refused");
        }
        if (defined('TCP_NODELAY')) {
            socket_set_option($socket, SOL_TCP, TCP_NODELAY, 1);
        } else {
            // See http://bugs.php.net/bug.php?id=46360
            socket_set_option($socket, SOL_TCP, 1, 1);
        }

        // Determine the database type

        if (socket_write($socket, pack('CC', 0xC8, 0x88)) === false) {
            throw new Tyrant_Exception("Unable to get database type");
        }
        $str = '';
        if (socket_recv($socket, $str, 1, 0) === false) {
            throw new Tyrant_Exception("Unable to get database type");
        }
        $c = unpack("C", $str);
        if (!isset($c[1]) || $c[1] !== 0) {
            throw new Tyrant_Exception("Unable to get database type");
        }
        $str = '';
        if (socket_recv($socket, $str, 4, 0) === false) {
            throw new Tyrant_Exception("Unable to get database type");
        }
        $num = unpack("N", $str);
        if (!isset($num[1])) {
            throw new Tyrant_Exception("Unable to get database type");
        }
        $size = unpack("l", pack("l", $num[1]));
        $len = $size[1];
        $str = '';
        if (socket_recv($socket, $str, $len, 0) === false) {
            throw new Tyrant_Exception("Unable to get database type");
        }
        $value = explode("\n", trim($str));
        $stats = array();
        foreach ($value as $v) {
            $v = explode("\t", $v);
            $stats[$v[0]] = $v[1];
        }
        if (!isset($stats['type'])) {
            throw new Tyrant_Exception("Unable to get database type");
        }
        
        // Get the right interface for the database type
        
        if ($stats['type'] == 'table') {
            include_once dirname(__FILE__).'/Tyrant/RDBTable.php';
            $conn = new Tyrant_RDBTable($socket);
        } else {
            include_once dirname(__FILE__).'/Tyrant/RDB.php';
            $conn = new Tyrant_RDB($socket);
        }
        $conn->sethost($host);
        $conn->setport($port);
        self::$connections[$id] =& $conn;
        self::$connection = $conn;
        return $conn;
    }

    /**
    * Return the current connection
    * The current connection is set using Tyrant::setConnection() and
    * defaults to the last connection made
    *
    * @return   object|null     First connection in the stack
    */
    public function getConnection()
    {
        return self::$connection;
    }

    /**
    * Changes the current connection
    * @param    string  Server hostname or IP address
    * @param    string  Server port
    * @param    string  Optional existing connection id
    * @return   object|null     First connection in the stack
    */
    public function setConnection($host = 'localhost', $port = '1978', $id = 0)
    {
        $id = implode(':', array($host, $port, $id));
        self::$connection =& self::$connections[$id];
    }

    /**
    * Disconnects and removes a connection
    * @param    string  Server hostname or IP address
    * @param    string  Server port
    * @param    string  Optional existing connection id
    */
    public function disconnect($host = 'localhost', $port = '1978', $id = 0)
    {
        $id = implode(':', array($host, $port, $id));
        if (isset(self::$connections[$id])) {
            $connection =& self::$connections[$id];
            $connection->disconnect();
            unset(self::$connections[$id]);
            return true;
        }
        return false;
    }
}
