<?php

class NavigationService {

	const version = '0.01';

	private $biggestCategories;

	private $lastExtraIndex = 1000;

	private $extraWordsMap = array(	'voted' => 'GetTopVotedArticles',
									'popular' => 'GetMostPopularArticles',
									'visited' => 'GetMostVisitedArticles',
									'newlychanged' => 'GetNewlyChangedArticles',
									'topusers' => 'GetTopFiveUsers');

	private $forContent = false;

	/**
	 * @author: Inez Korczyński
	 */
	public function parseMessage($messageName, $maxChildrenAtLevel = array(), $duration, $forContent = false ) {
		wfProfileIn( __METHOD__ );

		global $wgLang, $wgContLang, $wgMemc;

		$this->forContent = $forContent;

		$useCache = $wgLang->getCode() == $wgContLang->getCode();

		if($useCache || $this->forContent ) {
			$cacheKey = wfMemcKey($messageName, self::version);
			$nodes = $wgMemc->get($cacheKey);
		}

		if(empty($nodes)) {
			if ( $this->forContent ) {
				$lines = explode("\n", wfMsgForContent($messageName));
			} else {
				$lines = explode("\n", wfMsg($messageName));
			}
			$nodes = $this->parseLines($lines, $maxChildrenAtLevel);

			if($useCache || $this->forContent ) {
				$wgMemc->set($cacheKey, $nodes, $duration);
			}
		}

		wfProfileOut( __METHOD__ );
		return $nodes;
	}

	/**
	 * @author: Inez Korczyński
	 */
	private function parseLines($lines, $maxChildrenAtLevel = array()) {
		wfProfileIn( __METHOD__ );

		$nodes = array();

		if(is_array($lines) && count($lines) > 0) {

			$lastDepth = 0;
			$i = 0;
			$lastSkip = null;

			foreach($lines as $line) {

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
						$parentIndex = $nodes[$i]['parentIndex'];
					} else {
						for($x = $i; $x >= 0; $x--) {
							if($x == 0) {
								$parentIndex = 0;
								break;
							}
							if($nodes[$x]['depth'] <= $depth - 1) {
								$parentIndex = $x;
								break;
							}
						}
					}

					if(isset($maxChildrenAtLevel[$depth-1])) {
						if(isset($nodes[$parentIndex]['children'])) {
							if(count($nodes[$parentIndex]['children']) >= $maxChildrenAtLevel[$depth-1]) {
								$lastSkip = $depth;
								continue;
							}
						}
					}

					$node = $this->parseOneLine($line);
					$node['parentIndex'] = $parentIndex;
					$node['depth'] = $depth;

					$this->handleExtraWords($node, $nodes);

					$nodes[$node['parentIndex']]['children'][] = $i+1;
					$nodes[$i+1] = $node;
					$lastDepth = $node['depth'];
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
	private function parseOneLine($line) {
		wfProfileIn( __METHOD__ );

		// trim spaces and asterisks from line and then split it to maximum two chunks
		$lineArr = explode('|', trim($line, '* '), 2);

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
					$href = $title->fixSpecialName()->getLocalURL();
				} else {
					$href = '#';
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return array(
			'original' => $lineArr[0],
			'text' => $text,
			'href' => $href
		);
	}

	/**
	 * @author: Inez Korczyński
	 */
	private function handleExtraWords(&$node, &$nodes) {

		$originalLower = strtolower($node['original']);

		if(substr($originalLower, 0, 9) == '#category') {
			$param = trim(substr($node['original'], 9), '#');

			if(is_numeric($param)) {
				$category = $this->getBiggestCategory($param);
				$name = $category['name'];
			} else {
				$name = substr($param, 1);
			}

			$node['href'] = Title::makeTitle(NS_CATEGORY, $name)->getLocalURL();
			if(strpos($node['text'], '#') === 0) {
				$node['text'] = str_replace('_', ' ', $name);
			}

			$data = getMenuHelper($name);

			foreach($data as $key => $val) {
				$title = Title::newFromId($val);
				if(is_object($title)) {
					$node['children'][] = $this->lastExtraIndex;
					$nodes[$this->lastExtraIndex]['text'] = $title->getText();
					$nodes[$this->lastExtraIndex]['href'] = $title->getLocalUrl();
					$this->lastExtraIndex++;
				}
			}

		} else {
			$extraWord = trim($originalLower, '#');

			if(isset($this->extraWordsMap[$extraWord])) {

				if($node['text']{0} == '#') {
					$node['text'] = wfMsg(trim($node['original'], ' *'));
				}

				$fname = $this->extraWordsMap[$extraWord];
				$data = DataProvider::$fname();

				if(count($data) > 0) {
					$node['children'] = array();
					foreach($data as $val) {
						$node['children'][] = $this->lastExtraIndex;
						$nodes[$this->lastExtraIndex]['text'] = $val['text'];
						$nodes[$this->lastExtraIndex]['href'] = $val['url'];
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
