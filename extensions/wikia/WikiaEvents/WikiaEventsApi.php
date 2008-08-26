<?php

/**
 * @package MediaWiki 
 * @subpackage API
 * @author Piotr Molski <moli@wikia.com> for Wikia, Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @copyright (C) 2007, Wikia Inc.
 * @version: $Id$
 */

if (!class_exists("WikiaEventsConditions"))
{
	require_once "$IP/extensions/wikia/WikiaEvents/WikiaEventsConditions.php";
}

class WikiaEventsApi extends ApiQueryBase
{
	#---
	const QUERY = "query";
	const EVENT_TYPE = 1;
	#---
	var $city = null;
	var $user = null;
	#---
	var $mAction = null;
	var $evOption = array();
	var $evConditions = null;
	#---
	public function __construct($query, $moduleName)
	{
		$this->mAction = $query->getModuleName();
		parent::__construct($query, $moduleName, 'wk');
	}

    /**
     * main function
     */
	public function execute()
	{
		global $wgSystemEventSetup;
		if ($this->mAction == self::QUERY)
		{
			$reqParams = $this->extractRequestParams();
			#---
			foreach ($reqParams as $paramName => $paramValue)
			{
				$this->$paramName = $paramValue;
			}
			#---
			$this->evOption = $wgSystemEventSetup;
			#---
			$result = $this->checkEvents();
		}
		#---
	}

	private function checkEvents()
	{
		global $wgUser, $wgDBname, $wgSharedDB;
		global $wgEnableSystemEvents;
		global $wgSystemEventSetup;
		global $wgCityId;
		#---
		if (empty($wgEnableSystemEvents)) {
			return false;
		}
		
		$dbname = (!isset($wgSharedDB)) ? "wgDBname" : "wgSharedDB";
		
		#--- database instance
		$dbr =& $this->getDB();
		#$db->selectDB( (!defined(WIKIA_API_QUERY_DBNAME)) ? WIKIA_API_QUERY_DBNAME : $wgDBname );
		$dbr->selectDB( $$dbname );

		if ( is_null($dbr) ) {
			return false;						
		}
		#---
		$data = array();
		#---
		$evTypes = WikiaEventsConditions::getEventTypes();
		#---
		$evText = WikiaEventsConditions::getEventAllTexts(self::EVENT_TYPE);
		#---
		$this->addTables( array( "`".$$dbname."`.`system_events_users`" ) );
		$this->addFields( array(
				'eu_id',
				'eu_et_id',
				'eu_ev_id',
				'eu_user_id', 
				'eu_user_ip',
				'eu_visible_count',
				'eu_active'
				));
		
		#--- active events				
		$this->addWhereFld ("eu_active", 1);
		#--- event's type = EVENT_TYPE
		$this->addWhereFld ("eu_et_id", self::EVENT_TYPE);
		#--- condition;
		$this->addWhere ( "eu_visible_count <= '".$this->evOption['DisplayLength']."'" );
		
		#--- identifier of city
		$whereCity = 0;
		if ( !is_null($this->city) ) 
			$whereCity = intval($this->city);
		elseif ($this->isInt($wgCityId))
			$whereCity = intval($wgCityId);
		elseif (class_exists("WikiFactory"))
			$whereCity = WikiFactory::DomainToID( $_SERVER['SERVER_NAME'] );
		else
			return false;	
			
		#---
		$this->addWhereFld ( "eu_city_id", $whereCity );
		
		#--- user
		if ( !is_null($this->user) ) 
		{ 
			if ( $this->isInt($this->user) ) 
			{
				if ( $wgUser->getID() != $this->user ) {
					return false;
				} else {
					$this->addWhereFld ( "eu_user_id", $this->user );						
				}				
			} 
			elseif ((wfGetIP() == $this->user) && (User::isIP($this->user))) 
			{
				$this->addWhereFld ( "eu_user_ip", $this->user );						
			} 
			else
			{
				return false;
			}
		} 
		else 
		{
			$this->addWhereFld ( "eu_user_id", $wgUser->getID() );
			if (User::isIP($wgUser->getName()))
			{
				$this->addWhereFld ( "eu_user_ip", $wgUser->getName() );
			}
		}
		
		#--- order by
		$this->addOption( "ORDER BY", "rand()" /*"eu_timestamp"*/ );
		#--- limit 
		$this->addOption( "LIMIT", "1" );

		$res = $this->select(__METHOD__);
		if ($res) {
			if ($row = $dbr->fetchObject($res)) 
			{
				$data[$row->eu_id] = array(
					'id' => $row->eu_id,
					'event_id' => $row->eu_ev_id,
					'user_id' => $row->eu_user_id,
					'user_ip' => $row->eu_user_ip,
					'event' => $row->eu_et_id,
					'title' => $evText[$row->eu_ev_id]['title'],
					'content' => ucfirst($evText[$row->eu_ev_id]['content']),
					'visible_count' => $row->eu_visible_count
				);
				#--- set style for title
				$data[$row->eu_id]['title_style'] = WikiaEventsConditions::setDisplayOptions('title');
				#--- set style for content
				$data[$row->eu_id]['content_style'] = WikiaEventsConditions::setDisplayOptions('content');
				
				//if ($row->eu_visible_count == 0) // so should be visible first time - start counter.
				//{
				$displayLength = ($row->eu_et_id == 1) ? $wgSystemEventSetup['DisplayLength'] : $wgSystemEventSetup['EmailsCount'];
				$isActive = ($displayLength > ($row->eu_visible_count + 1)) ? 1 : 0;
				#--
				$res = WikiaEventsConditions::changeEventsCounter($row->eu_ev_id, $row->eu_et_id, $isActive);
				//}
				#---			
				ApiResult :: setContent( $data[$row->eu_id], $row->eu_ev_id);
			}
			#if ($dbr && $res) $dbr->freeResult($res);
		}
		#---
		$this->getResult()->setIndexedTagName($data, 'item');

		$this->getResult()->addValue('query', $this->getModuleName(), $data);
	}

	/*
	 * other private function
	 */
    private function isInt($number) 
    {
    	return (is_numeric($number) ? intval($number) == $number : false);
    }

	public function getAllowedParams()
	{
		$allowedParams = false;
		#---
		if ($this->mAction == self::QUERY)
		{
			$allowedParams = array (
				"city"	=> array (ApiBase :: PARAM_TYPE => 'integer'),
				"user"	=> array (ApiBase :: PARAM_TYPE => 'integer'),
			);
		}
		#---
		return $allowedParams;
	}

	public function getParamDescription()
	{
		$paramDesc = false;
		#---
		if ($this->mAction == self::QUERY)
		{
			$paramDesc = array (
				'city' => 'Identifier of wiki',
				'user' => 'Identifier of user',
			);
		}
		#---
		return $paramDesc;
	}

	public function getDescription()
	{
		$desc = false;
		#---
		if ($this->mAction == self::QUERY)
		{
			$desc = array ('This module is used to get and display hints for pages');
		}
		#---
		return $desc;
	}
	
	public function getExamples()
	{
		$examples = false;
		#---
		if ($this->mAction == self::QUERY)
		{
			$examples = array( 
				'api.php?action=query&list=wkevents',
				'api.php?action=query&list=wkevents&wkcity=177&wkuser=127.0.0.1'
			);
		}
		#---
		return $examples;
	}

	public function getVersion()
	{
		return __CLASS__ . ': $Id: '.__CLASS__.'.php '.filesize(dirname(__FILE__)."/".__CLASS__.".php").' '.strftime("%Y-%m-%d %H:%M:%S", time()).'Z wikia $';
	}
}

?>
