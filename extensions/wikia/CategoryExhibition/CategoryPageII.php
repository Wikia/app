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

	var $viewerClass = 'CategoryPageIIViewer';
	
	function addScripts(){
		global $wgOut, $wgRequest, $wgExtensionsPath, $wgScriptPath, $wgStyleVersion, $wgJsMimeType;
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/CategoryExhibition/js/CategoryExhibition.js?{$wgStyleVersion}\" ></script>\n");
	}

	function openShowCategory() {
		global $wgOut, $wgRequest, $wgExtensionsPath, $wgScriptPath, $wgStyleVersion, $wgJsMimeType;
		$wgOut->addStyle( wfGetSassUrl( 'extensions/wikia/CategoryExhibition/css/CategoryExhibition.scss' ) );
		$wgOut->addStyle( wfGetSassUrl( 'extensions/wikia/CategoryExhibition/css/CategoryExhibition.IE.scss' ), '', 'lte IE 8' );
		$this->addScripts();
		wfLoadExtensionMessages( 'CategoryPageII' );
		$viewer = new $this->viewerClass( $this->mTitle );
		$wgOut->addHTML( $viewer->getFormHTML() );
	}
}


class CategoryPageIIViewer {

	function getFormHTML() {
		global $wgTitle, $wgRequest;

		$categoryExhibitionSection = new CategoryExhibitionSection( $wgTitle );
		$categoryExhibitionSection->setSortTypeFromParam();
		$categoryExhibitionSection->setDisplayTypeFromParam();
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars(
			array(
				'path' => $wgTitle->getFullURL(),
				'current' => $categoryExhibitionSection->getSortType(),
				'sortTypes' => $categoryExhibitionSection->getSortTypes(),
				'displayType' => $categoryExhibitionSection->getDisplayType(),
			)
		);
		return $oTmpl->execute( "form" );
	}
}
