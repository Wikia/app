<?php
/**
 * Special page for the  CategoryTree extension, an AJAX based gadget
 * to display the category structure of a wiki
 *
 * @file
 * @ingroup Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2006 Daniel Kinzler
 * @license GNU General Public Licence 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is part of an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

class CategoryTreePage extends SpecialPage {
	var $target = '';
	var $tree = null;

	function __construct() {
		parent::__construct( 'CategoryTree', '', true );
	}

	/**
	 * @param $name
	 * @return mixed
	 */
	function getOption( $name ) {
		global $wgCategoryTreeDefaultOptions;

		if ( $this->tree ) {
			return $this->tree->getOption( $name );
		} else {
			return $wgCategoryTreeDefaultOptions[$name];
		}
	}

	/**
	 * Main execution function
	 * @param $par array Parameters passed to the page
	 */
	function execute( $par ) {
		global $wgCategoryTreeDefaultOptions, $wgCategoryTreeSpecialPageOptions, $wgCategoryTreeForceHeaders;

		$this->setHeaders();
		$request = $this->getRequest();
		if ( $par ) {
			$this->target = $par;
		} else {
			$this->target = $request->getVal( 'target', wfMsg( 'rootcategory' ) );
		}

		$this->target = trim( $this->target );

		# HACK for undefined root category
		if ( $this->target == '<rootcategory>' || $this->target == '&lt;rootcategory&gt;' ) {
			$this->target = null;
		}

		$options = array();

		# grab all known options from the request. Normalization is done by the CategoryTree class
		foreach ( $wgCategoryTreeDefaultOptions as $option => $default ) {
			if ( isset( $wgCategoryTreeSpecialPageOptions[$option] ) ) {
				$default = $wgCategoryTreeSpecialPageOptions[$option];
			}

			$options[$option] = $request->getVal( $option, $default );
		}

		$this->tree = new CategoryTree( $options );

		$output = $this->getOutput();
		$output->addWikiMsg( 'categorytree-header' );

		$this->executeInputForm();

		if ( $this->target !== '' && $this->target !== null ) {
			if ( !$wgCategoryTreeForceHeaders ) {
				CategoryTree::setHeaders( $output );
			}

			$title = CategoryTree::makeTitle( $this->target );

			if ( $title && $title->getArticleID() ) {
				$output->addHTML( Xml::openElement( 'div', array( 'class' => 'CategoryTreeParents' ) ) );
				$output->addHTML( wfMsgExt( 'categorytree-parents', 'parseinline' ) );
				$output->addHTML( wfMsg( 'colon-separator' ) );

				$parents = $this->tree->renderParents( $title );

				if ( $parents == '' ) {
					$output->addHTML( wfMsgExt( 'categorytree-no-parent-categories', 'parseinline' ) );
				} else {
					$output->addHTML( $parents );
				}

				$output->addHTML( Xml::closeElement( 'div' ) );

				$output->addHTML( Xml::openElement( 'div', array( 'class' => 'CategoryTreeResult' ) ) );
				$output->addHTML( $this->tree->renderNode( $title, 1 ) );
				$output->addHTML( Xml::closeElement( 'div' ) );
			} else {
				$output->addHTML( Xml::openElement( 'div', array( 'class' => 'CategoryTreeNotice' ) ) );
				$output->addHTML( wfMsgExt( 'categorytree-not-found', 'parseinline' , $this->target ) );
				$output->addHTML( Xml::closeElement( 'div' ) );
			}
		}
	}

	/**
	 * Input form for entering a category
	 */
	function executeInputForm() {
		global $wgScript;
		$thisTitle = SpecialPage::getTitleFor( $this->getName() );
		$mode = $this->getOption( 'mode' );

		$output = $this->getOutput();
		$output->addHTML( Xml::openElement( 'form', array( 'name' => 'categorytree', 'method' => 'get', 'action' => $wgScript, 'id' => 'mw-categorytree-form' ) ) );
		$output->addHTML( Xml::openElement( 'fieldset' ) );
		$output->addHTML( Xml::element( 'legend', null, wfMsgNoTrans( 'categorytree-legend' ) ) );
		$output->addHTML( Html::Hidden( 'title', $thisTitle->getPrefixedDbKey() ) );
		$output->addHTML( Xml::inputLabel( wfMsgNoTrans( 'categorytree-category' ), 'target', 'target', 20, $this->target ) . ' ' );
		$output->addHTML( Xml::openElement( 'select', array( 'name' => 'mode' ) ) );
		$output->addHTML( Xml::option( wfMsgNoTrans( 'categorytree-mode-categories' ), 'categories', $mode == CT_MODE_CATEGORIES ) );
		$output->addHTML( Xml::option( wfMsgNoTrans( 'categorytree-mode-pages' ), 'pages', $mode == CT_MODE_PAGES ) );
		$output->addHTML( Xml::option( wfMsgNoTrans( 'categorytree-mode-all' ), 'all', $mode == CT_MODE_ALL ) );
		$output->addHTML( Xml::closeElement( 'select' ) . ' ' );
		$output->addHTML( Xml::submitButton( wfMsgNoTrans( 'categorytree-go' ), array( 'name' => 'dotree' ) ) );
		$output->addHTML( Xml::closeElement( 'fieldset' ) );
		$output->addHTML( Xml::closeElement( 'form' ) );
	}
}
