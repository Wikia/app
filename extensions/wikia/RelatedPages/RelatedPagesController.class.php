<?php
class RelatedPagesController extends WikiaController {
	const MEMC_KEY_VER = '1.005';

	/**
	 * @desc Related pages are lazy-loaded on article pages for mobile, oasis and monobook. However, there are extensions
	 * dependent on this method where related pages module isn't lazy-loaded such as: FilePage (FilePageController.class.php)
	 */
	public function section() {
		global $wgTitle, $wgContentNamespaces, $wgRequest, $wgMemc;

		// request params
		$altTitle = $this->request->getVal( 'altTitle', null );
		$relatedPages = RelatedPages::getInstance();
		$anyNs = $this->request->getVal( 'anyNS', false );

		$title = empty( $altTitle ) ? $wgTitle : $altTitle;
		$articleid = $title->getArticleId();

		if( !$anyNs ) {
			$ignoreNS = !empty( $wgTitle ) && in_array( $wgTitle->getNamespace(), $wgContentNamespaces );
		} else {
			$ignoreNS = false;
		}

		$this->skipRendering =
			// check for mainpage
			Wikia::isMainPage() ||
			// check for content namespaces
			$ignoreNS ||
			// check if we have any categories
			count( $relatedPages->getCategories( $articleid ) ) == 0 ||
			// check action
			$wgRequest->getVal('action', 'view') != 'view' ||
			// skip, if module was already rendered
			$relatedPages->isRendered();

		if ( !$this->skipRendering ) {
			$mKey = wfMemcKey( 'mOasisRelatedPages', $articleid, self::MEMC_KEY_VER );
			$this->pages = $wgMemc->get( $mKey );
			$this->srcAttrName = $this->app->checkSkin( 'monobook' ) ? 'src' : 'data-src';

			if ( empty( $this->pages ) ) {
				$this->pages = $relatedPages->get( $articleid );

				if ( count( $this->pages ) > 0) {
					$wgMemc->set( $mKey, $this->pages, 3 * 3600 );
				} else {
					$this->skipRendering = true;
				}
			}
		}

		$this->mobileSkin = false;
		$this->relatedPagesHeading = wfMessage( 'wikiarelatedpages-heading' )->plain();
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}
}
