<?php

class RelatedPagesModule extends Module {

	public $pages = null;
	public $skipRendering = false;

	public function executeIndex() {
		global $wgOut, $wgTitle, $wgArticle, $wgContentNamespaces, $wgRequest, $wgMemc;

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

		/* (tmp disabled) check action
		if( $wgRequest->getVal('action', 'view') != 'view' ) {
			$this->skipRendering = true;
		}
		*/

		// skip, if module was already rendered
		if( $relatedPages->isRendered() ) {
			$this->skipRendering = true;
		}

		if( !$this->skipRendering ) {
			wfLoadExtensionMessages( 'RelatedPages' );

			$mKey = wfMemcKey('mOasisRelatedPages', $wgTitle->getArticleId());
			$this->pages = $wgMemc->get($mKey);
			if (empty($this->pages)) {
				$this->pages = $relatedPages->get( $wgTitle->getArticleId() );
				$wgMemc->set($mKey, $this->pages);
			}
		}
		else {
			$this->pages = array();
		}

	}

	static function onArticleSaveComplete(&$article, &$user, $text, $summary,
		$minoredit, &$watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId) {
		global $wgMemc;
		$mKey = wfMemcKey('mOasisRelatedPages', $article->mTitle->getArticleId());
		$wgMemc->delete($mKey);
		return true;
	}
}