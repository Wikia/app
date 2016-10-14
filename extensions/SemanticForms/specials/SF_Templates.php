<?php
/**
 * Shows list of all templates on the site.
 *
 * @author Yaron Koren
 * @file
 * @ingroup SF
 */

/**
 * @ingroup SFSpecialPages
 */
class SFTemplates extends SpecialPage {

	/**
	 * Constructor
	 */
	function __construct() {
		parent::__construct( 'Templates' );
	}

	function execute( $query ) {
		$this->setHeaders();
		list( $limit, $offset ) = wfCheckLimits();
		$rep = new TemplatesPage();
		$rep->execute( $query );
	}
}

/**
 * @ingroup SFSpecialPages
 */
class TemplatesPage extends QueryPage {

	public function __construct( $name = 'Templates' ) {
		parent::__construct( $name );
	}
	
	function getName() {
		return "Templates";
	}

	function isExpensive() { return false; }

	function isSyndicated() { return false; }

	function getPageHeader() {
		$header = '<p>' . wfMessage( 'sf_templates_docu' )->text() . "</p><br />\n";
		return $header;
	}

	function getPageFooter() {
	}

	function getQueryInfo() {
		return array(
			'tables' => array( 'page' ),
			'fields' => array( 'page_title AS title', 'page_title AS value' ),
			'conds' => array( 'page_namespace' => NS_TEMPLATE )
		);
	}

	function sortDescending() {
		return false;
	}

	function getCategoryDefinedByTemplate( $templateTitle ) {
		global $wgContLang;

		$templateText = SFUtils::getPageText( $templateTitle );
		$cat_ns_name = $wgContLang->getNsText( NS_TEMPLATE );
		if ( preg_match_all( "/\[\[(Category|$cat_ns_name):([^\]]*)\]\]/", $templateText, $matches ) ) {
			// Get the last match - if there's more than one
			// category tag, there's a good chance that the last
			// one will be the relevant one - the others are
			// probably part of inline queries.
			$categoryName = trim( end( $matches[2] ) );
			// If there's a pipe, remove it and anything after it.
			$locationOfPipe = strpos( $categoryName, '|' );
			if ( $locationOfPipe !== false ) {
				$categoryName = substr( $categoryName, 0, $locationOfPipe );
			}
			return $categoryName;
		}
		return "";
	}

	function formatResult( $skin, $result ) {
		$title = Title::makeTitle( NS_TEMPLATE, $result->value );
		$text = Linker::link( $title, htmlspecialchars( $title->getText() ) );
		$category = $this->getCategoryDefinedByTemplate( $title );
		if ( $category !== '' ) {
			$text .= ' ' . wfMessage(
				'sf_templates_definescat',
				SFUtils::linkText( NS_CATEGORY, $category )
			)->parse();
		}
		return $text;
	}
}
