<?php

/**
 * WikiaApiQuery
 *
 * @author Piotr Molski (moli) <moli@wikia.com>
 *
 * @todo document this
 *
 */

define ('WIKIA_API_QUERY_LIMIT', 	25);
define ('WIKIA_API_QUERY_MIN_LIMIT',	1);

define ('WIKIA_API_QUERY_OFFSET',	0);
define ('WIKIA_API_QUERY_MIN_OFFSET',	0);

define ('WIKIA_API_QUERY_CTIME',	5 * 60 * 3);
define ('WIKIA_API_QUERY_MIN_CTIME',	5);

define ('WIKIA_API_QUERY_DBNAME',	(isset($wgDBname))?$wgDBname:(isset($wgSharedDB))?$wgSharedDB:"");

define ('COOKIE_EXPR',	15552000);

class WikiaApiQuery extends ApiQueryBase {
    /**
     * const
     */
    #--- action's params
	const INSERT 	= "insert";
	const UPDATE 	= "update";
	const DELETE	= "wdelete";
	const QUERY 	= "query";

    #--- default params
	const MAX_LIMIT 	= 25;
	const DEF_LIMIT 	= 0;
	const DEF_LIMIT_COUNT 	= 5;
	const CACHE_TIME 	= 1800;

    #--- user status
    const USER_LOGIN		= 1;
    const USER_ANON		= 2;
    const USER_LOGOUT		= 3;

    #--- DB constant
    const DEFAULT_DB_TIME	= 'NOW()';

    /**
     * local variables
     */
	private $mAction, $mUser, $mTable, $mFields, $mWhere, $mOptions;
	private $mBrowser;
	private $mIndexTagName;
    /**
     * constructor
     */
	public function __construct($query, $moduleName) {
		$this->mAction = $query->getModuleName();
		$this->mUser = $this->getContext()->getUser();
		$this->mBrowser = $this->getUniqueBrowserId();
		$this->mIndexTagName = 'item';
		parent :: __construct($query, $moduleName, "wk");
	}

	/*
	 * private & protected function
	 */

	/*
	 *
	 * Allowed parameters
	 *
	 */

	private function getAllowedDefParams() {
		$allowParams = array (
			'dbname' => array (
				ApiBase :: PARAM_ISMULTI => 0,
				ApiBase :: PARAM_TYPE => 'string',
				ApiBase :: PARAM_DFLT => WIKIA_API_QUERY_DBNAME,
			));
		if ($this->getActionName() == 'query') {
			$allowParams = array_merge($allowParams, array (
				'limit' => array (
					ApiBase :: PARAM_ISMULTI => 0,
					ApiBase::PARAM_TYPE => 'limit',
					ApiBase :: PARAM_DFLT => WIKIA_API_QUERY_LIMIT,
					ApiBase :: PARAM_MIN => WIKIA_API_QUERY_MIN_LIMIT,
					ApiBase::PARAM_MAX => ApiBase::LIMIT_SML1,
					ApiBase::PARAM_MAX2 => ApiBase::LIMIT_SML2,
				),
				'offset' => array (
					ApiBase :: PARAM_ISMULTI => 0,
					ApiBase :: PARAM_TYPE => 'integer',
					ApiBase :: PARAM_DFLT => WIKIA_API_QUERY_OFFSET,
					ApiBase :: PARAM_MIN => WIKIA_API_QUERY_MIN_OFFSET,
				),
				'ctime' => array (
					ApiBase :: PARAM_ISMULTI => 0,
					ApiBase :: PARAM_TYPE => 'integer',
					ApiBase :: PARAM_DFLT => WIKIA_API_QUERY_CTIME,
					ApiBase :: PARAM_MIN => WIKIA_API_QUERY_MIN_CTIME,
				),
				));
		}
		return $allowParams;
	}

	#---
	protected function getAllowedInsParams() {
		return false;
	}

	#---
	protected function getAllowedUpdParams() {
		return false;
	}

	#---
	protected function getAllowedDelParams() {
		return false;
	}

	#---
	protected function getAllowedQueryParams() {
		return array();
	}

	#---
	public function getAllowedParams() {
		$allowParam = $this->getAllowedDefParams();
		switch ($this->getActionName())
		{
			case self::INSERT : $allowParam = array_merge($allowParam, $this->getAllowedInsParams()); break;
			case self::UPDATE : $allowParam = array_merge($allowParam, $this->getAllowedUpdParams()); break;
			case self::DELETE : $allowParam = array_merge($allowParam, $this->getAllowedDelParams()); break;
			default : $allowParam = array_merge($allowParam, $this->getAllowedQueryParams()); break;
		}
		return $allowParam;
        }


	/*
	 *
	 * Descriptions
	 *
	 */
	#---
	private function getDefDescription() {
		return false;
	}

	#---
	protected function getInsDescription() {
		return false;
	}

	#---
	protected function getUpdDescription() {
		return false;
	}

	#---
	protected function getDelDescription() {
		return false;
	}

	#---
	protected function getQueryDescription() {
		return false;
	}

	#---
	public function getDescription() {
		$desc = false;
		switch ($this->getActionName())
		{
			case self::INSERT : $desc = ($this->getInsDescription() === false)?false:$this->getInsDescription(); break;
			case self::UPDATE : $desc = ($this->getUpdDescription() === false)?false:$this->getUpdDescription(); break;
			case self::DELETE : $desc = ($this->getDelDescription() === false)?false:$this->getDelDescription(); break;
			default: $desc = ($this->getQueryDescription() === false)?false:$this->getQueryDescription(); break;
		}
		return $desc;
	}

	/*
	 *
	 * Description's parameters
	 *
	 */
	#---
	protected function getParamInsDescription() {
		return false;
	}

	#---
	protected function getParamUpdDescription() {
		return false;
	}

	#---
	protected function getParamDelDescription() {
		return false;
	}

	#---
	protected function getParamQueryDescription() {
		return false;
	}

	private function getParamDefDescription() {
		$paramDesc = array('dbname' => 'Name of database');
		if ($this->getActionName() == 'query') {
			$paramDesc = array_merge($paramDesc, array(
				'limit' => 'This parameter allow to get correct package with items and means "limit" in SQL statement. ',
				'offset' => 'Number of elements in items\' package. This parameter means "limit limit, offset" in SQL statement. ',
				'ctime'	=> 'Cache entry lifetime timeout (in seconds)',
			));
		}
		return $paramDesc;
	}

	#---
	public function getParamDescription() {
		$paramDesc = $this->getParamDefDescription();
		switch ($this->getActionName())
		{
			case self::INSERT : $paramDesc = array_merge($paramDesc, $this->getParamInsDescription()); break;
			case self::UPDATE : $paramDesc = array_merge($paramDesc, $this->getParamUpdDescription()); break;
			case self::DELETE : $paramDesc = array_merge($paramDesc, $this->getParamDelDescription()); break;
			default: $paramDesc = array_merge($paramDesc, $this->getParamQueryDescription()); break;
		}
		return $paramDesc;
	}


	/*
	 *
	 * show examples
	 *
	 */
	#---
	protected function getInsExamples() {
		return false; //default;
	}

	#---
	protected function getUpdExamples() {
		return false; //default;
	}

	#---
	protected function getDelExamples() {
		return false; //default;
	}

	public function getExamples() {
		$samples = (is_array(parent::getExamples()))?parent::getExamples():array();
		switch ($this->getActionName())
		{
			case self::INSERT : $samples = array_merge($samples, $this->getInsExamples()); break;
			case self::UPDATE : $samples = array_merge($samples, $this->getUpdExamples()); break;
			case self::DELETE : $samples = array_merge($samples, $this->getDelExamples()); break;
			default: $samples = array_merge($samples, $this->getQueryExamples()); break;
		}

		return $samples;
	}

    /**
     * Initial parameters
     */
	protected function getInitialParams() {
		$initialParams = $this->getAllowedParams();
		$requestParams = $this->extractRequestParams();
		foreach ($initialParams as $param => $value) {
			if ( isset($requestParams[$param]) ) {
				$initialParams[$param] = $requestParams[$param];
			} else {
				$initialParams[$param] = null;
			}
		}
		return $initialParams;
	}

    /**
     * main function
     */
    public function execute() {
    	//
    }

    /**
     * database functions
     */

	#---
	protected function setFields($value) {
		$this->mFields = $value;
	}

	#---
	protected function setField($key, $value) {
		$this->mFields[$key] = $value;
	}

	#---
	protected function setTable($value) {
		$this->mTable = $value;
	}

	#---
	protected function initQueryParams() {
		$this->mTable = null;
		$this->mFields = $this->mWhere = $this->mOptions = array();
	}

	#---
	protected function addWhere($value) {
		if ($this->getActionName() == 'query') {
			parent::addWhere($value);
		} else {
			if (is_array($value))
				$this->mWhere = array_merge($this->mWhere, $value);
			else
				$this->mWhere[] = $value;
		}
	}

	#---
	protected function addWhereIf($value, $condition) {
		if ($condition) {
			$this->addWhere($value);
			return true;
		}
		return false;
	}

	#---
	protected function addWhereFld($field, $value) {
		if ($this->getActionName() == 'query') {
			parent::addWhereFld($field,$value);
		} else {
			if (!is_null($value)) {
				$this->mWhere[$field] = $value;
			}
		}
	}

	#---
	public function queryOptions($value) {
		if ( is_array($value) )
			$this->mOptions = array_merge($this->mOptions, $value);
		else
			$this->mOptions[] = $value;
	}

	#---
	protected function addTables($value, $alias = NULL) {
		if ($this->getActionName() == 'query') {
			parent::addTables($value);
		} else {
			if (is_array($value)) {
				foreach($value as $_ => $v) {
					$this->mTable[] = $v;
				}
			} else {
				if (!is_array($this->mTable)) {
					$this->mTable = $value;
				} else {
					$this->mTable[] = $value;
				}
			}
		}
	}

	#---
	protected function addFields($value) {
		if ($this->getActionName() == 'query') {
			parent::addFields($value);
		} else {
			if (is_array($value)) {
				foreach($value as $_ => $v) {
					$this->mFields[] = $v;
				}
			} else {
				$this->mFields[] = $value;
			}
		}
	}

	#---
	protected function addOption($name, $value = null) {
		if ($this->getActionName() == 'query') {
			parent::addOption($name,$value);
		} else {
			if (is_null($value))
				$this->mOptions[] = $name;
			else
				$this->mOptions[$name] = $value;
		}
	}

	#---
	protected function insert($method) {
		if (wfReadOnly())
			$this->dieUsageMsg(array('readonlytext'));

		// getDB has its own profileDBIn/Out calls
		$db = $this->getDB();
		$db->begin($method);
		$res = $db->insert( $this->mTable, $this->mFields, $method, $this->mOptions);
		$db->commit($method);
		return $res;
	}

	#---
	protected function update($method) {
		if (wfReadOnly())
			$this->dieUsageMsg(array('readonlytext'));

		// getDB has its own profileDBIn/Out calls
		$db = $this->getDB();
		$db->begin($method);
		$db->update( $this->mTable, $this->mFields, $this->mWhere, $method, $this->mOptions);
		$db->commit($method);
		return true;
	}

	#---
	protected function replace($method) {
		if (wfReadOnly())
			$this->dieUsageMsg(array('readonlytext'));

		// getDB has its own profileDBIn/Out calls
		$db = $this->getDB();
		$db->begin($method);
		$db->replace( $this->mTable, "", $this->mFields, $method );
		$db->commit($method);
		return true;
	}

	#---
	protected function delete($method, $close = 1) {
		if (wfReadOnly())
			$this->dieUsageMsg(array('readonlytext'));

		$db = $this->getDB();
		$db->begin($method);
		$res = $db->delete( $this->mTable, $this->mWhere, $method );
		$db->commit($method);
		return $res;
	}

	#---
	protected function select($method, $extraQuery = array()) {
		if ($this->getActionName() == 'query') {
			$res = parent::select($method);
		} else {
			$db =& $this->getDB();
			$res = $db->select($this->mTable, $this->mFields, $this->mWhere, $method, $this->mOptions);
		}
		return $res;
	}

	#---
	public function getDataRowsFromDB ( $dbname, $select, $from, $where = array(), $options = array() )
	{
        #--- database instance
		$db =& $this->getDB();
        $db->selectDB( $dbname );

		$this->addTables( $from );
		if (!is_array($select)) $select = array($select);

		#-- always first item in $select array should be key
		$key = $select[0];

		#--
		if (!empty($where)) $this->addWhere($where);

		if (!empty($options)) {
			foreach ($options as $id => $option) {
				foreach ($option as $optname => $optvalue) {
					$this->addOption ( $optname, $optvalue );
				}
			}
		}

		$result = array();
		$res = $this->select(__METHOD__);
		while ($row = $db->fetchObject($res)) {
			foreach ( array_values($select) as $id => $value ) {
				$result[$row->$key][$value] = $row->$value;
			}
		}
		$db->freeResult($res);

		return $result;
	}

	/*
	 * memcache functions
	 */
	#---
	public function getDataFromCache( $key ) {
		global $wgMemc;
		$cached = $wgMemc->get(md5($key));
		return $cached;
	}

	#---
	public function initCacheKey (&$key, $initParam, $value = "") {
		global $wgDBname;
		$key = $wgDBname.":".$initParam;
		if ( !empty($value) ) {
			$key .= ":".$value;
		}
	}

	#---
	public function setCacheKey (&$key, $prefix, $value) {
		$prefix = (empty($prefix))?"":$prefix.":";
		$prefix .= $value;
		$key .= "::".$prefix;
	}

	#---
	public function saveCacheData($key, $data, $time = WIKIA_API_QUERY_CTIME) {
		global $wgMemc;
		$wgMemc->set(md5($key), $data, $time);
		return true;
	}

	#---
	public function deleteCacheData($key) {
		global $wgMemc;
		$wgMemc->delete(md5($key));
		return true;
	}

	/*
	 *
	 * user's verification
	 *
	 */
	#---
	public function getUser() {
		return $this->mUser;
	}

	#---
	public function isUserLogin() {
		return $this->mUser->isLoggedIn();
	}

	#---
	public function isUserAnon() {
		return $this->mUser->isAnon();
	}

	#---
	public function getBrowser() {
		return $this->mBrowser;
	}

	/*
	 * Others
	 */
	#---
	private function getUniqueBrowserId()
	{
		global $wgRequest;
		if (empty($_COOKIE['wgWikiaUniqueBrowserId'])) {
			$unique_id = md5($wgRequest->getIP());
		} else {
			$unique_id = $_COOKIE['wgWikiaUniqueBrowserId'];
		}

		return $unique_id;
	}

	#---
	public function setApiResult($name, $id = '') {
		$id = empty($id)?0:$id;
		$result = array($id => array('id' => $id));
		if (is_array($name)) {
			foreach ($name as $_ => $v) {
				$result[$id][$_] = $v;
			}
		} else {
			$result[$id]['name'] = $name;
		}

		return $result;
	}

	#---
	public function setIndexTagName($name) {
		$this->mIndexTagName = $name;
	}

	#---
	public function getIndexTagName() {
		return $this->mIndexTagName;
	}

	#---
	public function getActionName() {
		return $this->mAction;
	}

    /**
     * check that $number is really integer
     *
     * retun true|false
     */
    public function isInt($number) {
    	return (is_numeric($number) ? intval($number) == $number : false);
    }

    /**
     * check that $date is in correct format
     *
     * retun true|false
     */
    public function isCorrectDate($date) {
		return preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $date);
	}

	#---
	public function getVersion() {
		return __CLASS__ . ': $Id: '.__CLASS__.'.php '.filesize(dirname(__FILE__)."/".__CLASS__.".php").' '.strftime("%Y-%m-%d %H:%M:%S", time()).'Z wikia $';
	}
}

class WikiaApiQueryError extends MWException {
	public $mFaultCode, $mFaultText;

	private $apiFaultCode = array(
		'0' => 'Database error. ',
		'1' => 'Invalid one of parameters.',
		'2' => 'User is not logged',
		'3' => 'Cannot change data',
	);

	/**
	 * Construct a database error
	 * @param DatabaseBase $db The database object which threw the error
	 * @param string $error A simple error message to be used for debugging
	 */
	function __construct( $faultcode, $error = '') {
		$this->mFaultCode = $faultcode;
		$this->mFaultText = (!empty($error))?$error:$this->getApiFaultName();
		parent::__construct( $this->mFaultText );
	}

	function getApiFaultName() {
		return $this->apiFaultCode[$this->mFaultCode];
	}

	function getApiFaultCode() {
		return $this->mFaultCode;
	}

	public function getText() {
		return array( $this->mFaultCode => array('id' => $this->mFaultCode, 'name' => $this->getMessage(), 'fault' => $this->getApiFaultName() ) );
	}

	public function getFault() {
		return array( 'fault' => array('id' => $this->mFaultCode, 'name' => $this->getMessage(), 'fault' => $this->getApiFaultName() ) );
	}
}
