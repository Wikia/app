<?php
/**
 * WikiaMobile Hooks handlers
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 *
 */
class WikiaMobileHooks extends WikiaObject{
	/**
	 * @var null
	 */
	static private $mediaNsString = null;
	/**
	 * @var bool
	 */
	static private $displayErrorPage = false;

	/**
	 * @param $parser Parser
	 * @param $text String
	 * @param $strip_state
	 * @return bool
	 */
	public function onParserBeforeStrip( &$parser, &$text, &$strip_state ) {
		$this->wf->profileIn( __METHOD__ );

		if ( empty( $this->wg->WikiaMobileDisableMediaGrouping ) && $this->app->checkSkin( 'wikiamobile' ) ) {
			$matches = array();
			$translatedNs = $this->getLocalizedMediaNsString();

			//capture all the clusters (more than one consecuteive item) of wikitext media tags
			//and convert them to gallery tags (i.e. media grouping)
			if (
				!empty( $translatedNs ) &&
				preg_match_all(
					'/(?:\[\[\b(?:' . $translatedNs . ')\b:[^\]]+\]\](\s)*){2,}/',
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
						'/\[\[((?:' . $translatedNs . '):.*)\]\]/U',
						$match[0],
						$submatches,
						PREG_SET_ORDER
					);

					if ( $itemsCount > 0 ) {
						$result = "<gallery>\n";

						//analyze entries
						foreach ( $submatches as $item ) {
							$parts = explode( '|', $item[1] );
							$components = array();
							$totalParts = count( $parts );

							foreach ( $parts as $index => $part ) {
								if (
									//File:name
									$index == 0 ||
									!empty( $part ) && (
										//link=url
										strpos( 'link=', $part ) === 0  ||
										//caption
										(
											( $index == ( $totalParts - 1 ) )  &&
											!preg_match( '/(?:frame|thumb|right|left|[0-9]+px)/', $part )
										)
									)
								) {
									$components[] = $part;
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

		$this->wf->profileOut( __METHOD__ );
		return true;
	}

	/**
	 * @param $parser Parser
	 * @param $text String
	 * @return bool
	 */
	public function onParserAfterTidy( &$parser, &$text ){
		$this->wf->profileIn( __METHOD__ );

		//cleanup page output from unwanted stuff
		if ( $this->app->checkSkin( 'wikiamobile' ) ) {
			//remove inline styling to avoid weird results and optimize the output size
			$text = preg_replace(
				'/\s+(style|color|bgcolor|border|align|cellspacing|cellpadding|hspace|vspace)=(\'|")[^"\']*(\'|")/im',
				'',
				$text
			);
		}

		$this->wf->profileOut( __METHOD__ );
		return true;
	}

	/**
	 * @param $parser Parser
	 * @param $limitReport
	 * @return bool
	 */
	public function onParserLimitReport( $parser, &$limitReport ){
		$this->wf->profileIn( __METHOD__ );

		//strip out some unneeded content to lower the size of the output
		if ( $this->app->checkSkin( 'wikiamobile' ) ) {
			$limitReport = null;
		}

		$this->wf->profileOut( __METHOD__ );
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
	public function onMakeHeadline( $skin, $level, $attribs, $anchor, $text, $link, $legacyAnchor, &$ret ){
		$this->wf->profileIn( __METHOD__ );

		if ( $this->app->checkSkin( 'wikiamobile', $skin ) ) {
			//remove bold, italics, underline and anchor tags from section headings (also optimizes output size)
			$text = preg_replace( '/<\/?(b|u|i|a|em|strong){1}(\s+[^>]*)*>/im', '', $text );

			//$link contains the section edit link, add it to the next line to put it back
			//ATM editing is not allowed in WikiaMobile
			$ret = "<h{$level} id=\"{$anchor}\" {$attribs}{$text}</h{$level}>";
		}

		$this->wf->profileOut( __METHOD__ );
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
	public function onLinkBegin( $skin, $target, &$text, &$customAttribs, &$query, &$options, &$ret ){
		$this->wf->profileIn( __METHOD__ );
		if ( $this->app->checkSkin( 'wikiamobile', $skin ) && in_array( 'broken', $options ) ) {
			$ret = $text;
			return false;
		}

		$this->wf->profileOut( __METHOD__ );
		return true;
	}

	/**
	 * @param CategoryPage $categoryPage
	 * @return bool
	 */

	public function onCategoryPageView( CategoryPage &$categoryPage ) {
		$this->wf->profileIn( __METHOD__ );

		if ( $this->app->checkSkin( 'wikiamobile' ) ) {
			//lets do some local caching
			$out = $this->wg->Out;
			$title = $categoryPage->getTitle();
			$text = $title->getText();

			//converting categoryArticle to Article to avoid circular reference in CategoryPage::view
			F::build( 'Article', array( $title ) )->view();

			//add scripts that belongs only to category pages
			$scripts = F::build( 'AssetsManager', array(), 'getInstance' )->getURL( array( 'wikiamobile_categorypage_js' ) );

			//this is going to be additional call but at least it won't be loaded on every page
			foreach ( $scripts as $s ) {
				$out->addScript( '<script src="' . $s . '"></script>' );
			}

			//set proper titles for a page
			$out->setPageTitle( $text . ' <span id=catTtl>' . $this->wf->MsgForContent( 'wikiamobile-categories-tagline' ) . '</span>');
			$out->setHTMLTitle( $text );

			//render lists: exhibition and alphabetical
			$params = array( 'categoryPage' => $categoryPage );
			$out->addHTML( $this->app->renderView( 'WikiaMobileCategoryService', 'categoryExhibition', $params ) );
			$out->addHTML( $this->app->renderView( 'WikiaMobileCategoryService', 'alphabeticalList', $params ) );

			$this->wf->profileOut( __METHOD__ );
			return false;
		}

		$this->wf->profileOut( __METHOD__ );
		return true;
	}

	/**
	 * @param WikiPage $page
	 * @return bool
	 */
	public function onArticlePurge( WikiPage &$page ) {
		$this->wf->profileIn( __METHOD__ );

		$title = $page->getTitle();

		if ( $title->getNamespace() == NS_CATEGORY ) {
			$category = F::build( 'Category', array( $title ), 'newFromTitle' );

			/**
			 * @var $model WikiaMobileCategoryModel
			 */
			$model = F::build( 'WikiaMobileCategoryModel' );

			$model->purgeItemsCollectionCache( $category->getName() );
			$model->purgeExhibitionItemsCacheKey( $title->getText() );
		}

		$this->wf->profileOut( __METHOD__ );
		return true;
	}

	/**
	 * @param $article Article
	 *
	 * @return bool
	 */
	public function onBeforeDisplayNoArticleText( $article ){
		$this->wf->profileIn( __METHOD__ );

		if( $this->app->checkSkin( 'wikiamobile' )  ) {
			$title = $article->getTitle();

			if( $title->getNamespace() == NS_USER ) {
				//if user exists and it is not subpage display masthead
				//otherwise show 404 page
				$user = User::newFromName( $title->getBaseText() );

				if ( ( $user instanceof User && $user->getId() > 0) && !$title->isSubpage() ) {
					$this->wf->profileOut( __METHOD__ );
					return true;
				}
			}

			self::$displayErrorPage = true;
		}

		$this->wf->profileOut( __METHOD__ );
		return true;
	}

	/**
	 * Used to display 404 page whenever $displayErrorPage flag is set to true by onBeforeDisplayNoArticleText hook
	 *
	 * @param $out OutputPage
	 * @param $skin Skin
	 * @return bool
	 */
	public function onBeforePageDisplay( &$out, &$skin ){
		$this->wf->profileIn( __METHOD__ );

		if( $this->app->checkSkin( 'wikiamobile', $skin ) && self::$displayErrorPage ) {
			$out->clearHTML();

			$out->addHTML( $this->app->renderView( 'WikiaMobileErrorService', 'pageNotFound', array( 'out' => &$out) ) );

			$this->wf->profileOut( __METHOD__ );
			return false;
		}

		$this->wf->profileOut( __METHOD__ );
		return true;
	}

	/**
	 * @return null
	 */
	private function getLocalizedMediaNsString() {
		$this->wf->profileIn( __METHOD__ );

		if ( self::$mediaNsString === null ) {
			$translatedNs = array();

			//get all the possible variations of the File namespace
			//and the translation in the wiki's language
			foreach ( array( NS_FILE, NS_IMAGE, NS_VIDEO ) as $ns ) {
				$translatedNs[] = $this->wg->ContLang->getNsText( $ns );

				foreach( $this->wg->NamespaceAliases as $alias => $nsAlias ) {
					if( $nsAlias == $ns ) {
						$translatedNs[] = $alias;
					}
				}
			}

			self::$mediaNsString = implode( '|', array_unique( $translatedNs ) );
		}

		$this->wf->profileOut( __METHOD__ );
		return self::$mediaNsString;
	}
}
