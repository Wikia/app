<?php

class RelatedPagesModule extends Module {

	public $pages = null;
	public $skipRendering = false;

	public function executeIndex() {
		global $wgOut, $wgTitle, $wgArticle, $wgContentNamespaces, $wgRequest;

		$relatedPages = RelatedPages::getInstance();

		// add CSS for this module
		$wgOut->addStyle(wfGetSassUrl("extensions/wikia/RelatedPages/RelatedPages.scss"));

		// check for mainpage
		$isMain = ( ( $wgTitle->getArticleId() == Title::newMainPage()->getArticleId() ) && ( $wgTitle->getArticleId() != 0 ) );
		if( !$isMain ) {
			if( !empty($wgArticle->mRedirectedFrom) ) {
				$main = wfMsgForContent( 'mainpage' );
				if( $main == $wgArticle->mRedirectedFrom->getPrefixedText() ) {
					$isMain = true;
				}
			}
		}

		if( $isMain ) {
			$this->skipRendering = true;
		}

		// check for content namespaces
		if( !empty($wgTitle) && !in_array($wgTitle->getNamespace(), $wgContentNamespaces) ) {
				$this->skipRendering = true;
		}

		// check if we have any categories
		if( count( $relatedPages->getCategories() ) == 0 ) {
			$this->skipRendering = true;
		}

		// check action
		if($wgRequest->getVal('action', 'view') != 'view') {
			$this->skipRendering = true;
		}

		if( !$this->skipRendering ) {
			wfLoadExtensionMessages( 'RelatedPages' );

			$this->pages = $relatedPages->get( $wgTitle->getArticleId() );
		}
		else {
			$this->pages = array();
		}

	}

}