<?php

/**
 * @package MediaWiki
 * @author Bartlomiej Lapinski <bartek@wikia.com>, Tomasz Odrobny <tomek@wikia.com> for Wikia.com
 * @copyright (C) 2010, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: whatever goes here
 */

class WikiaStatsAutoHubsConsumerDB {
	private $dbs =  null;
    private $article_limits = array();
    private $refresh_time = 300;
    private $baned_user_groups = array('staff', 'bot', 'patrollers');
	/**
	 * constructor
	 */
	function __construct($db = DB_SLAVE  ) {
		global $wgStatsDB;
		$this->dbs = wfGetDB( $db, array(), $wgStatsDB);
	}

	private function makeInsert($table, $data, $options = array(), $onUpdate = '') {
		wfProfileIn( __METHOD__ );	
		if ( !is_array($data) ) {
			return null;
		}	
		$keys = array_keys( $data[0] );

		$sql = 'INSERT %s INTO %s (%s) VALUES %s %s';

		$first = true;
		$records = "";
		foreach ( $data as $row ) {
			if ( $first ) {
				$first = false;
			} else {
				$records .= ',';
			}
			$records .= '(' . $this->dbs->makeList( $row ) . ')';
		}
		wfProfileOut( __METHOD__ );
		return sprintf($sql, implode(' ', $options), $table, implode(',', $keys), $records, $onUpdate);
	}

	 /**
	 * instert stats for blogs per tag
	 *
	 * @param String $type
	 * @author Tomasz Odrobny, Piotr Molski
	 * @access private
	 *
	 */
	 public function insertBlogComment($data) {
		wfProfileIn( __METHOD__ );
		
		if ( empty($data) ) {
			return true;
		}
			  		
  		foreach ( $data as $lang => $tags ) {
			if ( !empty($tags) ) {
				foreach ( $tags as $tag_id => $records ) {
					$sql = $this->makeInsert("tags_top_blogs", $records, array('ignore'), "ON DUPLICATE KEY UPDATE tb_count = tb_count + 1");
					if ( $sql ) {
						$this->dbs->query($sql, __METHOD__);
					}
					$this->rebuildMemc($tag_id,$lang,"blog");
				}
			}
		}

		wfProfileOut( __METHOD__ );
	 }
	 
	 /**
	 * instert stats for article per tag
	 *
	 * @param String $type
	 * @author Tomasz Odrobny, Piotr Molski
	 * @access private
	 *
	 */
	 public function insertArticleEdit($data) {
		wfProfileIn( __METHOD__ );
		
		if ( empty($data) ) {
			return true;
		}
			  		
  		foreach ( $data as $lang => $tags ) {
			if ( !empty($tags) ) {
				foreach ( $tags as $tag_id => $records ) {
					$sql = $this->makeInsert("tags_top_articles", $records, array('ignore'), "ON DUPLICATE KEY UPDATE ta_count = ta_count + 1");
					if ( $sql ) {
						$this->dbs->query($sql, __METHOD__);
					}
					$this->rebuildMemc($tag_id,$lang,"article");
				}
			}
		}

		wfProfileOut( __METHOD__ );
	 }	 
	 
	 /**
	 * instert stats for users per tag
	 *
	 * @param String $type
	 * @author Tomasz Odrobny, Piotr Molski
	 * @access private
	 *
	 */
	 public function insertUserEdit($data) {
		wfProfileIn( __METHOD__ );
		
		if ( empty($data) ) {
			return true;
		}
			  		
  		foreach ( $data as $lang => $tags ) {
			if ( !empty($tags) ) {
				foreach ( $tags as $tag_id => $records ) {			
					$sql = $this->makeInsert("tags_top_users", $records, array('ignore'), "ON DUPLICATE KEY UPDATE tu_count = tu_count + 1");
					if ( $sql ) {
						$this->dbs->query($sql, __METHOD__);
					}
					$this->rebuildMemc($tag_id,$lang,"article");
				}
			}
		}

		wfProfileOut( __METHOD__ );
	 }	 	 


	/**
	 * delete old row from stats tables
	 *
	 * @param String $type
	 * @author Tomasz Odrobny
	 * @access private
	 *
	 */
	public function deleteOld() {
		wfProfileIn( __METHOD__ );

		$table_to_clear = array(
			'tags_top_users' => array('col' => 'tu_date', 'exp' => 7),
			'tags_top_articles' => array('col' => 'ta_date', 'exp' => 3),
			'tags_top_blogs' => array('col' => 'tb_date', 'exp' => 3)
		);

		foreach ($table_to_clear as $table => $date_col) {
			$delete_date = date("Y-m-d", mktime(0, 0, 0, date("m")  , date("d") - $date_col['exp'], date("Y")));
			$col = $date_col['col'];
			$this->dbs->delete( $table, array(  "$col = '$delete_date'" ) );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * get top blogs
	 *
	 * @author Tomasz Odrobny
	 * @access public
	 *
	 */

	public function getTopBlogs($tag_id, $lang, $limit = 5, $per_wiki = 1, $show_hide = false, $force_reload = false, $page_ids = null) {
		global $wgMemc, $wgContLang;

		wfProfileIn( __METHOD__ );
		$mcKey = wfSharedMemcKey( "auto_hubs", "blogs", $tag_id, $lang, $limit, $per_wiki );

		if( !$force_reload ) {
			$out = $wgMemc->get($mcKey);
			if( !empty($out) ) {
				wfProfileOut( __METHOD__ );
				return $out;
			}
		}
		$tag_id = (int) $tag_id;
		$conditions = array( "tb_tag_id = $tag_id and tb_city_lang = '$lang'" );
		// CorporatePage extension needs to get a list of staff blogs, and only has a list of page_ids
		if (is_array($page_ids) && !empty($page_ids)) {
			$conditions = array(" tb_page_id in (" . implode(",", $page_ids) . ")");
		}
		$res = $this->dbs->select(
				array( 'tags_top_blogs' ),
				array( 'tb_city_id as city_id,
						tb_page_id as page_id,
						tb_tag_id as tag_id,
						tb_date as date,
						tb_page_name as page_name,
						tb_page_url as page_url,
						tb_wikiname as wikiname,
						tb_wikiurl as wikiurl,
						sum(tb_count) as all_count' ),
				$conditions,
				__METHOD__,
				array(
					'GROUP BY' 	=> 'tb_city_id, tb_page_id',
					'ORDER BY' 	=> 'all_count desc',
					'LIMIT'		=> 100
				)
		);

		$out = $this->filterArticleBlog($res,$tag_id,$limit,$per_wiki,'blog',$show_hide);

		// add info about the logo, fix the page name
		foreach( $out as $key => $val ) {
			$out[$key]['logo'] = WikiFactory::getVarValueByName( "wgLogo", $val['city_id'] );
			$parts = explode( '/', $val['page_name'] );
			$out[$key]["user_name"] = str_replace(" ", "_", $parts[0]);
			$out[$key]["user_page"] = $out[$key]["wikiurl"]."/User:".$out[$key]["user_name"];
			if( count( $parts ) > 1 ) {
				array_shift( $parts );
				$out[$key]['page_name'] = implode( '/', $parts );
			} else {
				$out[$key]['page_name'] = $out[$key]['wikiname'];
			}

			if (!empty($out[$key]['timestamp'])) {
				$out[$key]['date'] =   $wgContLang->date( wfTimestamp( TS_MW, $out[$key]['timestamp'] ) );
			}
		}
		$out = array("value" => $out, "age" => time());
		$wgMemc->set($mcKey, $out, 60*60);
		wfProfileOut( __METHOD__ );
		return $out;
	}

	/**
	 * get top articles
	 *
	 * @author Tomasz Odrobny
	 * @access public
	 *
	 */

	public function getTopArticles($tag_id, $lang = "en", $limit = 5, $per_wiki = 1, $show_hide = false, $force_reload = false) {
		global $wgMemc;

		wfProfileIn( __METHOD__ );
		$mcKey = wfSharedMemcKey( "auto_hubs", "articles", $tag_id, $lang, $limit, $per_wiki );
		if( !$force_reload ) {
			$out = $wgMemc->get($mcKey);
			if( !empty($out) ) {
				wfProfileOut( __METHOD__ );
				return $out;
			}
		}

		$tag_id = (int) $tag_id;
		$conditions = array( "ta_tag_id = $tag_id and ta_city_lang = '$lang'" );
		$res = $this->dbs->select(
				array( 'tags_top_articles' ),
				array( 'ta_city_id as city_id,
						ta_page_id as page_id,
						ta_tag_id as tag_id,
						ta_date as date,
						ta_page_name as page_name,
						ta_page_url as page_url,
						ta_wikiname as wikiname,
						ta_wikiurl as wikiurl,
						sum(ta_count) as all_count' ),
				$conditions,
				__METHOD__,
				array(
					'GROUP BY' 	=> 'ta_city_id, ta_page_id',
					'ORDER BY' 	=> 'all_count desc',
					'LIMIT'		=> 100
				)
		);

		$out = $this->filterArticleBlog($res,$tag_id,$limit,$per_wiki,'article',$show_hide);

		$level = 1;
		$outLevel = $level;
		foreach ($out as $key => $value){
			$out[$key]['level'] = $outLevel;
			if( (!empty($out[$key]['wiki_counter'])) && ($out[$key]['wiki_counter'] == 1) ) {
				$level ++;
				if((!empty($out[$key+1]['all_count'])) && ( $out[$key]['all_count'] != $out[$key+1]['all_count'] )) {
					$outLevel = $level;
				}
			} else {
				$out[$key]['level'] = 'x';
			}
		}

		$out = array("value" => $out, "age" => time());
		$wgMemc->set($mcKey, $out,60*60 );
		wfProfileOut( __METHOD__ );
		return $out;
	}

	/**
	 * get top wikis
	 *
	 * @author Tomasz Odrobny
	 * @access public
	 *
	 */

	public function getTopWikis($tag_id, $lang, $limit, $show_hide = false, $force_reload = false) {
		global $wgMemc;

		wfProfileIn( __METHOD__ );
		$mcKey = wfSharedMemcKey( "auto_hubs", "wikis_top", $tag_id, $lang, $limit );
		if( !$force_reload ) {
			$out = $wgMemc->get($mcKey);
			if( !empty($out) ) {
				wfProfileOut( __METHOD__ );
				return $out;
			}
		}

		$tag_id = (int) $tag_id;
		$limit = 40;
		$lang_id = WikiFactory::LangCodeToId($lang);
		$conditions = array(
			"tag_id" 	=> $tag_id,
			"city_lang" => $lang_id
		);

		$res = $this->dbs->select(
				array( 'specials.page_views_summary_tags' ),
				array( 'tag_id as tag_id,
						city_id as city_id,
						pv_views as count ' ),
				$conditions,
				__METHOD__,
				array(
					'ORDER BY' 	=> 'count DESC',
					'LIMIT'		=> $limit
				)
		);
		
		if ( $this->dbs->numRows( $res ) == 0 ) {
			$date = date('Ymd', time() - 7 * 24 * 60 * 60);
			$conditions[] = "use_date > $date";
			$res = $this->dbs->select(
					array( ' stats.page_views_tags use key(tag_lang) ' ),
					array( 'tag_id as tag_id,
							city_id as city_id,
							sum(pv_views) as count ' ),
					$conditions,
					__METHOD__,
					array(
						'GROUP BY' 	=> ' tag_id,city_id ',
						'ORDER BY' 	=> ' count DESC ',
						'LIMIT'		=> $limit
					)
			);
		}

		$limits = $this->loadHideLimits("city");
		$limits_array = array();

		if ((!empty($limits[$tag_id])) && (count($limits[$tag_id]) > 0) ) {
			foreach ($limits[$tag_id] as $value) {
				$limits_array[] = $value['city_id'];
			}
		} else {
			$limits_array = array();
		}

		$pre_out = 1;
		$count = 0;
		$city_array = array();
		$numberOne = 1;

		while ( $value = $this->dbs->fetchRow($res) ) {
			$in_limits = in_array($value['city_id'], $limits_array);
			if( (!$in_limits) || $show_hide ) {
				$row = array('count' => $value['count']);

				if ($in_limits) {
					$row['hide'] = true;
				}

				$city_array[$value['city_id']] = $row;

				$count ++;
				if ( $count == $limit ) {
					break;
				}

				if ($count == 1) {
					$numberOne = $value['city_id'];
				}
			}
		}

		$dbs = WikiFactory::db( DB_SLAVE );

		$res = $dbs->select(
				array( "city_list"),
				array( "city_id,
						city_description as city_description,
						city_sitename,
						city_url,
						city_title" ),
				array(
					"city_id" => array_keys($city_array)
				),
				__METHOD__
		);

		while ( $value = $dbs->fetchRow($res) ) {
			if( !empty($city_array[$value['city_id']]) ) {
				$city_array[$value['city_id']] = array_merge( $value, $city_array[$value['city_id']]);
				$city_array[$value['city_id']]['city_description'] = trim( $city_array[$value['city_id']]['city_description'] );
			}
		}

		$out = array("value" => $city_array, "age" => time());

		$wgMemc->set($mcKey, $out, 60*60*12 );

		wfProfileOut( __METHOD__ );
		return $out;
	}

	public function getTopUsers($tag_id, $lang, $limit = 5, $force_reload = false) {
		global $wgMemc;

		wfProfileIn( __METHOD__ );
		$mcKey = wfSharedMemcKey( "auto_hubs", "users", $tag_id, $lang, $limit );
		if( !$force_reload ) {
			$out = $wgMemc->get($mcKey);
			if( !empty($out) ) {
				return $out;
			}
		}

		$tag_id = (int) $tag_id;
		$conditions = array( "tu_tag_id = $tag_id and tu_city_lang = '$lang'" );
		$res = $this->dbs->select(
				array( 'tags_top_users' ),
				array( 'tu_user_id as user_id,
						tu_tag_id as tag_id,
						tu_date as date,
						tu_username as username,
						tu_groups as groups,
						sum(tu_count) as all_count' ),
				$conditions,
				__METHOD__,
				array(
					'GROUP BY' 	=> 'tu_user_id',
					'ORDER BY' 	=> 'all_count desc',
					'LIMIT'		=> 100
				)
		);
		$out = array();
		$count = 0;
		while ( $row = $this->dbs->fetchRow( $res ) ) {
			if( $this->filterBanUsers($row) ){
				$out[] = $row;
				$count ++;
			}

			if( $count == $limit ) {
				break;
			}
		}

		// get avatars for the users
		foreach( $out as $key => $val ) {
			$userWiki = $this->getUserWiki($val['user_id']);
			if ( $userWiki !== false ) {
				list ( $wikiUrl, $pageUrl ) = array_values($userWiki);
				$avatar = Masthead::newFromUserId( $val['user_id'] );
				$avatar->setUserPageUrl($pageUrl);
				$out[$key]['avatar'] = $avatar->display( 30, 30 );
				$out[$key]['userpage'] = $pageUrl;
			}
		}

		$out = array("value" => $out, "age" => time());
		$wgMemc->set( $mcKey, $out,60*60 );
		wfProfileOut( __METHOD__ );
		return $out;
	}

	public function getUserWiki( $user_id ) {
		global $wgContLang, $wgMemc, $wgExternalDatawareDB;

		wfProfileIn( __METHOD__ );
		$dbw = wfGetDB( DB_SLAVE, 'blobs', $wgExternalDatawareDB );

		$mcKey = wfSharedMemcKey( "auto_hubs", "gt_user_wiki", $user_id  );

		$out = $wgMemc->get($mcKey,null);
		if( !empty($out) ) {
			wfProfileOut( __METHOD__ );
			return $out;
		}

		$oUser = User::newFromId( $user_id );
		if ( !$oUser instanceof User ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$oRes = $dbw->select(
			array( 'user_summary' ),
			array( 'edit_count', 'city_id' ),
			array( 'user_id' => $user_id ),
			__METHOD__,
			array(
				'ORDER BY' 	=> 'edit_count desc',
				'LIMIT'		=> 11
			)
		);
		$city_id = 0; while ( $oRow = $dbw->fetchObject( $oRes ) ) {
			if ( $oRow->city_id > 0 ) {
				$oRowPage = $dbw->selectRow(
					array( 'pages' ),
					array( 'page_wikia_id' ),
					array(
						'page_title'     => $oUser->getName(),
						'page_namespace' => NS_USER,
						'page_wikia_id'  => $oRow->city_id
					),
					__METHOD__
				);
				if ( $oRowPage && isset($oRowPage->page_wikia_id) ) {
					$city_id = $oRowPage->page_wikia_id;
					break;
				}
			}
		}
		$dbw->freeResult( $oRes );

		if ( empty($city_id) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$oGTitle = GlobalTitle::newFromText( $oUser->getName(), NS_USER, $city_id );

		$result = array();
		if ( is_object($oGTitle) ) {
			$result = array(
				'userWikiUrl' => $oGTitle->getServer(),
				'userPageUrl' => $oGTitle->getFullURL()
			);
		}

		if ( empty($result) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$wgMemc->set( $mcKey, $result, 60*60*24 );
		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * rebuild memc during event process
	 *
	 * @author Tomasz Odrobny
	 * @access private
	 *
	 */

	public function rebuildMemc($tag_id, $lang, $type,$force = false) {
		$time = time();
		switch ($type) {
			case 'article':
				$result = $this->getTopArticles($tag_id, $lang, 3, 1);
				if(( ( $time - $result['age'] ) > $this->refresh_time ) || $force ) {
					$this->getTopArticles($tag_id, $lang, 5, 1, false, true);
					$this->getTopArticles($tag_id, $lang, 15, 3, true, true);
				}

				$result = $this->getTopUsers($tag_id, $lang, 5) ;
				if(( ( $time - $result['age'] ) > $this->refresh_time ) || $force ) {
					$this->getTopUsers($tag_id, $lang, 5, true);
				}
			break;
			case 'blog':
				$result = $this->getTopBlogs($tag_id, $lang, 5, 1);
				if(( ( $time - $result['age'] ) > $this->refresh_time ) || $force ) {
					$this->getTopBlogs($tag_id, $lang, 3, 1, false, true);
					$this->getTopBlogs($tag_id, $lang, 9, 3, true, true);
				}
			case 'city':
				$result =  $this->getTopWikis($tag_id, $lang, 20, false, false);
				if(( ( $time - $result['age'] ) > $this->refresh_time ) || $force ) {
					$this->getTopWikis($tag_id, $lang, 20, false, true);
					$this->getTopWikis($tag_id, $lang, 30, true, true);
				}
			break;
			break;
		}
	}

	/**
	 * add exclude article to list
	 *
	 * @author Tomasz Odrobny
	 * @access public
	 *
	 */

	public function addExludeArticle($tag_id, $city_id, $page_id, $lang) {
		if ($this->addExlude($tag_id, $city_id, $page_id, 0, 'article')) {
			$this->loadHideLimits('article',true);
			$this->rebuildMemc($tag_id, $lang, 'article', true);
			return true;
		}
		return false;
	}

	/**
	 * add exclude article to list
	 *
	 * @author Tomasz Odrobny
	 * @access public
	 *
	 */

	public function addExludeBlog($tag_id, $city_id, $page_id, $lang) {
		if ($this->addExlude($tag_id, $city_id, $page_id, 0, 'blog')) {
			$this->loadHideLimits('blog',true);
			$this->rebuildMemc($tag_id, $lang, 'blog', true);
			return true;
		}
		return false;
	}

	/**
	 * add exclude wiki to list
	 *
	 * @author Tomasz Odrobny
	 * @access public
	 *
	 */

	public function addExludeWiki($tag_id, $city_id, $lang) {
		if ($this->addExlude($tag_id, $city_id, 0, 0, 'city')) {
			$this->loadHideLimits('city',true);
			$this->rebuildMemc($tag_id, $lang, 'city', true);
			return true;
		}
		return false;
	}
	/**
	 * remove exclude article to list
	 *
	 * @author Tomasz Odrobny
	 * @access public
	 *
	 */

	public function removeExludeArticle($tag_id, $city_id, $page_id, $lang) {
		if ($this->removeExlude($tag_id, $city_id, $page_id, 0, 'article')) {
			$this->loadHideLimits('article',true);
			$this->rebuildMemc($tag_id, $lang, 'article', true);
			return true;
		}
		return false;
	}

	/**
	 * remove exclude article to list
	 *
	 * @author Tomasz Odrobny
	 * @access public
	 *
	 */

	public function removeExludeBlog($tag_id, $city_id, $page_id, $lang) {
		if ($this->removeExlude($tag_id, $city_id, $page_id, 0, 'blog')) {
			$this->loadHideLimits('blog',true);
			$this->rebuildMemc($tag_id, $lang, 'blog', true);
			return true;
		}
		return false;
	}

	/**
	 * remove exclude wiki to list
	 *
	 * @author Tomasz Odrobny
	 * @access public
	 *
	 */

	public function removeExludeWiki($tag_id, $city_id, $lang) {
		if ($this->removeExlude($tag_id, $city_id, 0, 0, 'city')) {
			$this->loadHideLimits('city',true);
			$this->rebuildMemc($tag_id, $lang, $type,true);
			return true;
		}
		return false;
	}


	/**
	 * api call for get blog body
	 *
	 * @author Tomasz Odrobny
	 * @access private
	 *
	 */

	public function getBlogInfoByApi( $wikiurl, $page_id ) {
		global $wgMemc, $wgContLang;

		wfProfileIn( __METHOD__ );

	    $mcKey = wfSharedMemcKey( "auto_hubs", "blogi_api_info", $wikiurl, $page_id );

	    $out = $wgMemc->get($mcKey,null);
		if( !empty($out) ) {
			wfProfileOut( __METHOD__ );
			return $out;
		}

		$html_out = Http::get( $wikiurl."/api.php?action=blogs&page_id=".( (int) $page_id)."&summarylength=20&format=json" );
		$wikis = json_decode($html_out, true);

		if ( empty($wikis['blogpage'][$page_id]) ){
			wfProfileOut( __METHOD__ );
			return array();
		}

		$this->shortenText($wikis['blogpage'][$page_id]['description'], 30);

		if (strpos( $wikis['blogpage'][$page_id]['description'], 'wgAfterContentAndJS' ) > 0 ) {
			$temp = explode('wgAfterContentAndJS', $wikis['blogpage'][$page_id]['description']);

			$wikis['blogpage'][$page_id]['description'] = trim($temp[0]).". ";
		}

		$wgMemc->set($mcKey, $wikis['blogpage'][$page_id], 60*60 );

		wfProfileOut( __METHOD__ );
		return $wikis['blogpage'][$page_id];
	}


	/**
	 * load page stats by api
	 *
	 * @author Tomasz Odrobny
	 * @access private
	 *
	 */


	private function getWikiArticleCount($city_url) {
		$out = Http::get( $city_url."api.php?action=query&meta=siteinfo&siprop=statistics&format=json" );
		$out = json_decode($out, true);
		return $out['query']['statistics'];
	}

	/**
	 * short text for blog
	 *
	 * @author Tomasz Odrobny
	 * @access private
	 *
	 */

	private function shortenText(&$source_text, $word_count = 0 , $char_count = 0)
	{
		$source_text = strip_tags($source_text);
	    $word_count++;
	    $long_enough = TRUE;
	    $source_text = trim($source_text);

	    if ($source_text != "") {

	    }
	    if ($char_count > 0)  {
	    	if (strlen($source_text) <= $char_count ) {
	    		return 0 ;
	    	}
	    	$source_text_out = substr($source_text, 0, strrpos(substr($source_text, 0, $char_count), ' '));
	    	if ($source_text_out != $source_text) {
	    		$source_text = $source_text_out.'...';
	    	}
	    	return 0;
	    }

	    if ($word_count > 0)
	    {
	        $split_text = explode(" ", $source_text, $word_count);
	        if (sizeof($split_text) < $word_count)
	        {
	            $long_enough = FALSE;
	        }
	        else
	        {
	            array_pop($split_text);
	            $source_text = implode(" ", $split_text);
	        }
	    }
	    $source_text = trim($source_text);
	    if ( substr($source_text, -1) == "." ) {
	    	$source_text = trim($source_text)."..";
	    } else {
	    	$source_text = trim($source_text)."...";
	    }

	    return $long_enough;
	}

	/**
	 * add display exclude to db
	 *
	 * @author Tomasz Odrobny
	 * @access private
	 *
	 */

	private function removeExlude($tag_id, $city_id = 0, $page_id = 0, $user_id = 0, $type ) {
		$this->dbs->begin();
		$delete_date = date("Y-m-d", mktime(0, 0, 0, date("m")  , date("d") - $date_col['exp'], date("Y")));

		$con = "sf_city_id = $city_id and sf_page_id = $page_id and sf_user_id = $user_id and sf_tag_id = $tag_id and sf_type = '$type' ";

		$this->dbs->delete( 'tags_stats_filter' , array(  $con ) );

		$this->dbs->commit();
		return true;
	}


	/**
	 * add display exclude to db
	 *
	 * @author Tomasz Odrobny
	 * @access private
	 *
	 */

	private function addExlude($tag_id, $city_id = 0, $page_id = 0, $user_id = 0, $type ) {
		$this->dbs->begin();
		$this->dbs->insert('tags_stats_filter',
			array(
				 'sf_city_id' => $city_id,
				 'sf_page_id' => $page_id,
  				 'sf_user_id' => $user_id,
  				 'sf_tag_id'  => $tag_id,
  				 'sf_type' => $type
			),'Database::insert',array("IGNORE"));
		$out = $this->dbs->affectedRows() > 0;
		$this->dbs->commit();
		return $out;
	}

	/**
	 * filter for baned user groups: staff etc.
	 *
	 * @author Tomasz Odrobny
	 * @access private
	 *
	 */

	private function filterBanUsers($row) {
		wfProfileIn( __METHOD__ );

		if( $row['user_id'] == 0 ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$groups = explode(";",$row['groups']);
		foreach ( $groups as $value ) {
			if( in_array(strtolower($value), $this->baned_user_groups) ) {
				wfProfileOut( __METHOD__ );
				return false;
			}
		}

		if( 'Wikia' == $row['username'] ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * filter article or blog list
	 *
	 * @author Tomasz Odrobny
	 * @access private
	 *
	 */

	private function filterArticleBlog(&$res,$tag_id,$limit,$per_wiki,$type, $show_hide) {
		$per_wiki_counter = array();
		$counter = 0;
		$out = array();

		while ( $row = $this->dbs->fetchRow( $res ) ) {
			if ($type == 'blog' ) {
				$row = array_merge($row, $this->getBlogInfoByApi($row['wikiurl'], $row['page_id']));
				if ( empty( $row['description'] ) || ( strlen($row['description']) < 50 ) ) {
					continue;
				}
			}

			$row['real_pagename'] = $row['page_name'];
			$row['page_name'] = urldecode( str_replace('_' ,' ' , $row['page_name']) );
			if( $this->filterArticlesBlog($row, $tag_id, $type ) ) {
				if( $this->filterLimitPerWiki($row, $per_wiki, $per_wiki_counter ) ) {
					$counter++;
					$out[] = $row;
				}
			} else {

				if($show_hide){
					$row['hide'] = true;
					$out[] = $row;
					$counter++;
				}
			}

			if ($counter == $limit){
				break;
			}
		}
		return $out;
	}

	private function filterLimitPerWiki(&$row,$limit,&$counter) {
		$city_id = $row['city_id'];
		$page_id = $row['page_id'];

		if (empty($counter[$city_id])) {
			$counter[$city_id] = 0;
		}

		if( ((int) $counter[$city_id]) < $limit ){
			$counter[$city_id]++;
			$row['wiki_counter'] = $counter[$city_id];
			return true;
		}
		return false;
	}

	private function filterArticlesBlog($row, $tag_id, $type) {
		if( empty($this->article_limits[$type]) ) {
			$this->article_limits[$type] = $this->loadHideLimits($type);
		}

		if (empty($this->article_limits[$type][$tag_id])) {
			return true;
		}

		foreach ( $this->article_limits[$type][$tag_id] as $value ) {
			if( ($value['city_id'] == $row['city_id']) && ($value['page_id'] == $row['page_id']) ) {
				return false;
			}
		}

		return true;
	}

	private function loadHideLimits($type = 'blog', $force_reload = false) {
		global $wgMemc;
		$mcKey = wfSharedMemcKey( "auto_hubs", "limites_pages", $type);
		if(!$force_reload) {
			$out = $wgMemc->get($mcKey);
			if( !empty($out) ) {
				return $out;
			}
		}

		$res = $this->dbs->select(
			array( 'tags_stats_filter' ),
			array( 'sf_id as id,
					sf_city_id as city_id,
					sf_page_id as page_id,
					sf_tag_id as tag_id ' ),
			array(" sf_type = '$type' "),
			__METHOD__);

		$data = array();

		while( $row = $this->dbs->fetchRow( $res ) ) {
			$tag_id = $row['tag_id'];
			unset($row['tag_id']);
			$data[$tag_id][] = $row;
		}

		$wgMemc->set($mcKey,$data);
		return $data;
	}

}
