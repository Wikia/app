<?php namespace r\pb;
/**
 * Auto generated from ql2.proto at 2013-05-29 23:14:34
 */

/**
 * Version enum embedded in VersionDummy message
 */
final class VersionDummy_Version
{
    const PB_V0_1 = 0x3f61ba36;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'V0_1' => self::PB_V0_1,
        );
    }
}

/**
 * VersionDummy message
 */
class VersionDummy extends \ProtobufMessage
{
    /* Field index constants */

    /* @var array Field descriptors */
    protected static $fields = array(
    );

    /**
     * Constructs new message container and clears its internal state
     *
     * @return null
     */
    public function __construct()
    {
        $this->clear();
    }

    /**
     * Clears message values and sets default ones
     *
     * @return null
     */
    public function clear()
    {
    }

    /**
     * Returns field descriptors
     *
     * @return array
     */
    public function getFields()
    {
        return self::$fields;
    }
}

/**
 * DatumType enum embedded in Datum message
 */
final class Datum_DatumType
{
    const PB_R_NULL = 1;
    const PB_R_BOOL = 2;
    const PB_R_NUM = 3;
    const PB_R_STR = 4;
    const PB_R_ARRAY = 5;
    const PB_R_OBJECT = 6;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'R_NULL' => self::PB_R_NULL,
            'R_BOOL' => self::PB_R_BOOL,
            'R_NUM' => self::PB_R_NUM,
            'R_STR' => self::PB_R_STR,
            'R_ARRAY' => self::PB_R_ARRAY,
            'R_OBJECT' => self::PB_R_OBJECT,
        );
    }
}

/**
 * AssocPair message embedded in Datum message
 */
class Datum_AssocPair extends \ProtobufMessage
{
    /* Field index constants */
    const KEY = 1;
    const VAL = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::KEY => array(
            'name' => 'key',
            'required' => false,
            'type' => 7,
        ),
        self::VAL => array(
            'name' => 'val',
            'required' => false,
            'type' => 'r\pb\Datum'
        ),
    );

    /**
     * Constructs new message container and clears its internal state
     *
     * @return null
     */
    public function __construct()
    {
        $this->clear();
    }

    /**
     * Clears message values and sets default ones
     *
     * @return null
     */
    public function clear()
    {
        $this->values[self::KEY] = null;
        $this->values[self::VAL] = null;
    }

    /**
     * Returns field descriptors
     *
     * @return array
     */
    public function getFields()
    {
        return self::$fields;
    }

    /**
     * Sets value of 'key' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setKey($value)
    {
        return $this->setValue(self::KEY, $value);
    }

    /**
     * Returns value of 'key' property
     *
     * @return string
     */
    public function getKey()
    {
        return $this->getValue(self::KEY);
    }

    /**
     * Sets value of 'val' property
     *
     * @param Datum $value Property value
     *
     * @return null
     */
    public function setVal(Datum $value)
    {
        return $this->setValue(self::VAL, $value);
    }

    /**
     * Returns value of 'val' property
     *
     * @return Datum
     */
    public function getVal()
    {
        return $this->getValue(self::VAL);
    }
}

/**
 * Datum message
 */
class Datum extends \ProtobufMessage
{
    /* Field index constants */
    const TYPE = 1;
    const R_BOOL = 2;
    const R_NUM = 3;
    const R_STR = 4;
    const R_ARRAY = 5;
    const R_OBJECT = 6;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TYPE => array(
            'name' => 'type',
            'required' => false,
            'type' => 5,
        ),
        self::R_BOOL => array(
            'name' => 'r_bool',
            'required' => false,
            'type' => 8,
        ),
        self::R_NUM => array(
            'name' => 'r_num',
            'required' => false,
            'type' => 1,
        ),
        self::R_STR => array(
            'name' => 'r_str',
            'required' => false,
            'type' => 7,
        ),
        self::R_ARRAY => array(
            'name' => 'r_array',
            'repeated' => true,
            'type' => 'r\pb\Datum'
        ),
        self::R_OBJECT => array(
            'name' => 'r_object',
            'repeated' => true,
            'type' => 'r\pb\Datum_AssocPair'
        ),
    );

    /**
     * Constructs new message container and clears its internal state
     *
     * @return null
     */
    public function __construct()
    {
        $this->clear();
    }

    /**
     * Clears message values and sets default ones
     *
     * @return null
     */
    public function clear()
    {
        $this->values[self::TYPE] = null;
        $this->values[self::R_BOOL] = null;
        $this->values[self::R_NUM] = null;
        $this->values[self::R_STR] = null;
        $this->values[self::R_ARRAY] = array();
        $this->values[self::R_OBJECT] = array();
    }

    /**
     * Returns field descriptors
     *
     * @return array
     */
    public function getFields()
    {
        return self::$fields;
    }

    /**
     * Sets value of 'type' property
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setType($value)
    {
        return $this->setValue(self::TYPE, $value);
    }

    /**
     * Returns value of 'type' property
     *
     * @return int
     */
    public function getType()
    {
        return $this->getValue(self::TYPE);
    }

    /**
     * Sets value of 'r_bool' property
     *
     * @param bool $value Property value
     *
     * @return null
     */
    public function setRBool($value)
    {
        return $this->setValue(self::R_BOOL, $value);
    }

    /**
     * Returns value of 'r_bool' property
     *
     * @return bool
     */
    public function getRBool()
    {
        return $this->getValue(self::R_BOOL);
    }

    /**
     * Sets value of 'r_num' property
     *
     * @param float $value Property value
     *
     * @return null
     */
    public function setRNum($value)
    {
        return $this->setValue(self::R_NUM, $value);
    }

    /**
     * Returns value of 'r_num' property
     *
     * @return float
     */
    public function getRNum()
    {
        return $this->getValue(self::R_NUM);
    }

    /**
     * Sets value of 'r_str' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setRStr($value)
    {
        return $this->setValue(self::R_STR, $value);
    }

    /**
     * Returns value of 'r_str' property
     *
     * @return string
     */
    public function getRStr()
    {
        return $this->getValue(self::R_STR);
    }

    /**
     * Appends value to 'r_array' list
     *
     * @param Datum $value Value to append
     *
     * @return null
     */
    public function appendRArray(Datum $value)
    {
        $this->appendValue(self::R_ARRAY, $value);
    }

    /**
     * Clears 'r_array' list
     *
     * @return null
     */
    public function clearRArray()
    {
        $this->clearValues(self::R_ARRAY);
    }

    /**
     * Returns 'r_array' list
     *
     * @return Datum[]
     */
    public function getRArray()
    {
        return $this->getValue(self::R_ARRAY);
    }

    /**
     * Returns 'r_array' iterator
     *
     * @return ArrayIterator
     */
    public function getRArrayIterator()
    {
        return new \ArrayIterator($this->getValue(self::R_ARRAY));
    }

    /**
     * Returns element from 'r_array' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return Datum
     */
    public function getRArrayAt($offset)
    {
        return $this->getValue(self::R_ARRAY, $offset);
    }

    /**
     * Returns count of 'r_array' list
     *
     * @return int
     */
    public function getRArrayCount()
    {
        return $this->getCount(self::R_ARRAY);
    }

    /**
     * Appends value to 'r_object' list
     *
     * @param Datum_AssocPair $value Value to append
     *
     * @return null
     */
    public function appendRObject(Datum_AssocPair $value)
    {
        $this->appendValue(self::R_OBJECT, $value);
    }

    /**
     * Clears 'r_object' list
     *
     * @return null
     */
    public function clearRObject()
    {
        $this->clearValues(self::R_OBJECT);
    }

    /**
     * Returns 'r_object' list
     *
     * @return Datum_AssocPair[]
     */
    public function getRObject()
    {
        return $this->getValue(self::R_OBJECT);
    }

    /**
     * Returns 'r_object' iterator
     *
     * @return ArrayIterator
     */
    public function getRObjectIterator()
    {
        return new \ArrayIterator($this->getValue(self::R_OBJECT));
    }

    /**
     * Returns element from 'r_object' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return Datum_AssocPair
     */
    public function getRObjectAt($offset)
    {
        return $this->getValue(self::R_OBJECT, $offset);
    }

    /**
     * Returns count of 'r_object' list
     *
     * @return int
     */
    public function getRObjectCount()
    {
        return $this->getCount(self::R_OBJECT);
    }
}

/**
 * TermType enum embedded in Term message
 */
final class Term_TermType
{
    const PB_DATUM = 1;
    const PB_MAKE_ARRAY = 2;
    const PB_MAKE_OBJ = 3;
    const PB_VAR = 10;
    const PB_JAVASCRIPT = 11;
    const PB_ERROR = 12;
    const PB_IMPLICIT_VAR = 13;
    const PB_DB = 14;
    const PB_TABLE = 15;
    const PB_GET = 16;
    const PB_GET_ALL = 78;
    const PB_EQ = 17;
    const PB_NE = 18;
    const PB_LT = 19;
    const PB_LE = 20;
    const PB_GT = 21;
    const PB_GE = 22;
    const PB_NOT = 23;
    const PB_ADD = 24;
    const PB_SUB = 25;
    const PB_MUL = 26;
    const PB_DIV = 27;
    const PB_MOD = 28;
    const PB_APPEND = 29;
    const PB_SLICE = 30;
    const PB_SKIP = 70;
    const PB_LIMIT = 71;
    const PB_GETATTR = 31;
    const PB_CONTAINS = 32;
    const PB_PLUCK = 33;
    const PB_WITHOUT = 34;
    const PB_MERGE = 35;
    const PB_BETWEEN = 36;
    const PB_REDUCE = 37;
    const PB_MAP = 38;
    const PB_FILTER = 39;
    const PB_CONCATMAP = 40;
    const PB_ORDERBY = 41;
    const PB_DISTINCT = 42;
    const PB_COUNT = 43;
    const PB_UNION = 44;
    const PB_NTH = 45;
    const PB_GROUPED_MAP_REDUCE = 46;
    const PB_GROUPBY = 47;
    const PB_INNER_JOIN = 48;
    const PB_OUTER_JOIN = 49;
    const PB_EQ_JOIN = 50;
    const PB_ZIP = 72;
    const PB_COERCE_TO = 51;
    const PB_TYPEOF = 52;
    const PB_UPDATE = 53;
    const PB_DELETE = 54;
    const PB_REPLACE = 55;
    const PB_INSERT = 56;
    const PB_DB_CREATE = 57;
    const PB_DB_DROP = 58;
    const PB_DB_LIST = 59;
    const PB_TABLE_CREATE = 60;
    const PB_TABLE_DROP = 61;
    const PB_TABLE_LIST = 62;
    const PB_INDEX_CREATE = 75;
    const PB_INDEX_DROP = 76;
    const PB_INDEX_LIST = 77;
    const PB_FUNCALL = 64;
    const PB_BRANCH = 65;
    const PB_ANY = 66;
    const PB_ALL = 67;
    const PB_FOREACH = 68;
    const PB_FUNC = 69;
    const PB_ASC = 73;
    const PB_DESC = 74;
    const PB_INFO = 79;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'DATUM' => self::PB_DATUM,
            'MAKE_ARRAY' => self::PB_MAKE_ARRAY,
            'MAKE_OBJ' => self::PB_MAKE_OBJ,
            'VAR' => self::PB_VAR,
            'JAVASCRIPT' => self::PB_JAVASCRIPT,
            'ERROR' => self::PB_ERROR,
            'IMPLICIT_VAR' => self::PB_IMPLICIT_VAR,
            'DB' => self::PB_DB,
            'TABLE' => self::PB_TABLE,
            'GET' => self::PB_GET,
            'GET_ALL' => self::PB_GET_ALL,
            'EQ' => self::PB_EQ,
            'NE' => self::PB_NE,
            'LT' => self::PB_LT,
            'LE' => self::PB_LE,
            'GT' => self::PB_GT,
            'GE' => self::PB_GE,
            'NOT' => self::PB_NOT,
            'ADD' => self::PB_ADD,
            'SUB' => self::PB_SUB,
            'MUL' => self::PB_MUL,
            'DIV' => self::PB_DIV,
            'MOD' => self::PB_MOD,
            'APPEND' => self::PB_APPEND,
            'SLICE' => self::PB_SLICE,
            'SKIP' => self::PB_SKIP,
            'LIMIT' => self::PB_LIMIT,
            'GETATTR' => self::PB_GETATTR,
            'CONTAINS' => self::PB_CONTAINS,
            'PLUCK' => self::PB_PLUCK,
            'WITHOUT' => self::PB_WITHOUT,
            'MERGE' => self::PB_MERGE,
            'BETWEEN' => self::PB_BETWEEN,
            'REDUCE' => self::PB_REDUCE,
            'MAP' => self::PB_MAP,
            'FILTER' => self::PB_FILTER,
            'CONCATMAP' => self::PB_CONCATMAP,
            'ORDERBY' => self::PB_ORDERBY,
            'DISTINCT' => self::PB_DISTINCT,
            'COUNT' => self::PB_COUNT,
            'UNION' => self::PB_UNION,
            'NTH' => self::PB_NTH,
            'GROUPED_MAP_REDUCE' => self::PB_GROUPED_MAP_REDUCE,
            'GROUPBY' => self::PB_GROUPBY,
            'INNER_JOIN' => self::PB_INNER_JOIN,
            'OUTER_JOIN' => self::PB_OUTER_JOIN,
            'EQ_JOIN' => self::PB_EQ_JOIN,
            'ZIP' => self::PB_ZIP,
            'COERCE_TO' => self::PB_COERCE_TO,
            'TYPEOF' => self::PB_TYPEOF,
            'UPDATE' => self::PB_UPDATE,
            'DELETE' => self::PB_DELETE,
            'REPLACE' => self::PB_REPLACE,
            'INSERT' => self::PB_INSERT,
            'DB_CREATE' => self::PB_DB_CREATE,
            'DB_DROP' => self::PB_DB_DROP,
            'DB_LIST' => self::PB_DB_LIST,
            'TABLE_CREATE' => self::PB_TABLE_CREATE,
            'TABLE_DROP' => self::PB_TABLE_DROP,
            'TABLE_LIST' => self::PB_TABLE_LIST,
            'INDEX_CREATE' => self::PB_INDEX_CREATE,
            'INDEX_DROP' => self::PB_INDEX_DROP,
            'INDEX_LIST' => self::PB_INDEX_LIST,
            'FUNCALL' => self::PB_FUNCALL,
            'BRANCH' => self::PB_BRANCH,
            'ANY' => self::PB_ANY,
            'ALL' => self::PB_ALL,
            'FOREACH' => self::PB_FOREACH,
            'FUNC' => self::PB_FUNC,
            'ASC' => self::PB_ASC,
            'DESC' => self::PB_DESC,
            'INFO' => self::PB_INFO,
        );
    }
}

/**
 * AssocPair message embedded in Term message
 */
class Term_AssocPair extends \ProtobufMessage
{
    /* Field index constants */
    const KEY = 1;
    const VAL = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::KEY => array(
            'name' => 'key',
            'required' => false,
            'type' => 7,
        ),
        self::VAL => array(
            'name' => 'val',
            'required' => false,
            'type' => 'r\pb\Term'
        ),
    );

    /**
     * Constructs new message container and clears its internal state
     *
     * @return null
     */
    public function __construct()
    {
        $this->clear();
    }

    /**
     * Clears message values and sets default ones
     *
     * @return null
     */
    public function clear()
    {
        $this->values[self::KEY] = null;
        $this->values[self::VAL] = null;
    }

    /**
     * Returns field descriptors
     *
     * @return array
     */
    public function getFields()
    {
        return self::$fields;
    }

    /**
     * Sets value of 'key' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setKey($value)
    {
        return $this->setValue(self::KEY, $value);
    }

    /**
     * Returns value of 'key' property
     *
     * @return string
     */
    public function getKey()
    {
        return $this->getValue(self::KEY);
    }

    /**
     * Sets value of 'val' property
     *
     * @param Term $value Property value
     *
     * @return null
     */
    public function setVal(Term $value)
    {
        return $this->setValue(self::VAL, $value);
    }

    /**
     * Returns value of 'val' property
     *
     * @return Term
     */
    public function getVal()
    {
        return $this->getValue(self::VAL);
    }
}

/**
 * Term message
 */
class Term extends \ProtobufMessage
{
    /* Field index constants */
    const TYPE = 1;
    const DATUM = 2;
    const ARGS = 3;
    const OPTARGS = 4;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TYPE => array(
            'name' => 'type',
            'required' => false,
            'type' => 5,
        ),
        self::DATUM => array(
            'name' => 'datum',
            'required' => false,
            'type' => 'r\pb\Datum'
        ),
        self::ARGS => array(
            'name' => 'args',
            'repeated' => true,
            'type' => 'r\pb\Term'
        ),
        self::OPTARGS => array(
            'name' => 'optargs',
            'repeated' => true,
            'type' => 'r\pb\Term_AssocPair'
        ),
    );

    /**
     * Constructs new message container and clears its internal state
     *
     * @return null
     */
    public function __construct()
    {
        $this->clear();
    }

    /**
     * Clears message values and sets default ones
     *
     * @return null
     */
    public function clear()
    {
        $this->values[self::TYPE] = null;
        $this->values[self::DATUM] = null;
        $this->values[self::ARGS] = array();
        $this->values[self::OPTARGS] = array();
    }

    /**
     * Returns field descriptors
     *
     * @return array
     */
    public function getFields()
    {
        return self::$fields;
    }

    /**
     * Sets value of 'type' property
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setType($value)
    {
        return $this->setValue(self::TYPE, $value);
    }

    /**
     * Returns value of 'type' property
     *
     * @return int
     */
    public function getType()
    {
        return $this->getValue(self::TYPE);
    }

    /**
     * Sets value of 'datum' property
     *
     * @param Datum $value Property value
     *
     * @return null
     */
    public function setDatum(Datum $value)
    {
        return $this->setValue(self::DATUM, $value);
    }

    /**
     * Returns value of 'datum' property
     *
     * @return Datum
     */
    public function getDatum()
    {
        return $this->getValue(self::DATUM);
    }

    /**
     * Appends value to 'args' list
     *
     * @param Term $value Value to append
     *
     * @return null
     */
    public function appendArgs(Term $value)
    {
        $this->appendValue(self::ARGS, $value);
    }

    /**
     * Clears 'args' list
     *
     * @return null
     */
    public function clearArgs()
    {
        $this->clearValues(self::ARGS);
    }

    /**
     * Returns 'args' list
     *
     * @return Term[]
     */
    public function getArgs()
    {
        return $this->getValue(self::ARGS);
    }

    /**
     * Returns 'args' iterator
     *
     * @return ArrayIterator
     */
    public function getArgsIterator()
    {
        return new \ArrayIterator($this->getValue(self::ARGS));
    }

    /**
     * Returns element from 'args' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return Term
     */
    public function getArgsAt($offset)
    {
        return $this->getValue(self::ARGS, $offset);
    }

    /**
     * Returns count of 'args' list
     *
     * @return int
     */
    public function getArgsCount()
    {
        return $this->getCount(self::ARGS);
    }

    /**
     * Appends value to 'optargs' list
     *
     * @param Term_AssocPair $value Value to append
     *
     * @return null
     */
    public function appendOptargs(Term_AssocPair $value)
    {
        $this->appendValue(self::OPTARGS, $value);
    }

    /**
     * Clears 'optargs' list
     *
     * @return null
     */
    public function clearOptargs()
    {
        $this->clearValues(self::OPTARGS);
    }

    /**
     * Returns 'optargs' list
     *
     * @return Term_AssocPair[]
     */
    public function getOptargs()
    {
        return $this->getValue(self::OPTARGS);
    }

    /**
     * Returns 'optargs' iterator
     *
     * @return ArrayIterator
     */
    public function getOptargsIterator()
    {
        return new \ArrayIterator($this->getValue(self::OPTARGS));
    }

    /**
     * Returns element from 'optargs' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return Term_AssocPair
     */
    public function getOptargsAt($offset)
    {
        return $this->getValue(self::OPTARGS, $offset);
    }

    /**
     * Returns count of 'optargs' list
     *
     * @return int
     */
    public function getOptargsCount()
    {
        return $this->getCount(self::OPTARGS);
    }
}

/**
 * QueryType enum embedded in Query message
 */
final class Query_QueryType
{
    const PB_START = 1;
    const PB_CONTINUE = 2;
    const PB_STOP = 3;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'START' => self::PB_START,
            'CONTINUE' => self::PB_CONTINUE,
            'STOP' => self::PB_STOP,
        );
    }
}

/**
 * AssocPair message embedded in Query message
 */
class Query_AssocPair extends \ProtobufMessage
{
    /* Field index constants */
    const KEY = 1;
    const VAL = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::KEY => array(
            'name' => 'key',
            'required' => false,
            'type' => 7,
        ),
        self::VAL => array(
            'name' => 'val',
            'required' => false,
            'type' => 'r\pb\Term'
        ),
    );

    /**
     * Constructs new message container and clears its internal state
     *
     * @return null
     */
    public function __construct()
    {
        $this->clear();
    }

    /**
     * Clears message values and sets default ones
     *
     * @return null
     */
    public function clear()
    {
        $this->values[self::KEY] = null;
        $this->values[self::VAL] = null;
    }

    /**
     * Returns field descriptors
     *
     * @return array
     */
    public function getFields()
    {
        return self::$fields;
    }

    /**
     * Sets value of 'key' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setKey($value)
    {
        return $this->setValue(self::KEY, $value);
    }

    /**
     * Returns value of 'key' property
     *
     * @return string
     */
    public function getKey()
    {
        return $this->getValue(self::KEY);
    }

    /**
     * Sets value of 'val' property
     *
     * @param Term $value Property value
     *
     * @return null
     */
    public function setVal(Term $value)
    {
        return $this->setValue(self::VAL, $value);
    }

    /**
     * Returns value of 'val' property
     *
     * @return Term
     */
    public function getVal()
    {
        return $this->getValue(self::VAL);
    }
}

/**
 * Query message
 */
class Query extends \ProtobufMessage
{
    /* Field index constants */
    const TYPE = 1;
    const QUERY = 2;
    const TOKEN = 3;
    const GLOBAL_OPTARGS = 6;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TYPE => array(
            'name' => 'type',
            'required' => false,
            'type' => 5,
        ),
        self::QUERY => array(
            'name' => 'query',
            'required' => false,
            'type' => 'r\pb\Term'
        ),
        self::TOKEN => array(
            'name' => 'token',
            'required' => false,
            'type' => 5,
        ),
        self::GLOBAL_OPTARGS => array(
            'name' => 'global_optargs',
            'repeated' => true,
            'type' => 'r\pb\Query_AssocPair'
        ),
    );

    /**
     * Constructs new message container and clears its internal state
     *
     * @return null
     */
    public function __construct()
    {
        $this->clear();
    }

    /**
     * Clears message values and sets default ones
     *
     * @return null
     */
    public function clear()
    {
        $this->values[self::TYPE] = null;
        $this->values[self::QUERY] = null;
        $this->values[self::TOKEN] = null;
        $this->values[self::GLOBAL_OPTARGS] = array();
    }

    /**
     * Returns field descriptors
     *
     * @return array
     */
    public function getFields()
    {
        return self::$fields;
    }

    /**
     * Sets value of 'type' property
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setType($value)
    {
        return $this->setValue(self::TYPE, $value);
    }

    /**
     * Returns value of 'type' property
     *
     * @return int
     */
    public function getType()
    {
        return $this->getValue(self::TYPE);
    }

    /**
     * Sets value of 'query' property
     *
     * @param Term $value Property value
     *
     * @return null
     */
    public function setQuery(Term $value)
    {
        return $this->setValue(self::QUERY, $value);
    }

    /**
     * Returns value of 'query' property
     *
     * @return Term
     */
    public function getQuery()
    {
        return $this->getValue(self::QUERY);
    }

    /**
     * Sets value of 'token' property
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setToken($value)
    {
        return $this->setValue(self::TOKEN, $value);
    }

    /**
     * Returns value of 'token' property
     *
     * @return int
     */
    public function getToken()
    {
        return $this->getValue(self::TOKEN);
    }

    /**
     * Appends value to 'global_optargs' list
     *
     * @param Query_AssocPair $value Value to append
     *
     * @return null
     */
    public function appendGlobalOptargs(Query_AssocPair $value)
    {
        $this->appendValue(self::GLOBAL_OPTARGS, $value);
    }

    /**
     * Clears 'global_optargs' list
     *
     * @return null
     */
    public function clearGlobalOptargs()
    {
        $this->clearValues(self::GLOBAL_OPTARGS);
    }

    /**
     * Returns 'global_optargs' list
     *
     * @return Query_AssocPair[]
     */
    public function getGlobalOptargs()
    {
        return $this->getValue(self::GLOBAL_OPTARGS);
    }

    /**
     * Returns 'global_optargs' iterator
     *
     * @return ArrayIterator
     */
    public function getGlobalOptargsIterator()
    {
        return new \ArrayIterator($this->getValue(self::GLOBAL_OPTARGS));
    }

    /**
     * Returns element from 'global_optargs' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return Query_AssocPair
     */
    public function getGlobalOptargsAt($offset)
    {
        return $this->getValue(self::GLOBAL_OPTARGS, $offset);
    }

    /**
     * Returns count of 'global_optargs' list
     *
     * @return int
     */
    public function getGlobalOptargsCount()
    {
        return $this->getCount(self::GLOBAL_OPTARGS);
    }
}

/**
 * FrameType enum embedded in Frame message
 */
final class Frame_FrameType
{
    const PB_POS = 1;
    const PB_OPT = 2;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'POS' => self::PB_POS,
            'OPT' => self::PB_OPT,
        );
    }
}

/**
 * Frame message
 */
class Frame extends \ProtobufMessage
{
    /* Field index constants */
    const TYPE = 1;
    const POS = 2;
    const OPT = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TYPE => array(
            'name' => 'type',
            'required' => false,
            'type' => 5,
        ),
        self::POS => array(
            'name' => 'pos',
            'required' => false,
            'type' => 5,
        ),
        self::OPT => array(
            'name' => 'opt',
            'required' => false,
            'type' => 7,
        ),
    );

    /**
     * Constructs new message container and clears its internal state
     *
     * @return null
     */
    public function __construct()
    {
        $this->clear();
    }

    /**
     * Clears message values and sets default ones
     *
     * @return null
     */
    public function clear()
    {
        $this->values[self::TYPE] = null;
        $this->values[self::POS] = null;
        $this->values[self::OPT] = null;
    }

    /**
     * Returns field descriptors
     *
     * @return array
     */
    public function getFields()
    {
        return self::$fields;
    }

    /**
     * Sets value of 'type' property
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setType($value)
    {
        return $this->setValue(self::TYPE, $value);
    }

    /**
     * Returns value of 'type' property
     *
     * @return int
     */
    public function getType()
    {
        return $this->getValue(self::TYPE);
    }

    /**
     * Sets value of 'pos' property
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setPos($value)
    {
        return $this->setValue(self::POS, $value);
    }

    /**
     * Returns value of 'pos' property
     *
     * @return int
     */
    public function getPos()
    {
        return $this->getValue(self::POS);
    }

    /**
     * Sets value of 'opt' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setOpt($value)
    {
        return $this->setValue(self::OPT, $value);
    }

    /**
     * Returns value of 'opt' property
     *
     * @return string
     */
    public function getOpt()
    {
        return $this->getValue(self::OPT);
    }
}

/**
 * Backtrace message
 */
class Backtrace extends \ProtobufMessage
{
    /* Field index constants */
    const FRAMES = 1;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::FRAMES => array(
            'name' => 'frames',
            'repeated' => true,
            'type' => 'r\pb\Frame'
        ),
    );

    /**
     * Constructs new message container and clears its internal state
     *
     * @return null
     */
    public function __construct()
    {
        $this->clear();
    }

    /**
     * Clears message values and sets default ones
     *
     * @return null
     */
    public function clear()
    {
        $this->values[self::FRAMES] = array();
    }

    /**
     * Returns field descriptors
     *
     * @return array
     */
    public function getFields()
    {
        return self::$fields;
    }

    /**
     * Appends value to 'frames' list
     *
     * @param Frame $value Value to append
     *
     * @return null
     */
    public function appendFrames(Frame $value)
    {
        $this->appendValue(self::FRAMES, $value);
    }

    /**
     * Clears 'frames' list
     *
     * @return null
     */
    public function clearFrames()
    {
        $this->clearValues(self::FRAMES);
    }

    /**
     * Returns 'frames' list
     *
     * @return Frame[]
     */
    public function getFrames()
    {
        return $this->getValue(self::FRAMES);
    }

    /**
     * Returns 'frames' iterator
     *
     * @return ArrayIterator
     */
    public function getFramesIterator()
    {
        return new \ArrayIterator($this->getValue(self::FRAMES));
    }

    /**
     * Returns element from 'frames' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return Frame
     */
    public function getFramesAt($offset)
    {
        return $this->getValue(self::FRAMES, $offset);
    }

    /**
     * Returns count of 'frames' list
     *
     * @return int
     */
    public function getFramesCount()
    {
        return $this->getCount(self::FRAMES);
    }
}

/**
 * ResponseType enum embedded in Response message
 */
final class Response_ResponseType
{
    const PB_SUCCESS_ATOM = 1;
    const PB_SUCCESS_SEQUENCE = 2;
    const PB_SUCCESS_PARTIAL = 3;
    const PB_CLIENT_ERROR = 16;
    const PB_COMPILE_ERROR = 17;
    const PB_RUNTIME_ERROR = 18;

    /**
     * Returns defined enum values
     *
     * @return int[]
     */
    public function getEnumValues()
    {
        return array(
            'SUCCESS_ATOM' => self::PB_SUCCESS_ATOM,
            'SUCCESS_SEQUENCE' => self::PB_SUCCESS_SEQUENCE,
            'SUCCESS_PARTIAL' => self::PB_SUCCESS_PARTIAL,
            'CLIENT_ERROR' => self::PB_CLIENT_ERROR,
            'COMPILE_ERROR' => self::PB_COMPILE_ERROR,
            'RUNTIME_ERROR' => self::PB_RUNTIME_ERROR,
        );
    }
}

/**
 * Response message
 */
class Response extends \ProtobufMessage
{
    /* Field index constants */
    const TYPE = 1;
    const TOKEN = 2;
    const RESPONSE = 3;
    const BACKTRACE = 4;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TYPE => array(
            'name' => 'type',
            'required' => false,
            'type' => 5,
        ),
        self::TOKEN => array(
            'name' => 'token',
            'required' => false,
            'type' => 5,
        ),
        self::RESPONSE => array(
            'name' => 'response',
            'repeated' => true,
            'type' => 'r\pb\Datum'
        ),
        self::BACKTRACE => array(
            'name' => 'backtrace',
            'required' => false,
            'type' => 'r\pb\Backtrace'
        ),
    );

    /**
     * Constructs new message container and clears its internal state
     *
     * @return null
     */
    public function __construct()
    {
        $this->clear();
    }

    /**
     * Clears message values and sets default ones
     *
     * @return null
     */
    public function clear()
    {
        $this->values[self::TYPE] = null;
        $this->values[self::TOKEN] = null;
        $this->values[self::RESPONSE] = array();
        $this->values[self::BACKTRACE] = null;
    }

    /**
     * Returns field descriptors
     *
     * @return array
     */
    public function getFields()
    {
        return self::$fields;
    }

    /**
     * Sets value of 'type' property
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setType($value)
    {
        return $this->setValue(self::TYPE, $value);
    }

    /**
     * Returns value of 'type' property
     *
     * @return int
     */
    public function getType()
    {
        return $this->getValue(self::TYPE);
    }

    /**
     * Sets value of 'token' property
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setToken($value)
    {
        return $this->setValue(self::TOKEN, $value);
    }

    /**
     * Returns value of 'token' property
     *
     * @return int
     */
    public function getToken()
    {
        return $this->getValue(self::TOKEN);
    }

    /**
     * Appends value to 'response' list
     *
     * @param Datum $value Value to append
     *
     * @return null
     */
    public function appendResponse(Datum $value)
    {
        $this->appendValue(self::RESPONSE, $value);
    }

    /**
     * Clears 'response' list
     *
     * @return null
     */
    public function clearResponse()
    {
        $this->clearValues(self::RESPONSE);
    }

    /**
     * Returns 'response' list
     *
     * @return Datum[]
     */
    public function getResponse()
    {
        return $this->getValue(self::RESPONSE);
    }

    /**
     * Returns 'response' iterator
     *
     * @return ArrayIterator
     */
    public function getResponseIterator()
    {
        return new \ArrayIterator($this->getValue(self::RESPONSE));
    }

    /**
     * Returns element from 'response' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return Datum
     */
    public function getResponseAt($offset)
    {
        return $this->getValue(self::RESPONSE, $offset);
    }

    /**
     * Returns count of 'response' list
     *
     * @return int
     */
    public function getResponseCount()
    {
        return $this->getCount(self::RESPONSE);
    }

    /**
     * Sets value of 'backtrace' property
     *
     * @param Backtrace $value Property value
     *
     * @return null
     */
    public function setBacktrace(Backtrace $value)
    {
        return $this->setValue(self::BACKTRACE, $value);
    }

    /**
     * Returns value of 'backtrace' property
     *
     * @return Backtrace
     */
    public function getBacktrace()
    {
        return $this->getValue(self::BACKTRACE);
    }
}
