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

require_once dirname(__FILE__).'/Common.php';

/**
* Hash and other types of database connection, all except the Table type
*
* @package    Tyrant
* @author     Bertrand Mansion <bmansion@mamasam.com>
*/
class Tyrant_RDB extends Tyrant_Common
{
    /**
    * Unconditionally set key to value
    * If a record with the same key exists in the database, 
    * it is overwritten.
    *
    * @param    string|int  Specifies the key.
    * @param    mixed       A scalar value (or an object with __toString)
    * @return   bool        True if successful, false otherwise
    * @throws   Tyrant_Exception
    */
    public function put($key, $value)
    {
        $cmd = pack('CCNN', 0xC8, 0x10, strlen($key), strlen($value)) . 
                $key . $value;
        $code = $this->_send($cmd);
        if ($code !== 0) {
            throw new Tyrant_Exception("Put error");
        }        
        return true;
    }

    /**
    * Store a new record
    * If a record with the same key exists in the database,
    * this method has no effect.
    *
    * @param    string|int  Specifies the key.
    * @param    mixed       A scalar value (or an object with __toString)
    * @return   bool        True if successful, false otherwise
    * @throws   Tyrant_Exception
    */
    public function putkeep($key, $value)
    {
        $cmd = pack('CCNN', 0xC8, 0x11, strlen($key), strlen($value)) . 
                $key . $value;
        $code = $this->_send($cmd);
        if ($code !== 0) {
            throw new Tyrant_Exception("Put error");
        }        
        return true;
    }

    /**
    * Append value to the existing value for key, or set key to
    * value if it does not already exist.
    *
    * @param    string|int  Specifies the key.
    * @param    mixed       A scalar value (or an object with __toString)
    * @return   bool        True if successful, false otherwise
    * @throws   Tyrant_Exception
    */
    public function putcat($key, $value)
    {
        $cmd = pack('CCNN', 0xC8, 0x12, strlen($key), strlen($value)) . 
                $key . $value;
        $code = $this->_send($cmd);
        if ($code !== 0) {
            throw new Tyrant_Exception("Put error");
        }        
        return true;
    }

    /**
    * Concatenate a value at the end of the existing record and 
    * shift it to the left
    *
    * @param    string|int  Specifies the key.
    * @param    mixed       A scalar value (or an object with __toString)
    * @return   bool        True if successful, false otherwise
    * @throws   Tyrant_Exception
    */
    public function putshl($key, $value, $width)
    {
        $width = $width < 0 ? 0 : (int)$width;
        $cmd = pack('CCNNN', 0xC8, 0x13, strlen($key), strlen($value), $width) . 
                $key . $value;
        $code = $this->_send($cmd);
        if ($code !== 0) {
            throw new Tyrant_Exception("Put error");
        }        
        return true;
    }

    /**
    * Set key to value without waiting for a server response
    *
    * @param    string|int  Specifies the key.
    * @param    mixed       A scalar value (or an object with __toString)
    * @return   bool        True if successful, false otherwise
    * @throws   Tyrant_Exception
    */
    public function putnr($key, $value)
    {
        $cmd = pack('CCNN', 0xC8, 0x18, strlen($key), strlen($value)) . 
                $key . $value;
        $status = $this->_socketWrite($cmd);
        if ($status === false) {
            throw new Tyrant_Exception("Put error");
        }
        return true;
    }

    /**
    * Get the value of a key from the server
    *
    * @param    string|int  Specifies the key.
    * @return   string|null The value
    */
    public function get($key)
    {
        $cmd = pack('CCN', 0xC8, 0x30, strlen($key)) . $key;
        $code = $this->_send($cmd);
        if ($code !== 0) {
            return null;
        }
        $value = $this->_recv();
        return $value;
    }

    /**
    * Retrieve records
    * As a result of this method, keys existing in the database have 
    * the corresponding values and keys not existing in the database 
    * are removed.
    *
    * @param    array   Associative array containing the retrieval keys
    *                   The array is given by reference so it will be 
    *                   filled with the values found.
    * @return   int|false   Number of retrieved records or false on failure.
    */
    public function mget(&$recs)
    {
        $rnum = 0;
        $cmd = "";
        foreach ($recs as $key => $value) {
            $cmd .= pack("N", strlen($key)) . $key;
            $rnum++;
        }
        $cmd = pack("CCN", 0xC8, 0x31, $rnum) . $cmd;
        $code = $this->_send($cmd);
        if ($code !== 0) {
            return false;
        }
        $rnum = $this->_recvInt32();
        if ($rnum === false) {
            return false;
        }
        $recs = array();
        for ($i = 0; $i < $rnum; $i++) {
            $ksiz = $this->_recvInt32();
            $vsiz = $this->_recvInt32();
            if ($ksiz === false || $vsiz === false) {
                return false;
            }
            $kref = $this->_recv($ksiz);
            $vref = $this->_recv($vsiz);
            $recs[$kref] = $vref;
        }
        return $rnum;
    }

    /**
    * Add an integer to a record
    * If the corresponding record exists, the value is treated as 
    * an integer and is added to the existing value. If no record exists, 
    * a new record is created with the value.
    * 
    * @param    string      The key
    * @param    int         The additional value
    * @return   int|false   The summation value or false
    * @throws   Tyrant_Exception
    */
    public function addInt($key, $num = 0)
    {
        $cmd = pack("CCNN", 0xC8, 0x60, strlen($key), (int)$num) . $key;
        $code = $this->_send($cmd);
        if ($code !== 0) {
            throw new Tyrant_Exception("Could not addInt to ".$key);
        }
        return $this->_recvInt32();
    }

    /**
    * Add a real number to a record
    * If the corresponding record exists, the value is treated as 
    * a real number and is added to the existing value. If no record exists, 
    * a new record is created with the value.
    * 
    * @param    string      The key
    * @param    int         The additional value
    * @return   int|false   The summation value or false
    * @throws   Tyrant_Exception
    */
    public function addDouble($key, $num = 0)
    {
        $integ = substr($num, 0, strpos($num, '.'));
        $fract = (abs($num) - floor(abs($num)))*1000000000000;
        $cmd = pack('CCN', 0xC8, 0x61, strlen($key)) . 
                $this->_pack64($integ) . $this->_pack64($fract) . $key;
        $code = $this->_send($cmd);
        if ($code !== 0) {
            throw new Tyrant_Exception("AddDouble error");
        }
        $integ = $this->_recvint64();
        $fract = $this->_recvint64();
        return $integ + ($fract / 1000000000000);
    }
}