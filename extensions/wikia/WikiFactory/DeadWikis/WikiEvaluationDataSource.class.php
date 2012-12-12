<?php

class WikiEvaluationDataSource {

	/**
	 * @var WikiDataSource
	 */
	protected $source;
	
	public function __construct( $id = null ) {
		$this->source = new WikiDataSource( $id );
	}
	
	public function getId() {
		return $this->source->getId();
	}
	
	public function getDbName() {
		return $this->source->getDbName();
	}

	public function getAge() {
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

	public function getLastEditTimestamp() {
		$excludedUsersQuery = "NOT rev_user IN (" . implode(',',$this->getData('ExcludedUsers')) . ")";
		$timestamp = $this->source->getDB()->selectField(
			array( 'revision', 'page' ),
			'max(rev_timestamp)',
			array(
				'rev_page = page_id',
				'page_namespace' => 0,
				"rev_user_text != '127.0.0.1'",
				$excludedUsersQuery,
			),
			__METHOD__
		);
		if ( !empty($timestamp) ) {
			$timestamp = wfTimestamp( TS_UNIX, $timestamp );
		}
		return $timestamp;
	}

	public function getEditsCount( $period = null ) {
		$excludedUsersQuery = "NOT rev_user IN (" . implode(',',$this->getData('ExcludedUsers')) . ")";
		$periodQuery = "1 = 1";
		if ( !is_null($period) ) {
			$periodQuery = "rev_timestamp >= \"".wfTimestamp(TS_MW,strtotime($period))."\"";
		}
		return $this->source->getDB()->selectField(
			array( 'revision', 'page' ),
			'count(*)',
			array(
				'rev_page = page_id',
				'page_namespace' => 0,
				"rev_user_text != '127.0.0.1'",
				$excludedUsersQuery,
				$periodQuery,
			)
			,__METHOD__
		);
	}

	public function getContentPagesCount() {
		return $this->source->getDB()->selectField('page','count(*)',array(
			'page_namespace' => 0,
			'page_is_redirect' => 0,
			'page_len > 0',
		),__METHOD__);
	}

	public function getLoggedActionsCount() {
		$excludedLogTypes = array( 'patrol' );
		$excludedLogTypes = array_map( array( $this->source->getDB(), 'addQuotes' ), $excludedLogTypes );
		$excludedLogTypes = "NOT log_type IN (" . implode(',',$excludedLogTypes) . ")";
		$value = $this->source->getDB()->selectField('logging','count(*)',array(
			$excludedLogTypes,
		),__METHOD__);
		if (is_numeric($value)) {
			$value = max(0, $value - 6) /* actions done during wiki creation */;
		}
		return $value;
	}

	public function getPageViews( $period ) {
		$timestamp = strtotime($period);
		$startDate = date( 'Y-m-d', $timestamp );
		$endDate = date( 'Y-m-d', strtotime('-1 day') );
		
		$res = 0;
		$pageviews = DataMartService::getPageviewsMonthly( $startDate, $endDate, $this->getId() );
		if ( !empty( $pageviews ) && is_array( $pageviews ) ) {
			foreach ( $pageviews as $date => $value ) {
				$res += $value;
			}
		} 
			
		return intval( $res );
	}

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
			$users[] = intval($row['ug_user']);
		}
		$db->freeResult($set);

		return $users;
	}
	
	protected function getData_BotUsers() {
		global $wgExternalSharedDB;

		$db = wfGetDB(DB_SLAVE,array(),$wgExternalSharedDB);
		$set = $db->select('user_groups','ug_user',array(
			'ug_group' => array( 'bot', 'bot-global' ),
		),__METHOD__,array('DISTINCT'));

		$users = array();
		while ($row = $db->fetchRow($set)) {
			$users[] = intval($row['ug_user']);
		}
		$db->freeResult($set);

		return $users;
	}
	
	protected function getData_ExcludedUsers() {
		global $wgExternalSharedDB;

		$db = wfGetDB(DB_SLAVE,array(),$wgExternalSharedDB);
		$set = $db->select('`user`','user_id',array(
			'user_name' => array( 'Default', 'CreateWiki' ),
		),__METHOD__,array('DISTINCT'));

		$users = array();
		while ($row = $db->fetchRow($set)) {
			$users[] = intval($row['user_id']);
		}
		$db->freeResult($set);

		$users = array_merge( $users, $this->getData( 'StaffUsers' ), $this->getData( 'BotUsers' ) );

		$users = array_unique($users);

		return $users;
	}

}
