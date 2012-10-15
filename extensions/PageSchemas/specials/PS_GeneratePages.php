<?php
/**
 * Displays an interface to let users create all pages based on the
 * Page Schemas XML.
 *
 * @author Ankit Garg
 * @author Yaron Koren
 */


class PSGeneratePages extends IncludableSpecialPage {
	function __construct() {
		parent::__construct( 'GeneratePages', 'generatepages' );
	}

	function execute( $category ) {
		global $wgUser, $wgRequest, $wgOut, $wgPageSchemasHandlerClasses;

		if ( ! $wgUser->isAllowed( 'generatepages' ) ) {
			$wgOut->permissionRequired( 'generatepages' );
			return;
		}

		$this->setHeaders();
		$param = $wgRequest->getText('param');
		if ( !empty( $param ) && !empty( $category ) ) {
			// Generate the pages!
			$this->generatePages( $param, $wgRequest->getArray( 'page' ) );
			$text = Html::element( 'p', null, wfMsg( 'ps-generatepages-success' ) );
			$wgOut->addHTML( $text );
			return true;
		}

		if ( $category == "") {
			// No category listed.
			// TODO - show an error message.
			return true;
		}

		// Standard "generate pages" form, with category name set.
		// Check for a valid category, with a page schema defined.
		$pageSchemaObj = new PSSchema( $category );
		if ( !$pageSchemaObj->isPSDefined() ) {
			$text = Html::element( 'p', null, wfMsg( 'ps-generatepages-noschema' ) );
			$wgOut->addHTML( $text );
			return true;
		}

		$text = Html::element( 'p', null, wfMsg( 'ps-generatepages-desc' ) ) . "\n";
		$text .= '<form method="post">';
		$text .= Html::input( 'param', $category, 'hidden' ) . "\n";

		// This hook will set an array of strings, with each value
		// as a title of a page to be created.
		$pageList = array();
		foreach ( $wgPageSchemasHandlerClasses as $psHandlerClass ) {
			$pagesFromHandler = call_user_func( array( $psHandlerClass, "getPagesToGenerate" ), $pageSchemaObj );
			foreach ( $pagesFromHandler as $page ) {
				$pageList[] = $page;
			}
		}
		// SpecialPage::getSkin() was added in MW 1.18
		if ( is_callable( $this, 'getSkin' ) ) {
			$skin = $this->getSkin();
		} else {
			global $wgUser;
			$skin = $wgUser->getSkin();
		}
		foreach ( $pageList as $page ) {
			if ( !( $page instanceof Title ) ) { continue; }
			$pageName = PageSchemas::titleString( $page );
			$text .= Html::input( 'page[]', $pageName, 'checkbox', array( 'checked' => true ) );
			$text .= "\n" . $skin->link( $page ) . "<br />\n";
		}
		$text .= "<br />\n";
		$text .= Html::input( null, wfMsg( 'generatepages' ), 'submit' );
		$text .= "\n</form>";
		$wgOut->addHTML( $text );
		return true;
	}

	/**
	 * Creates all the pages that the user specified.
	 */
	function generatePages( $categoryName, $selectedPageList ) {
		$pageSchema = new PSSchema( $categoryName );
		$pageSchema->generateAllPages( $selectedPageList );
	}

	/**
	 * Don't list this in Special:SpecialPages.
	 */
	function isListed() {
		return false;
	}
}
