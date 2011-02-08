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
* Query class for the RDBTable database queries
*
* @package    Tyrant
* @author     Bertrand Mansion <bmansion@mamasam.com>
*/
class Tyrant_Query
{
    /**
    * Query arguments
    * @var  array
    */
    protected $args = array();

    /**
    * Query condition: string is equal to
    */
    const QCSTREQ = 0;

    /**
    * Query condition: string is included in
    */
    const QCSTRINC = 1;

    /**
    * Query condition: string begins with
    */
    const QCSTRBW = 2;

    /**
    * Query condition: string ends with
    */
    const QCSTREW = 3;

    /**
    * Query condition: string includes all tokens in
    */
    const QCSTRAND = 4;

    /**
    * Query condition: string includes at least one token in
    */
    const QCSTROR = 5;

    /**
    * Query condition: string is equal to at least one token in
    */
    const QCSTROREQ = 6;

    /**
    * Query condition: string matches regular expressions of
    */
    const QCSTRRX = 7;

    /**
    * Query condition: number is equal to
    */
    const QCNUMEQ = 8;

    /**
    * Query condition: number is greater than
    */
    const QCNUMGT = 9;

    /**
    * Query condition: number is greater than or equal to
    */
    const QCNUMGE = 10;

    /**
    * Query condition: number is less than
    */
    const QCNUMLT = 11;

    /**
    * Query condition: number is less than or equal to
    */
    const QCNUMLE = 12;

    /**
    * Query condition: number is between two tokens of
    */
    const QCNUMBT = 13;

    /**
    * Query condition: number is equal to at least one token in
    */
    const QCNUMOREQ = 14;

    /**
    * Query condition: full-text search with the phrase of the expression
    */
    const QCFTSPH = 15;

    /**
    * Query condition: full-text search with all tokens in the expression
    */
    const QCFTSAND = 16;

    /**
    * Query condition: full-text search with at least one token in the expression
    */
    const QCFTSOR = 17;

    /**
    * Query condition: full-text search with the compound expression
    */
    const QCFTSEX = 18;

    /**
    * Query condition: negation flag
    */
    const QCNEGATE = 16777216;

    /**
    * Query condition: no index flag
    */
    const QCNOIDX = 33554432;

    /**
    * Order type: string ascending
    */
    const QOSTRASC = 0;

    /**
    * Order type: string descending
    */
    const QOSTRDESC = 1;

    /**
    * Order type: number ascending
    */
    const QONUMASC = 2;

    /**
    * Order type: number descending
    */
    const QONUMDESC = 3;

    /**
    * Add a query argument for "string is equal to column"
    * @param    string  Column to query upon
    * @param    string  Value to search
    */
    public function is($name, $expr)
    {
        $this->addCond($name, self::QCSTREQ, $expr);
    }

    /**
    * Add a query argument for "string is included in column"
    * @param    string  Column to query upon
    * @param    string  Value to search
    */
    public function like($name, $expr)
    {
        $this->addCond($name, self::QCSTRINC, $expr);
    }

    /**
    * Add a query argument for "string includes at least one token from column"
    * @param    string  Column to query upon
    * @param    string  Value to search
    */
    public function has($name, $expr)
    {
        $this->addCond($name, self::QCSTROR, $expr);
    }

    /**
    * Add a query argument for "string includes all tokens from column"
    * @param    string  Column to query upon
    * @param    string  Value to search
    */
    public function hasAll($name, $expr)
    {
        $this->addCond($name, self::QCSTRAND, $expr);
    }

    /**
    * Add a query argument for "string is equal to at least one token from column"
    * @param    string  Column to query upon
    * @param    string  Value to search
    */
    public function isOne($name, $expr)
    {
        $this->addCond($name, self::QCSTROREQ, $expr);
    }

    /**
    * Add a query argument for "string begins with"
    * @param    string  Column to query upon
    * @param    string  Value to search
    */
    public function starts($name, $expr)
    {
        $this->addCond($name, self::QCSTRBW, $expr);
    }

    /**
    * Add a query argument for "string ends with"
    * @param    string  Column to query upon
    * @param    string  Value to search
    */
    public function ends($name, $expr)
    {
        $this->addCond($name, self::QCSTREW, $expr);
    }

    /**
    * Add a query argument for "string matches regular expressions of"
    * @param    string  Column to query upon
    * @param    string  Value to search
    */
    public function matches($name, $expr)
    {
        $this->addCond($name, self::QCSTRRX, $expr);
    }

    /**
    * Add a query argument for "number is equal to"
    * @param    string  Column to query upon
    * @param    string  Value to search
    */
    public function eq($name, $expr)
    {
        $this->addCond($name, self::QCNUMEQ, $expr);
    }

    /**
    * Add a query argument for "number is greater than"
    * @param    string  Column to query upon
    * @param    string  Value to search
    */
    public function gt($name, $expr)
    {
        $this->addCond($name, self::QCNUMGT, $expr);
    }

    /**
    * Add a query argument for "number is greater than or equal to"
    * @param    string  Column to query upon
    * @param    string  Value to search
    */
    public function gte($name, $expr)
    {
        $this->addCond($name, self::QCNUMGE, $expr);
    }

    /**
    * Add a query argument for "number is less than"
    * @param    string  Column to query upon
    * @param    string  Value to search
    */
    public function lt($name, $expr)
    {
        $this->addCond($name, self::QCNUMLT, $expr);
    }

    /**
    * Add a query argument for "number is less than or equal to"
    * @param    string  Column to query upon
    * @param    string  Value to search
    */
    public function lte($name, $expr)
    {
        $this->addCond($name, self::QCNUMLE, $expr);
    }

    /**
    * Add a query argument for "number is between two tokens of"
    * @param    string  Column to query upon
    * @param    string  Value to search
    */
    public function between($name, $expr)
    {
        $this->addCond($name, self::QCNUMBT, $expr);
    }

    /**
    * Add a query argument for "number is equal to at least one token in"
    * @param    string  Column to query upon
    * @param    string  Value to search
    */
    public function eqOne($name, $expr)
    {
        $this->addCond($name, self::QCNUMOREQ, $expr);
    }

    /**
    * Add a sort parameter for the query
    * @param    string  Column to sort
    * @param    string  'numeric' or 'literal'
    * @param    string  'asc' or 'desc'
    */
    public function sortBy($name, $type = 'numeric', $direction = 'asc')
    {
        if ($type != 'numeric') {
            $type = $direction != 'asc' ? self::QOSTRDESC : self::QOSTRASC;
        } else {
            $type = $direction != 'asc' ? self::QONUMDESC : self::QONUMASC;
        }
        $this->setOrder($name, $type);
    }

    /**
    * Add a narrowing condition for the query.
    * @param    string  Name of a column.  An empty string means the primary key.
    * @param    int     Operation type, see class constants.
    * @param    mixed   Operand exression.
    */
    public function addCond($name, $op, $expr)
    {
        $this->args[] = "addcond\0" . $name . "\0" . $op . "\0" . $expr;
    }

    /**
    * Add a sort parameter for the query
    * @param    string  Name of a column.
    * @param    int     Sort type, see class constants.
    */
    public function setOrder($name, $type)
    {
        $this->args['order'] = "setorder\0" . $name . "\0" . $type;
    }

    /**
    * Limit the number of records returned by the query
    * @param    int     Maximum number of records returned
    * @param    int     Number of records to skip
    */
    public function setLimit($max = -1, $skip = -1)
    {
        $this->args['limit'] = "setlimit\0" . $max . "\0" . $skip;
    }

    /**
    * Return the query arguments
    * @return   array   Query arguments
    */
    public function args()
    {
        return $this->args;
    }
}