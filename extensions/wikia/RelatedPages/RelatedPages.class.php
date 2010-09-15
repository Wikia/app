<?php

class RelatedPages {

	private $pages = null;
	private $categories = null;
	private $categoryCacheTTL = 8; // in hours
	private $categoryRankCacheTTL = 24; // in hours
	private $categoriesLimit = 6;
	private $pageSectionNo = 4; // number of section before which module should be injected (for long articles)
	private $isRendered = false;
	static private $instance = null;

	private function __construct( ) {
		$this->categories = array();
	}

	private function __clone() {
	}

	/**
	 * get class instance
	 * @return RelatedPages
	 */
	static public function getInstance() {
		if(self::$instance == null) {
			self::$instance = new RelatedPages();
		}
		return self::$instance;
	}

	public function setCategories( $categories ) {
		$this->categories = $categories;
	}

	public function getCategories() {
		return array_keys( $this->categories );
	}

	public function reset() {
		$this->pages = null;
	}

	public function isRendered() {
		return $this->isRendered;
	}

	public function setRendered($value) {
		$this->isRendered = $value;
	}

	public function getPageSectionNo() {
		return $this->pageSectionNo;
	}

	/**
	 * get related pages for article
	 * @param int $articleId Article ID
	 * @param int $limit limit
	 */
	public function get( $articleId, $limit = 3 ) {
		global $wgContentNamespaces;
		wfProfileIn( __METHOD__ );

		// prevent from calling this function more than one, use reset() to omit
		if( is_array( $this->pages ) ) {
			wfProfileOut( __METHOD__ );
			return $this->pages;
		}

		$this->pages = array();
		$categories = $this->getCategories();

		if ( count($categories) > 0 ) {
			$categories = $this->getCategoriesByRank( $categories );
			if( count( $categories ) > $this->categoriesLimit ) {
				// limit the number of categories to look for
				$categories = array_slice( $categories, 0, $this->categoriesLimit );
			}

			$pagesPerCategory = array();
			$allPages = array();
			$counters = array();

			foreach( $categories as $category ) {
				$pages = $this->getPagesForCategory( $category );
				$pagesPerCategory[$category] = $pages;
				$allPages = array_merge( $allPages, $pages );
			}
			$allPages = array_unique( $allPages );
			unset( $allPages[array_search($articleId, $allPages)] );
			sort( $allPages );

			$pageCounters = array();
			for( $i = 0; $i < count( $allPages); $i++ ) {
				foreach( $pagesPerCategory as $categoryPages ) {
					if( in_array($allPages[$i], $categoryPages) ) {
						if( isset($pageCounters[$allPages[$i]]) ) {
							$pageCounters[$allPages[$i]]++;
						}
						else {
							$pageCounters[$allPages[$i]] = 1;
						}
					}
				}
			}
			arsort($pageCounters);

			$count = 0;
			foreach ( array_keys( $pageCounters ) as $pageId ) {
				$title = Title::newFromId( $pageId );
				if(!empty($title) && $title->exists() && $count < $limit) {
					$this->pages[ $title->getArticleID() ] = array( 'url' => $title->getFullUrl(), 'title' => $title->getPrefixedText(), 'wrappedTitle' => $this->getWrappedTitle( $title->getPrefixedText() ) );
				}
				$count++;
			}

			if( class_exists('imageServing') ) {
				// ImageServing extension enabled, get images
				$imageServing = new imageServing( array_keys( $this->pages ), 200, array( 'w' => 2, 'h' => 1 ) );
				$images = $imageServing->getImages(1); // get just one image per article

				// TMP: always remove last article to get a text snippeting working example
				$images = array_slice($images, 0, $limit-1, true);

				foreach( $this->pages as $pageId => $data ) {
					if( isset( $images[$pageId] ) ) {
						$image = $images[$pageId][0];
						$data['imgUrl'] = $image['url'];
					}
					else {
						// no images, get a text snippet
						$data['text'] = $this->getArticleSnippet( $pageId );
					}
					$this->pages[ $pageId ] = $data;
				}
			}
			else {
				// ImageServing not enabled, just get text snippets for all articles
				foreach( $this->pages as $pageId => $data ) {
					$data['text'] = $this->getArticleSnippet( $pageId );
					$this->pages[ $pageId ] = $data;
				}
			}
		} // if $categories

		wfProfileOut( __METHOD__ );
		return $this->pages;
	}

	private function getWrappedTitle( $titleText ) {
		return chunk_split( $titleText, 30, '<br />' );
	}

	/**
	 * get all pages for given category
	 * @param string $category category name
	 * @return array list of page ids
	 */
	private function getPagesForCategory( $category ) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$cacheKey = wfMemcKey( __METHOD__, $category );
		$cache = $wgMemc->get( $cacheKey );
		if( is_array($cache) ) {
			wfProfileOut( __METHOD__ );
			return $cache;
		}

		$dbr = wfGetDB( DB_SLAVE );
		$tables = array( "categorylinks" );
		$joinSql = $this->getPageJoinSql( $dbr, $tables );

		$pages = array();
		$res = $dbr->select(
			$tables,
			array( "cl_from AS page_id" ),
			array( "cl_to" => $category ),
			__METHOD__,
			array(),
			$joinSql
		);

		while( $row = $dbr->fetchObject($res) ) {
			$pages[] = $row->page_id;
		}

		$wgMemc->set( $cacheKey, $pages, ( $this->categoryCacheTTL * 3600 ) );

		wfProfileOut( __METHOD__ );
		return $pages;
	}

	private function getPageJoinSql( $dbr, &$tables ) {
		global $wgContentNamespaces;
		wfProfileIn( __METHOD__ );

		if(count($wgContentNamespaces) > 0) {
			$joinSql = array( "page" =>
				array(
					"JOIN",
					implode(
						" AND ",
						array(
							"page_id = cl_from",
							( count($wgContentNamespaces) == 1)
								? "page_namespace = " . intval(reset($wgContentNamespaces))
								: "page_namespace in ( " . $dbr->makeList( $wgContentNamespaces ) . " )",
						)
					)
				)
			);
			$tables[] = "page";
		} else {
			$joinSql = array();
		}

		wfProfileOut( __METHOD__ );
		return $joinSql;
	}

	/**
	 * get categories sorted by rank
	 * @param array $categories
	 */
	private function getCategoriesByRank( Array $categories ) {
		$categoryRank = $this->getCategoryRank();

		$results = array();
		foreach( $categories as $category ) {
			if( isset($categoryRank[$category]) ) {
				$results[$categoryRank[$category]] = $category;
			}
		}

		ksort( $results );
		return count($results) ? array_values( $results ) : $categories;
	}

	/**
	 * get category rank, based on number of articles assigned
	 * @return array
	 */
	private function getCategoryRank() {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$cacheKey = wfMemcKey( __METHOD__ );
		$cache = $wgMemc->get( $cacheKey );
		if( is_array($cache) ) {
			wfProfileOut( __METHOD__ );
			return $cache;
		}

		$dbr = wfGetDB( DB_SLAVE );
		$tables = array( "categorylinks" );
		$joinSql = $this->getPageJoinSql( $dbr, $tables );

		$res = $dbr->select(
			$tables,
			array( "cl_to", "COUNT(cl_to) AS count" ),
			array(),
			__METHOD__,
			array(
				"GROUP BY" => "cl_to",
				"HAVING" => "count > 1",
				"ORDER BY" => "count DESC"
			),
			$joinSql
		);
		$results = array();

		$rank = 1;
		while($row = $dbr->fetchObject($res)) {
			$results[$row->cl_to] = $rank;
			$rank++;
		}

		$wgMemc->set( $cacheKey, $results, ( $this->categoryRankCacheTTL * 3600 ) );

		wfProfileOut( __METHOD__ );
		return $results;
	}

	/**
	 * get a snippet of article text
	 * @param int $articleId Article ID
	 * @param int $length snippet length (in characters)
	 */
	public function getArticleSnippet( $articleId, $length = 100 ) {
		global $wgTitle, $wgParser;

		$article = Article::newFromID( $articleId );
		$content = $article->getContent();

		// Perl magic will happen! Beware! Perl 5.10 required!
		$re_magic = '#SSX(?<R>([^SE]++|S(?!S)|E(?!E)|SS(?&R))*EE)#i';

		// remove {{..}} tags
		$re = strtr( $re_magic, array( 'S' => "\\{", 'E' => "\\}", 'X' => '' ));
		$content = preg_replace($re, '', $content);

		// remove [[Image:...]] and [[File:...]] tags
		$re = strtr( $re_magic, array( 'S' => "\\[", 'E' => "\\]", 'X' => "(Image|File):" ));
		$content = preg_replace($re, '', $content);

		// skip "edit" section and TOC
		$content .= "\n__NOEDITSECTION__\n__NOTOC__";

		$tmpParser = new Parser();
		$content = $tmpParser->parse( $content, $wgTitle, new ParserOptions )->getText();

		// remove <script> tags (RT #46350)
		$content = preg_replace('#<script[^>]+>(.*)<\/script>#', '', $content);

		// experimental: remove <th> tags
		$content = preg_replace('#<th[^>]*>(.*?)<\/th>#s', '', $content);

		// remove HTML tags
		$content = trim(strip_tags($content));

		// compress white characters
		$content = mb_substr($content, 0, $length + 200);
		$content = strtr($content, array('&nbsp;' => ' ', '&amp;' => '&'));
		$content = preg_replace('/\s+/',' ',$content);

		// store first x characters of parsed content
		$content = mb_substr($content, 0, $length);
		$content = strtr($content, array('&nbsp;' => ' ', '&amp;' => '&'));

		return $content;
	}

	public static function onOutputPageMakeCategoryLinks( $outputPage, $categories, $categoryLinks ) {
		RelatedPages::getInstance()->setCategories( $categories );
		return true;
	}

	public static function onOutputPageBeforeHTML( &$out, &$text ) {
		if ( class_exists( 'ArticleAdLogic' ) && $out->isArticle() && ArticleAdLogic::isContentPage() && ArticleAdLogic::isLongArticle($text)) {
			// long article, inject Related Pages module after x section
			$relatedPages = RelatedPages::getInstance();

			$sections = preg_split( '/<h2>/i', $text, -1, PREG_SPLIT_OFFSET_CAPTURE );

			if( !empty( $sections[$relatedPages->getPageSectionNo()] ) ) {
				// we have enough sections, proceed
				$sectionPos = $sections[$relatedPages->getPageSectionNo()][1];

				$first = substr( $text, 0, $sectionPos - 4 );
				$last = substr( $text, $sectionPos - 4);

				$text = $first . wfRenderModule('RelatedPages') . $last;

				$relatedPages->setRendered( true );
			}
		}
		return true;
	}

}
