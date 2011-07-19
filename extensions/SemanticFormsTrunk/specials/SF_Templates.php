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
		SFUtils::loadMessages();
	}

	function execute( $query ) {
		$this->setHeaders();
		list( $limit, $offset ) = wfCheckLimits();
		$rep = new TemplatesPage();
		// execute() method added in MW 1.18
		if ( method_exists( $rep, 'execute' ) ) {
			$rep->execute( $query );
		} else {
			return $rep->doQuery( $offset, $limit );
		}
	}
}

/**
 * @ingroup SFSpecialPages
 */
class TemplatesPage extends QueryPage {

	public function __construct( $name = 'Templates' ) {
		// For MW <= 1.17
		if ( $this instanceof SpecialPage ) {
			parent::__construct( $name );
		}
	}
	
	function getName() {
		return "Templates";
	}

	function isExpensive() { return false; }

	function isSyndicated() { return false; }

	function getPageHeader() {
		global $wgUser;
		
		SFUtils::loadMessages();
		
		$sk = $wgUser->getSkin();
		$create_template_link = SFUtils::linkForSpecialPage( $sk, 'CreateTemplate' );
		$header = "<p>" . $create_template_link . ".</p>\n";
		$header .= '<p>' . wfMsg( 'sf_templates_docu' ) . "</p><br />\n";
		return $header;
	}

	function getPageFooter() {
	}

	function getSQL() {
		$NStemp = NS_TEMPLATE;
		$dbr = wfGetDB( DB_SLAVE );
		$page = $dbr->tableName( 'page' );
		// QueryPage uses the value from this SQL in an ORDER clause,
		// so return page_title as title.
		return "SELECT 'Templates' as type,
			page_title as title,
			page_title as value
			FROM $page
			WHERE page_namespace = {$NStemp}";
	}

	// For MW 1.18+
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

		$templateArticle = new Article( $templateTitle );
		$templateText = $templateArticle->getContent();
		$cat_ns_name = $wgContLang->getNsText( NS_TEMPLATE );
		if ( preg_match_all( "/\[\[(Category|$cat_ns_name):([^\]]*)\]\]/", $templateText, $matches ) ) {
			// Get the last match - if there's more than one
			// category tag, there's a good chance that the last
			// one will be the relevant one - the others are
			// probably part of inline queries.
			return trim( end( $matches[2] ) );
		}
		return "";
	}

	function formatResult( $skin, $result ) {
		$title = Title::makeTitle( NS_TEMPLATE, $result->value );
		$text = $skin->makeLinkObj( $title, htmlspecialchars( $title->getText() ) );
		$category = $this->getCategoryDefinedByTemplate( $title );
		if ( $category != '' ) {
			SFUtils::loadMessages();
			$text .= ' ' . wfMsg( 'sf_templates_definescat' ) . ' ' . SFUtils::linkText( NS_CATEGORY, $category );
		}
		return $text;
	}
}
