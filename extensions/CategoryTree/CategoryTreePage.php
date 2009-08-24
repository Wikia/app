<?php
/**
 * Special page for the  CategoryTree extension, an AJAX based gadget
 * to display the category structure of a wiki
 *
 * @addtogroup Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2006 Daniel Kinzler
 * @license GNU General Public Licence 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is part of an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

class CategoryTreePage extends SpecialPage {

	var $target = '';
	var $tree = NULL;

	/**
	 * Constructor
	 */
	function __construct() {
		global $wgOut;
		SpecialPage::SpecialPage( 'CategoryTree', '', true );
		wfLoadExtensionMessages( 'CategoryTree' );
	}

	function getOption( $name ) {
		global $wgCategoryTreeDefaultOptions;

		if ( $this->tree ) return $this->tree->getOption( $name );
		else return $wgCategoryTreeDefaultOptions[$name];
	}

	/**
	 * Main execution function
	 * @param $par Parameters passed to the page
	 */
	function execute( $par ) {
		global $wgRequest, $wgOut, $wgCategoryTreeDefaultOptions, $wgCategoryTreeSpecialPageOptions, $wgCategoryTreeForceHeaders;

		$this->setHeaders();

		if ( $par ) $this->target = $par;
		else $this->target = $wgRequest->getVal( 'target', wfMsg( 'rootcategory') );

		$this->target = trim( $this->target );

		#HACK for undefined root category
		if ( $this->target == '<rootcategory>' || $this->target == '&lt;rootcategory&gt;' ) $this->target = NULL;

		$options = array();

		# grab all known options from the request. Normalization is done by the CategoryTree class
		foreach ( $wgCategoryTreeDefaultOptions as $option => $default ) {
			if ( isset( $wgCategoryTreeSpecialPageOptions[$option] ) )
				$default = $wgCategoryTreeSpecialPageOptions[$option];

			$options[$option] = $wgRequest->getVal( $option, $default );
		}

		$this->tree = new CategoryTree( $options );

		$wgOut->addWikiMsg( 'categorytree-header' );

		$this->executeInputForm();

		if( $this->target !== '' && $this->target !== NULL ) {
			if ( !$wgCategoryTreeForceHeaders ) CategoryTree::setHeaders( $wgOut );

			$title = CategoryTree::makeTitle( $this->target );

			if ( $title && $title->getArticleID() ) {
				$wgOut->addHTML( Xml::openElement( 'div', array( 'class' => 'CategoryTreeParents' ) ) );
				$wgOut->addHTML( wfMsgExt( 'categorytree-parents', 'parseinline' ) );
				$wgOut->addHTML( wfMsg( 'colon-separator' ) );

				$parents = $this->tree->renderParents( $title );

				if ( $parents == '' ) {
					$wgOut->addHTML( wfMsgExt( 'categorytree-no-parent-categories', 'parseinline' ) );
				} else {
					$wgOut->addHTML( $parents );
				}

				$wgOut->addHTML( Xml::closeElement( 'div' ) );

				$wgOut->addHTML( Xml::openElement( 'div', array( 'class' => 'CategoryTreeResult' ) ) );
				$wgOut->addHTML( $this->tree->renderNode( $title, 1 ) );
				$wgOut->addHTML( Xml::closeElement( 'div' ) );
			}
			else {
				$wgOut->addHTML( Xml::openElement( 'div', array( 'class' => 'CategoryTreeNotice' ) ) );
				$wgOut->addHTML( wfMsgExt( 'categorytree-not-found', 'parseinline' , $this->target ) );
				$wgOut->addHTML( Xml::closeElement( 'div' ) );
			}
		}

	}

	/**
	 * Input form for entering a category
	 */
	function executeInputForm() {
		global $wgScript, $wgOut;
		$thisTitle = Title::makeTitle( NS_SPECIAL, $this->getName() );
		$mode = $this->getOption('mode');

		$wgOut->addHTML( Xml::openElement( 'form', array( 'name' => 'categorytree', 'method' => 'get', 'action' => $wgScript, 'id' => 'mw-categorytree-form' ) ) );
		$wgOut->addHTML( Xml::openElement( 'fieldset' ) );
		$wgOut->addHTML( Xml::element( 'legend', null, wfMsgNoTrans( 'categorytree-legend' ) ) );
		$wgOut->addHTML( Xml::hidden( 'title', $thisTitle->getPrefixedDbKey() ) );
		$wgOut->addHTML( Xml::inputLabel( wfMsgNoTrans( 'categorytree-category' ), 'target', 'target', 20, $this->target ) . ' ' );
		$wgOut->addHTML( Xml::openElement( 'select', array( 'name' => 'mode' ) ) );
		$wgOut->addHTML( Xml::option( wfMsgNoTrans( 'categorytree-mode-categories' ), 'categories', $mode == CT_MODE_CATEGORIES ? true : false ) );
		$wgOut->addHTML( Xml::option( wfMsgNoTrans( 'categorytree-mode-pages' ), 'pages', $mode == CT_MODE_PAGES ? true : false ) );
		$wgOut->addHTML( Xml::option( wfMsgNoTrans( 'categorytree-mode-all' ), 'all', $mode == CT_MODE_ALL ? true : false ) );
		$wgOut->addHTML( Xml::closeElement( 'select' ) . ' ' );
		$wgOut->addHTML( Xml::submitButton( wfMsgNoTrans( 'categorytree-go' ), array( 'name' => 'dotree' ) ) );
		$wgOut->addHTML( Xml::closeElement( 'fieldset' ) );
		$wgOut->addHTML( Xml::closeElement( 'form' ) );
	}
}
