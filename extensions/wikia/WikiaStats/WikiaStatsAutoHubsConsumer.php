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
	const sleepTime = 10;
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
		global $wgStatsDB, $wgCityId, $wgMemc, $wgStatsDBEnabled, $wgSharedDB, $wgIP;
		wfProfileIn( __METHOD__ );

		if ( empty( $wgStatsDBEnabled ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

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
					array( 'wiki_id, page_id, page_ns, user_id, rev_timestamp, user_is_bot' ),
					$where,
					__METHOD__
				);
				$result = array(); $loop = 0;
				while ( $oRow = $dbr->fetchObject( $oRes ) ) {
					if ( $oRow->rev_timestamp > $this->mDate ) {
						$this->mDate = $oRow->rev_timestamp;
					}
					$result[$oRow->wiki_id][$oRow->page_id] = $oRow;
					$loop++;
				}
				$dbr->freeResult( $oRes );

				Wikia::log( __METHOD__, 'events', 'Read ' . $loop . ' events (for ' . count($result). ' Wikis) successfully. Next timestamp: ' . $this->mDate );

				$records = count($result);
				if ( !empty($result) ) {
					$producerDB = new WikiaStatsAutoHubsConsumerDB(DB_MASTER);
					$data = array(
						'blogs' 	=> array(),
						'articles' 	=> array(),
						'user'		=> array(),
						'tags'		=> array()
					);
					$loop = 0;
					foreach ( $result as $city_id => $rows) {
						$start = time();
						$loop++;
						Wikia::log( __METHOD__, 'events', 'Wikia ' . $city_id . ' (' . $loop . '/' . $records . ') processing: ' . count($rows) . ' rows' );

						$memkey = sprintf("%s:wikia:%d", __METHOD__, $city_id);
						$info = $wgMemc->get($memkey);
						if ( empty($info) ) {
							# wikia
							$oWikia = WikiFactory::getWikiByID($city_id);
							if ( !is_object($oWikia) ) {
								Wikia::log ( __METHOD__, "Wikia not found: " . $city_id );
								continue;
							}
							# server
							$server = WikiFactory::getVarValueByName( "wgServer", $city_id );
							$info = array(
								'lang'		=> $oWikia->city_lang,
								'db'		=> $oWikia->city_dbname,
								'sitename'	=> $oWikia->city_title,
								'server'	=> $server
							);
							$wgMemc->set( $memkey, $info, 60*60*2 );
						}

						if ( !isset( $info['db'] ) && !isset( $info['sitename'] ) && !isset( $info['lang'] ) && !isset( $info['server'] ) ) {
							Wikia::log ( __METHOD__, "Wikia not found: " . $city_id );
							continue;
						}

						# initial table
						$lang = $info['lang'];
						if ( !isset($data['blogs'][$lang]) ) {
							$data['blogs'][$lang] = array();
						}
						if ( !isset($data['articles'][$lang]) ) {
							$data['articles'][$lang] = array();
						}
						if ( !isset($data['user'][$lang]) ) {
							$data['user'][$lang] = array();
						}

						# tags
						$oWFTags = new WikiFactoryTags($city_id);
						$tags = $oWFTags->getTags();

						foreach ( $rows as $oRow ) {
							if ( is_object( $oRow ) ) {

								$oUser = User::newFromId( $oRow->user_id );
								if ( !is_object( $oUser ) ) continue;

								if( NS_BLOG_ARTICLE == $oRow->page_ns ) {
									if ( !empty($tags) ) {
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
												'tb_count'		=> 1
											);
										}
									}
								} else {
									$memkey = sprintf( "%s:%s:user:%d", __METHOD__, $wgSharedDB, $oRow->user_id );
									$user = $wgMemc->get($memkey);
									if ( empty($user) ) {
										$groups = $oUser->getGroups();
										$user_groups = implode(";", $groups);

										$user = array( 'name' => $oUser->getName(), 'groups' => $user_groups );
										$wgMemc->set( $memkey, $user, 60*60*2 );
									}

									if ( !isset($user['name']) ) {
										continue;
									}

									if ( $user['name'] == $wgIP || User::isIP( $user['name'] ) ) {
										continue;
									}

									if ( !empty($tags) ) {
										foreach( $tags as $id => $val ) {
											$date = date("Y-m-d");
											$mcKey = wfSharedMemcKey( "auto_hubs", "unique_control", $city_id, $oRow->page_id, $oRow->user_id, $id, $date );
											$out = $wgMemc->get($mcKey,null);
											if ($out == 1) { continue ; }
											$wgMemc->set($mcKey, 1, 24*60*60);

											$allowed = ( $oRow->user_is_bot != 'Y' && !in_array( $oUser->getName(), $producerDB->getBanedUsers() ) );

											if ( !isset($data['user'][$lang][$id]) && $allowed ) {
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
												'ta_count'		=> 1
											);

											if ( $allowed ) {
												$data['user'][$lang][$id][] = array(
													'tu_user_id'	=> $oRow->user_id,
													'tu_tag_id'		=> $id,
													'tu_date'		=> $date,
													'tu_groups'		=> $user['groups'],
													'tu_username'	=> addslashes($user['name']),
													'tu_city_lang'	=> $lang,
													'tu_count'		=> 1
												);
											}
										}
									}
								}
							}
						}
						$end = time();
						$time = Wikia::timeDuration($end - $start);
						Wikia::log( __METHOD__, 'events', 'Wikia ' . $city_id . ' processed in: ' . $time );
					}

					// insert data to database
					# blogs
					$start = time();
					Wikia::log( __METHOD__, 'events', 'Insert ' . count($data['blogs']) . ' blogs' );
					$producerDB->insertBlogComment($data['blogs']);
					$end = time();
					$time = Wikia::timeDuration($end - $start);
					Wikia::log( __METHOD__, 'events', 'Inserts done in: ' . $time );

					# articles
					$start = time();
					Wikia::log( __METHOD__, 'events', 'Insert ' . count($data['articles']) . ' articles' );
					$producerDB->insertArticleEdit($data['articles']);
					$end = time();
					$time = Wikia::timeDuration($end - $start);
					Wikia::log( __METHOD__, 'events', 'Inserts done in: ' . $time );

					$start = time();
					Wikia::log( __METHOD__, 'events', 'Insert ' . count($data['user']) . ' users' );
					$producerDB->insertUserEdit($data['user']);
					$end = time();
					$time = Wikia::timeDuration($end - $start);
					Wikia::log( __METHOD__, 'events', 'Inserts done in: ' . $time );

					// unset data
					unset($data);
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
	}
}
