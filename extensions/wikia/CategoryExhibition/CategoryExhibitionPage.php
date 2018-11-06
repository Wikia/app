<?php

/**
 * Custom category page showing exhibition of pages, subcategories and media in the category
 */
class CategoryExhibitionPage extends CategoryPageWithLayoutSelector {
	public function openShowCategory() {
		parent::openShowCategory();

		global $wgJsMimeType, $wgExtensionsPath;

		$context = $this->getContext();
		$output = $context->getOutput();
		$context->getTitle();
		$context->getRequest();
		$context->getUser();

		$output->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/CategoryExhibition/css/CategoryExhibition.scss' ) );
		$output->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/CategoryExhibition/js/CategoryExhibition.js\" ></script>\n" );

		$urlParams = new CategoryUrlParams( $context->getRequest(), $context->getUser() );
		$urlParams->savePreference();

		$oTmpl = new EasyTemplate( __DIR__ . '/templates/' );
		$oTmpl->set_vars(
			[
				'path' => $context->getTitle()->getFullURL(),
				'sortTypes' => $urlParams->getAllowedSortTypes(),
				'current' => $urlParams->getSortType()
			]
		);
		$formHtml = $oTmpl->render( 'form' );

		$output->addHTML( $formHtml );
	}

	public function closeShowCategory() {
		$context = $this->getContext();

		$urlParams = new CategoryUrlParams( $context->getRequest(), $context->getUser() );
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

		if ( $urlParams->getSortParam() ) {
			// One of display or sort params present in the URL.
			// We want the bots to avoid those pages and stick to the default sorting options
			$context->getOutput()->setRobotPolicy( 'noindex,nofollow' );
		} else {
			// Default sorting options, let's add pagination info for robots
			$this->addPaginationToHead( $context->getOutput(), $paginators );
		}

		// Give a proper message if category is empty
		if ( $r == '' ) {
			$r = wfMsgExt( 'category-empty', array( 'parse' ) );
		}

		$context->getOutput()->addHTML( $r );
	}

	protected function getCurrentLayout() {
		return CategoryPageWithLayoutSelector::LAYOUT_CATEGORY_EXHIBITION;
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
