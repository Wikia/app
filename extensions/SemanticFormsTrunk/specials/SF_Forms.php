<?php
/**
 * Shows list of all forms on the site.
 *
 * @author Yaron Koren
 * @file
 * @ingroup SF
 */

/**
 * @ingroup SFSpecialPages
 */
class SFForms extends SpecialPage {

	/**
	 * Constructor
	 */
	function __construct() {
		parent::__construct( 'Forms' );
		SFUtils::loadMessages();
	}

	function execute( $query ) {
		$this->setHeaders();
		list( $limit, $offset ) = wfCheckLimits();
		$rep = new FormsPage();
		// execute() method added in 1.18
		if ( method_exists( $rep, 'execute' ) ) {
			return $rep->execute( $query );
		} else {
			return $rep->doQuery( $offset, $limit );
		}
	}
}

/**
 * @ingroup SFSpecialPages
 */
class FormsPage extends QueryPage {
	public function __construct( $name = 'Forms' ) {
		// For MW <= 1.17
		if ( $this instanceof SpecialPage ) {
			parent::__construct( $name );
		}
	}
	
	function getName() {
		return "Forms";
	}

	function isExpensive() { return false; }

	function isSyndicated() { return false; }

	function getPageHeader() {
		global $wgUser;
		
		SFUtils::loadMessages();
		
		$sk = $wgUser->getSkin();
		$create_form_link = SFUtils::linkForSpecialPage( $sk, 'CreateForm' );
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
	
	// For MW 1.18+
	function getQueryInfo() {
		return array(
			'tables' => array( 'page' ),
			'fields' => array( 'page_title AS title', 'page_title AS value' ),
			'conds' => array( 'page_namespace' => SF_NS_FORM, 'page_is_redirect' => 0 )
		);
	}

	function sortDescending() {
		return false;
	}

	function formatResult( $skin, $result ) {
		$title = Title::makeTitle( SF_NS_FORM, $result->value );
		return $skin->makeLinkObj( $title, htmlspecialchars( $title->getText() ) );
	}
}
