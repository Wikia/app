<?php

/**
 * Custom category page showing exhibition of pages, subcategories and media in the category
 */
class CategoryExhibitionPage extends CategoryPageII {
	public function closeShowCategory() {
		global $wgOut, $wgRequest, $wgUser;

		$urlParams = new CategoryUrlParams( $wgRequest, $wgUser );
		$urlParams->savePreference();

		$sections = [
			new CategoryExhibitionSectionPages( $this->mTitle, $urlParams ),
			new CategoryExhibitionSectionSubcategories( $this->mTitle, $urlParams ),
			new CategoryExhibitionSectionMedia( $this->mTitle, $urlParams ),
			new CategoryExhibitionSectionBlogs( $this->mTitle, $urlParams ),
		];

		$oTmpl = new EasyTemplate( __DIR__ . '/templates/' );

		$paginators = [];

		$r = '';
		foreach ( $sections as $section ) {
			/** @var CategoryExhibitionSection $section */
			$oTmpl->set_vars( $section->getTemplateVars() );
			$r .= $oTmpl->render( 'section-wrapper' );
			$paginators[] = $section->getPaginator();
		}

		if ( $urlParams->getDisplayParam() || $urlParams->getSortParam() ) {
			// One of display or sort params present in the URL.
			// We want the bots to avoid those pages and stick to the default sorting options
			$wgOut->setRobotPolicy( 'noindex,nofollow' );
		} else {
			// Default sorting options, let's add pagination info for robots
			$this->addPaginationToHead( $wgOut, $paginators );
		}

		// Give a proper message if category is empty
		if ( $r == '' ) {
			$r = wfMsgExt( 'category-empty', array( 'parse' ) );
		}

		$wgOut->addHTML( $r );
	}

	/**
	 * Find the paginator that offers the most pages and use it to generate
	 * <link rel="next/prev"> links and place them to <head>
	 *
	 * @param OutputPage $out
	 * @param $paginators array of Paginator and/or null objects
	 */
	private function addPaginationToHead( OutputPage $out, $paginators ) {
		$maxPages = 0;
		$maxPagesPaginator = null;

		foreach ( $paginators as $paginator ) {
			if ( $paginator && $paginator->getPagesCount() > $maxPages ) {
				$maxPages = $paginator->getPagesCount();
				$maxPagesPaginator = $paginator;
			}
		}

		if ( $maxPagesPaginator ) {
			$out->addHeadItem( 'Paginator', $maxPagesPaginator->getHeadItem() );
		}
	}
}
