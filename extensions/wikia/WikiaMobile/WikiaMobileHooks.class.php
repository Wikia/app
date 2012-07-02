<?php
/**
 * WikiaMobile Hooks handlers
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaMobileHooks extends WikiaObject{
	const IMAGE_GROUP_MIN = 2;

	public function onParserAfterTidy( &$parser, &$text ){
		$this->wf->profileIn( __METHOD__ );

		//cleanup page output from unwanted stuff
		if ( $this->app->checkSkin( 'wikiamobile', $parser->getOptions()->getSkin() ) ) {
			//remove inline styling to avoid weird results and optimize the output size
			$text = preg_replace( '/\s+(style|color|bgcolor|border|align|cellspacing|cellpadding|hspace|vspace)=(\'|")[^"\']*(\'|")/im', '', $text );

			//transform groups of IMAGE_GROUP_MIN images in a row into a media stack
			$text = preg_replace( '/(\s*<figure[^>]*>(<\/?a|<img|<\/?figcaption|[^<])+<\/figure>\s*){' . self::IMAGE_GROUP_MIN . ',}/im', '<section class="wkImgStk grp thumb">$0<footer class=thumbcaption>' . $this->wf->Msg('wikiaPhotoGallery-slideshow-view-number', '1', '') . '</footer></section>', $text );
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
			$ret = "<h{$level} id=\"{$anchor}\"{$attribs}{$text}";

			if ( $level == 2 ) {
				//add chevron to expand the section
				$ret .= '<span class=chev></span>';
			}

			$ret .= "</h{$level}>";
		}

		$this->wf->profileOut( __METHOD__ );
		return true;
	}

	public function onLinkBegin( $skin, $target, &$text, &$customAttribs, &$query, &$options, &$ret ){
		if ( $this->app->checkSkin( 'wikiamobile', $skin ) && in_array( 'broken', $options ) ) {
			$ret = $text;
			return false;
		}

		return true;
	}

	public function onCategoryPageView( CategoryPage &$categoryPage ) {
		$this->wf->profileIn( __METHOD__ );

		if ( $this->app->checkSkin( 'wikiamobile' ) ) {
			//TODO: move JS for Category to be loaded only here
			//converting categoryArticle to Article to avoid circular reference in CategoryPage::view
			F::build( 'Article', array( $categoryPage->getTitle() ) )->view();

			$scripts = F::build( 'AssetsManager' ,array(), 'getInstance')->getURL( array( 'categorypage_wikiamobile_js' ) );

			$this->wg->Out->setPageTitle( $categoryPage->getTitle()->getText() . ' <span id=catTtl>Category Page</span>');

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
}
