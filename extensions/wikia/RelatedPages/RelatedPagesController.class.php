<?php

class RelatedPagesController extends WikiaController {

	public function init() {
		$this->addAfterSection = null;
		$this->pages = array();
		$this->skipRendering = false;
	}

	public function executeIndex() {
		global $wgTitle, $wgContentNamespaces, $wgRequest, $wgMemc, $wgRelatedPagesAddAfterSection;

		$relatedPages = RelatedPages::getInstance();

		$categories = $this->request->getVal( 'categories' );

		if( !is_null( $categories ) ) {
			$relatedPages->setCategories( $categories );
		}

		// check for mainpage
		if( Wikia::isMainPage() ) {
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
		if( $wgRequest->getVal('action', 'view') != 'view' ) {
			$this->skipRendering = true;
		}

		// skip, if module was already rendered
		if( $relatedPages->isRendered() ) {
			$this->skipRendering = true;
		}

		if( !$this->skipRendering ) {
			$mKey = wfMemcKey('mOasisRelatedPages', $wgTitle->getArticleId());
			$this->pages = $wgMemc->get($mKey);
			$this->srcAttrName = $this->app->checkSkin( 'monobook' ) ? 'src' : 'data-src';
			if( empty($this->pages) ) {
				$this->pages = $relatedPages->get( $wgTitle->getArticleId() );
				if(count($this->pages) > 0) {
					$wgMemc->set($mKey, $this->pages, 3 * 3600);
				}
				else {
					$this->skipRendering = true;
				}
			}

			// RT #84264
			if (!empty($wgRelatedPagesAddAfterSection) && is_numeric($wgRelatedPagesAddAfterSection)) {
				$this->addAfterSection = intval($wgRelatedPagesAddAfterSection);
			}
		}
		
		if ( $this->app->checkSkin( 'wikiamobile' ) ) {
			$this->overrideTemplate( 'WikiaMobileIndex' );
		}
	}

	/**
	 * @param $article Article
	 * @param $user User
	 * @param $text
	 * @param $summary
	 * @param $minoredit
	 * @param $watchthis
	 * @param $sectionanchor
	 * @param $flags
	 * @param $revision
	 * @param $status
	 * @param $baseRevId
	 * @return bool
	 */
	static function onArticleSaveComplete(&$article, &$user, $text, $summary,
		$minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId) {
		global $wgMemc;
		$mKey = wfMemcKey('mOasisRelatedPages', $article->mTitle->getArticleId());
		$wgMemc->delete($mKey);
		return true;
	}
}
