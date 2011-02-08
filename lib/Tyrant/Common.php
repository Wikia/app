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
require_once dirname(__FILE__).'/../Tyrant.php';

/**
* Abstract base class for all types of database connections
*
* This base class is mostly here to avoid duplication of code since
* databases share common functions. It
*
* @package    Tyrant
* @author     Bertrand Mansion <bmansion@mamasam.com>
*/
abstract class Tyrant_Common implements ArrayAccess, Countable, Iterator
{
    protected $socket;
    protected $mhost;
    protected $mport;

    abstract function put($key, $value);
    abstract function get($key);

    public function __construct(&$socket)
    {
        $this->socket =& $socket;
    }

    /**
    * Close the connection to TokyoTyrant
    */
    public function disconnect()
    {
        if (is_resource($this->socket)) {
            socket_close($this->socket);
            $this->socket = null;
        }
    }

    /**
    * Returns the connection socket
    * @return resource  Connection socket
    */
    public function &socket()
    {
        return $this->socket;
    }

    /**
    * Set/Get the connection host/port
    */
	public function sethost($host) { $this->mhost = $host; }
	public function setport($port) { $this->mport = $port; }

	public function gethost() { return $this->mhost; }
	public function getport() { return $this->mport; }

    /**
    * Removes a record
    *
    * @param    string  Specifies the primary key
    * @return   bool    True when successful, false otherwise
    */
    public function out($key)
    {
        $cmd = pack('CCN', 0xC8, 0x20, strlen($key)) . $key;
        $code = $this->_send($cmd);
        if ($code !== 0) {
            return false;
        }
        return true;
    }

    /**
    * Gets the size of the value of a record
    *
    * @param    string  Specifies the key
    * @return   int|false   Number with size or false otherwise
    */
    public function vsiz($key)
    {
        $cmd = pack("CCN", 0xC8, 0x38, strlen($key)) . $key;
        $code = $this->_send($cmd);
        if ($code !== 0) {
            return false;
        }
        return $this->_recvInt32();
    }

    /**
    * Initializes the iterator
    *
    * The iterator is used in order to access the key of every record
    * stored in a database.
    *
    * @return   bool    True when successful, false otherwise
    */
    public function iterinit()
    {
        $cmd = pack("CC", 0xC8, 0x50);
        $code = $this->_send($cmd);
        if ($code !== 0) {
            return false;
        }
        return true;
    }

    /**
    * Gets the next key of the iterator
    *
    * It is possible to access every record by iteration of
    * calling this method. It is allowed to update or remove
    * records whose keys are fetched while the iteration.
    * However, it is not assured if updating the database is
    * occurred while the iteration. Besides, the order of this
    * traversal access method is arbitrary, so it is not assured
    * that the order of storing matches the one of the traversal
    * access.
    *
    * @return   mixed   Either the next key when successful, false if no more records are available
    */
    public function iternext()
    {
        $cmd = pack("CC", 0xC8, 0x51);
        $code = $this->_send($cmd);
        if ($code !== 0) {
            return false;
        }
        $ksiz = $this->_recvInt32();
        if ($ksiz === false) {
            return false;
        }
        $kref = $this->_recv($ksiz);
        return $kref;
    }

    /**
    * Gets forward matching keys
    *
    * The return value is an array of the keys of the
    * corresponding records. This method does never fail and return
    * an empty array even if no record corresponds. Note that this
    * method may be very slow because every key in the database is
    * scanned.
    *
    * @param    string  Prefix of the corresponding keys
    * @param    int     Maximum number of keys to be fetched. If it
    *                   is not defined or negative, no limit is specified.
    * @return   array   An array of found primary keys
    */
    public function fwmkeys($prefix, $max = null)
    {
        $keys = array();
        if (empty($max) || $max < 0) {
            $max = (1<<31);
        }
        $cmd = pack("CCNN", 0xC8, 0x58, strlen($prefix), $max) . $prefix;
        $code = $this->_send($cmd);
        if ($code !== 0) {
            return $keys;
        }
        $knum = $this->_recvInt32();
        if ($knum === false) {
            return $keys;
        }
        for ($i = 0; $i < $knum; $i++) {
            $ksiz = $this->_recvInt32();
            if ($ksiz === false) {
                return $keys;
            }
            $kref = $this->_recv($ksiz);
            $keys[] = $kref;
        }
        return $keys;
    }

    /**
    * Synchronizes updated contents with the file and the device
    * @return   bool    True when successful, false otherwise
    */
    public function sync()
    {
        $cmd = pack('CC', 0xC8, 0x70);
        $code = $this->_send($cmd);
        if ($code !== 0) {
            return false;
        }
        return true;
    }

    /**
    * Optimize the database file
    * @return   bool    True when successful, false otherwise
    */
    public function optimize($params = "")
    {
        $cmd = pack('CCN', 0xC8, 0x71, strlen($params)) . $params;
        $code = $this->_send($cmd);
        if ($code !== 0) {
            return false;
        }
        return true;
    }

    /**
    * Remove all records
    * @return   bool    True when successful, false otherwise
    */
    public function vanish()
    {
        $cmd = pack('CC', 0xC8, 0x72);
        $code = $this->_send($cmd);
        if ($code !== 0) {
            return false;
        }
        return true;
    }

    /**
    * Copy the database file
    *
    * The database file is assured to be kept synchronized and not modified
    * while the copying or executing operation is in progress.
    * So, this method is useful to create a backup file of the database file.
    *
    * @param    string  Specifies the path of the destination file.
    *                   If it begins with `@', the trailing substring
    *                   is executed as a command line.
    * @return   True if successful, false otherwise.
    */
    public function copy($path)
    {
        $cmd = pack('CCN', 0xC8, 0x73, strlen($path)) . $path;
        $code = $this->_send($cmd);
        if ($code !== 0) {
            return false;
        }
        return true;
    }

    /**
    * Restore the database with update log
    *
    * @param    Specifies the path of the update log directory
    * @param    Specifies the beginning time stamp in microseconds
    * @param    Specifies options by bitwise-or:
    *           - Tyrant::ROCHKCON for consistency checking
    * @return   True if successful, false otherwise.
    */
    public function restore($path, $msec, $opts = 0)
    {
        $cmd = pack('CCN', 0xC8, 0x74, strlen($path)) .
                $this->_pack64($msec) . $opts . $path;
        $code = $this->_send($cmd);
        if ($code !== 0) {
            return false;
        }
        return true;
    }

    /**
    * Get the number of records
    * @return int|false Number of records or false if something goes wrong
    */
    public function rnum()
    {
        $cmd = pack('CC', 0xC8, 0x80);
        $code = $this->_send($cmd);
        if ($code !== 0) {
            return false;
        }
        return $this->_recvInt64();
    }

    /**
    * Get the size of the database
    * @return mixed  Database size or false if something goes wrong
    */
    public function size()
    {
        $cmd = pack('CC', 0xC8, 0x81);
        $code = $this->_send($cmd);
        if ($code !== 0) {
            return false;
        }
        return $this->_recvInt64();
    }

    /**
    * Get some statistics about the database
    * @return   array   Array of statistics about the database
    */
    public function stat()
    {
        $cmd = pack('CC', 0xC8, 0x88);
        $code = $this->_send($cmd);
        if ($code !== 0) {
            return false;
        }
        $value = $this->_recv();
        $value = explode("\n", trim($value));
        $stats = array();
        foreach ($value as $v) {
            $v = explode("\t", $v);
            $stats[$v[0]] = $v[1];
        }
        return $stats;
    }


    /**
    * Call a versatile function for miscellaneous operations
    *
    * All databases support "putlist", "outlist", and "getlist".
    * - putlist is to store records. It receives keys and values one
    *   after the other, and returns an empty list.
    * - outlist is to remove records. It receives keys, and returns
    *   an empty list.
    * - getlist is to retrieve records. It receives keys, and returns
    *   values.
    *
    * Table database supports "setindex", "search", "genuid".
    *
    * @param    string  Specifies the name of the function
    * @param    array   Specifies an array containing arguments
    * @param    int     Specifies options by bitwise-or
    *                   bitflag that can be Tyrant::MONOULOG to prevent
    *                   writing to the update log
    * @return   array|false     Values or false if something goes wrong
    */
    public function misc($name, Array $args = array(), $opts = 0)
    {
        $cmd = pack('CCNNN', 0xC8, 0x90, strlen($name), $opts,
                count($args)) . $name;
        foreach ($args as $arg) {
            $cmd .= pack('N', strlen($arg)) . $arg;
        }
        $code = $this->_send($cmd);
        if ($code !== 0) {
            return false;
        }
        $rnum = $this->_recvInt32();
        $res = array();
        for ($i = 0; $i < $rnum; $i++) {
            $esiz = $this->_recvInt32();
            if ($esiz === false) {
                return false;
            }
            $eref = $this->_recv($esiz);
            if ($eref === false) {
                return false;
            }
            $res[] = $eref;
        }
        return $res;
    }


    /**
    * Call a function of the script language extension
    *
    * @param    string  Specifies the function name
    * @param    string  Specifies the key. Defaults to an empty string.
    * @param    string  Specifies the value. Defaults to an empty string.
    * @param    int     Specifies options by bitwise-or:
    *                   - Tyrant::XOLCKREC for record locking
    *                   - Tyrant::XOLCKGLB for global locking
    *                   Defaults to no option.
    * @return   mixed   Value of the response or false on failure
    */
    public function ext($name, $key = '', $value = '', $opts = 0)
    {
        $cmd = pack('CCNNNN', 0xC8, 0x68, strlen($name), $opts,
                strlen($key), strlen($value)) .
                $name . $key . $value;
        $code = $this->_send($cmd);
        if ($code !== 0) {
            return false;
        }
        $vsiz = $this->_recvInt32();
        if ($vsiz < 0) {
            return false;
        }
        $vbuf = $this->_recv($vsiz);
        return $vbuf;
    }


    protected function _socketWrite($cmd)
    {
        $len = strlen($cmd);
        $offset = 0;
        while ($offset < $len) {
            $sent = socket_write($this->socket, substr($cmd, $offset), $len-$offset);
            if ($sent === false) {
                return false;
            }
            $offset += $sent;
        }
        return ($offset < $len) ? false : true;
    }

    protected function _send($cmd)
    {
        $status = $this->_socketWrite($cmd);
        if ($status === false) {
            return false;
        }
        $code = $this->_recvCode();
        if ($code === false) {
            return false;
        }
        return $code;
    }

    protected function _recv($len = null)
    {
        if (is_null($len)) {
            $len = $this->_recvInt32();
            if ($len === false) {
                return false;
            }
        }
        if ($len < 1) {
            return "";
        }
        $str = "";
        if (($rec = socket_recv($this->socket, $str, $len, 0)) <= 0) {
            return false;
        }
        if (strlen($str) == $len) {
            return $str;
        }
        $len -= strlen($str);
        while ($len > 0) {
            $tstr = "";
            if (($rec = socket_recv($this->socket, $tstr, $len, 0)) <= 0) {
                return false;
            }
            $len -= strlen($tstr);
            $str .= $tstr;
        }
        return $str;
    }

    protected function _recvCode()
    {
        if (($rbuf = $this->_recv(1)) !== false) {
            $c = unpack("C", $rbuf);
            if (!isset($c[1])) {
                return false;
            }
            return $c[1];
        }
        return false;
    }

    protected function _recvInt32()
    {
        if (($rbuf = $this->_recv(4)) !== false) {
            $num = unpack("N", $rbuf);
            if (!isset($num[1])) {
                return false;
            }
            $size = unpack("l", pack("l", $num[1]));
            return $size[1];
        }
        return false;
    }

    protected function _recvInt64()
    {
        if (($rbuf = $this->_recv(8)) !== false) {
            return $this->_unpack64($rbuf);
        }
        return false;
    }

    /**
    * Portability function to pack a x64 value with PHP limitations
    * @return   mixed   Packed number
    */
    protected function _pack64($v)
    {
    	// x64
    	if (PHP_INT_SIZE >= 8) {
    		$v = (int)$v;
    		return pack ("NN", $v>>32, $v&0xFFFFFFFF);
    	}
    	// x32, int
    	if (is_int($v)) {
    		return pack("NN", $v < 0 ? -1 : 0, $v);
    	}
    	// x32, bcmath
    	if (function_exists("bcmul")) {
            if (bccomp($v, 0) == -1) {
    			$v = bcadd("18446744073709551616", $v);
    		}
    		$h = bcdiv($v, "4294967296", 0);
    		$l = bcmod($v, "4294967296");
    		return pack ("NN", (float)$h, (float)$l); // conversion to float is intentional; int would lose 31st bit
    	}
    	// x32, no-bcmath
    	$p = max(0, strlen($v) - 13);
    	$lo = abs((float)substr($v, $p));
    	$hi = abs((float)substr($v, 0, $p));
    	$m = $lo + $hi*1316134912.0; // (10 ^ 13) % (1 << 32) = 1316134912
    	$q = floor($m/4294967296.0);
    	$l = $m - ($q*4294967296.0);
    	$h = $hi*2328.0 + $q; // (10 ^ 13) / (1 << 32) = 2328
    	if ($v < 0) {
            if ($l == 0) {
    			$h = 4294967296.0 - $h;
            } else {
    			$h = 4294967295.0 - $h;
    			$l = 4294967296.0 - $l;
    		}
    	}
    	return pack("NN", $h, $l);
    }

    /**
    * Portability function to unpack a x64 value with PHP limitations
    * @return   mixed   Might return a string of numbers or the actual value
    */
    protected function _unpack64($v)
    {
    	list($hi, $lo) = array_values (unpack("N*N*", $v));
    	// x64
    	if (PHP_INT_SIZE >= 8) {
    		if ($hi < 0) $hi += (1<<32); // because php 5.2.2 to 5.2.5 is totally fucked up again
    		if ($lo < 0) $lo += (1<<32);
    		return ($hi<<32) + $lo;
    	}
    	// x32, int
    	if ($hi == 0) {
    		if ($lo > 0) {
    			return $lo;
    		}
    		return sprintf("%u", $lo);
    	} elseif ($hi == -1) {
    	    // x32, int
    		if ($lo < 0) {
    			return $lo;
    		}
    		return sprintf("%.0f", $lo - 4294967296.0);
    	}
    	$neg = "";
    	$c = 0;
    	if ($hi < 0) {
    		$hi = ~$hi;
    		$lo = ~$lo;
    		$c = 1;
    		$neg = "-";
    	}
    	$hi = sprintf ("%u", $hi);
    	$lo = sprintf ("%u", $lo);
    	// x32, bcmath
    	if (function_exists("bcmul")) {
    		return $neg . bcadd(bcadd($lo, bcmul($hi, "4294967296")), $c);
    	}
    	// x32, no-bcmath
    	$hi = (float)$hi;
    	$lo = (float)$lo;
    	$q = floor($hi/10000000.0);
    	$r = $hi - $q*10000000.0;
    	$m = $lo + $r*4967296.0;
    	$mq = floor($m/10000000.0);
    	$l = $m - $mq*10000000.0 + $c;
    	$h = $q*4294967296.0 + $r*429.0 + $mq;
    	$h = sprintf("%.0f", $h);
    	$l = sprintf("%07.0f", $l);
    	if ($h == "0") {
    		return $neg . sprintf("%.0f", (float)$l);
    	}
    	return $neg . $h . $l;
    }

    /**
    * Store the current iterator key or false if no key is available
    * @var string
    */
    protected $_current;

    /**
    * Rewind the Iterator to the first element.
    * Similar to the reset() function for arrays in PHP
    * @return void
    */
    public function rewind()
    {
        $this->iterinit();
        $this->_current = $this->iternext();
    }

    /**
    * Return the current element.
    * Similar to the current() function for arrays in PHP
    * @return mixed current element from the collection
    */
    public function current()
    {
        return $this->get($this->_current);
    }

    /**
    * Return the identifying key of the current element.
    * Similar to the key() function for arrays in PHP
    * @return mixed either an integer or a string
    */
    public function key()
    {
        return $this->_current;
    }

    /**
    * Move forward to next element.
    * Similar to the next() function for arrays in PHP
    * @return void
    */
    public function next()
    {
        $this->_current = $this->iternext();
    }

    /**
    * Check if there is a current element after calls to rewind() or next().
    * Used to check if we've iterated to the end of the collection
    * @return boolean FALSE if there's nothing more to iterate over
    */
    public function valid()
    {
        return $this->_current !== false;
    }


    /**
    * Returns whether the key exists
    * @return boolean
    */
    public function offsetExists($offset)
    {
        return $this->vsiz($offset) !== false;
    }

    /**
    * Returns the value associated with the key
    * @return mixed
    */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
    * Sets a value for the key
    * @return boolean   True if value was set successfully
    */
    public function offsetSet($offset, $value)
    {
        return $this->put($offset, $value);
    }

    /**
    * Removes the value for the key
    * @return void
    */
    public function offsetUnset($offset)
    {
        $this->out($offset);
    }

    /**
    * Returns the number of records in the database
    * @return int   Number of records
    */
    public function count()
    {
        return $this->rnum();
    }
}
