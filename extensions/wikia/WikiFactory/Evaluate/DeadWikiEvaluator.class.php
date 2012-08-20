<?php

abstract class WikiEvaluator {

	protected $id;
	/**
	 * @var Database
	 */
	protected $db;

	protected $status = false;
	protected $messages = array();

	public function __construct( $id ) {
		$this->id = $id;

		$this->evaluate();
		$this->db = null;
	}

	public function getStatus() {
		return $this->status;
	}

	public function getMessages() {
		return $this->messages;
	}

	public function getMessage() {
		return implode(', ',$this->messages);
	}


	protected function evaluate() {
		$this->messages = array();
		$this->status = false;

		// find db name
		$dbname = WikiFactory::IDtoDB($this->id);
		if ( empty($dbname) ) {
			$this->messages[] = "Wiki could not be found by ID: {$this->id}";
			return;
		}

		// open db connection (and check if db really exists)
		$db = wfGetDB(DB_SLAVE, array(), $dbname);
		if ( !is_object($db) ) {
			$this->messages[] = "Wiki db could not be opened: {$dbname}";
			return;
		}
		$this->db = $db;

		$this->doEvaluate();

		$this->status = empty($this->messages);
	}

	protected function getAge() {
		global $wgExternalSharedDB;

		$db = wfGetDB(DB_SLAVE,array(),$wgExternalSharedDB);
		$timestamp = $db->selectField('city_list','city_created',array(
			'city_id' => $this->id,
		),__METHOD__);
		if ( !empty($timestamp) ) {
			$timestamp = wfTimestamp( TS_UNIX, $timestamp );
		}
		return $timestamp;
	}

	protected function getEditsCount() {
		$excludedUsersQuery = "NOT rc_user IN (" . implode(',',$this->getData('ExcludedUsers')) . ")";
		return $this->db->selectField('recentchanges','count(*)',array(
			'rc_namespace' => 0,
			'rc_bot' => 0,
			'rc_type' => array( 0, 1 ),
			"rc_ip != '127.0.0.1'",
			$excludedUsersQuery,
		),__METHOD__);
	}

	protected function getContentPagesCount() {
		return $this->db->selectField('page','count(*)',array(
			'page_namespace' => 0,
			'page_is_redirect' => 0,
			'page_len' => 0,
		),__METHOD__);
	}

	protected function getLoggedActionsCount() {
		$excludedLogTypes = array( 'patrol' );
		$excludedLogTypes = array_map( array( $this->db, 'addQuotes' ), $excludedLogTypes );
		$excludedLogTypes = "NOT log_type IN (" . implode(',',$excludedLogTypes) . ")";
		$value = $this->db->selectField('logging','count(*)',array(
			$excludedLogTypes,
		),__METHOD__);
		if (is_numeric($value)) {
			$value = max(0, $value - 6) /* actions done during wiki creation */;
		}
		return $value;
	}

	protected function getPageViews( $period ) {
		$timestamp = strtotime($period);
		$startDate = date( 'Y-m-d', $timestamp );
		$endDate = date( 'Y-m-d', strtotime('-1 day') );
		
		$res = 0;
		$pageviews = DataMartService::getPageviewsMonthly( $startDate, $endDate, $this->id );
		if ( !empty( $pageviews ) && is_array( $pageviews ) ) {
			foreach ( $pageviews as $date => $value ) {
				$res += $value;
			}
		} 
			
		return intval( $res );
	}

	protected function check( $options ) {
		$type = $options['type'];
		$value = $options['value'];
		$name = $options['name'];

		if ($value === false) {
			$this->messages[] = "{$name} could not be fetched";
			return;
		}

		$conds = array( 'min', 'max' );
		$condsCount = 0;
		foreach ($conds as $cond) {
			if (!array_key_exists($cond,$options)) {
				continue;
			}

			$condsCount++;
			$refValue = $options[$cond];
			$rawRefValue = $refValue;
			if ($type == 'datetime' && is_string($refValue)) {
				$refValue = strtotime($refValue);
			}

			switch ($cond) {
				case 'min':
					if ($value < $refValue) {
						$this->messages[] = "{$name} (\"{$value}\") is lesser than \"{$rawRefValue}\"";
						return;
					}
					break;
				case 'max':
					if ($value > $refValue) {
						$this->messages[] = "{$name} (\"{$value}\") is greater than \"{$rawRefValue}\"";
						return;
					}
					break;
			}
		}

		if ($condsCount == 0) {
			$this->messages[] = "{$name} has not been checked by any predicate";
		}
	}

	abstract protected function doEvaluate();

	static protected $cachedData = array();

	protected function getData( $name ) {
		$class = get_class($this);
		if (!array_key_exists($class, self::$cachedData) || !array_key_exists($name, self::$cachedData[$class])) {
			$callback = array( $this, "getData_{$name}" );
			if (is_callable($callback))
				$value = call_user_func($callback);
			else
				$value = false;
			self::$cachedData[$class][$name] = $value;
		}
		return self::$cachedData[$class][$name];
	}

	protected function getData_StaffUsers() {
		global $wgExternalSharedDB;

		$db = wfGetDB(DB_SLAVE,array(),$wgExternalSharedDB);
		$set = $db->select('user_groups','ug_user',array(
			'ug_group' => 'staff',
		),__METHOD__,array('DISTINCT'));

		$users = array();
		while ($row = $db->fetchRow($set)) {
			$users[] = intval($row->ug_user);
		}
		$db->freeResult($set);

		return $users;
	}

	protected function getData_ExcludedUsers() {
		global $wgExternalSharedDB;

		$db = wfGetDB(DB_SLAVE,array(),$wgExternalSharedDB);
		$set = $db->select('user','user_id',array(
			'user_name' => array( 'Default', 'CreateWiki' ),
		),__METHOD__,array('DISTINCT'));

		$users = array();
		while ($row = $db->fetchRow($set)) {
			$users[] = intval($row->ug_user);
		}
		$db->freeResult($set);

		$users = array_merge( $users, $this->getData( 'StaffUsers' ) );

		$users = array_unique($users);

		return $users;
	}

}

class DeadWikiEvaluator extends WikiEvaluator {

	protected function doEvaluate() {
		// wiki age
		$this->check(array(
			'type' => 'datetime',
			'value' => $this->getAge(),
			'max' => '-90 days',
			'name' => 'Wiki creation date',
		));

		// edits count
		$this->check(array(
			'type' => 'int',
			'value' => $this->getEditsCount(),
			'max' => 0,
			'name' => 'Number of edits',
		));

		// content pages count
		$this->check(array(
			'type' => 'int',
			'value' => $this->getContentPagesCount(),
			'max' => 1,
			'name' => 'Number of content pages',
		));

		// logged actions count
		$this->check(array(
			'type' => 'int',
			'value' => $this->getLoggedActionsCount(),
			'max' => 4,
			'name' => 'Number of logged actions',
		));

		// pageviews in 4 weeks
		$this->check(array(
			'type' => 'int',
			'value' => $this->getPageViews('-4 weeks'),
			'max' => 4,
			'name' => 'Page views in 4 weeks',
		));

		// pageviews in the last year
		$this->check(array(
			'type' => 'int',
			'value' => $this->getPageViews('-1 year'),
			'max' => 9,
			'name' => 'Page views in the last year',
		));
	}

}
