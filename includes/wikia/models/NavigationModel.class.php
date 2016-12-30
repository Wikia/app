<?php

/**
 * Model for Wiki Navigation
 *
 * @author Jakub "Student" Olek
 */
class NavigationModel extends WikiaModel {
	const WIKIA_GLOBAL_VARIABLE = 'wgOasisGlobalNavigation';
	const WIKI_LOCAL_MESSAGE = 'Wiki-navigation';
	// 3 hours
	const CACHE_TTL = 10800;

	const CACHE_VERSION = '1';
	const ORIGINAL = 'original';
	const PARENT_INDEX = 'parentIndex';
	const CHILDREN = 'children';
	const DEPTH = 'depth';
	const HREF = 'href';
	const HASH = 'hash';
	const TEXT = 'text';
	const SPECIAL = 'specialAttr';
	const CANONICAL_NAME = 'canonicalName';
	const CANONICAL_ATTR = 'canonicalAttr';

	const TYPE_MESSAGE = 'message';
	const TYPE_VARIABLE = 'variable';

	const WIKIA_GLOBAL = 'global';
	const WIKI = 'wiki';

	const COMMUNITY_WIKI_ID = 177;

	// magic word used to force given menu item to not be turned into a link (BugId:15189)
	const NOLINK = '__NOLINK__';
	const ALLOWABLE_TAGS = '';

	//errors
	const ERR_MAGIC_WORD_IN_LEVEL_1 = 'Magic word at level 1';

	const LOCALNAV_LEVEL_1_ITEMS_COUNT = 4;
	const LOCALNAV_LEVEL_2_ITEMS_COUNT = 7;
	const LOCALNAV_LEVEL_3_ITEMS_COUNT = 10;

	const GLOBALNAV_LEVEL_1_ITEMS_COUNT = 7;
	const GLOBALNAV_LEVEL_2_ITEMS_COUNT = 4;
	const GLOBALNAV_LEVEL_3_ITEMS_COUNT = 4;

	const MEMC_VERSION = 2;

	private $menuNodes;

	private $biggestCategories;
	private $lastExtraIndex = 1000;
	private $extraWordsMap = [
		'voted' => 'GetTopVotedArticles',
		'popular' => 'GetMostPopularArticles',
		'visited' => 'GetMostVisitedArticles',
		'newlychanged' => 'GetNewlyChangedArticles',
		'topusers' => 'GetTopFiveUsers'
	];

	private $shouldTranslateContent = true;

	// list of errors encountered when parsing the wikitext
	private $errors = [];

	/**
	 * Return memcache key used for given message / variable
	 *
	 * @param string $messageName message / variable name
	 *
	 * @return string memcache key
	 */
	private function getMemcKey( $messageName ) {
		$messageName = str_replace( ' ', '_', $messageName );

		return wfMemcKey( __CLASS__, $this->wg->Lang->getCode(), $messageName, self::CACHE_VERSION );
	}

	public function clearMemc( $key = self::WIKIA_GLOBAL_VARIABLE ) {
		WikiaDataAccess::cachePurge(
			$this->getMemcKey( $key )
		);
	}

	private function setShouldTranslateContent( $shouldTranslateContent ) {
		$this->shouldTranslateContent = $shouldTranslateContent;
	}

	private function getShouldTranslateContent() {
		return $this->shouldTranslateContent;
	}

	/**
	 * Return list of errors encountered when parsing the wikitext
	 *
	 * @return array list of errors
	 */
	public function getErrors() {
		return $this->errors;
	}

	public function getWiki( $msgName = false, $wikiText = '' ) {
		global $wgUser, $wgOnTheWikiAsLastTab;

		$wikia = $this->parse(
			self::TYPE_VARIABLE,
			self::WIKIA_GLOBAL_VARIABLE,
			[
				1,
				$this->wg->maxLevelTwoNavElements,
				$this->wg->maxLevelThreeNavElements
			],
			self::CACHE_TTL,
			true
		);

		$this->setShouldTranslateContent( false );
		if ( !empty( $msgName ) && $msgName == self::WIKI_LOCAL_MESSAGE && !empty( $wikiText ) ) {
			$wiki = $this->parseText(
				$wikiText,
				[
					$this->wg->maxLevelOneNavElements,
					$this->wg->maxLevelTwoNavElements,
					$this->wg->maxLevelThreeNavElements
				]
			);
		} else {
			$wiki = ( $this->wg->User->isAllowed( 'read' ) ?
				// Only show menu items if user is allowed to view wiki content (BugId:44632)
				$this->parse(
					self::TYPE_MESSAGE,
					self::WIKI_LOCAL_MESSAGE,
					[
						$this->wg->maxLevelOneNavElements,
						$this->wg->maxLevelTwoNavElements,
						$this->wg->maxLevelThreeNavElements
					],
					self::CACHE_TTL
				) : [] );
		}
		$this->setShouldTranslateContent( true );

		// if user is anon 'On The Wiki' tab is displayed as last tab
		if ( $wgOnTheWikiAsLastTab && $wgUser->isAnon() ) {
			return [
				'wiki' => $wiki,
				'wikia' => $wikia
			];
		} else {
			return [
				'wikia' => $wikia,
				'wiki' => $wiki
			];
		}
	}

	public function getLocalNavigationTree( $messageName, $refreshCache = false ) {
		return $this->getTree(
			NavigationModel::TYPE_MESSAGE,
			$messageName,
			[
				self::LOCALNAV_LEVEL_1_ITEMS_COUNT,
				self::LOCALNAV_LEVEL_2_ITEMS_COUNT,
				self::LOCALNAV_LEVEL_3_ITEMS_COUNT
			],
			$refreshCache
		);
	}

	public function getOnTheWikiNavigationTree( $variableName, $refreshCache = false ) {
		return $this->getTree(
			NavigationModel::TYPE_VARIABLE,
			$variableName,
			[
				1,
				self::LOCALNAV_LEVEL_2_ITEMS_COUNT,
				self::LOCALNAV_LEVEL_3_ITEMS_COUNT
			],
			$refreshCache
		);
	}

	private function getTreeMemcKey( /* args */ ) {
		return $this->getMemcKey( implode( '-', func_get_args() + [ self::MEMC_VERSION ] ) );
	}

	/**
	 * @param string $type
	 * @param string $source
	 * @param array $maxChildrenAtLevel
	 * @param bool $refreshCache pass true to refresh the cache which stores parsed navigation tree
	 *
	 * @return Mixed|null
	 */
	public function getTree( $type, $source, Array $maxChildrenAtLevel = [], $refreshCache = false ) {
		$menuData = WikiaDataAccess::cache(
			$this->getTreeMemcKey( $type, $source, implode( $maxChildrenAtLevel, '-' ) ),
			self::CACHE_TTL,
			function () use ( $type, $source, $maxChildrenAtLevel ) {
				$menuData = [];

				$this->menuNodes = $this->parse(
					$type,
					$source,
					$maxChildrenAtLevel,
					self::CACHE_TTL
				);

				foreach ( $this->menuNodes[0][self::CHILDREN] as $id ) {
					$menuData[] = $this->recursiveConvertMenuNodeToArray( $id );
				}

				return $menuData;
			},
			( $refreshCache === true ) ? WikiaDataAccess::REFRESH_CACHE : WikiaDataAccess::USE_CACHE
		);

		return $menuData;
	}

	/*
	 * TODO we should refactor whole model when we remove Oasis
	 *
	 * This (recursive) function generates tree from menuNodes.
	 * It basically reverts part of NavigationModel parse; changes simple array
	 * structure to a nested tree of elements; contain text, href
	 * and specialAttr for given menu node and all it's children nodes.
	 * Source ticket: CON-804
	 *
	 * IMPORTANT: This function will be called 140 times as on 2014-06-27 - seven hubs,
	 * four submenus for each hub, five links in each submenu.
	 *
	 * @param $index integer of menuitem index to generate data from
	 * @return array tree of menu nodes for given index
	 */
	private function recursiveConvertMenuNodeToArray( $index ) {
		$node = $this->menuNodes[$index];
		$returnValue = [
			self::TEXT => $node[self::TEXT],
			'textEscaped' => htmlspecialchars( $node[self::TEXT], ENT_QUOTES | ENT_HTML5, 'UTF-8' ),
			self::HREF => $node[self::HREF],
		];
		if ( !empty( $node[self::SPECIAL] ) ) {
			$returnValue[self::SPECIAL] = $node[self::SPECIAL];
		}
		if ( !empty( $node[self::CANONICAL_NAME] ) ) {
			$returnValue[self::CANONICAL_NAME] = $node[self::CANONICAL_NAME];
			$returnValue[self::CANONICAL_ATTR] = 'data-canonical="' . strtolower( $node[self::CANONICAL_NAME] ) . '" ';
		} else {
			$returnValue[self::CANONICAL_ATTR] = null;
		}

		if ( isset( $node[self::CHILDREN] ) ) {
			$children = [];

			foreach ( $node[self::CHILDREN] as $childId ) {
				$children[] = $this->recursiveConvertMenuNodeToArray( $childId );
			}

			$returnValue[self::CHILDREN] = $children;
		}

		return $returnValue;
	}

	/**
	 * Parse wikitext from given "source" - either MediaWiki message or WikiFactory variable
	 *
	 * @param string $type source type
	 * @param string $source name of message / variable to be parsed
	 * @param array $maxChildrenAtLevel allowed number of items on each menu level
	 * @param int $duration cache duration
	 * @param boolean $filterInactiveSpecialPages ignore item linking to not existing special pages?
	 *
	 * @return array parsed menu wikitext
	 */
	public function parse(
		$type,
		$source,
		Array $maxChildrenAtLevel = [],
		$duration = 3600,
		$filterInactiveSpecialPages = false
	) {
		$nodes = WikiaDataAccess::cacheWithOptions(
			$this->getMemcKey( $source ),
			function () use ( $type, $source, $maxChildrenAtLevel, $filterInactiveSpecialPages ) {
				// get wikitext from given source
				switch ( $type ) {
					case self::TYPE_MESSAGE:
						$text = wfMessage( $source )->inContentLanguage()->text();
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

				return $this->parseText( $text, $maxChildrenAtLevel, $filterInactiveSpecialPages );
			},
			[
				'cacheTTL' => $duration,
				// cache ttl is set for 5 second, so if DB is down it will have some time to recover
				'negativeCacheTTL' => 5,
			]
		);

		return $nodes;
	}

	public function parseText( $text, Array $maxChildrenAtLevel = [], $filterInactiveSpecialPages = false ) {
		$lines = explode( "\n", $text );

		$this->errors = [];

		$nodes = $this->stripTags(
			$this->filterSpecialPages(
				$this->parseLines( $lines, $maxChildrenAtLevel ),
				$filterInactiveSpecialPages
			)
		);

		// Add hash for cache busting purposes
		if ( isset( $nodes[0] ) ) {
			$nodes[0][self::HASH] = md5( serialize( $nodes ) );
		}

		return $nodes;
	}

	private function stripTags( $nodes ) {
		foreach ( $nodes as &$node ) {
			$text = !empty( $node[self::TEXT] ) ? $node[self::TEXT] : null;
			if ( !is_null( $text ) ) {
				$node[self::TEXT] = strip_tags( $text, self::ALLOWABLE_TAGS );
			}
		}

		return $nodes;
	}

	private function filterSpecialPages( $nodes, $filterInactiveSpecialPages ) {
		if ( !$filterInactiveSpecialPages ) {
			return $nodes;
		}

		// filters out every special page that is not defined
		foreach ( $nodes as $key => &$node ) {
			if ( isset( $node[self::ORIGINAL] ) && stripos( $node[self::ORIGINAL], 'special:' ) === 0 ) {

				list( , $specialPageName ) = explode( ':', $node[self::ORIGINAL] );

				if ( !SpecialPageFactory::exists( $specialPageName ) ) {
					$inParentKey = array_search( $key, $nodes[$node[self::PARENT_INDEX]][self::CHILDREN] );
					// remove from parent's child list
					unset( $nodes[$node[self::PARENT_INDEX]][self::CHILDREN][$inParentKey] );
					// remove node
					unset( $nodes[$key] );
				} else {
					// store special page canonical name for click tracking
					$node[self::CANONICAL_NAME] = $specialPageName;
				}
			}
		}

		return $nodes;
	}

	/**
	 *
	 * @author: Inez Korczyński
	 */
	public function parseLines( $lines, $maxChildrenAtLevel = [] ) {
		$nodes = [];

		if ( is_array( $lines ) && count( $lines ) > 0 ) {

			$parentIndex = 0;
			$lastDepth = 0;
			$i = 0;
			$lastSkip = null;

			foreach ( $lines as $line ) {

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
						$parentIndex = $nodes[$i][self::PARENT_INDEX];
					} else {
						for ( $x = $i; $x >= 0; $x-- ) {
							if ( $x == 0 ) {
								$parentIndex = 0;
								break;
							}
							if ( $nodes[$x][self::DEPTH] <= $depth - 1 ) {
								$parentIndex = $x;
								break;
							}
						}
					}

					if ( isset( $maxChildrenAtLevel[$depth - 1] ) ) {
						if ( isset( $nodes[$parentIndex][self::CHILDREN] ) ) {
							if ( count( $nodes[$parentIndex][self::CHILDREN] ) >= $maxChildrenAtLevel[$depth - 1] ) {
								$lastSkip = $depth;
								continue;
							}
						}
					}

					$node = $this->parseOneLine( $line );
					$node[self::PARENT_INDEX] = $parentIndex;
					$node[self::DEPTH] = $depth;

					$ret = $this->handleExtraWords( $node, $nodes, $depth );

					if ( $ret === false ) {
						$this->errors[self::ERR_MAGIC_WORD_IN_LEVEL_1] = true;
					} else {
						$nodes[$node[self::PARENT_INDEX]][self::CHILDREN][] = $i + 1;
						$nodes[$i + 1] = $node;
						$lastDepth = $node[self::DEPTH];
						$i++;
					}
				}
			}
		}

		return $nodes;
	}

	/**
	 * @author: Inez Korczyński
	 */
	public function parseOneLine( $line ) {
		// trim spaces and asterisks from line and then split it to maximum two chunks
		$lineArr = explode( '|', trim( $line, '* ' ), 3 );

		if ( isset( $lineArr[2] ) ) {
			$specialParam = trim( addslashes( $lineArr[2] ) );
			unset( $lineArr[2] );
		} else {
			$specialParam = null;
		}

		// trim [ and ] from line to have just http://www.wikia.com instrad of [http://www.wikia.com] for external links
		$lineArr[0] = trim( $lineArr[0], '[]' );

		if ( count( $lineArr ) == 2 && $lineArr[1] != '' ) {
			// * Foo|Bar - links with label
			$link = trim( wfMessage( $lineArr[0] )->inContentLanguage()->text() );
			$desc = trim( $lineArr[1] );
		} else {
			// * Foo
			$link = $desc = trim( $lineArr[0] );

			// handle __NOLINK__ magic words (BugId:15189)
			if ( substr( $link, 0, 10 ) == self::NOLINK ) {
				$link = $desc = substr( $link, 10 );
				$doNotLink = true;
			}
		}

		$text = null;

		if ( $this->getShouldTranslateContent() ) {
			$text = wfMessage( $desc )->inContentLanguage()->text();
		}

		if ( empty( $text ) || wfEmptyMsg( $desc, $text ) ) {
			$text = $desc;
		}

		if ( wfEmptyMsg( $lineArr[0], $link ) ) {
			$link = $lineArr[0];
		}

		if ( empty( $doNotLink ) ) {
			if ( preg_match( '/^(?:' . wfUrlProtocols() . ')/', $link ) ) {
				$href = $link;
			} else if ( preg_match( '/^\/{1}\w+[\w\/]*/', $link ) ) {
				$href = $link;
			} else {
				if ( empty( $link ) ) {
					$href = '#';
				} else if ( $link{0} == '#' ) {
					$href = '#';
				} else {
					//BugId:51034 - URL-encoded article titles break inter-wiki links
					//in global Nav (but work correctly in the article body)
					$title = Title::newFromText( urldecode( $link ) );

					if ( $title instanceof Title ) {
						$href = $title->fixSpecialName()->getLocalURL();
						$pos = strpos( $link, '#' );
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
		} else {
			$href = '#';
		}

		return [
			self::ORIGINAL => $lineArr[0],
			self::TEXT => $text,
			self::HREF => $href,
			self::SPECIAL => $specialParam
		];
	}

	/**
	 * @author: Inez Korczyński
	 *
	 * Return false when given submenu should not be added in a given place
	 */
	private function handleExtraWords( &$node, &$nodes, $depth ) {
		$originalLower = strtolower( $node[self::ORIGINAL] );

		if ( substr( $originalLower, 0, 9 ) == '#category' ) {
			// ignore magic words in Level 1 (BugId:15240)
			if ( $depth == 1 ) {
				return false;
			}

			$param = trim( substr( $node[self::ORIGINAL], 9 ), '#' );

			if ( is_numeric( $param ) ) {
				$category = $this->getBiggestCategory( $param );
				$name = $category['name'];
			} else {
				$name = substr( $param, 1 );
			}

			//if the name is still empty abort and display it to user
			//so he/she can fix it
			//most it was something like: #category or #category_
			if ( !empty( $name ) ) {

				$node[self::HREF] = Title::makeTitle( NS_CATEGORY, $name )->getLocalURL();

				if ( strpos( $node[self::TEXT], '#' ) === 0 ) {
					$node[self::TEXT] = str_replace( '_', ' ', $name );
				}

				$data = getMenuHelper( $name );

				foreach ( $data as $val ) {
					$title = Title::newFromId( $val );

					if ( is_object( $title ) ) {
						$this->addChildNode( $node, $nodes, $title->getText(), $title->getLocalUrl() );
					}
				}
			}
		} else {
			$extraWord = trim( $originalLower, '#' );

			if ( isset( $this->extraWordsMap[$extraWord] ) ) {

				if ( $node[self::TEXT]{0} == '#' ) {
					$node[self::TEXT] = wfMsg( trim( $node[self::ORIGINAL], ' *' ) );
				}

				$fname = $this->extraWordsMap[$extraWord];
				$data = DataProvider::$fname();
				//http://bugs.php.net/bug.php?id=46322 count(false) == 1
				if ( !empty( $data ) ) {
					// ignore magic words in Level 1 (BugId:15240)
					if ( $depth == 1 ) {
						return false;
					}

					foreach ( $data as $val ) {
						$this->addChildNode( $node, $nodes, $val[self::TEXT], $val['url'] );
					}
				}
			}
		}

		return true;
	}

	/**
	 * Add menu item as a child of given node
	 */
	private function addChildNode( &$node, &$nodes, $text, $url ) {
		$node[self::CHILDREN][] = $this->lastExtraIndex;
		$nodes[$this->lastExtraIndex][self::TEXT] = $text;
		$nodes[$this->lastExtraIndex][self::HREF] = $url;
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
				wfMemcKey( 'biggest', $limit ),
				// a week
				604800,
				function () use ( $blackList, $limit ) {
					$filterWordsA = [];

					foreach ( $blackList as $word ) {
						$filterWordsA[] = '(cl_to not like "%' . $word . '%")';
					}

					$dbr =& wfGetDB( DB_SLAVE );
					$tables = [ "categorylinks" ];
					$fields = [ "cl_to, COUNT(*) AS cnt" ];
					$where = count( $filterWordsA ) > 0 ? [ implode( ' AND ', $filterWordsA ) ] : [];
					$options = [ "ORDER BY" => "cnt DESC", "GROUP BY" => "cl_to", "LIMIT" => $limit ];

					$res = $dbr->select( $tables, $fields, $where, __METHOD__, $options );

					$ret = [];
					while ( $row = $dbr->fetchObject( $res ) ) {
						$ret[] = [ 'name' => $row->cl_to, 'count' => $row->cnt ];
					}

					return $ret;
				}
			);
		}

		return isset( $this->biggestCategories[$index - 1] ) ? $this->biggestCategories[$index - 1] : null;
	}

	/**
	 * Check if given title refers to wiki nav messages
	 *
	 * @param $title Title title to check
	 *
	 * @return bool
	 */
	public static function isWikiNavMessage( Title $title ) {
		return ( $title->getNamespace() === NS_MEDIAWIKI ) && ( $title->getText() === self::WIKI_LOCAL_MESSAGE );
	}
}
