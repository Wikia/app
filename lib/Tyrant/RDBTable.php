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
require_once dirname(__FILE__).'/Query.php';

/**
* Table type database connection
*
* @package    Tyrant
* @author     Bertrand Mansion <bmansion@mamasam.com>
*/
class Tyrant_RDBTable extends Tyrant_Common
{
    /**
    * index type: lexical string
    */
    const ITLEXICAL = 0;

    /**
    * index type: decimal string
    */
    const ITDECIMAL = 1;

    /**
    * index type: token inverted index
    */
    const ITTOKEN = 2;

    /**
    * index type: q-gram inverted index
    */
    const ITQGRAM = 3;

    /**
    * index type: optimize
    */
    const ITOPT = 9998;

    /**
    * index type: void
    */
    const ITVOID = 9999;

    /**
    * index type: keep existing index
    */
    const ITKEEP = 16777216; // 1 << 24

    /**
    * Store a record
    * If a record with the same key exists in the database,
    * it is overwritten.
    *
    * @param    string|int  Specifies the primary key.
    * @param    array       Associative array containing key/values.
    * @return   bool        True if successful, false otherwise
    * @throws   Tyrant_Exception
    */
    public function put($key, $value)
    {
        $args = array($key);
        foreach ($value as $ckey => $cvalue) {
            $args[] = $ckey;
            $args[] = $cvalue;
        }
        $rv = $this->misc('put', $args, 0);
        if ($rv === false) {
            throw new Tyrant_Exception("Put error");
        }
        return true;
    }

    /**
    * Store a new record
    * If a record with the same key exists in the database,
    * this method has no effect.
    *
    * @param    string|int  Specifies the primary key.
    * @param    array       Associative array containing key/values.
    * @return   bool        True if successful, false otherwise
    * @throws   Tyrant_Exception
    */
    public function putkeep($key, Array $values)
    {
        $args = array($key);
        foreach ($values as $ckey => $cvalue) {
            $args[] = $ckey;
            $args[] = $cvalue;
        }
        $rv = $this->misc('putkeep', $args, 0);
        if ($rv === false) {
            throw new Tyrant_Exception("Put error");
        }
        return true;
    }

    /**
    * Concatenate columns of the existing record
    * If there is no corresponding record, a new record is created.
    *
    * @param    string|int  Specifies the primary key.
    * @param    array       Associative array containing key/values.
    * @return   bool        True if successful, false otherwise
    * @throws   Tyrant_Exception
    */
    public function putcat($key, Array $values)
    {
        $args = array($key);
        foreach ($values as $ckey => $cvalue) {
            $args[] = $ckey;
            $args[] = $cvalue;
        }
        $rv = $this->misc('putcat', $args, 0);
        if ($rv === false) {
            throw new Tyrant_Exception("Put error");
        }
        return true;
    }

    /**
    * Retrieve a record
    * @param    int|string  Specifies the primary key.
    * @return   array|false If successful, the return value is an
    *                       associative array, false if no record were found.
    */
    public function get($key)
    {
        $args = array($key);
        $rv = $this->misc('get', $args, Tyrant::MONOULOG);
        if ($rv === false) {
            $rnum = $this->_recvInt32();
            return null;
        }
        $cols = array();
        $cnum = count($rv) - 1;
        $i = 0;
        while ($i < $cnum) {
            $cols[$rv[$i]] = $rv[$i+1];
            $i += 2;
        }
        return $cols;
    }

    /**
    * Retrieve records
    * Due to the protocol restriction, this method can not handle records
    * with binary columns including the "\0" chracter.
    *
    * @param    array   Associative array containing the primary keys.
    *                   As a result of this method, keys existing in the
    *                   database have the corresponding columns and keys
    *                   not existing in the database are removed.
    * @return   int|false   If successful, the return value is the number of
    *                       records found. False if none found.
    */
    public function mget(Array &$recs)
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
            $cols = array();
            $kref = $this->_recv($ksiz);
            $vref = $this->_recv($vsiz);
            $cary = explode("\0", $vref);
            $cnum = count($cary) - 1;
            $j = 0;
            while ($j < $cnum) {
                $cols[$cary[$j]] = $cary[$j+1];
                $j += 2;
            }
            $recs[$kref] = $cols;
        }
        return $rnum;
    }

    /**
    * Set a column index
    * @param    string  Name of a column.
    *                   If the name of an existing index is specified,
    *                   the index is rebuilt. An empty string means the
    *                   primary key.
    * @param    int     Specifies the index type:
    *                   - Tyrant_RDBTable::ITLEXICAL for lexical string
    *                   - Tyrant_RDBTable::ITDECIMAL for decimal string
    *                   - Tyrant::ITOPT for optimizing the index
    *                   - tyrant_RDBTable::ITVOID for removing the index
    *                   If Tyrant_RDBTable::ITKEEP is added by bitwise-or and
    *                   the index exists, this method merely returns failure.
    *
    * @return   bool    True if successful
    * @throws   Tyrant_Exception
    */
    public function setindex($name, $type)
    {
        $args = array($name, $type);
        $rv = $this->misc('setindex', $args, 0);
        if ($rv === false) {
            throw new Tyrant_Exception("Could not set index on ".$name);
        }
        return true;
    }

    /**
    * Generate a unique ID number
    * @return   int   The new unique ID number
    * @throws   Tyrant_Exception
    */
    public function genuid()
    {
        $rv = $this->misc('genuid', array());
        if ($rv === false) {
            throw new Tyrant_Exception("Could not generate a new unique ID");
        }
        return $rv[0];
    }

    /**
    * Execute a search
    * This method does never fail and return an empty array even
    * if no record corresponds.
    *
    * @param    object  A Tyrant_Query object
    * @return   array   Array of the primary keys of records found.
    */
    public function search(Tyrant_Query $query)
    {
        $rv = $this->misc("search", $query->args(), Tyrant::MONOULOG);
        return empty($rv) ? array() : $rv;
    }

    /**
    * Remove each corresponding records
    *
    * @param    object  A Tyrant_Query object
    * @return bool True if successful, false otherwise
    */
    public function searchOut(Tyrant_Query $query)
    {
        $args = $query->args();
        $args[] = "out";
        $rv = $this->misc("search", $args, 0);
        return empty($rv) ? array() : $rv;
    }

    /**
    * Get records corresponding to the search of a query object
    * The return value is an array of associative arrays with column of
    * the corresponding records. This method does never fail and return
    * an empty array even if no record corresponds.
    * Due to the protocol restriction, this method can not handle records
    * with binary columns including the "\0" chracter.
    *
    * @param    object  A Tyrant_Query object
    * @param    string|array    Array of column names to be fetched.
    *                           An empty string returns the primary key.
    *                           If it is left null, every column is fetched.
    * @return   array   Array of records found
    */
    public function searchGet(Tyrant_Query $query, $names = null)
    {
        $args = $query->args();
        if (is_array($names)) {
            $args[] = "get\0" . implode("\0", $names);
        } else {
            $args[] = "get";
        }
        $rv = $this->misc("search", $args, Tyrant::MONOULOG);
        if (empty($rv)) {
            return array();
        }
        foreach ($rv as $i => $v) {
            $cols = array();
            $cary = explode("\0", $v);
            $cnum = count($cary) - 1;
            $j = 0;
            while ($j < $cnum) {
                $cols[$cary[$j]] = $cary[$j+1];
                $j += 2;
            }
            $rv[$i] = $cols;
        }
        return $rv;
    }

    /**
    * Get the count of corresponding records
    *
    * @param    object  A Tyrant_Query object
    * @return   int     Count of corresponding records or 0 on failure
    */
    public function searchCount(Tyrant_Query $query)
    {
        $args = $query->args();
        $args[] = "count";
        $rv = $this->misc("search", $args, Tyrant::MONOULOG);
        return empty($rv) ? 0 : $rv[0];
    }
}
