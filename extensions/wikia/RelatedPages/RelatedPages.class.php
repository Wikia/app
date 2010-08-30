<?php

class RelatedPages {

	private $pages = null;
	private $categories = null;
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

	/**
	 * get related pages for article
	 * @param int $articleId Article ID
	 * @param int $limit limit
	 */
	public function get( $articleId, $limit = 3 ) {
		global $wgContentNamespaces;

		// prevent from calling this function more than one, use reset() to omit
		if( is_array( $this->pages ) ) {
			return $this->pages;
		}

		$this->pages = array();

		$categories = $this->getCategories();
		if ( $categories ) {
			sort( $categories );

			// caching tmp off
			//$cacheKey = wfMemcKey(__CLASS__, join(':', $categories), 1);
			//$out = $wgMemc->get($cacheKey);
			$out = null;

			if(!is_array($out)) {

				$dbr = wfGetDB(DB_SLAVE, 'stats');

				$tables = array( "categorylinks" );

				if(count($wgContentNamespaces) > 0) {
					$joinSql = array( "page" =>
						array(
							"JOIN",
							implode(
								" AND ",
								array(
									"page_id = cl_from",
									( count($wgContentNamespaces) == 1)
										? "page_namespace = " . intval(array_shift($wgContentNamespaces))
										: "page_namespace in ( " . $dbr->makeList( $wgContentNamespaces ) . " )",
								)
							)
						)
					);
					$tables[] = "page";
				} else {
					$joinSql = array();
				}

				$options = array("GROUP BY" => "cl_from");
				if (count($categories) > 1) {
					$options["HAVING"] = "COUNT(cl_to) > 1";
				} else {
					$options["LIMIT"] = 100;
				}

				$res1 = $dbr->select(
					$tables,
					array( "cl_from", "COUNT(cl_to) AS count" ),
					array(
						"cl_to in ( " . $dbr->makeList( $categories ) . " )",
					),
					"RelatedPages Query 1",
					$options,
					$joinSql
				);
				$out = array();
				$results = array();
				while($row1 = $dbr->fetchObject($res1)) {
					$results[$row1->cl_from] = $row1->count;
				}

				if ( count($categories) > 1 ) {
					arsort($results);
					//uasort($results, 'RelatedPages_Compare');
					$out = array_slice(array_keys($results), 0, 5);
				} else {
					if ( count($results) > 0 ) {
						$out = array_rand($results, min(count($results), 5));
						if ( !is_array($out) ) {
							$out = array($out);
						}
					}
				}

				if ( count($categories) > 1 && count($out) < 5 ) {
					$results = array();

					$res2 = $dbr->select(
						$tables,
						array( "cl_from" ),
						array(
							"cl_to in ( " . $dbr->makeList( $categories ) . " )",
						),
						"RelatedPages Query 2",
						array(
							"GROUP BY" => "cl_from",
							"LIMIT" => 100
						),
						$joinSql
					);

					while($row2 = $dbr->fetchObject($res2)) {
						if(!in_array($row2->cl_from, $out)) {
							$results[] = $row2->cl_from;
						}
					}

					if ( !empty($results) ) {
						$randOut = array_rand(array_flip($results), min(count($results), 5 - count($out)));
						if ( !is_array($randOut) ) { // array_rand will return a single element instead of an array of size 1
							$randOut = array($randOut);
						}
						$out = array_merge($out, $randOut);
					}
				}

				//$wgMemc->set($cacheKey, $out, 60 * 60 * 6);
			}

			if ( count($out) > 0 ) {
				unset($out[array_search($articleId, $out)]);

				// quit if we have no data after removing current page
				if ( empty( $out ) ) {
					return array();
				}

				$count = 0;
				foreach ( $out as $item ) {
					$title = Title::newFromId($item);
					if(!empty($title) && $title->exists() && $count < $limit) {
						$this->pages[ $title->getArticleID() ] = array( 'url' => $title->getFullUrl(), 'title' => $title->getPrefixedText() );
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

			}
		} // if categories

		return $this->pages;
	}

	/**
	 * get a snippet of article text
	 * @param int $articleId Article ID
	 * @param int $length snippet length (in characters)
	 */
	public function getArticleSnippet( $articleId, $length = 150 ) {
		global $wgTitle, $wgParser;

		$article = Article::newFromID( $articleId );
		$content = $article->getContent();

		$tmpParser = new Parser();
		$content = $tmpParser->parse( $content, $wgTitle, new ParserOptions )->getText();

		// remove [edit] section links
		$content = preg_replace('#<span class="editsection">(.*)</a>]</span>#', '', $content);

		// remove <script> tags (RT #46350)
		$content = preg_replace('#<script[^>]+>(.*)<\/script>#', '', $content);

		// remove HTML tags
		$content = trim(strip_tags($content));

		// store first 150 characters of parsed content
		$content = mb_substr($content, 0, $length);
		$content = strtr($content, array('&nbsp;' => ' ', '&amp;' => '&'));

		return $content;
	}

	public static function onOutputPageMakeCategoryLinks( $outputPage, $categories, $categoryLinks ) {
		RelatedPages::getInstance()->setCategories( $categories );
		return true;
	}
}
