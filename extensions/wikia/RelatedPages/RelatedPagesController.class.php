<?php

class RelatedPagesController extends WikiaController {

	public function init() {
		$this->addAfterSection = null;
		$this->pages = array();
		$this->skipRendering = false;
	}

	public function executeIndex() {
		global $wgTitle, $wgContentNamespaces, $wgRequest, $wgMemc, $wgRelatedPagesAddAfterSection;

		$articleid = $wgTitle->getArticleId();

		$relatedPages = RelatedPages::getInstance();

		$categories = $this->request->getVal( 'categories' );

		if ( !is_null( $categories ) ) {
			$relatedPages->setCategories( $categories );
		}

		$this->skipRendering =
			// check for mainpage
			Wikia::isMainPage() ||
			// check for content namespaces
			!empty( $wgTitle ) && !in_array( $wgTitle->getNamespace(), $wgContentNamespaces ) ||
			// check if we have any categories
			count( $relatedPages->getCategories( $articleid ) ) == 0 ||
			// check action
			$wgRequest->getVal('action', 'view') != 'view' ||
			// skip, if module was already rendered
			$relatedPages->isRendered();

		if ( !$this->skipRendering ) {
			$mKey = wfMemcKey('mOasisRelatedPages', $articleid );
			//$this->pages = $wgMemc->get($mKey);
			$this->srcAttrName = $this->app->checkSkin( 'monobook' ) ? 'src' : 'data-src';

			if ( empty($this->pages) ) {
				$this->pages = $relatedPages->get( $articleid );

				if ( count( $this->pages ) > 0) {
					$wgMemc->set( $mKey, $this->pages, 3 * 3600 );
				} else {
					$this->skipRendering = true;
				}
			}

			// RT #84264
			if ( !empty( $wgRelatedPagesAddAfterSection ) && is_numeric( $wgRelatedPagesAddAfterSection ) ) {
				$this->addAfterSection = intval($wgRelatedPagesAddAfterSection);
			}
		}
		
		if ( $this->app->checkSkin( 'wikiamobile' ) ) {
			$this->overrideTemplate( 'WikiaMobileIndex' );
		}
	}

	static function onWikiaMobileAssetsPackages(&$jsHead, &$jsBody, &$scss) {
		$jsBody[] = 'wikiamobile_relatedpages_js';
		$scss[] = 'wikiamobile_relatedpages_scss';

		return true;
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
