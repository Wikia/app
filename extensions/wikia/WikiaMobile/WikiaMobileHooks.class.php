<?php
/**
 * WikiaMobile Hooks handlers
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 *
 */
class WikiaMobileHooks {
	/**
	 * @var null
	 */
	static private $mediaNsString = null;

	/**
	 * @param $parser Parser
	 * @param $text String
	 * @param $strip_state
	 * @return bool
	 */
	static public function onParserBeforeStrip( &$parser, &$text, &$strip_state ) {
		global $wgWikiaMobileDisableMediaGrouping;
		wfProfileIn( __METHOD__ );

		if ( empty( $wgWikiaMobileDisableMediaGrouping ) && F::app()->checkSkin( 'wikiamobile' ) ) {
			$matches = array();
			$translatedNs = self::getLocalizedMediaNsString();

			//capture all the clusters (more than one consecuteive item) of wikitext media tags
			//and convert them to gallery tags (i.e. media grouping)
			if (
				!empty( $translatedNs ) &&
				preg_match_all(
				/*
				 * This regex is to catch situations like these
				 * [[Image:name.jpg]]
				 * [[Image:name.jpg]]
				 * and also images with links in captions
				 * [[Image:name.jpg|[[Link]] caption]]
				 * [[Image:name.jpg|[[Link]] caption [[Link|link]]]]
				 */
					'/(?:\[\[\b(?:' . $translatedNs . ')\b:[^\]\[]*(?:\[\[[^\[]*\]\][^\[]*)*\]\]\s*){2,}/',
					$text,
					$matches,
					PREG_OFFSET_CAPTURE
				)
			) {
				$count = count( $matches[0] );

				//replacing substrings, you gotta start from the bottom ;)
				//to keep char offsets valid
				for ( $x = $count - 1; $x >= 0; $x-- ) {
					$match = $matches[0][$x];

					$submatches = array();

					$itemsCount = preg_match_all(
						'/(?<=\[\[' . $translatedNs . '):([^\]\[]*(?:\[\[[^\[]*\]\][^\[]*)*(?=\]\])\s*?)/',
						$match[0],
						$submatches,
						PREG_SET_ORDER
					);

					if ( $itemsCount > 0 ) {
						$result = "<gallery>\n";

						//analyze entries
						foreach ( $submatches as $item ) {
							$parts = explode( '|', $item[1] );
							$components = [];

							foreach ( $parts as $index => $part ) {
								//File name
								if ( $index == 0 ) {
									$components[] = $part;
									continue;
								}

								if ( !empty( $part ) ) {
									//Link part
									if ( strpos( 'link=', $part ) === 0 ) {
										$components[] = $part;
										continue;
									}

									//All parts of caption as this might be exploded ie.:
									//[[File:aa.jpg|thumb|300px|caption with [[Link|LINK]] right?]]
									if ( !preg_match( '/(?:frame|thumb|right|left|\d+\s?px)/', $part ) ) {
										$components[] = htmlspecialchars( $part );
									}

								}
							}

							$result .= implode( '|', $components ) . "\n";
						}

						//IMPORTANT: keep a new line at the end of the string to preserve
						//the wikitext that comes next
						$result .= "</gallery>\n";

						$text = substr_replace(
							$text,
							$result,
							$match[1],
							strlen( $match[0] )
						);
					}
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @param $parser Parser
	 * @param $text String
	 * @return bool
	 */
	static public function onParserAfterTidy( &$parser, &$text ){
		wfProfileIn( __METHOD__ );

		//cleanup page output from unwanted stuff
		if ( F::app()->checkSkin( 'wikiamobile' ) ) {
			//remove inline styling to avoid weird results and optimize the output size
			$text = preg_replace(
				'/\s+(style|color|bgcolor|border|align|cellspacing|cellpadding|hspace|vspace)=(\'|")[^"\']*(\'|")/im',
				'',
				$text
			);
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @param $parser Parser
	 * @param $limitReport
	 * @return bool
	 */
	static public function onParserLimitReport( $parser, &$limitReport ){
		wfProfileIn( __METHOD__ );

		//strip out some unneeded content to lower the size of the output
		if ( F::app()->checkSkin( 'wikiamobile' ) ) {
			$limitReport = null;
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @param $skin Skin
	 * @param $level
	 * @param $attribs
	 * @param $anchor
	 * @param $text
	 * @param $link
	 * @param $legacyAnchor
	 * @param $ret
	 * @return bool
	 */
	static public function onMakeHeadline( $skin, $level, $attribs, $anchor, $text, $link, $legacyAnchor, &$ret ){
		global $wgArticleAsJson;
		wfProfileIn( __METHOD__ );

		if ( F::app()->checkSkin( 'wikiamobile', $skin ) ) {
			//retrieve section index from mw:editsection tag
			preg_match( '#section="(.*?)"#', $link, $matches );
			if ( $wgArticleAsJson || F::app()->wg->User->isAnon() ) {
				$link = '';
			}
			//remove bold, italics, underline and anchor tags from section headings (also optimizes output size)
			$text = preg_replace( '/<\/?(b|u|i|a|em|strong){1}(\s+[^>]*)*>/im', '', $text );
			$ret = "<h{$level} id='{$anchor}' section='{$matches[1]}' {$attribs}{$text}{$link}</h{$level}>";
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @param $skin Skin
	 * @param $title Title
	 * @param $section Integer
	 * @param $tooltip
	 * @param $result
	 * @param bool $lang
	 */
	public static function onDoEditSectionLink( $skin, $nt, $section, $tooltip, &$result, $lang ) {
		if ( F::app()->checkSkin( 'wikiamobile', $skin ) ) {
			$link = F::app()->wg->Title->getLocalURL( [
				'section' => $section,
				'action' => 'edit'
			] );

			$result = "<a href='$link' class='editsection'></a>";

			return false;
		}

		return true;
	}

	/**
	 * @param $skin
	 * @param $target
	 * @param $text
	 * @param $customAttribs
	 * @param $query
	 * @param $options
	 * @param $ret
	 * @return bool
	 */
	static public function onLinkBegin( $skin, $target, &$text, &$customAttribs, &$query, &$options, &$ret ){
		wfProfileIn( __METHOD__ );
		if ( in_array( 'broken', $options ) && F::app()->checkSkin( 'wikiamobile', $skin ) ) {
			$ret = $text;
			wfProfileOut( __METHOD__ );
			return false;
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @param CategoryPage $categoryPage
	 * @return bool
	 */

	static public function onCategoryPageView( CategoryPage &$categoryPage ) {
		wfProfileIn( __METHOD__ );

		$app = F::app();

		if ( $app->checkSkin( 'wikiamobile' ) ) {
			//lets do some local caching
			$out = $app->wg->Out;
			$title = $categoryPage->getTitle();
			$text = $title->getText();

			//converting categoryArticle to Article to avoid circular reference in CategoryPage::view
			( new Article( $title ) )->view();

			//add scripts that belongs only to category pages
			$scripts = AssetsManager::getInstance()->getURL( array( 'wikiamobile_categorypage_js' ) );

			//this is going to be additional call but at least it won't be loaded on every page
			foreach ( $scripts as $s ) {
				$out->addScript( '<script src="' . $s . '"></script>' );
			}

			//set proper titles for a page
			$out->setPageTitle( $text );
			$out->setHTMLTitle( $text );

			//render lists: exhibition and alphabetical
			$params = array( 'categoryPage' => $categoryPage );
			$out->addHTML( $app->renderView( 'WikiaMobileCategoryService', 'categoryExhibition', $params ) );
			$out->addHTML( $app->renderView( 'WikiaMobileCategoryService', 'alphabeticalList', $params ) );

			wfProfileOut( __METHOD__ );
			return false;
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @param WikiPage $page
	 * @return bool
	 */
	static public function onArticlePurge( WikiPage &$page ) {
		wfProfileIn( __METHOD__ );

		$title = $page->getTitle();

		if ( $title->getNamespace() == NS_CATEGORY ) {
			$category = Category::newFromTitle( $title );

			$model = new WikiaMobileCategoryModel();

			$model->purgeItemsCollectionCache( $category->getName() );
			$model->purgeExhibitionItemsCacheKey( $title->getText() );
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @param $article Article
	 *
	 * @return bool
	 */
	static public function onBeforeDisplayNoArticleText( $article ){
		wfProfileIn( __METHOD__ );

		if ( F::app()->checkSkin( 'wikiamobile' )  ) {
			$title = $article->getTitle();
			$ns = $title->getNamespace();

			if ( $ns == NS_USER ) {
				//if user exists and it is not subpage display masthead
				//otherwise show 404 page
				$user = User::newFromName( $title->getBaseText() );

				if ( ( $user instanceof User && $user->getId() > 0 ) && !$title->isSubpage() ) {
					wfProfileOut( __METHOD__ );
					return true;
				}
			} else if ( $ns == NS_CATEGORY ) {
				//if it is a category that has some pages display it as well
				$category = Category::newFromTitle( $title );

				if ( $category instanceof Category && ( $category->getPageCount() + $category->getSubcatCount() + $category->getFileCount() ) > 0 ) {
					wfProfileOut( __METHOD__ );
					return true;
				}
			//Do not show error on non-blank help pages (including shared help)
			} else if ( $ns == NS_HELP && ( $title->isKnown() ||
					is_callable('SharedHelpArticleExists') && SharedHelpArticleExists( $title ) ) ) {
				wfProfileOut( __METHOD__ );
				return true;
			}

			WikiaMobileErrorService::$displayErrorPage = true;
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Used to display 404 page whenever $displayErrorPage flag is set to true by onBeforeDisplayNoArticleText hook
	 *
	 * @param $out OutputPage
	 * @param $skin Skin
	 * @return bool
	 */
	static public function onBeforePageDisplay( &$out, &$skin ){
		wfProfileIn( __METHOD__ );
		$app = F::app();

		if( $app->checkSkin( 'wikiamobile', $skin ) && WikiaMobileErrorService::$displayErrorPage == true ) {
			$out->clearHTML();

			$out->addHTML( $app->renderView( 'WikiaMobileErrorService', 'pageNotFound', array( 'out' => &$out) ) );

			wfProfileOut( __METHOD__ );
			return false;
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @return null
	 */
	static private function getLocalizedMediaNsString() {
		global $wgContLang, $wgNamespaceAliases;
		wfProfileIn( __METHOD__ );

		if ( self::$mediaNsString === null ) {
			$translatedNs = array();

			//get all the possible variations of the File namespace
			//and the translation in the wiki's language
			$translatedNs[] = $wgContLang->getNsText( NS_FILE );

			foreach ( $wgNamespaceAliases as $alias => $nsAlias ) {
				if ( $nsAlias == NS_FILE ) {
					$translatedNs[] = $alias;
				}
			}

			self::$mediaNsString = implode( '|', array_unique( $translatedNs ) );
		}

		wfProfileOut( __METHOD__ );
		return self::$mediaNsString;
	}
}
