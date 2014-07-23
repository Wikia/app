<?php
/**
 * Special handling for category description pages
 * Modelled after ImagePage.php
 *
 */

if( !defined( 'MEDIAWIKI' ) )
	die( 1 );

/**
 */
class CategoryPageII extends CategoryPage {

	/**
	 * @param Title $title
	 */
	public function __construct( Title $title ) {
		parent::__construct( $title );

		// VOLDEV-16: Load CategoryTree extension if enabled and we're in list mode
		if ( !( $this instanceof CategoryExhibitionPage ) &&
			F::app()->wg->EnableCategoryTreeExt
		) {
			$this->mCategoryViewerClass = 'CategoryTreeCategoryViewer';
		}
	}

	function openShowCategory() {
		$out = $this->getContext()->getOutput();
		$title = $this->getContext()->getTitle();

		$out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/CategoryExhibition/css/CategoryExhibition.scss' ) );
		$out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/CategoryExhibition/css/CategoryExhibition.IE.scss' ), '', 'lte IE 8' );

		$out->addScript( Html::linkedScript( AssetsManager::getInstance()->getOneCommonURL( 'extensions/wikia/CategoryExhibition/js/CategoryExhibition.js' ) ) );

		$categoryExhibitionSection = new CategoryExhibitionSection( $title );
		$categoryExhibitionSection->setSortTypeFromParam();
		$categoryExhibitionSection->setDisplayTypeFromParam();

		$oTmpl = new EasyTemplate( __DIR__ . '/templates/' );
		$oTmpl->set_vars(
			array(
				'path' => $title->getFullURL(),
				'current' => $categoryExhibitionSection->getSortType(),
				'sortTypes' => $categoryExhibitionSection->getSortTypes(),
				'displayType' => $categoryExhibitionSection->getDisplayType(),
			)
		);

		$out->addHTML( $oTmpl->render( "form" ) );
	}
}
