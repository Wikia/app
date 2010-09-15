<?php

	/**
	 * Category service
	 * @author wladek
	 */
	class CategoryService extends Service {

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
		 * @param $title Title|string Title object os category name
		 */
		public function __construct($title) {
			if (!$title instanceof Title) {
				$title = Title::newFromText($title,NS_CATEGORY);
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
			array_unshift($args,'categoryservice');
			return call_user_func_array('wfMemcKey',$args);
		}

		/**
		 * Returns memcached key for top articles data
		 * @param $dbkey string Category dbkey
		 * @param $ns int Namespace id
		 * @return string
		 */
		static public function getTopArticlesKey( $dbkey, $ns ) {
			return self::getKey( 'toparticles', $dbkey, $ns );
		}

		/**
		 * Returns page views count in last month.
		 * Uses stats.specials.page_views_summary_articles on production, page_visited on dev-boxes (inaccurate but testable).
		 *
		 * @param $pageIds array|int Array of article ids (or single integer to check one article)
		 * @return array|int
		 */
		static protected function fetchPageViewsStats( $pageIds ) {
			global $wgStatsDB, $wgCityId, $wgDevelEnvironment;;

			if (empty($wgDevelEnvironment)) {
				$dbr = wfGetDB( DB_SLAVE, null, $wgStatsDB );
				$res = $dbr->select(
					array( 'specials.page_views_summary_articles' ),
					array( 'page_id', 'pv_views' ),
					array(
						'city_id' => $wgCityId,
						'page_id' => $pageIds,
					),
					__METHOD__,
					array(
						'ORDER BY' => 'pv_views DESC',
					)
				);
			} else {
				// DevBox fallback because due to lack of functional stats db
				$dbr = wfGetDB( DB_SLAVE );
				$res = $dbr->select(
					array( 'page_visited' ),
					array( 'article_id as page_id', 'count as pv_views' ),
					array(
						'article_id' => $pageIds,
					),
					__METHOD__,
					array(
						'ORDER BY' => 'pv_views DESC',
					)
				);
			}

			$data = array();
			while ($row = $res->fetchObject($res)) {
				$data[intval($row->page_id)] = intval($row->pv_views);
			}

			// If asked with plain integer return a single integer too
			if (!is_array($pageIds)) {
				$data = !empty($data) ? reset($data) : 0;
			}

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
			global $wgDevelEnvironment;

			$articles = array();
			if (!empty($wgDevelEnvironment)) {
				$dbr = wfGetDB( DB_SLAVE, 'category' );
				$res = $dbr->select(
					array( 'page', 'categorylinks', 'page_visited' ),
					array( 'page_id', 'page_title', 'page_namespace', 'count'  ),
					array(
						'cl_to' => $this->dbkey,
						'page_namespace' => $namespace,
					),
					__METHOD__,
					array( 'ORDER BY' => 'count DESC' ,
//						'USE INDEX' => array( 'categorylinks' => 'cl_sortkey' ),
						'LIMIT'    => $count ),
					array( 'categorylinks'  => array( 'INNER JOIN', 'cl_from = page_id' ),
						'page_visited' => array( 'LEFT JOIN', 'article_id = page_id' ) )
				);

				$articles = array();
				while ($row = $res->fetchObject($res)) {
					$pageId = intval($row->page_id);
					$articles[$pageId] = array(
						'page_id' => $pageId,
						'page_title' => $row->page_title,
						'page_namespace' => $row->page_namespace,
						'views' => $row->count,
					);
				}

			} else {
				$dbr = wfGetDB( DB_SLAVE );
				$res = $dbr->select(
					array( 'page', 'categorylinks' ),
					array( 'page_id', 'page_title', 'page_namespace'  ),
					array(
						'cl_to' => $this->dbkey,
						'page_namespace' => $namespace,
					),
					__METHOD__,
					array(),
					array( 'categorylinks'  => array( 'INNER JOIN', 'cl_from = page_id' ) )
				);

				$pages = array();
				while ($row = $res->fetchObject($res)) {
					$pages[$row->page_id] = $row;
				}
				$pageIds = array_keys($pages);

				$pageViews = self::fetchPageViewsStats($pageIds);
				$articles = array();
				foreach ($pageViews as $pageId => $views) {
					$page = $pages[$pageId];
					$articles[$pageId] = array(
						'page_id' => $pageId,
						'page_title' => $row->page_title,
						'page_namespace' => $row->page_namespace,
						'views' => $views,
					);
				}
			}

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

			$id = $article->getID();
			$title = $article->getTitle();
			$ns = $title->getNamespace();

			$views = self::fetchPageViewsStats($id);

			foreach ($added as $one) {
				$catTitle = Title::newFromText($one,NS_CATEGORY);
				$catDBkey = $catTitle->getDBKey();

				$key = self::getTopArticlesKey($catDBkey, $ns);
				$data = $wgMemc->get($key);
				if (is_array($data)) {
					if ($data['count'] < count($data['articles']) || $data['minimum'] < $views) {
						$wgMemc->delete($key);
					}
				}
			}

			foreach ($deleted as $one) {
				$catTitle = Title::newFromText($one,NS_CATEGORY);
				$catDBkey = $catTitle->getDBKey();

				$key = self::getTopArticlesKey($catDBkey, $ns);
				$data = $wgMemc->get($key);
				if (is_array($data)) {
					if (array_key_exists($id,$data['articles'])) {
						$wgMemc->delete($key);
					}
				}
			}

			return true;
		}

		/**
		 * Hook entry for intercepting article moves to refresh memcached data if needed
		 * @return bool
		 */
		static public function onTitleMoveComplete( &$title, &$newtitle, &$user, $pageid, $redirid ) {
			global $wgMemc;

			$article = Article::newFromID($pageid);

			$id = $pageid;
			$ns = $title->getNamespace();

			$views = self::fetchPageViewsStats($id);

			$dbr = wfGetDB(DB_SLAVE);
			$res = $dbr->select( 'categorylinks', array( 'cl_to' ),
				array( 'cl_from' => $pageid ), __METHOD__ );
			$categories = array();
			while ( $row = $dbr->fetchObject( $res ) ) {
				$categories[] = $row->cl_to;
			}

			foreach ($categories as $one) {
				$catTitle = Title::newFromText($one,NS_CATEGORY);
				$catDBkey = $catTitle->getDBKey();

				$key = self::getTopArticlesKey($catDBkey, $ns);
				$data = $wgMemc->get($key);
				if (is_array($data)) {
					if (array_key_exists($pageid,$data['articles']) || array_key_exists($redirid,$data['articles'])) {
						$wgMemc->delete($key);
					}
				}
			}

			return true;
		}

	}
