<?php
/**
 * Author: Tomek Odrobny
 * Data model
 */
class FollowModel {
	static public $ajaxListLimit = 600;
	static public $specialPageListLimit = 15;
	static private $defaultNamespaces = [
		NS_CATEGORY => 'wikiafollowedpages-special-heading-category',
		NS_PROJECT => 'wikiafollowedpages-special-heading-project' ,
		NS_TEMPLATE => 'wikiafollowedpages-special-heading-templates',
		NS_USER => 'wikiafollowedpages-special-heading-user',
		NS_MEDIAWIKI => 'wikiafollowedpages-special-heading-mediawiki',
		NS_FORUM => 'wikiafollowedpages-special-heading-forum',
		NS_FILE => 'wikiafollowedpages-special-heading-media',
		NS_USER_WALL => 'wikiafollowedpages-special-heading-wall',
	];

	/**
	 * getWatchList -- get data for followed pages
	 *
	 * @static
	 * @access public
	 *
	 * @return array
	 */
	static function getWatchList($user_id, $from = 0, $limit = 15, $namespace_head = null, $show_deleted_pages = true) {
		wfProfileIn( __METHOD__ );

		$namespaces = static::prepareNamespaces( $namespace_head );
		$user_id = (int) $user_id;
		$from = (int) $from;
		$limit = (int) $limit;
		$order = array(
			'wikiafollowedpages-special-heading-category',
			'wikiafollowedpages-special-heading-article',
			'wikiafollowedpages-special-heading-blogs',
			'wikiafollowedpages-special-heading-forum',
			'wikiafollowedpages-special-heading-project',
			'wikiafollowedpages-special-heading-user',
			'wikiafollowedpages-special-heading-templates',
			'wikiafollowedpages-special-heading-mediawiki',
			'wikiafollowedpages-special-heading-media',
			'wikiafollowedpages-special-heading-wall',
			'wikiafollowedpages-special-heading-board'
		);

		$out = static::getWatchListCount(
			$user_id,
			$limit,
			$namespaces,
			static::getWatchListArray( $user_id, $from, $limit, $show_deleted_pages, $namespaces )
		);

		foreach ($order as $key => $value) {
			if (!empty($out[$value]) ) {
				$order[$key] = $out[$value];
			} else {
				unset($order[$key]);
			}
		}

		wfProfileOut( __METHOD__ );
		return $order;
	}

	/**
	 * @desc Prepares list of namespaces which should be taken into consideration in selecting the list from DB
	 *
	 * @param String $namespace_head
	 *
	 * @return Array $namespaces
	 */
	private static function prepareNamespaces( $namespace_head ) {
		global $wgContentNamespaces, $wgEnableBlogArticles, $wgEnableForumExt;
		wfProfileIn( __METHOD__ );
		$namespaces = static::$defaultNamespaces;

		if ( !empty( $wgEnableBlogArticles ) ) {
			$namespaces[NS_BLOG_ARTICLE] = 'wikiafollowedpages-special-heading-blogs';
			$namespaces[NS_BLOG_LISTING] = 'wikiafollowedpages-special-heading-blogs';
		}

		if ( !empty( $wgEnableForumExt ) ) {
			$namespaces[NS_WIKIA_FORUM_BOARD_THREAD] = 'wikiafollowedpages-special-heading-board';
		}

		foreach( $wgContentNamespaces as $value ) {
			$namespaces[$value] = 'wikiafollowedpages-special-heading-article';
		}

		if( $namespace_head != null ) {
			foreach( $namespaces as $key => $value ) {
				if ( $value != $namespace_head ) {
					unset( $namespaces[$key] );
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return $namespaces;
	}

	/**
	 * @desc Gets pages from watchlist depending on given parameters; The result list is grouped by static::$namespaces
	 *
	 * @param Integer $user_id
	 * @param Integer $from
	 * @param Integer $limit
	 * @param Boolean $show_deleted_pages
	 * @param Array $namespaces
	 *
	 * @return Array
	 */
	private static function getWatchListArray( $user_id, $from, $limit, $show_deleted_pages, $namespaces ) {
		global $wgServer, $wgScript, $wgContentNamespaces;
		wfProfileIn( __METHOD__ );

		$db = wfGetDB( DB_SLAVE );
		$namespaces_keys = array_keys( $namespaces );
		$queryArray = [];
		$out_data = [];

		foreach ($namespaces_keys as $value) {
			$value = (int) $value;
			$isWall = $value == NS_USER_WALL;

			$queryArray[] = "(select wl_namespace, wl_title from watchlist where wl_user = " . $user_id . " and wl_namespace = " . $value
				// special case for Wall to avoid sub-pages
				. ( $isWall ? " and not wl_title like '%/%' " : '' )
				. " ORDER BY wl_wikia_addedtimestamp desc limit " . $from . "," . $limit . ")";
		}

		$res = $db->query( implode(" union ",$queryArray) );
		while ($row =  $db->fetchRow( $res ) ) {
			$title = Title::makeTitle( $row['wl_namespace'], $row['wl_title'] );
			$row['url'] = $title->getFullURL();
			$row['hideurl'] = $wgServer . $wgScript . "?action=ajax&rs=wfAjaxWatch&rsargs[]=".$title->getPrefixedURL()."&rsargs[]=u";
			$row['wl_title'] = str_replace("_"," ",$row['wl_title'] );
			if (defined('NS_BLOG_ARTICLE') && $row['wl_namespace'] == NS_BLOG_ARTICLE) {
				$explode = explode("/", $row['wl_title']);
				if ( count($explode) > 1) {
					$row['wl_title'] = $explode[1];
					$row['by_user'] =  $explode[0];
				}
			}
			if ( defined( 'NS_WIKIA_FORUM_BOARD_THREAD' ) && $row['wl_namespace'] == NS_WIKIA_FORUM_BOARD_THREAD ) {
				$wallMessage = WallMessage::newFromTitle( $title );
				$wallMessage->load();
				$row['wl_title'] = $wallMessage->getMetaTitle();
				$row['wl_title_obj'] = Title::newFromText( $wallMessage->getID(), NS_USER_WALL_MESSAGE );
				$row['on_board'] = Xml::tags(
					'a',
					array(
						'href' => $wallMessage->getWallUrl(),
						'title' => $wallMessage->getArticleTitle()->getText()
					),
					$wallMessage->getArticleTitle()->getText()
				);
			}

			if ( in_array($row['wl_namespace'], $wgContentNamespaces) && (NS_MAIN != $row['wl_namespace']) ) {
				$title = Title::makeTitle($row['wl_namespace'], "none");
				$row['other_namespace'] = $title->getNsText();
			}

			if( $show_deleted_pages ) {
				$out_data[ $namespaces[ $row['wl_namespace'] ]][] = $row;
			} else {
				if( $title->isKnown() ||  $title->getNamespace() == NS_USER_WALL) {
					$out_data[ $namespaces[ $row['wl_namespace'] ]][] = $row;
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return $out_data;
	}

	/**
	 * @desc Gets amount of watchlist elements grouped by static::$namespaces
	 *
	 * @param Integer $user_id
	 * @param Integer $limit
	 * @param Array $namespaces list of namespaces by which results will be narrowed
	 * @param Array $watchedPages result array from static::getWatchListArray()
	 *
	 * @return array
	 */
	private static function getWatchListCount( $user_id, $limit, $namespaces, $watchedPages ) {
		wfProfileIn( __METHOD__ );
		$db = wfGetDB( DB_SLAVE );
		$namespaces_keys = array_keys( $namespaces );

		/**
		 * Wall Logic
		 *
		 * When you fallow tread the fallowing is marked in NS_USER_WALL_MESSAGE, NS_USER_WALL
		 * so we will skip NS_USER_WALL with are subpage to filter out this.
		 */
		$con = " wl_user = " . $user_id . " and wl_namespace in (" . implode( ',', $namespaces_keys ) . ")";
		// special case for Wall to avoid sub-pages
		$con .= ( " and ( not wl_namespace = ".NS_USER_WALL."  or ( wl_namespace = ".NS_USER_WALL."  and not wl_title like '%/%' ) )" );


		$res = $db->select(
			array( 'watchlist' ),
			array( 'wl_namespace',
				'count(wl_title) as cnt' ),
			$con,
			__METHOD__,
			array(
				'ORDER BY' 	=> 'wl_wikia_addedtimestamp desc,wl_title',
				'GROUP BY' => 'wl_namespace'
			)
		);

		$out = [];
		while ($row =  $db->fetchRow( $res ) ) {
			$ns = $namespaces[ $row['wl_namespace'] ];
			if ( !empty($out[$ns]) ) {
				$out[$ns]['count'] += $row['cnt'];
			} else {
				$out[$ns] = array('ns' => $ns,'count' => $row['cnt'], 'data' => ( empty( $watchedPages[$ns] ) ? array() : $watchedPages[$ns] ) );
			}

			$out[$ns]['show_more'] = 0;
			if ( $out[$ns]['count']  > $limit ) {
				$out[$ns]['show_more'] = 1;
			}
		}

		wfProfileOut( __METHOD__ );
		return $out;
	}

	/**
	 * @desc getUserPageWatchList -- getdata for box on user page
	 *
	 * @param Integer $user_id
	 *
	 * @static
	 * @access public
	 *
	 * @return Array
	 */
	static function getUserPageWatchList($user_id) {
		global $wgContentNamespaces, $wgEnableBlogArticles;

		$NS = array();
		if ( !empty($wgEnableBlogArticles) ) {
			$NS[] = NS_BLOG_ARTICLE;
		}

		$NS = array_merge($NS,$wgContentNamespaces);

		wfProfileIn( __METHOD__ );
		$db = wfGetDB( DB_SLAVE );
		$con = 'wl_user = '.intval($user_id).' and wl_namespace in ('.implode(',', $NS).')';
		$res = $db->select(
				array( 'watchlist' ),
				array( 'wl_namespace',
					   'wl_title'),
				$con,
				__METHOD__,
				array(
					'ORDER BY' 	=> 'wl_wikia_addedtimestamp desc,wl_title',
					'LIMIT'		=> 10
				)
		);

		$watchlist = array();
		while ($row = $db->fetchRow( $res ) ) {
			$title = Title::makeTitle( $row['wl_namespace'], $row['wl_title'] );
			$row['url'] = $title->getFullURL();
			$row['wl_title'] = str_replace("_"," ",$row['wl_title'] );
			if ( !empty($wgEnableBlogArticles) && $wgEnableBlogArticles ) {
				if ($row['wl_namespace'] == NS_BLOG_ARTICLE || $row['wl_namespace'] == NS_BLOG_LISTING) {
					$explode = explode("/", $row['wl_title']);
					if ( count($explode) > 1) {
						$row['wl_title'] = $explode[1];
						$row['by_user'] =  $explode[0];
					}
				}
			}
			$watchlist[] = $row;
		}

		wfProfileOut( __METHOD__ );
		return $watchlist;
	}
}
