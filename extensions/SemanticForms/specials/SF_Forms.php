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
	}

	function execute( $query ) {
		$this->setHeaders();
		list( $limit, $offset ) = $this->getRequest()->getLimitOffset();
		$rep = new FormsPage();
		return $rep->execute( $query );
	}

	protected function getGroupName() {
		return 'pages';
	}
}

/**
 * @ingroup SFSpecialPages
 */
class FormsPage extends QueryPage {
	public function __construct( $name = 'Forms' ) {
		parent::__construct( $name );
	}
	
	function getName() {
		return "Forms";
	}

	function isExpensive() { return false; }

	function isSyndicated() { return false; }

	function getPageHeader() {
		$header = Html::element( 'p', null, wfMessage( 'sf_forms_docu' )->text() );
		return $header;
	}

	function getPageFooter() {
	}

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
		return Linker::link( $title, htmlspecialchars( $title->getText() ) );
	}
}
