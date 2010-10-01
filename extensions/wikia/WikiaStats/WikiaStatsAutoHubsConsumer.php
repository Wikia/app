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
		global $wgStatsDB, $wgCityId, $wgMemc;
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
					$data = array(
						'blogs' 	=> array(),
						'articles' 	=> array(),
						'user'		=> array()
					);
					foreach ( $result as $city_id => $rows) {
						$start = time();
						Wikia::log( __METHOD__, 'events', 'Wikia ' . $city_id . ' processing: ' . count($rows) . ' rows' );
						
						foreach ( $rows as $oRow ) {
							if ( is_object( $oRow ) ) {
								# wikia
								$oWikia = WikiFactory::getWikiByID($city_id);
								if ( !is_object($oWikia) ) {
									Wikia::log ( __METHOD__, "Wikia not found: " . $city_id );
									continue;
								}
								# server
								$server = WikiFactory::getVarValueByName( "wgServer", $city_id );
								# language
								$lang = $oWikia->city_lang;
								# sitename
								$sitename = $oWikia->city_title;
								# initial table
								if ( !isset($data['blogs'][$lang]) ) {
									$data['blogs'][$lang] = array();
								}
								if ( !isset($data['articles'][$lang]) ) {
									$data['articles'][$lang] = array();
								}
								if ( !isset($data['user'][$lang]) ) {
									$data['user'][$lang] = array();
								}										
								
								# global title 
								$oGTitle = GlobalTitle::newFromId( $oRow->page_id, $city_id );
								if ( !is_object($oGTitle) ) {
									Wikia::log ( __METHOD__, "GlobalTitle not found: " . $oRow->page_id . ", ". $city_id);
									continue;
								}
								
								# tags
								$oWFTags = new WikiFactoryTags($city_id);
								$tags = $oWFTags->getAllTags();
								$tags = ( isset($tags['byid']) ) ? $tags['byid'] : $tags;
								if( NS_BLOG_ARTICLE == $oRow->page_ns ) {
									foreach( $tags as $id => $val ) {
										if ( !isset($data['blogs'][$lang][$id]) ) {
											$data['blogs'][$lang][$id] = array();
										}
										# prepare insert data
										$data['blogs'][$lang][$id][] = array(
											'tb_city_id'	=> $city_id, 
											'tb_page_id'	=> $oRow->page_id, 
											'tb_tag_id'		=> $id, 
											'tb_date'		=> date("Y-m-d"),
											'tb_city_lang'	=> $lang,
											'tb_page_name'	=> addslashes($oGTitle->mUrlform),
											'tb_page_url'	=> addslashes($oGTitle->getFullURL()),
											'tb_wikiname' 	=> addslahses($sitename),
											'tb_wikiurl'	=> addslashes($server),
											'tb_count'		=> 1										
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
										$date = date("Y-m-d");
										$mcKey = wfSharedMemcKey( "auto_hubs", "unique_control", $city_id, $oRow->page_id, $oRow->user_id, $id, $date );
										$out = $wgMemc->get($mcKey,null);
										if ($out == 1) { continue ; }
										$wgMemc->set($mcKey, 1, 24*60*60);
																				
										if ( !isset($data['user'][$lang][$id]) ) {
											$data['user'][$lang][$id] = array();
										}
										if ( !isset($data['articles'][$lang][$id]) ) {
											$data['articles'][$lang][$id] = array();
										}										
										#
										# prepare insert data
										$data['articles'][$lang][$id][] = array(									
											'ta_city_id'	=> $city_id, 
											'ta_page_id' 	=> $oRow->page_id, 
											'ta_tag_id' 	=> $id, 
											'ta_date'		=> $date,
											'ta_city_lang' 	=> $lang,
											'ta_page_name'	=> addslashes($oGTitle->mUrlform),
											'ta_page_url'	=> addslashes($oGTitle->getFullURL()),
											'ta_wikiname'	=> $sitename,
											'ta_wikiurl'	=> $server,
											'ta_count'		=> 1
										);	
										
										$data['user'][$lang][$id][] = array(									
											'tu_user_id'	=> $oRow->user_id, 
											'tu_tag_id'		=> $id, 
											'tu_date'		=> $date,
											'tu_groups'		=> $user_groups,
											'tu_username'	=> addslashes($oUser->getName()), 
											'tu_city_lang'	=> $lang,
											'tu_count'		=> 1										
										);		
									}
								}
							}
						}
						$end = time();
						$time = Wikia::timeDuration($end - $start);
						Wikia::log( __METHOD__, 'events', 'Wikia ' . $city_id . ' processed in: ' . $time );
					}
					
					// insert data to database
					$producerDB->insertBlogComment($data['blogs']);
					$producerDB->insertArticleEdit($data['articles']);
					$producerDB->insertUserEdit($data['user']);	
					// clear old data 
					$producerDB->deleteOld();			
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
