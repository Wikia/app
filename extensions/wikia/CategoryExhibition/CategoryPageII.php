<?php

/**
 * Standard category page decorated with the form in the top which you can use to switch
 * the view type to exhibition. Also the base for the CategoryExhibitionPage (which adds
 * closeShowCategory method)
 */
class CategoryPageII extends CategoryPage {
	public function openShowCategory() {
		global $wgOut, $wgExtensionsPath, $wgJsMimeType, $wgTitle, $wgRequest, $wgUser;

		$wgOut->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/CategoryExhibition/css/CategoryExhibition.scss' ) );
		$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/CategoryExhibition/js/CategoryExhibition.js\" ></script>\n" );

		$urlParams = new CategoryUrlParams( $wgRequest, $wgUser );
		$urlParams->savePreference();

		$oTmpl = new EasyTemplate( __DIR__ . '/templates/' );
		$oTmpl->set_vars(
			[
				'path' => $wgTitle->getFullURL(),
				'sortTypes' => $urlParams->getAllowedSortOptions(),
				'current' => $urlParams->getSortType(),
				'displayType' => $urlParams->getDisplayType(),
			]
		);
		$formHtml = $oTmpl->render( 'form' );

		$wgOut->addHTML( $formHtml );
	}
}
