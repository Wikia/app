<?php

/**
 * @package MediaWiki
 * @author Bartlomiej Lapinski <bartek@wikia.com> for Wikia.com
 * @copyright (C) 2010, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: whatever goes here
 */

/**
 * class that transfers data from Stomp queue into database
 */
class WikiaStatsAutoHubsConsumer {
	const defaultTS = 3600;
	const sleepTime = 60;
	var $mDate = null;
	/**
	 * constructor
	 */
	function __construct( $date = null) {
		if ( is_null($date) ) {
			$date = date('Y-m-d H:i:s', time() - self::defaultTS) ;
		}
		$this->mDate = $date;
	}

	/**
	 * connect to statsdb and processing events table
	 */
	public function receiveFromEvents() {
		global $wgStatsDB, $wgCityId;
		wfProfileIn( __METHOD__ );
		
		try {	
			while( 1 ) {
				$dbr = wfGetDB(DB_SLAVE, array(), $wgStatsDB);
				$where = array(
					" rev_timestamp >= '" . $this->mDate . "' ",
					" (event_type = 2 or event_type = 1 ) "
				);
				if ( !empty($wgStatsIgnoreWikis) ) {
					$where[] = 'wiki_id not in ('.$dbr->makeList( $wgStatsIgnoreWikis ).')';
				}
				
				$oRes = $dbr->select(
					array( 'events' ),
					array( 'wiki_id, page_id, page_ns, user_id, rev_timestamp' ),
					$where,
					__METHOD__
				);
				$result = array(); $loop = 0;
				while ( $oRow = $dbr->fetchObject( $oRes ) ) {
					if ( $oRow->rev_timestamp > $this->mDate ) {
						$this->mDate = $oRow->rev_timestamp;
					}
					$result[$oRow->wiki_id][] = $oRow;
					$loop++;
				}
				$dbr->freeResult( $oRes );			

				Wikia::log( __METHOD__, 'events', 'Read ' . $loop . ' events (for ' . count($result). ' Wikis) successfully. Next timestamp: ' . $this->mDate );				
		
				if ( !empty($result) ) {
					$producerDB = new WikiaStatsAutoHubsConsumerDB();
					
					foreach ( $result as $city_id => $rows) {
						$start = time();
						Wikia::log( __METHOD__, 'events', 'Wikia ' . $city_id . ' processing: ' . count($rows) . ' rows' );
						
						foreach ( $rows as $oRow ) {
							if ( is_object( $oRow ) ) {
								# wikia
								$oWikia = WikiFactory::getWikiByID($city_id);
								if ( !is_object($oWikia) ) {
									continue;
								}
								# server
								$server = WikiFactory::getVarValueByName( "wgServer", $city_id );
								# language
								$lang = $oWikia->city_lang;
								# sitename
								$sitename = $oWikia->city_title;
								
								# global title 
								$oGTitle = GlobalTitle::newFromId( $oRow->page_id, $city_id );
								if ( !is_object($oGTitle) ) {
									continue;
								}
								
								# tags
								$oWFTags = new WikiFactoryTags($city_id);
								$tags = $oWFTags->getAllTags();			
								if( NS_BLOG_ARTICLE == $oRow->page_ns ) {
									foreach( $tags as $id => $val ) {
										$producerDB->insertBlogComment( 
											$city_id, 
											$oRow->page_id, 
											$id, 
											$oGTitle->mUrlform, 
											$oGTitle->getFullURL(), 
											$sitename, 
											$server, 
											$lang 
										);
									}
								} else {
									$oUser = User::newFromId( $oRow->user_id );
									if ( !is_object($oUser) ) {
										continue;
									}
									$groups = $oUser->getGroups();	
									$user_groups = implode(";", $groups);		
				
									foreach( $tags as $id => $val ) {
										$producerDB->insertArticleEdit( 
											$city_id, 
											$oRow->pageId, 
											$oRow->user_id, 
											$id, 
											$oGTitle->mUrlform, 
											$oGTitle->getFullURL(), 
											$sitename,
											$server, 
											$user_groups, 
											$oUser->getName(), 
											$lang
										);
									}
								}
							}
						}
						$end = time();
						$time = Wikia::timeDuration($end - $start);
						Wikia::log( __METHOD__, 'events', 'Wikia ' . $city_id . ' processed in: ' . $time );
					}
				} else {
					Wikia::log ( __METHOD__, "No data found in events table. Last timestamp: " . $this->mDate );
				}
				Wikia::log ( __METHOD__, "Wait " . self::sleepTime . " sec. " );
				sleep(self::sleepTime);				
			}	
		} catch( MWException $e ) {
			$mesg = $e->getMessage();
			$class = get_class( $e ); 			
			Wikia::log( __METHOD__, 'events', $mesg );
			die( 'Cannot proceed events data. Message was: ' . $mesg . '. Class was:' . $class );
		}

		wfProfileOut( __METHOD__ );
	}
	
	public static function ErrorHandler($errno, $errstr, $errfile, $errline){		
		/* skip memc error because of @ */
		if ( strpos( $errfile, 'memcached-client.php' ) > 0 ) {
			return true;
		}
		

		if ($errno  == E_STRICT){	
			return true;	
		}

		$log = "php error: [$errno] $errstr; file: $errfile ; line: $errline \n";
		Wikia::log( __METHOD__, 'php error', $log );
		die( $log );
		sleep(3);
		return true; 
	}
}
