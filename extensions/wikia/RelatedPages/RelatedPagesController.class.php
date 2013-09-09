<?php

class RelatedPagesController extends WikiaController {

	const MEMC_KEY = 'mRelatedPages';

	public function init() {
		$this->addAfterSection = null;
		$this->pages = array();
		$this->skipRendering = false;
	}

	public function index( $params = null ) {
		global $wgTitle, $wgContentNamespaces, $wgRequest, $wgMemc;

		$altTitle = $this->request->getVal('altTitle', null);
		$title = empty($altTitle) ? $wgTitle : $altTitle;
		$articleId = $title->getArticleId();
		$relatedPages = RelatedPages::getInstance();
		$categories = $this->request->getVal( 'categories' );

		if ( !is_null( $categories ) ) {
			$relatedPages->setCategories( $categories );
		}

		// Determine if we need to care about the current namespace or not
		if ( !empty($params["anyNS"]) ) {
			$ignoreNS = false;
		} else {
			$ignoreNS = !empty( $wgTitle ) && !in_array( $wgTitle->getNamespace(), $wgContentNamespaces );
		}

		$this->skipRendering =
			// check for mainpage
			Wikia::isMainPage() ||
			// check for content namespaces
			$ignoreNS ||
			// check if we have any categories
			count( $relatedPages->getCategories( $title ) ) == 0 ||
			// check action
			$wgRequest->getVal('action', 'view') != 'view' ||
			// skip, if module was already rendered
			$relatedPages->isRendered();

		if ( $this->skipRendering ) {
			return false;
		}

		$mKey = wfMemcKey(self::MEMC_KEY, $articleId );
		$this->srcAttrName = $this->app->checkSkin( 'monobook' ) ? 'src' : 'data-src';

		if ( empty($this->pages) ) {
			$this->pages = $relatedPages->get( $articleId );
				if ( count( $this->pages ) > 0) {
				$wgMemc->set( $mKey, $this->pages, 3 * 3600 );
			} else {
				$this->skipRendering = true;
			}
		}

		$isMobileSkin = $this->app->checkSkin( 'wikiamobile' );
		// data for mustache template
		$this->data = [ 'mobileSkin' => $isMobileSkin ];

		if( !$isMobileSkin ) {
			$this->response->addAsset( 'relatedpages_js' );
		}

		$this->response->setTemplateEngine(WikiaResponse::TEMPLATE_ENGINE_MUSTACHE);
	}

	static function onWikiaMobileAssetsPackages( &$jsStaticPackages, &$jsExtensionPackages, &$scssPackages) {
		$jsStaticPackages[] = 'relatedpages_js';
		//css is in WikiaMobile.scss as AM can't concatanate scss files currently

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
		$mKey = wfMemcKey(self::MEMC_KEY, $article->mTitle->getArticleId());
		$wgMemc->delete($mKey);
		return true;
	}
}
