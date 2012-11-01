<?php

/**
 * CategorySelect
 *
 * A CategorySelect extension for MediaWiki
 * Provides an interface for managing categories in article without editing whole article
 *
 * @author Maciej Błaszkowski (Marooned) <marooned@wikia-inc.com>
 * @author Kyle Florence <kflorence@wikia-inc.com>
 */

class CategorySelect {
	private static $categories;
	private static $data;
	private static $frame;
	private static $maybeCategory;
	private static $maybeCategoryBegin;
	private static $namespaces;
	private static $nodeLevel;
	private static $outerTag;
	private static $tagsWhiteList;

	public static function getData( $wikitext = '', $force = false ) {
		wfProfileIn( __METHOD__ );

		if ( !$force && is_array( self::$data ) ) {
			return self::$data;
		}

		$app = F::app();

		// enable changes in Preprocessor and Parser
		$app->wg->CategorySelectEnabled = true;

		// prepare Parser
		$app->wg->Parser->startExternalParse( $app->wg->Title, new ParserOptions, OT_WIKI );

		// get DOM tree [PPNode_DOM class] as an XML string
		$xml = $app->wg->Parser->preprocessToDom( $wikitext )->__toString();

		// disable changes in Preprocessor and Parser
		$app->wg->CategorySelectEnabled = false;

		// add ecnoding information
		$xml = '<?xml version="1.0" encoding="UTF-8"?>' . $xml;

		//init variables
		self::$nodeLevel = 0;
		self::getDefaultNamespaces();

		// we will ignore categories added inside following list of tags (BugId:8208)
		self::$tagsWhiteList = array_keys( $app->wg->Parser->mTagHooks );

		//create XML DOM document from provided XML
		$dom = new DOMDocument();
		$dom->loadXML( $xml );

		//get everything under main node
		$root = $dom->getElementsByTagName( 'root' )->item( 0 );

		self::$frame = $app->wg->Parser->getPreprocessor()->newFrame();

		$categories = self::parseNode( $root );

		// make wikitext from DOM tree
		$modifiedWikitext = self::$frame->expand( $root, PPFrame::NO_TEMPLATES | PPFrame::RECOVER_COMMENTS );

		// replace markers back to wikitext
		$modifiedWikitext = $app->wg->Parser->mStripState->unstripBoth( $modifiedWikitext );

		self::$data = array(
			'wikitext' => rtrim( $modifiedWikitext ),
			'categories' => $categories
		);

		wfProfileOut( __METHOD__ );

		return self::$data;
	}

	public function getDefaultNamespaces() {
		if ( !empty( self::$namespaces ) ) {
			return self::$namespaces;
		}

		$namespaces = F::app()->wg->ContLang->getNsText( NS_CATEGORY );

		if ( strpos( $namespaces, 'Category' ) === false ) {
			$namespaces = 'Category|' . $namespaces;
		}

		self::$namespaces = $namespaces;

		return $namespaces;
	}

	/**
	 * Change format of categories metadata. Supports:
	 * array -> json, array -> wikitext, json -> wikitext, json -> array
	 */
	public function changeFormat( $categories, $from, $to ) {
		if ( $from == 'json' ) {
			$categories = $categories == '' ? array() : json_decode( $categories, true );
		}

		if ( $to == 'wikitext' ) {
			$changed = '';
			if ( !empty( $categories ) && is_array( $categories ) ) {
				foreach( $categories as $category ) {
					if ( empty( $category ) ) {
						continue;
					}

					$str = "\n[[" . $category[ 'namespace' ] . ':' . $category[ 'name' ];

					if ( !empty( $category[ 'sortkey' ] ) ) {
						$str .= '|' . $category[ 'sortkey' ];
					}

					$str .= ']]';

					if ( !empty( $category[ 'outerTag' ] ) ) {
						$str = '<' . $category[ 'outerTag' ] . '>' . $str . '</' . $category[ 'outerTag' ] . '>';
					}

					$changed .= $str;
				}
			}

		} else if ( $to == 'array' ) {
			$changed = $categories;

		} else if ( $to == 'json' ) {
			$changed = json_encode( $categories );
		}

		return $changed;
	}

	static private function parseNode(&$root, $outerTag = '') {
		self::$nodeLevel++;

		$out = array();
		if ($root->hasChildNodes()) {
			$nodes = &$root->childNodes;
			$nodesToDelete = array();	//iterating through the childNodes array and removing those children will stop the iteration
			foreach ($nodes as $node) {
				switch ($node->nodeType) {
					case XML_ELEMENT_NODE:
						switch ($node->nodeName) {
							case 'template':
								break;
							case 'ext':
								$tmpOuterTag = $node->getElementsByTagName('name')->item(0)->textContent;
								if (in_array($tmpOuterTag, self::$tagsWhiteList)) {
									continue;
								}
								$inner = $node->getElementsByTagName('inner')->item(0);
								if (!is_null($inner)) {
									$childOut = self::parseNode($inner, $tmpOuterTag);
									if (count($childOut)) {
										$out = array_merge($out, $childOut);
										//remove tags when there is no content after removing category
										if (trim($inner->textContent) == '') {
											$nodesToDelete[] = $node;
											//try to remove newline right after <tag>[[category:abc]]</tag>\n - it will be in next sibbling
											if (!is_null($node->nextSibling) && $node->nextSibling->nodeType == XML_TEXT_NODE) {
												$node->nextSibling->nodeValue = preg_replace('/^\n/', '', $node->nextSibling->nodeValue);
											}
										}
									}
								}
								break;
						}
						break;
					case XML_TEXT_NODE:
						$text = $node->textContent;
						$childOut = self::lookForCategory($text, $outerTag);
						$node->nodeValue = $text;
						if (isset(self::$maybeCategory[0]['end'])) {
							$processedCategory = array_shift(self::$maybeCategory);
							$newNode = $newCategory = '';
							for ($i = $processedCategory['beginSibblingsBefore']; $i > 0; $i--) {
								$previous = $node->previousSibling;
								//remove ending of the category from the last node
								if ($i == $processedCategory['beginSibblingsBefore']) {
									$newCategory = $processedCategory['end'];
									$newNode = $node->textContent;
								}

								//remove begining of the category from the first node
								if ($i == 1) {
									$previous->nodeValue = str_replace($processedCategory['begin'], '', $previous->nodeValue);
									$newCategory = $processedCategory['begin'] . $newCategory;
									$newNode = $previous->textContent . $newNode;
								}

								$nodeContent = $previous->textContent;
								if ($previous->nodeType == XML_ELEMENT_NODE) {
									switch ($previous->nodeName) {
										case 'template':
											$nodeContent = self::$frame->expand($previous, PPFrame::NO_TEMPLATES );
											break;
										case 'ext':
											$tmpTagName = $previous->getElementsByTagName('name')->item(0)->textContent;
											$tmpTagInner = $previous->getElementsByTagName('inner')->item(0)->textContent;
											$nodeContent = "<$tmpTagName>$tmpTagInner</$tmpTagName>";
											break;
									}
								}
								//concatenate every nodes between 'begin' and 'end' of category
								if ($i != 1) {
									$newCategory = $nodeContent . $newCategory;
								}
								$root->removeChild($previous);
							}

							//extract category name and sort key for categories with weird syntax (eg. with templates)
							$newCategory = trim($newCategory, '[]');
							preg_match('/^(' . self::$namespaces . '):/i', $newCategory, $m);
							$catNamespace = $m[1];
							$newCategory = preg_replace('/^(?:' . self::$namespaces . '):/i', '', $newCategory);
							$len = strlen($newCategory);
							$pipePos = 0;
							$curly = $square = 0;
							for ($i = 0; $i < $len && !$pipePos; $i++) {
								switch ($newCategory[$i]) {
									case '{':
										$curly++;
										break;
									case '}':
										$curly--;
										break;
									case '[':
										$square++;
										break;
									case ']':
										$square--;
										break;
									case '|':
										if ($curly == 0 && $square == 0) {
											$pipePos = $i;
									}
								}
							}
							if ($pipePos) {
								$catName = substr($newCategory, 0, $pipePos);
								$sortKey = substr($newCategory, $pipePos + 1);
							} else {
								$catName = $newCategory;
								$sortKey = '';
							}

							$childOut['text'] = $newNode;
							$childOut['categories'][] = array('namespace' => $catNamespace, 'name' => $catName, 'outerTag' => $outerTag, 'sortkey' => $sortKey);
						}
						if (count($childOut['categories'])) {
							$out = array_merge($out, $childOut['categories']);
							$node->nodeValue = $childOut['text'];
						}
						break;
				}
				self::$maybeCategoryBegin[self::$nodeLevel] = isset(self::$maybeCategoryBegin[self::$nodeLevel]) ? self::$maybeCategoryBegin[self::$nodeLevel] + 1 : 1;
			}

			//delete marked nodes - one can't do it in foreach loop
			foreach ($nodesToDelete as $node) {
				$node->parentNode->removeChild($node);
			}

		}
		self::$nodeLevel--;
		return $out;
	}

	static private function lookForCategory(&$text, $outerTag) {
		self::$categories = array();
		self::$outerTag = $outerTag;
		$text = preg_replace_callback('/\[\[(' . self::$namespaces . '):([^]]+)]]\n?/i', array('self', 'replaceCallback'), $text);
		$result = array('text' => $text, 'categories' => self::$categories);

		$maybeIndex = count(self::$maybeCategory);
		if ($maybeIndex) {
			//look for category ending
			//TODO: this will not catch [[Category:Abc<noinclude>]]</noinclude>
			if (self::$nodeLevel == self::$maybeCategory[$maybeIndex-1]['level'] && preg_match('/^([^[]*?]])/', $text, $match)) {
				$text = preg_replace('/^[^[]*?]]/', '', $text, 1);
				self::$maybeCategory[$maybeIndex-1]['end'] = $match[1];
				self::$maybeCategory[$maybeIndex-1]['beginSibblingsBefore'] = self::$maybeCategoryBegin[self::$nodeLevel];
			}
		}
		if (preg_match('/(\[\[(?:' . self::$namespaces . '):.*$)/i', $text, $match)) {
			self::$maybeCategory[$maybeIndex] = array('namespace' => $match[1], 'begin' => $match[1], 'level' => self::$nodeLevel);
			self::$maybeCategoryBegin[self::$nodeLevel] = 0;
		}
		return $result;
	}

	//used in lookForCategory() as a callback function for preg_replace_callback()
	static private function replaceCallback($match) {
		if (strpos($match[2], '[') !== false || strpos($match[2], ']') !== false) {
			return $match[0];
		}
		$pipePos = strpos($match[2], '|');
		if ($pipePos) {
			$catName = substr($match[2], 0, $pipePos);
			$sortKey = substr($match[2], $pipePos + 1);
		} else {
			$catName = $match[2];
			$sortKey = '';
		}
		self::$categories[] = array('namespace' => $match[1], 'name' => $catName, 'outerTag' => self::$outerTag, 'sortkey' => $sortKey);
		return '';
	}
}