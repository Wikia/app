<?php

class NavigationService {

	const version = '0.01';
	const ORIGINAL = 'original';
	const PARENT_INDEX = 'parentIndex';
	const CHILDREN = 'children';
	const DEPTH = 'depth';
	const HREF = 'href';
	const TEXT = 'text';
	const SPECIAL = 'specialAttr';


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

	public function getMemcKey($messageName) {
		return wfMemcKey(__CLASS__, $messageName, self::version);
	}

	/**
	 * @author: Inez Korczyński
	 */
	public function parseMessage($messageName, $maxChildrenAtLevel = array(), $duration = 3600, $forContent = false, $filterInactiveSpecialPages = false ) {
		wfProfileIn( __METHOD__ );
		global $wgLang, $wgContLang, $wgMemc;

		$this->forContent = $forContent;

		$useCache = $wgLang->getCode() == $wgContLang->getCode();

		if($useCache || $this->forContent ) {
			$cacheKey = $this->getMemcKey($messageName);
			$nodes = $wgMemc->get($cacheKey);
		}

		if(empty($nodes)) {
			$text = $this->forContent ? wfMsgForContent($messageName) : wfMsg($messageName);
			$nodes = $this->parseText($text, $maxChildrenAtLevel, $filterInactiveSpecialPages);

			if($useCache || $this->forContent ) {
				$wgMemc->set($cacheKey, $nodes, $duration);
			}
		}

		wfProfileOut( __METHOD__ );
		return $nodes;
	}

	public function parseText($text, $maxChildrenAtLevel = array(), $filterInactiveSpecialPages = false) {
		$lines = explode("\n", $text);

		$nodes = $this->parseLines($lines, $maxChildrenAtLevel);
		$nodes = $this->filterSpecialPages( $nodes, $filterInactiveSpecialPages );

		return $nodes;
	}

	public function filterSpecialPages( $nodes, $filterInactiveSpecialPages ){
		wfProfileIn( __METHOD__ );
		if( !$filterInactiveSpecialPages ) {
			return $nodes;
		}

		// filters out every special page that is not defined
		foreach( $nodes as $key => $node ){
			if (
				isset( $node[ self::ORIGINAL ] ) &&
				stripos( $node[ self::ORIGINAL ], 'special:' ) === 0
			) {

				list(, $specialPageName) = explode( ':', $node[ self::ORIGINAL ] );
				if ( !SpecialPage::exists( $specialPageName ) ){
					$inParentKey = array_search( $key, $nodes[ $node[ self::PARENT_INDEX ] ][ self::CHILDREN ]);
					// remove from parent's child list
					unset( $nodes[ $node[ self::PARENT_INDEX ] ][ self::CHILDREN ][$inParentKey] );
					// remove node
					unset( $nodes[ $key ] );
				}
			}
		}
		wfProfileOut( __METHOD__ );
		return $nodes;
	}

	/**
	 *
	 * @author: Inez Korczyński
	 */
	public function parseLines($lines, $maxChildrenAtLevel = array()) {
		wfProfileIn( __METHOD__ );

		$nodes = array();

		if(is_array($lines) && count($lines) > 0) {

			$lastDepth = 0;
			$i = 0;
			$lastSkip = null;

			foreach ($lines as $line ) {

				// we are interested only in lines that are not empty and start with asterisk
				if(trim($line) != '' && $line{0} == '*') {

					$depth = strrpos($line, '*') + 1;

					if($lastSkip !== null && $depth >= $lastSkip) {
						continue;
					} else {
						$lastSkip = null;
					}

					if($depth == $lastDepth + 1) {
						$parentIndex = $i;
					} else if ($depth == $lastDepth) {
						$parentIndex = $nodes[$i][ self::PARENT_INDEX ];
					} else {
						for($x = $i; $x >= 0; $x--) {
							if($x == 0) {
								$parentIndex = 0;
								break;
							}
							if($nodes[$x][ self::DEPTH ] <= $depth - 1) {
								$parentIndex = $x;
								break;
							}
						}
					}

					if(isset($maxChildrenAtLevel[$depth-1])) {
						if(isset($nodes[$parentIndex][ self::CHILDREN ])) {
							if(count($nodes[$parentIndex][ self::CHILDREN ]) >= $maxChildrenAtLevel[$depth-1]) {
								$lastSkip = $depth;
								continue;
							}
						}
					}

					$node = $this->parseOneLine($line);
					$node[ self::PARENT_INDEX ] = $parentIndex;
					$node[ self::DEPTH ] = $depth;

					$this->handleExtraWords($node, $nodes);

					$nodes[$node[ self::PARENT_INDEX ]][ self::CHILDREN ][] = $i+1;
					$nodes[$i+1] = $node;
					$lastDepth = $node[ self::DEPTH ];
					$i++;
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return $nodes;
	}

	/**
	 * @author: Inez Korczyński
	 */
	public function parseOneLine($line) {
		wfProfileIn( __METHOD__ );

		// trim spaces and asterisks from line and then split it to maximum two chunks
		$lineArr = explode('|', trim($line, '* '), 3);

		if ( isset( $lineArr[2] ) ){
			$specialParam = trim( addslashes( $lineArr[2] ) );
			unset( $lineArr[2] );
		} else {
			$specialParam = '';
		}

		// trim [ and ] from line to have just http://www.wikia.com instrad of [http://www.wikia.com] for external links
		$lineArr[0] = trim($lineArr[0], '[]');

		if(count($lineArr) == 2 && $lineArr[1] != '') {
			$link = trim(wfMsgForContent($lineArr[0]));
			$desc = trim($lineArr[1]);
		} else {
			$link = $desc = trim($lineArr[0]);
		}

		$text = $this->forContent ? wfMsgForContent( $desc ) : wfMsg( $desc );

		if(wfEmptyMsg( $desc, $text )) {
			$text = $desc;
		}

		if(wfEmptyMsg($lineArr[0], $link)) {
			$link = $lineArr[0];
		}

		if(preg_match( '/^(?:' . wfUrlProtocols() . ')/', $link )) {
			$href = $link;
		} else {
			if(empty($link)) {
				$href = '#';
			} else if($link{0} == '#') {
				$href = '#';
			} else {
				$title = Title::newFromText($link);
				if(is_object($title)) {
					$sectionUrl = explode('#', $link);
					if (!empty($sectionUrl[1])) {
						$href = $title->fixSpecialName()->getLocalURL().'#'.$sectionUrl[1];
					}
					else {
						$href = $title->fixSpecialName()->getLocalURL();
					}
				} else {
					$href = '#';
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return array(
			self::ORIGINAL => $lineArr[0],
			self::TEXT => $text,
			self::HREF => $href,
			self::SPECIAL => $specialParam
		);
	}

	/**
	 * @author: Inez Korczyński
	 */
	private function handleExtraWords(&$node, &$nodes) {

		$originalLower = strtolower($node[ self::ORIGINAL ]);

		if(substr($originalLower, 0, 9) == '#category') {
			$param = trim(substr($node[ self::ORIGINAL ], 9), '#');

			if(is_numeric($param)) {
				$category = $this->getBiggestCategory($param);
				$name = $category['name'];
			} else {
				$name = substr($param, 1);
			}

			$node[ self::HREF ] = Title::makeTitle(NS_CATEGORY, $name)->getLocalURL();
			if(strpos($node[ self::TEXT ], '#') === 0) {
				$node[ self::TEXT ] = str_replace('_', ' ', $name);
			}

			$data = getMenuHelper($name);

			foreach($data as $key => $val) {
				$title = Title::newFromId($val);
				if(is_object($title)) {
					$node[ self::CHILDREN ][] = $this->lastExtraIndex;
					$nodes[$this->lastExtraIndex][ self::TEXT ] = $title->getText();
					$nodes[$this->lastExtraIndex][ self::HREF ] = $title->getLocalUrl();
					$this->lastExtraIndex++;
				}
			}

		} else {
			$extraWord = trim($originalLower, '#');

			if(isset($this->extraWordsMap[$extraWord])) {

				if($node[ self::TEXT ]{0} == '#') {
					$node[ self::TEXT ] = wfMsg(trim($node[ self::ORIGINAL], ' *'));
				}

				$fname = $this->extraWordsMap[$extraWord];
				$data = DataProvider::$fname();
				//http://bugs.php.net/bug.php?id=46322 count(false) == 1
				if (!empty($data)) {
					foreach($data as $val) {
						$node[ self::CHILDREN ][] = $this->lastExtraIndex;
						$nodes[$this->lastExtraIndex][ self::TEXT ] = $val[ self::TEXT ];
						$nodes[$this->lastExtraIndex][ self::HREF ] = $val['url'];
						$this->lastExtraIndex++;
					}
				}
			}
		}
	}

	/**
	 * @author: Inez Korczyński
	 */
	private function getBiggestCategory($index) {
		global $wgMemc, $wgBiggestCategoriesBlacklist;
		$limit = max($index, 15);
		if($limit > count($this->biggestCategories)) {
			$key = wfMemcKey('biggest', $limit);
			$data = $wgMemc->get($key);
			if(empty($data)) {
				$filterWordsA = array();
				foreach($wgBiggestCategoriesBlacklist as $word) {
					$filterWordsA[] = '(cl_to not like "%'.$word.'%")';
				}
				$dbr =& wfGetDB( DB_SLAVE );
				$tables = array("categorylinks");
				$fields = array("cl_to, COUNT(*) AS cnt");
				$where = count($filterWordsA) > 0 ? array(implode(' AND ', $filterWordsA)) : array();
				$options = array("ORDER BY" => "cnt DESC", "GROUP BY" => "cl_to", "LIMIT" => $limit);
				$res = $dbr->select($tables, $fields, $where, __METHOD__, $options);
				$categories = array();
				while ($row = $dbr->fetchObject($res)) {
					$this->biggestCategories[] = array('name' => $row->cl_to, 'count' => $row->cnt);
				}
				$wgMemc->set($key, $this->biggestCategories, 60 * 60 * 24 * 7);
			} else {
				$this->biggestCategories = $data;
			}
		}
		return isset($this->biggestCategories[$index-1]) ? $this->biggestCategories[$index-1] : null;
	}
}
