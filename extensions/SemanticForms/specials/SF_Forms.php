<?php
/**
 * Shows list of all forms on the site.
 *
 * @author Yaron Koren
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

class SFForms extends SpecialPage {

	/**
	 * Constructor
	 */
	function SFForms() {
		SpecialPage::SpecialPage( 'Forms' );
		wfLoadExtensionMessages( 'SemanticForms' );
	}

	function execute( $query ) {
		$this->setHeaders();
		list( $limit, $offset ) = wfCheckLimits();
		$rep = new FormsPage();
		return $rep->doQuery( $offset, $limit );
	}
}

class FormsPage extends QueryPage {
	function getName() {
		return "Forms";
	}

	function isExpensive() { return false; }

	function isSyndicated() { return false; }

	function getPageHeader() {
		global $wgUser;
		
		wfLoadExtensionMessages( 'SemanticForms' );
		
		$sk = $wgUser->getSkin();
		$cf = SpecialPage::getPage( 'CreateForm' );
		$create_form_link = $sk->makeKnownLinkObj( $cf->getTitle(), $cf->getDescription() );
		$header = "<p>" . $create_form_link . ".</p>\n";
		$header .= '<p>' . wfMsg( 'sf_forms_docu' ) . "</p><br />\n";
		return $header;
	}

	function getPageFooter() {
	}

	function getSQL() {
		$NSform = SF_NS_FORM;
		$dbr = wfGetDB( DB_SLAVE );
		$page = $dbr->tableName( 'page' );
		// QueryPage uses the value from this SQL in an ORDER clause,
		// so return page_title as title.
		return "SELECT 'Form' AS type,
			page_title AS title,
			page_title AS value
			FROM $page
			WHERE page_namespace = {$NSform}
			AND page_is_redirect = 0";
	}

	function sortDescending() {
		return false;
	}

	function formatResult( $skin, $result ) {
		$title = Title::makeTitle( SF_NS_FORM, $result->value );
		return $skin->makeLinkObj( $title, $title->getText() );
	}
}
