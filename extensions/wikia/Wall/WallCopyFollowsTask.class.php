<?php 
if( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension and cannot be used standalone.\n";
	exit(1);
}

class WallCopyFollowsTask extends BatchTask {
	
	const TTL = 36000; //10hrs
	
	private $mParams;
	
	/**
	 * contructor
	 * @access public
	 */
	public function  __construct() {
		$this->mType = 'wallcopyfollows';
		$this->mVisible = true;
		$this->mTTL = self::TTL;
		parent::__construct();
		$this->mDebug = false;
	}
	
	/**
	 * execute
	 *
	 * entry point for TaskExecutor
	 *
	 * @access public
	 * @author Andrzej 'nAndy' Łukaszewski
	 *
	 * @param mixed $params default null - task data from wikia_tasks table
	 *
	 * @return boolean - status of operation
	 */
	public function execute($params = null) {
		global $wgCityId;

		$noErrors = true;
		$params = unserialize($params->task_arguments);
		
		if( isset($params['wiki_id']) ) {
			$wikiId = intval($params['wiki_id']);
		} else {
			$this->log('No wiki id given.');
			$noErrors = false;
		}
		
		if( $noErrors && $wikiId > 0 ) {
			$wiki = WikiFactory::getWikiById($wikiId);
			
			if( !is_object($wiki) ) {
				$wiki = WikiFactory::getWikiById($wgCityId, true);
			}
			
			if( !is_object($wiki) ) {
				$this->log('Not a valid wiki. (wiki id: '.$wikiId.')');
				$noErrors = false;
			}
			
			if( empty($wiki->city_dbname) ) {
				$this->log('Not a valid wiki db ('.$wiki->city_dbname.'). (wiki id: '.$wikiId.')');
				$noErrors = false;
			}
			
			if( $noErrors ) {
				if( defined('NS_USER_WALL') && defined('NS_USER_WALL_MESSAGE') ) {
					$wikiDb = $wiki->city_dbname;
					$dbw = wfGetDB(DB_SLAVE, array(), $wikiDb);
					
					//checking followed users
					$results = $dbw->select(
						'watchlist', 
						array(
							'wl_user', 
							'wl_title'
						), 
						array(
							'wl_namespace' => NS_USER_TALK,
							'wl_user > 0', 
							'locate(wl_title, \'/\') = 0',
						),
						__METHOD__
					);
					
					if( $results !== false ) {
						while( $row = $dbw->fetchObject($results) ) {
							if( isset($row->wl_user) && isset($row->wl_title) ) {
								$users[] = array('user_id' => $row->wl_user, 'title' => $row->wl_title);
							} else {
								$this->log('WALL_TASK_NOTICE: No wl_user or wl_title from database. wl_user: '.( isset($row->wl_user) ? $row->wl_user : 'not set' ).' wl_title: '.( isset($row->wl_title) ? $row->wl_title : 'not set' ));
							}
						}
						$dbw->freeResult($results);
						
						//creating data of followed walls
						foreach($users as $user) {
							$data[] = array(
								'wl_user' => $user['user_id'],
								'wl_namespace' => NS_USER_WALL,
								'wl_title' => $user['title'],
							);
							$data[] = array(
								'wl_user' => $user['user_id'],
								'wl_namespace' => NS_USER_WALL_MESSAGE,
								'wl_title' => $user['title'],
							);
						}
						
						if( !empty($data) ) {
							$dbw = wfGetDB(DB_MASTER, array(), $wikiDb);
							return $dbw->insert('watchlist', $data, __METHOD__, 'IGNORE');
						} else {
							$this->log('WALL_TASK_NOTICE: No data to add to database');
						}
					} else {
						$this->log('WALL_TASK_NOTICE: No results from database query');
					}
				} else {
					$this->log('No NS_USER_WALL and/or NS_USER_WALL_MESSAGE defined when copy follows action run');
					$noErrors = false;
				}
			}
		}
		
		return $noErrors;
	}
	
	/**
	 * getForm
	 *
	 * this task is not visible in selector so it doesn't have real HTML form
	 *
	 * @access public
	 * @author eloy@wikia
	 *
	 * @param Title $title: Title struct
	 * @param mixes $data: params from HTML form
	 *
	 * @return false
	 */
	public function getForm( $title, $data = false ) {
		return false;
	}
	
	/**
	 * getType
	 *
	 * return string with codename type of task
	 *
	 * @access public
	 * @author eloy@wikia
	 *
	 * @return string: unique name
	 */
	public function getType() {
		return $this->mType;
	}
	
	/**
	 * isVisible
	 *
	 * check if class is visible in TaskManager from dropdown
	 *
	 * @access public
	 * @author eloy@wikia
	 *
	 * @return boolean: visible or not
	 */
	public function isVisible() {
		return $this->mVisible;
	}
	
	/**
	 * submitForm
	 *
	 * since this task is invisible for form selector we use this method for
	 * saving request data in database
	 *
	 * @access public
	 * @author eloy@wikia
	 *
	 * @return true
	 */
	public function submitForm() {
		return true;
	}
	
}