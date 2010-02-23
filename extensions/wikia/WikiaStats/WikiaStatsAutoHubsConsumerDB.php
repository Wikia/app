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
    private $article_limits = null;
    private $refresh_time = 60; 
    private $baned_user_groups = array('staff');
	/**
	 * constructor
	 */
	function __construct($db = DB_MASTER  ) {
		global $wgExternalStatsDB;
		$this->dbs = wfGetDB( $db );//, array(), $wgExternalStatsDB );
	}

	 /**
	 * instert stats for users and article per tag
	 *
	 * @param String $type
	 * @author Tomasz Odrobny 
	 * @access private
	 *
	 */
	
	public function insertBlogComment($city_id, $page_id, $tag_id, $page_name, $page_url, $wikiname, $wikiurl, $lang) {
		wfProfileIn( __METHOD__ );
		
		$date = date ("Y-m-d");

  		$this->dbs->begin();
  		  		
		$inster_array = array(
  					'tb_city_id' => (int) $city_id,
					'tb_page_id' => (int) $page_id,
					'tb_tag_id' => (int) $tag_id,
					'tb_date' => "'$date'",
					'tb_city_lang' => "'$lang'",
					'tb_page_name' => $this->dbs->addQuotes($page_name),
					'tb_page_url' => $this->dbs->addQuotes($page_url),
					'tb_wikiname' => $this->dbs->addQuotes($wikiname),
					'tb_wikiurl' => $this->dbs->addQuotes($wikiurl),
					'tb_count' => 1
		);
		
		$sql = "insert into tags_top_blogs  ( " . implode(",",array_keys ($inster_array)) . ") 
									values  ( " . implode(",",$inster_array) . ") 		
					ON DUPLICATE KEY UPDATE `tb_count` = `tb_count` + 1 ;";

		$this->dbs->query($sql);
		$this->deleteOld();
		$this->dbs->commit();
		
		$this->rebuildMemc($tag_id,$lang,"blog");
		
		wfProfileOut( __METHOD__ );
	}
	
	/**
	 * instert stats for users and article per tag
	 *
	 * @param String $type
	 * @author Tomasz Odrobny 
	 * @access private
	 *
	 */
	
	public function insertArticleEdit($city_id, $page_id, $user_id, $tag_id, $page_name, $page_url, $wikiname, $wikiurl, $groups, $username, $lang) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );
		$date = date ("Y-m-d");
		
		$mcKey = wfSharedMemcKey( "auto_hubs", "unique_control", $city_id, $page_id, $user_id, $tag_id, $date );
		$out = $wgMemc->get($mcKey,null);
		
		if ($out == 1) {
			return ;
		}
		$wgMemc->set($mcKey,1,24*60*60);
		
  		$this->dbs->begin();

		$inster_array = array(
					'tu_user_id' => (int) $user_id,
					'tu_tag_id' => (int) $tag_id,
					'tu_date' => "'$date'",
					'tu_groups' => $this->dbs->addQuotes( $groups ),
					'tu_username' => $this->dbs->addQuotes( $username ),
					'tu_city_lang' => "'$lang'",
					'tu_count' => 1,
		);
		
		$sql = "insert into tags_top_users  ( " . implode(",",array_keys ($inster_array)) . ") 
									values  ( " . implode(",",$inster_array) . ") 		
					ON DUPLICATE KEY UPDATE `tu_count` = `tu_count` + 1 ;";
		
		if( $user_id != 0 ) {
			$this->dbs->query($sql);	
		}
		
		$inster_array = array(
  					'ta_city_id' => (int) $city_id,
					'ta_page_id' => (int) $page_id,
					'ta_tag_id' => (int) $tag_id,
					'ta_date' => "'$date'",
					'ta_city_lang' => "'$lang'",
					'ta_page_name' => $this->dbs->addQuotes($page_name),
					'ta_page_url' => $this->dbs->addQuotes($page_url),
					'ta_wikiname' => $this->dbs->addQuotes($wikiname),
					'ta_wikiurl' => $this->dbs->addQuotes($wikiurl),
					'ta_count' => 1
		);
		
		$sql = "insert into tags_top_article  ( " . implode(",",array_keys ($inster_array)) . ") 
									values  ( " . implode(",",$inster_array) . ") 		
					ON DUPLICATE KEY UPDATE `ta_count` = `ta_count` + 1 ;";
		
		$this->dbs->query($sql);
		$this->deleteOld(); 
		$this->dbs->commit();
	
		$this->rebuildMemc($tag_id,$lang,"user");
		$this->rebuildMemc($tag_id,$lang,"article");
		
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
			'tags_top_article' => array('col' => 'ta_date', 'exp' => 3),
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
	
	public function getTopBlogs($tag_id, $lang, $limit = 5, $per_wiki = 1, $show_hide = false, $force_reload = false) {
		global $wgMemc;
		
		wfProfileIn( __METHOD__ );
		$mcKey = wfSharedMemcKey( "auto_hubs", "blogs", $tag_id, $lang, $limit, $per_wiki );
		
		if( !$force_reload ) {
			$out = $wgMemc->get($mcKey,null);
			if( !empty($out) ) {
				return $out;
			}
		}
		$tag_id = (int) $tag_id;
		$conditions = array( "tb_tag_id = $tag_id and tb_city_lang = '$lang'" );
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
			$out = $wgMemc->get($mcKey,null);
			if( !empty($out) ) {
				return $out;
			}
		}
		
		$tag_id = (int) $tag_id;
		$conditions = array( "ta_tag_id = $tag_id and ta_city_lang = '$lang'" );
		$res = $this->dbs->select(
				array( 'tags_top_article' ),
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
		$out = array("value" => $out, "age" => time());
		$wgMemc->set($mcKey, $out,60*60 );
		wfProfileOut( __METHOD__ );
		return $out;
	}
	
	/**
	 * get top users 
	 *
	 * @author Tomasz Odrobny 
	 * @access public
	 *
	 */
	
	public function getTopUsers($tag_id, $lang, $limit = 5, $force_reload = false) {
		global $wgMemc;
		
		wfProfileIn( __METHOD__ );
		$mcKey = wfSharedMemcKey( "auto_hubs", "users", $tag_id, $lang, $limit );
		if( !$force_reload ) {
			$out = $wgMemc->get($mcKey,null);
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
		$out = array("value" => $out, "age" => time());
		$wgMemc->set( $mcKey, $out,60*60 );
		wfProfileOut( __METHOD__ );
		return $out;
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
				$result = $this->getTopArticles($tag_id, $lang, 5, 1);
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
					$this->getTopBlogs($tag_id, $lang, 5, 1, false, true);
					$this->getTopBlogs($tag_id, $lang, 15, 3, true, true);
				}
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
			$this->loadArticleBlogLimits('article',true);
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
		
	public function addExludeBlog($tag_id, $city_id, $page_id) {
		if ($this->addExlude($tag_id, $city_id, $page_id, 0, 'blog')) {
			$this->loadArticleBlogLimits('blog',true);
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
		
	public function addExludeWiki($tag_id, $city_id) {
		return $this->addExlude($tag_id, $city_id, 0, 0, 'city'); 
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
		$groups = explode(";",$row['groups']);
		foreach ( $groups as $value ) {
			if( in_array($value, $this->baned_user_groups) ) {
				wfProfileOut( __METHOD__ );
				return false;
			} 
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
			if( $this->filterArticlesBlog($row, $tag_id, $type ) ) {
				if( $this->filterLimitPerWiki($row, $per_wiki, $per_wiki_counter ) ) {
					$out[] = $row;
					$counter++;
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
	
	private function filterLimitPerWiki($row,$limit,&$counter) {
		$city_id = $row['city_id'];
		$page_id = $row['page_id'];
		
		if (empty($counter[$city_id])) {
			$counter[$city_id] = 0;
		}
		
		if( ((int) $counter[$city_id]) < $limit ){
			$counter[$city_id]++;
			return true;
		}
		return false;
	}
	
	private function filterArticlesBlog($row, $tag_id, $type) {
		if( empty($this->article_limits) ) {
			$this->article_limits = $this->loadArticleBlogLimits($type);	
		}

		if (empty($this->article_limits[$tag_id])) {
			return true;
		}
	
		foreach ( $this->article_limits[$tag_id] as $value ) {
			if( ($value['city_id'] == $row['city_id']) && ($value['page_id'] == $row['page_id']) ) {
				return false;
			}
		} 
		
		return true;
	}
	
	private function loadArticleBlogLimits($type = 'blog', $force_reload = false) {
		global $wgMemc;
		$mcKey = wfSharedMemcKey( "auto_hubs", "limites_pages", $type);
		if(!$force_reload) {	
			$out = $wgMemc->get($mcKey,null);
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