<?php
/**
 * Model for Wiki Navigation
 *
 * @author Jakub "Student" Olek
 */

class NavigationModel extends WikiaModel {
	const WIKIA_GLOBAL_VARIABLE = 'wgOasisGlobalNavigation';
	const WIKI_LOCAL_MESSAGE = 'Wiki-navigation';
	const CACHE_TTL = 10800; // 3 hours

	const version = '1';
	const ORIGINAL = 'original';
	const PARENT_INDEX = 'parentIndex';
	const CHILDREN = 'children';
	const DEPTH = 'depth';
	const HREF = 'href';
	const HASH = 'hash';
	const TEXT = 'text';
	const SPECIAL = 'specialAttr';
	const CANONICAL_NAME = 'canonicalName';

	const TYPE_MESSAGE = 'message';
	const TYPE_VARIABLE = 'variable';

	const COMMUNITY_WIKI_ID = 177;

	// magic word used to force given menu item to not be turned into a link (BugId:15189)
	const NOLINK = '__NOLINK__';
	const ALLOWABLE_TAGS = '';

	private $biggestCategories;
	private $lastExtraIndex = 1000;
	private $extraWordsMap = array(
		'voted' => 'GetTopVotedArticles',
		'popular' => 'GetMostPopularArticles',
		'visited' => 'GetMostVisitedArticles',
		'newlychanged' => 'GetNewlyChangedArticles',
		'topusers' => 'GetTopFiveUsers'
	);

	private $forContent = false;
	private $useSharedMemcKey = false;

	// list of errors encountered when parsing the wikitext
	private $errors = array();

	const ERR_MAGIC_WORD_IN_LEVEL_1 = 1;

	public function __construct( $useSharedMemcKey = false ) {
		parent::__construct();

		$this->useSharedMemcKey = $useSharedMemcKey;
	}

	/**
	 * Return memcache key used for given message / variable
	 *
	 * City ID can be specified to return key for different wiki
	 *
	 * @param string $name message / variable name
	 * @param int $cityId city ID (false - default to current wiki)
	 * @return string memcache key
	 */
	public function getMemcKey( $messageName, $cityId = false ) {
		if ( $this->useSharedMemcKey ) {
			$wikiId = substr( $this->wf->SharedMemcKey(), 0, -1 );

		} else {
			$wikiId = ( is_numeric($cityId)) ? $cityId : intval( $this->wg->CityId );

			// fix for internal and staff (BugId:15149)
			if ($wikiId == 0) {
				$wikiId = $this->wg->DBname;
			}
		}

		$messageName = str_replace(' ', '_', $messageName);

		return implode(':', array(__CLASS__, $wikiId, $this->wg->Lang->getCode(), $messageName, self::version));
	}

	/**
	 * Return list of errors encountered when parsing the wikitext
	 *
	 * @return array list of errors
	 */
	public function getErrors() {
		return $this->errors;
	}

	public function get(){
		return $this->parseMenu(
			self::WIKIA_GLOBAL_VARIABLE,
			array(
				4,
				4,
				4
			),
			true
		);
	}

	public function parseMenu( $menuName, Array $maxChildrenAtLevel, $filterInactiveSpecialPages = false ){
		switch( $menuName ) {
			case self::WIKIA_GLOBAL_VARIABLE:
				// get menu content from WikiFactory variable
				return $this->parseVariable(
					$menuName,
					$maxChildrenAtLevel,
					self::CACHE_TTL,
					true /* $forContent */,
					$filterInactiveSpecialPages
				);
				break;

			case self::WIKI_LOCAL_MESSAGE:
			default:
				// get menu content from the message
				return $this->parseMessage(
					$menuName,
					$maxChildrenAtLevel,
					self::CACHE_TTL,
					true /* $forContent */,
					$filterInactiveSpecialPages
				);
		}
	}

	/**
	 * @author: Inez Korczyński
	 */
	public function parseMessage($messageName, Array $maxChildrenAtLevel = array(), $duration = 3600, $forContent = false, $filterInactiveSpecialPages = false) {

		return $this->parseHelper(self::TYPE_MESSAGE, $messageName, $maxChildrenAtLevel, $duration, $forContent, $filterInactiveSpecialPages);
	}

	public function parseVariable($variableName, Array $maxChildrenAtLevel = array(), $duration = 3600, $forContent = false, $filterInactiveSpecialPages = false) {

		return $this->parseHelper(self::TYPE_VARIABLE, $variableName, $maxChildrenAtLevel, $duration, $forContent, $filterInactiveSpecialPages);
	}

	/**
	 * Parse wikitext from given "source" - either MediaWiki message or WikiFactory variable
	 *
	 * @param string $type source type
	 * @param string $source name of message / variable to be parsed
	 * @param array $maxChildrenAtLevel allowed number of items on each menu level
	 * @param int $duration cache duration
	 * @param boolean $forContent use content language when parsing messages?
	 * @param boolean $filterInactiveSpecialPages ignore item linking to not existing special pages?
	 * @return array parsed menu wikitext
	 */
	private function parseHelper( $type, $source, Array $maxChildrenAtLevel = array(), $duration = 3600, $forContent = false, $filterInactiveSpecialPages = false ) {
		$this->wf->ProfileIn( __METHOD__ . ":$type");

		$this->forContent = $forContent;

		$cacheKey = $this->getMemcKey($source);
		$nodes = $this->wg->Memc->get($cacheKey);

		if ( !is_array( $nodes ) ) {
			$this->wf->ProfileIn( __METHOD__  . '::miss' );

			// get wikitext from given source
			switch( $type ) {
				case self::TYPE_MESSAGE:
					$text = $this->forContent ? $this->wf->MsgForContent( $source ) : $this->wf->Msg( $source );
					break;

				case self::TYPE_VARIABLE:
					// try to use "local" value
					$text = $this->app->getGlobal( $source );

					// fallback to WikiFactory value from community (city id 177)
					if ( !is_string( $text ) ) {
						$text = WikiFactory::getVarValueByName( $source, self::COMMUNITY_WIKI_ID );
					}
					break;
				default:
					$text = '';
			}

			// and parse it
			$nodes = $this->parseText( $text, $maxChildrenAtLevel, $forContent, $filterInactiveSpecialPages );
			$this->wg->Memc->set( $cacheKey, $nodes, $duration );

			$this->wf->ProfileOut( __METHOD__  . '::miss');
		}

		$this->wf->ProfileOut( __METHOD__ . "$type");
		return $nodes;
	}

	public function parseText($text, Array $maxChildrenAtLevel = array(), $forContent = false, $filterInactiveSpecialPages = false) {
		$this->wf->ProfileIn( __METHOD__ );

		$lines = explode("\n", $text);
		$this->forContent = $forContent;

		$this->errors = array();

		$nodes = $this->stripTags(
			$this->filterSpecialPages(
				$this->parseLines( $lines, $maxChildrenAtLevel ),
				$filterInactiveSpecialPages
			)
		);

		// Add hash for cache busting purposes
		if ( isset( $nodes[0] ) ) {
			$nodes[0][ self::HASH ] = md5( serialize( $nodes ) );
		}

		$this->wf->ProfileOut( __METHOD__ );
		return $nodes;
	}

	private function stripTags($nodes) {
		$this->wf->ProfileIn( __METHOD__ );

		foreach($nodes as &$node) {
			$text = !empty($node['text']) ? $node['text'] : null;
			if( !is_null( $text ) ) {
				$node['text'] = strip_tags( $text, self::ALLOWABLE_TAGS );
			}
		}

		$this->wf->ProfileOut( __METHOD__ );
		return $nodes;
	}

	private function filterSpecialPages( $nodes, $filterInactiveSpecialPages ){
		if( !$filterInactiveSpecialPages ) {
			return $nodes;
		}

		$this->wf->ProfileIn( __METHOD__ );

		// filters out every special page that is not defined
		foreach( $nodes as $key => &$node ){
			if (
				isset( $node[ self::ORIGINAL ] ) &&
				stripos( $node[ self::ORIGINAL ], 'special:' ) === 0
			) {

				list(, $specialPageName) = explode( ':', $node[ self::ORIGINAL ] );

				if ( !SpecialPageFactory::exists( $specialPageName ) ){
					$inParentKey = array_search( $key, $nodes[ $node[ self::PARENT_INDEX ] ][ self::CHILDREN ]);
					// remove from parent's child list
					unset( $nodes[ $node[ self::PARENT_INDEX ] ][ self::CHILDREN ][$inParentKey] );
					// remove node
					unset( $nodes[ $key ] );
				}
				else {
					// store special page canonical name for click tracking
					$node[ self::CANONICAL_NAME ] = $specialPageName;
				}
			}
		}

		$this->wf->ProfileOut( __METHOD__ );
		return $nodes;
	}

	/**
	 *
	 * @author: Inez Korczyński
	 */
	public function parseLines($lines, $maxChildrenAtLevel = array()) {
		$this->wf->ProfileIn( __METHOD__ );

		$nodes = array();

		if ( is_array( $lines ) && count( $lines ) > 0) {

			$parentIndex = 0;
			$lastDepth = 0;
			$i = 0;
			$lastSkip = null;

			foreach( $lines as $line ) {

				// we are interested only in lines that are not empty and start with asterisk
				if ( trim( $line ) != '' && $line{0} == '*' ) {

					$depth = strrpos( $line, '*' ) + 1;

					if ( $lastSkip !== null && $depth >= $lastSkip ) {
						continue;
					} else {
						$lastSkip = null;
					}

					if ( $depth == $lastDepth + 1 ) {
						$parentIndex = $i;
					} else if ( $depth == $lastDepth ) {
						$parentIndex = $nodes[$i][ self::PARENT_INDEX ];
					} else {
						for( $x = $i; $x >= 0; $x-- ) {
							if ( $x == 0 ) {
								$parentIndex = 0;
								break;
							}
							if ( $nodes[$x][ self::DEPTH ] <= $depth - 1 ) {
								$parentIndex = $x;
								break;
							}
						}
					}

					if ( isset( $maxChildrenAtLevel[$depth-1] ) ) {
						if ( isset( $nodes[ $parentIndex ][ self::CHILDREN ] ) ) {
							if ( count( $nodes[ $parentIndex ][ self::CHILDREN ] ) >= $maxChildrenAtLevel[$depth-1] ) {
								$lastSkip = $depth;
								continue;
							}
						}
					}

					$node = $this->parseOneLine( $line );
					$node[ self::PARENT_INDEX ] = $parentIndex;
					$node[ self::DEPTH ] = $depth;

					$ret = $this->handleExtraWords( $node, $nodes, $depth );

					if ( $ret === false ) {
						$this->errors[self::ERR_MAGIC_WORD_IN_LEVEL_1] = true;
					}
					else {
						$nodes[$node[ self::PARENT_INDEX ]][ self::CHILDREN ][] = $i + 1;
						$nodes[$i+1] = $node;
						$lastDepth = $node[ self::DEPTH ];
						$i++;
					}
				}
			}
		}

		$this->wf->ProfileOut( __METHOD__ );
		return $nodes;
	}

	/**
	 * @author: Inez Korczyński
	 */
	public function parseOneLine($line) {
		$this->wf->ProfileIn( __METHOD__ );

		// trim spaces and asterisks from line and then split it to maximum two chunks
		$lineArr = explode( '|', trim($line, '* '), 3 );

		if ( isset( $lineArr[2] ) ){
			$specialParam = trim( addslashes( $lineArr[2] ) );
			unset( $lineArr[2] );
		} else {
			$specialParam = null;
		}

		// trim [ and ] from line to have just http://www.wikia.com instrad of [http://www.wikia.com] for external links
		$lineArr[0] = trim( $lineArr[0], '[]' );

		if ( count( $lineArr ) == 2 && $lineArr[1] != '' ) {
			// * Foo|Bar - links with label
			$link = trim( $this->wf->MsgForContent( $lineArr[0] ) );
			$desc = trim( $lineArr[1] );
		} else {
			// * Foo
			$link = $desc = trim( $lineArr[0] );

			// handle __NOLINK__ magic words (BugId:15189)
			if ( substr( $link, 0, 10 ) == self::NOLINK ) {
				$link = $desc = substr($link, 10);
				$doNotLink = true;
			}
		}

		$text = $this->forContent ? $this->wf->MsgForContent( $desc ) : $this->wf->Msg( $desc );

		if ( $this->wf->EmptyMsg( $desc, $text ) ) {
			$text = $desc;
		}

		if ( $this->wf->EmptyMsg( $lineArr[0], $link ) ) {
			$link = $lineArr[0];
		}

		if ( empty( $doNotLink ) ) {
			if ( preg_match( '/^(?:' . $this->wf->UrlProtocols() . ')/', $link ) ) {
				$href = $link;
			} else {
				if ( empty( $link ) ) {
					$href = '#';
				} else if( $link{0} == '#' ) {
					$href = '#';
				} else {
					//BugId:51034 - URL-encoded article titles break inter-wiki links
					//in global Nav (but work correctly in the article body)
					$title = Title::newFromText( urldecode( $link ) );

					if ( $title instanceof Title  ) {
						$href = $title->fixSpecialName()->getLocalURL();
						$pos = strpos($link, '#');
						if ( $pos !== false ) {
							$sectionUrl = substr( $link, $pos + 1 );
							if ( $sectionUrl !== '' ) {
								$href .= '#' . $sectionUrl;
							}
						}
					} else {
						$href = '#';
					}
				}
			}
		}
		else {
			$href = '#';
		}

		$this->wf->ProfileOut( __METHOD__ );
		return array(
			self::ORIGINAL => $lineArr[0],
			self::TEXT => $text,
			self::HREF => $href,
			self::SPECIAL => $specialParam
		);
	}

	/**
	 * @author: Inez Korczyński
	 *
	 * Return false when given submenu should not be added in a given place
	 */
	private function handleExtraWords(&$node, &$nodes, $depth) {
		$this->wf->ProfileIn( __METHOD__ );

		$originalLower = strtolower( $node[ self::ORIGINAL ] );

		if ( substr( $originalLower, 0, 9 ) == '#category' ) {
			// ignore magic words in Level 1 (BugId:15240)
			if ( $depth == 1 ) {
				$this->wf->ProfileOut(__METHOD__);
				return false;
			}

			$param = trim( substr( $node[ self::ORIGINAL ], 9 ), '#' );

			if ( is_numeric( $param ) ) {
				$category = $this->getBiggestCategory( $param );
				$name = $category['name'];
			} else {
				$name = substr($param, 1);
			}

			$node[ self::HREF ] = Title::makeTitle( NS_CATEGORY, $name )->getLocalURL();

			if ( strpos( $node[ self::TEXT ], '#' ) === 0 ) {
				$node[ self::TEXT ] = str_replace( '_', ' ', $name );
			}

			$data = getMenuHelper( $name );

			foreach( $data as $val ) {
				$title = Title::newFromId($val);

				if ( is_object( $title ) ) {
					$this->addChildNode( $node, $nodes, $title->getText(), $title->getLocalUrl() );
				}
			}

		} else {
			$extraWord = trim( $originalLower, '#' );

			if ( isset( $this->extraWordsMap[$extraWord] ) ) {

				if ( $node[ self::TEXT ]{0} == '#' ) {
					$node[ self::TEXT ] = $this->wf->Msg( trim( $node[ self::ORIGINAL], ' *' ) );
				}

				$fname = $this->extraWordsMap[$extraWord];
				$data = DataProvider::$fname();
				//http://bugs.php.net/bug.php?id=46322 count(false) == 1
				if ( !empty( $data ) ) {
					// ignore magic words in Level 1 (BugId:15240)
					if ( $depth == 1 ) {
						$this->wf->ProfileOut(__METHOD__);
						return false;
					}

					foreach( $data as $val ) {
						$this->addChildNode( $node, $nodes, $val[ self::TEXT ], $val['url'] );
					}
				}
			}
		}

		$this->wf->ProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Add menu item as a child of given node
	 */
	private function addChildNode(&$node, &$nodes, $text, $url) {
		$node[ self::CHILDREN ][] = $this->lastExtraIndex;
		$nodes[$this->lastExtraIndex][ self::TEXT ] = $text;
		$nodes[$this->lastExtraIndex][ self::HREF ] = $url;
		$this->lastExtraIndex++;
	}

	/**
	 * @author: Inez Korczyński
	 */
	private function getBiggestCategory( $index ) {
		$limit = max( $index, 15 );

		if ( $limit > count( $this->biggestCategories ) ) {

			$blackList = $this->wg->BiggestCategoriesBlacklist;

			$this->biggestCategories = WikiaDataAccess::cache(
				$this->wf->MemcKey( 'biggest', $limit ),
				60 * 60 * 24 * 7,
				function() use ( $blackList, $limit ) {
					$filterWordsA = array();

					foreach( $blackList as $word) {
						$filterWordsA[] = '(cl_to not like "%'.$word.'%")';
					}

					$dbr =& wfGetDB( DB_SLAVE );
					$tables = array( "categorylinks" );
					$fields = array( "cl_to, COUNT(*) AS cnt" );
					$where = count( $filterWordsA) > 0 ? array( implode(' AND ', $filterWordsA ) ) : array();
					$options = array( "ORDER BY" => "cnt DESC", "GROUP BY" => "cl_to", "LIMIT" => $limit );

					$res = $dbr->select( $tables, $fields, $where, __METHOD__, $options );

					$ret = array();
					while ($row = $dbr->fetchObject($res)) {
						$ret[] = array( 'name' => $row->cl_to, 'count' => $row->cnt );
					}

					return $ret;
				}
			);
		}

		return isset( $this->biggestCategories[$index-1] ) ? $this->biggestCategories[$index-1] : null;
	}
}