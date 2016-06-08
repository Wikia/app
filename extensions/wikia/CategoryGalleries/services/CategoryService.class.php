<?php

	/**
	 * Category service
	 * @author wladek
	 */
	class CategoryService extends Service {
		const CACHE_VERSION = 1;

		/**
		 * Cache time-to-live (int seconds)
		 * @var int
		 */
		const CACHE_TTL = 86400;

		/**
		 * Category title
		 * @var Title
		 */
		protected $title = null;

		/**
		 * Category dbkey
		 * @var string
		 */
		protected $dbkey = null;

		/**
		 * Creates the category service object
		 * @param $title Title|string Title object or category name
		 */
		public function __construct($title) {
			if (!$title instanceof Title) {
				$title = Title::makeTitle(NS_CATEGORY,$title);
			}
			$this->title = $title;
			$this->dbkey = $this->title->getDBkey();
		}

		/**
		 * Returns memcached key bound to this class.
		 * Takes any number of arguments
		 * @return string
		 */
		static public function getKey( $tokens = null ) {
			$args = func_get_args();
			array_unshift($args, 'categoryservice', self::CACHE_VERSION );
			return call_user_func_array('wfMemcKey',$args);
		}

		/**
		 * Returns memcached key for top articles data
		 * @param $dbkey string Category dbkey
		 * @param $ns int Namespace id
		 * @return string
		 */
		static public function getTopArticlesKey( $dbkey, $ns ) {
			return self::getKey( 'toparticles', md5($dbkey), $ns );
		}

		/**
		 * Returns page views count in last month.
		 * @param $pageIds array|int Array of article ids (or single integer to check one article)
		 * @return array|int
		 */
		static protected function getPageViews( $pageIds ) {
			global $wgCityId;

			wfProfileIn(__METHOD__);

			if ( empty($pageIds)  ) {
				wfProfileOut(__METHOD__);
				return is_array($pageIds) ? array() : 0;
			}

			//fix for BugId:33086
			//use DataMart for pageviews data as all the other
			//data sources are stale/obsolete
			$data = array();
			$ids = ( is_array ( $pageIds ) ) ? $pageIds : array( $pageIds );
			$rows = DataMartService::getTopArticlesByPageview( $wgCityId, $ids, null, false, count( $ids ) );

			foreach( $rows as $id => $pv ) {
				$data[intval( $id )] = intval( $pv );
			}

			// If asked with plain integer return a single integer too
			if (!is_array($pageIds)) {
				$data = !empty($data) ? reset($data) : 0;
			}

			wfProfileOut(__METHOD__);
			return $data;
		}

		/**
		 * Returns top articles from given namespace in current category.
		 * Always pulls data from DB and returns as array entries.
		 *
		 * @param $count int Maximum number of articles to return
		 * @param $namespace int Namespace id (default: NS_MAIN)
		 * @return array
		 */
		protected function fetchTopArticlesInfo( $count, $namespace = NS_MAIN ) {
			wfProfileIn(__METHOD__);

			$articles = array();
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				array( 'page', 'categorylinks' ),
				array( 'page_id', 'page_title', 'page_namespace'  ),
				array(
					'cl_to' => $this->dbkey,
					'page_namespace' => $namespace,
				),
				__METHOD__,
				array(
					// PLATFORM-2246: do not fetch all articles in the category as there can be tens of thousands of them
					'LIMIT' => 5000
				),
				array( 'categorylinks'  => array( 'INNER JOIN', 'cl_from = page_id' ) )
			);

			if($res !== false){
				$pages = array();

				while ($row = $res->fetchObject($res)) {
					$pages[intval($row->page_id)] = $row;
				}

				$pageIds = array_keys($pages);
				$pageViews = self::getPageViews($pageIds);
				$articles = array();
				$entries = 0;

				foreach ($pageViews as $pageId => $views) {
					if ($entries >= $count)
						break;
					if (empty($pages[$pageId]))
						continue;
					$page = $pages[$pageId];
					$articles[$pageId] = array(
						'page_id' => $pageId,
						'page_title' => $page->page_title,
						'page_namespace' => $page->page_namespace,
						'views' => $views,
					);
					$entries++;
					unset($pages[$pageId]);
				}

				foreach ($pages as $page) {
					if ($entries >= $count)
						break;
					$page->page_id = intval($page->page_id);
					$articles[$page->page_id] = array(
						'page_id' => $page->page_id,
						'page_title' => $page->page_title,
						'page_namespace' => $page->page_namespace,
						'views' => 0,
					);
					$entries++;
				}
			}

			wfProfileOut(__METHOD__);
			return $articles;
		}

		/**
		 * Returns top articles from given namespace in current category
		 * Uses memcached to speed up the process and returns the Title objects in array.
		 *
		 * @param $count int Maximum number of articles to return
		 * @param $namespace int Namespace id (default: NS_MAIN)
		 * @return array
		 */
		public function getTopArticles( $count, $namespace = NS_MAIN ) {
			global $wgMemc;

			wfProfileIn(__METHOD__);

			$key = self::getTopArticlesKey($this->dbkey,$namespace);
			$data = $wgMemc->get($key);

			if (!is_array($data) || $data['count'] < $count) {
				$articles = $this->fetchTopArticlesInfo($count,$namespace);
				$lastArticle = count($articles) > 0 ? end($articles) : null;
				$data = array(
					'count' => $count,
					'minimum' => $lastArticle ? $lastArticle['views'] : -1,
					'articles' => $articles,
				);

				$wgMemc->set($key,$data,self::CACHE_TTL);
			}

			$result = array();
			$articles = array_slice($data['articles'],0,$count);
			foreach ($articles as $article) {
				$result[$article['page_id']] = Title::makeTitle($article['page_namespace'], $article['page_title']);
			}

			wfProfileOut(__METHOD__);
			return $result;
		}

		/**
		 * Hook entry for intercepting category change in articles in order to refresh memcached data if needed
		 * @param $article Article Article object
		 * @param $added array List of added categories to the article
		 * @param $deleted array List of deleted categories from the article
		 * @return bool
		 */
		static public function onArticleUpdateCategoryCounts( $article, $added, $deleted ) {
			// Most of the time categories are not changed during the edit, so speed up
			if (empty($added) && empty($deleted)) {
				return true;
			}

			global $wgMemc;

			wfProfileIn(__METHOD__);

			$id = $article->getID();
			$title = $article->getTitle();
			$ns = $title->getNamespace();

			$views = self::getPageViews($id);

			foreach ($added as $one) {
				$catTitle = Title::makeTitle(NS_CATEGORY,$one);
				$catDBkey = $catTitle->getDBKey();

				$key = self::getTopArticlesKey($catDBkey, $ns);
				$data = $wgMemc->get($key);
				if (is_array($data)) {
					if ($data['count'] > count($data['articles']) || $data['minimum'] < $views) {
						self::invalidateTopArticles($catTitle,$ns);
					}
				} else {
					self::invalidateTopArticles($catTitle,$ns);
				}
			}

			foreach ($deleted as $one) {
				$catTitle = Title::makeTitle(NS_CATEGORY,$one);
				$catDBkey = $catTitle->getDBKey();

				$key = self::getTopArticlesKey($catDBkey, $ns);
				$data = $wgMemc->get($key);
				if (is_array($data)) {
					if (array_key_exists($id,$data['articles'])) {
						self::invalidateTopArticles($catTitle,$ns);
					}
				} else {
					self::invalidateTopArticles($catTitle,$ns);
				}
			}

			wfProfileOut(__METHOD__);
			return true;
		}

		/**
		 * Hook entry for intercepting article moves to refresh memcached data if needed
		 * @param $title Title
		 * @return bool
		 */
		static public function onTitleMoveComplete( &$title, &$newtitle, &$user, $pageid, $redirid ) {
			global $wgMemc;

			wfProfileIn(__METHOD__);

			$ns = $title->getNamespace();

			$dbr = wfGetDB(DB_SLAVE);
			$res = $dbr->select( 'categorylinks', array( 'cl_to' ),
				array( 'cl_from' => $pageid ), __METHOD__ );
			$categories = array();
			while ( $row = $dbr->fetchObject( $res ) ) {
				$categories[] = $row->cl_to;
			}

			foreach ($categories as $one) {
				$catTitle = Title::makeTitle(NS_CATEGORY,$one);
				$catDBkey = $catTitle->getDBKey();

				$key = self::getTopArticlesKey($catDBkey, $ns);
				$data = $wgMemc->get($key);
				if (is_array($data)) {
					if (array_key_exists($pageid,$data['articles']) || array_key_exists($redirid,$data['articles'])) {
						self::invalidateTopArticles($catTitle,$ns);
					}
				} else {
					self::invalidateTopArticles($catTitle,$ns);
				}
			}

			wfProfileOut(__METHOD__);
			return true;
		}

		/**
		 * Invalidates top articles cache for given category and namespace
		 * @param $catTitle Title Category title object
		 * @param $ns int Namespace index of invalidated top articles data
		 */
		static public function invalidateTopArticles( $catTitle, $ns ) {
			global $wgMemc;

			wfProfileIn(__METHOD__);

			$catDBkey = $catTitle->getDBKey();
			$key = self::getTopArticlesKey($catDBkey, $ns);
			$wgMemc->delete($key);
			wfRunHooks('CategoryService::invalidateTopArticles',array($catTitle,$ns));

			wfProfileOut(__METHOD__);
		}

	}
