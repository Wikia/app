<?php
/**
 * WikiaMobile Hooks handlers
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaMobileHooks extends WikiaObject{
	static private $mediaNsString = null;

	public function onParserBeforeStrip( &$parser, &$text, &$strip_state ) {
		$this->wf->profileIn( __METHOD__ );

		if ( empty( $this->wg->WikiaMobileDisableMediaGrouping ) && $this->app->checkSkin( 'wikiamobile', $parser->getOptions()->getSkin() ) ) {
			$matches = array();
			$translatedNs = $this->getLocalizedMediaNsString();

			//capture all the clusters (more than one consecuteive item) of wikitext media tags
			//and convert them to gallery tags (i.e. media grouping)
			if (
				!empty( $translatedNs ) &&
				preg_match_all(
					'/(?:\[\[\b(?:' . $translatedNs . ')\b:.*\]\]\s{0,2}){2,}/',
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
						'/\[\[((?:' . $translatedNs . '):.*)\]\]/',
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
									//link=url
									strpos( 'link=', $part ) === 0 ||
									//caption
									(
										( $index == ( $totalParts - 1 ) )  &&
										!preg_match( '/(?:frame|thumb|right|left|[0-9]+px)/', $part )
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

	public function onParserAfterTidy( &$parser, &$text ){
		$this->wf->profileIn( __METHOD__ );

		//cleanup page output from unwanted stuff
		if ( $this->app->checkSkin( 'wikiamobile', $parser->getOptions()->getSkin() ) ) {
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

	public function onParserLimitReport( $parser, &$limitReport ){
		$this->wf->profileIn( __METHOD__ );

		//strip out some unneeded content to lower the size of the output
		if ( $this->app->checkSkin( 'wikiamobile' ) ) {
			$limitReport = null;
		}

		$this->wf->profileOut( __METHOD__ );
		return true;
	}

	public function onMakeHeadline( $skin, $level, $attribs, $anchor, $text, $link, $legacyAnchor, $ret ){
		$this->wf->profileIn( __METHOD__ );

		if ( $this->app->checkSkin( 'wikiamobile', $skin ) ) {
			//remove bold, italics, underline and anchor tags from section headings (also optimizes output size)
			$text = preg_replace( '/<\/?(b|u|i|a|em|strong){1}(\s+[^>]*)*>/im', '', $text );

			//$link contains the section edit link, add it to the next line to put it back
			//ATM editing is not allowed in WikiaMobile
			$ret = "<h{$level} id=\"{$anchor}\"{$attribs}{$text}</h{$level}>";
		}

		$this->wf->profileOut( __METHOD__ );
		return true;
	}

	public function onLinkBegin( $skin, $target, &$text, &$customAttribs, &$query, &$options, &$ret ){
		$this->wf->profileIn( __METHOD__ );
		if ( $this->app->checkSkin( 'wikiamobile', $skin ) && in_array( 'broken', $options ) ) {
			$ret = $text;
			return false;
		}

		$this->wf->profileOut( __METHOD__ );
		return true;
	}

	public function onCategoryPageView( CategoryPage &$categoryPage ) {
		$this->wf->profileIn( __METHOD__ );

		if ( $this->app->checkSkin( 'wikiamobile' ) ) {
			//TODO: move JS for Category to be loaded only here
			//converting categoryArticle to Article to avoid circular reference in CategoryPage::view
			F::build( 'Article', array( $categoryPage->getTitle() ) )->view();

			$scripts = F::build( 'AssetsManager' ,array(), 'getInstance')->getURL( array( 'wikiamobile_categorypage_js' ) );

			$this->wg->Out->setPageTitle( $categoryPage->getTitle()->getText() . ' <span id=catTtl>' . $this->wf->MsgForContent( 'wikiamobile-categories-tagline' ) . '</span>');

			$this->wg->Out->setHTMLTitle( $categoryPage->getTitle()->getText() );

			$this->wg->Out->addHTML( $this->app->renderView( 'WikiaMobileCategoryService', 'categoryExhibition', array( 'categoryPage' => $categoryPage ) ) );
			$this->wg->Out->addHTML( $this->app->renderView( 'WikiaMobileCategoryService', 'alphabeticalList', array( 'categoryPage' => $categoryPage ) ) );

			//this is going to be additional call but at least it won't be loaded on every page
			foreach ( $scripts as $s ) {
				$this->wg->Out->addScript( '<script src=' . $s . '>' );
			}

			$this->wf->profileOut( __METHOD__ );
			return false;
		}

		$this->wf->profileOut( __METHOD__ );
		return true;
	}

	public function onArticlePurge( WikiPage &$page ) {
		$this->wf->profileIn( __METHOD__ );

		$title = $page->getTitle();

		if ( $title->getNamespace() == NS_CATEGORY ) {
			$category = F::build( 'Category', array( $title ), 'newFromTitle' );
			$model = F::build( 'WikiaMobileCategoryModel' );

			$model->purgeItemsCollectionCache( $category->getName() );
			$model->purgeExhibitionItemsCacheKey( $title->getText() );
		}

		$this->wf->profileOut( __METHOD__ );
		return true;
	}

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
