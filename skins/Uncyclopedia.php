<?php
/**
 * MonoBook nouveau
 *
 * Translated from gwicke's previous TAL template version to remove
 * dependency on PHPTAL.
 *
 * @todo document
 * @file
 * @ingroup Skins
 */

if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

/**
 * Inherit main code from MonoBookTemplate, set the CSS and custom template elements.
 * @todo document
 * @ingroup Skins
 */

require_once("skins/MonoBook.php");

class SkinUncyclopedia extends SkinMonoBook {
	/**
	 * Using monobook.
	 *
	 * @param OutputPage $out
	 */
	function initPage( OutputPage $out ) {
		parent::initPage( $out );
		$this->skinname  = 'uncyclopedia';
		$this->stylename = 'uncyclopedia';
		$this->template  = MonoBookTemplate::class;

		// turn off ads
		$this->ads = false;
	}

	function setupSkinUserCss( OutputPage $out ) {
		// Append to the default screen common & print styles...
		WikiaSkinMonobook::setupSkinUserCss( $out );

		$out->addStyle( 'uncyclopedia/main.css', 'screen' );

		$out->addStyle( 'uncyclopedia/IE50Fixes.css', 'screen', 'lt IE 5.5000' );
		$out->addStyle( 'uncyclopedia/IE55Fixes.css', 'screen', 'IE 5.5000' );
		$out->addStyle( 'uncyclopedia/IE60Fixes.css', 'screen', 'IE 6' );
		$out->addStyle( 'uncyclopedia/IE70Fixes.css', 'screen', 'IE 7' );

		$out->addStyle( 'uncyclopedia/rtl.css', 'screen', '', 'rtl' );
	}


	function wikiaBox() {
		// no-op - do not display FANDOM portlet
	}

	public function addWikiaCss(&$out) {
		return true;
	}
}
