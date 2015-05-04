<?php

/**
 * CategoryHelper
 *
 * @desc CategoryHelper provides an interface for managing categories in article without editing whole article
 *
 * @author Maciej Błaszkowski (Marooned) <marooned@wikia-inc.com>
 * @author Kyle Florence <kflorence@wikia-inc.com>
 */
class CategoryHelper {
	private static $categories;
	private static $categoriesService;
	private static $data;
	private static $frame;
	private static $maybeCategory;
	private static $maybeCategoryBegin;
	private static $namespaces;
	private static $nodeLevel;
	private static $outerTag;
	private static $tagsWhiteList;

	/**
	 * Change format of categories metadata. Supports:
	 * array -> json, array -> wikitext, json -> wikitext, json -> array
	 *
	 * @param Array | String $categories list of categories in array or as JSON
	 * @param String $fromFormat the format of given categories; supported 'json', 'wikitext', 'array'
	 * @param String $toFormat the format of result
	 *
	 * @return Array | String
	 */
	public static function changeFormat( $categories, $fromFormat, $toFormat ) {
		wfProfileIn( __METHOD__ );
		$changed = null;

		if ( $fromFormat == 'json' ) {
			$categories = $categories == '' ? array() : json_decode( $categories, true );
		}

		if ( $toFormat == 'wikitext' ) {
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

					if ( !empty( $category[ 'outertag' ] ) ) {
						$str = '<' . $category[ 'outertag' ] . '>' . $str . '</' . $category[ 'outertag' ] . '>';
					}

					$changed .= $str;
				}
			}
		} else if ( $toFormat == 'array' ) {
			$changed = $categories;
		} else if ( $toFormat == 'json' ) {
			$changed = json_encode( $categories );
		}

		wfProfileOut( __METHOD__ );
		return $changed;
	}

	/**
	 * Extracts category tags from wikitext and returns a hash with an array
	 * of categories data and a modified version of the wikitext with the category
	 * tags removed.
	 *
	 * @param String $wikitext
	 * @param Boolean $force default === false to skip cache set it to true
	 *
	 * @return Array
	 */
	public static function extractCategoriesFromWikitext( $wikitext, $force = false, $lang = null ) {
		wfProfileIn( __METHOD__ );

		if ( !$force && is_array( self::$data ) ) {
			wfProfileOut( __METHOD__ );
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

		// add encoding information
		$xml = '<?xml version="1.0" encoding="UTF-8"?>' . $xml;

		//init variables
		self::$nodeLevel = 0;
		self::getDefaultNamespaces( $lang );

		// we will ignore categories added inside following list of tags (BugId:8208)
		self::$tagsWhiteList = array_keys( $app->wg->Parser->mTagHooks );

		// and includeonly tags (BugId:99450)
		self::$tagsWhiteList[] = 'includeonly';

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
			'categories' => $categories,
			'wikitext' => rtrim( $modifiedWikitext ),
		);

		wfProfileOut( __METHOD__ );

		return self::$data;
	}

	/**
	 * Gets an array of links for the given categories.
	 *
	 * @param Array $categories
	 *
	 * @return Array
	 */
	public static function getCategoryLinks( $categories ) {
		wfProfileIn( __METHOD__ );

		$app = F::app();
		$categoryLinks = array();

		if ( !empty( $categories ) ) {
			foreach( $categories as $category ) {
				$title = self::getCategoryTitle( $category );

				if ( !empty( $title ) ) {
					$text = $app->wg->ContLang->convertHtml( $title->getText() );
					$categoryLinks[] = Linker::link( $title, $text );
				}
			}
		}

		wfProfileOut( __METHOD__ );

		return $categoryLinks;
	}

	/**
	 * Gets the type of a category (either "hidden" or "normal").
	 *
	 * @param String $category
	 *
	 * @return String
	 */
	public static function getCategoryType( $category ) {
		if ( !isset( self::$categoriesService ) ) {
			self::$categoriesService = new CategoriesService();
		}

		$title = self::getCategoryTitle( $category );
		$type = 'normal';

		if ( !empty( $title ) ) {
			$text = $title->getDBKey();

			if ( self::$categoriesService->isCategoryHidden( $text ) ) {
				$type = 'hidden';
			}
		}

		return $type;
	}

	/**
	 * Gets the default namespaces for a wiki and content language.
	 * @return String
	 */
	public static function getDefaultNamespaces( $lang = null ) {
		if ( !isset( self::$namespaces ) ) {

			if ( is_null($lang) || !( $lang instanceof Language ) ) {
				$lang = F::app()->wg->ContLang;
			}

			$namespaces = $lang->getNsText( NS_CATEGORY );

			if ( strpos( $namespaces, 'Category' ) === false ) {
				$namespaces = 'Category|' . $namespaces;
			}

			self::$namespaces = $namespaces;
		}

		return self::$namespaces;
	}

	/**
	 * Extracts category tags from wikitext and returns a hash of the categories
	 * and the wikitext with categories removed. If wikitext is not provided, it will
	 * attempt to pull it from the current article.
	 *
	 * @param String $wikitext
	 * @param Boolean $force by default === false; set it to true if you want to skip cache
	 *
	 * @return Array
	 */
	public static function getExtractedCategoryData( $wikitext = '', $force = false ) {
		if ( !isset( self::$data ) ) {

			// Try to extract wikitext from the article
			if ( empty( $wikitext ) ) {
				/** @var Article $article */
				$article = F::app()->wg->Article;

				if ( isset( $article ) ) {
					$wikitext = $article->fetchContent();
				}
			}

			if ( !empty( $wikitext ) ) {
				self::$data = self::extractCategoriesFromWikitext( $wikitext, $force );
			}
		}

		return self::$data;
	}

	/**
	 * Gets the category names from an array of category arrays.
	 *
	 * @param Array $categories
	 *
	 * @return Array
	 */
	public static function getCategoryNames( $categories ) {
		$names = array();

		foreach( $categories as $category ) {
			$title = self::getCategoryTitle( $category );

			if ( !empty( $title ) ) {
				$names[] = $title->getText();
			}
		}

		return $names;
	}

	/**
	 * Gets the normalized category name from a category array.
	 *
	 * @param Array | String $category
	 *
	 * @return Title | Null
	 */
	public static function getCategoryTitle( $category ) {
		$title = null;

		// Support name from category array
		if ( is_array( $category ) && array_key_exists( 'name', $category ) ) {
			$category = $category[ 'name' ];
		}

		if ( is_string( $category ) ) {
			$title = Title::makeTitleSafe( NS_CATEGORY, $category );
		}

		return $title;
	}

	/**
	 * Gets the unique categories (keyed by name) from an array of categories.
	 * If multiple arrays are provided, they will be merged left.
	 * @return Array
	 */
	public static function getUniqueCategories( /* Array ... */ ) {
		wfProfileIn( __METHOD__ );

		$args = func_get_args();
		// Make sure no argument is unsuitable for array_merge
		$categoryArrays = [];
		foreach ( $args as $argument ) {
			$categoryArrays [] = (array)$argument;
		}

		$categories = call_user_func_array( 'array_merge', $categoryArrays );

		$categoryNames = array();
		$uniqueCategories = array();

		foreach( $categories as $category ) {
			$title = self::getCategoryTitle( $category );

			if ( !empty( $title ) ) {
				$name = $title->getText();

				if ( !in_array( $name, $categoryNames ) ) {
					$categoryNames[] = $name;
					$uniqueCategories[] = $category;
				}
			}
		}

		wfProfileOut( __METHOD__ );

		return $uniqueCategories;
	}

	/**
	 * Gets the difference between arrays of categories, returning an array
	 * of categories that aren't present in the first array of categories.
	 * @return Array
	 */
	public static function getDiffCategories( /* Array ... */ ) {
		wfProfileIn( __METHOD__ );

		$args = func_get_args();
		$base = array_shift( $args );
		$categories = call_user_func_array( 'array_merge', $args );

		$diff = array();

		$names = self::getCategoryNames( $base );

		foreach( $categories as $category ) {
			$title = self::getCategoryTitle( $category );

			if ( !empty( $title ) ) {
				$name = $title->getText();

				if ( !in_array( $name, $names ) ) {
					$diff[] = $category;
				}
			}
		}

		wfProfileOut( __METHOD__ );

		return $diff;
	}

	private static function parseNode(&$root, $outerTag = '') {
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
							$childOut['categories'][] = array(
								'name' => $catName,
								'namespace' => $catNamespace,
								'outertag' => $outerTag,
								'sortkey' => $sortKey,
								'type' => self::getCategoryType( $catName ),
							);
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

	private static function lookForCategory(&$text, $outerTag) {
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
	private static function replaceCallback($match) {
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
		self::$categories[] = array(
			'name' => $catName,
			'namespace' => $match[1],
			'outertag' => self::$outerTag,
			'sortkey' => $sortKey,
			'type' => self::getCategoryType( $catName ),
		);
		return '';
	}
}
