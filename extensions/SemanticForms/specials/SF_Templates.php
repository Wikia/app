<?php
/**
 * Shows list of all templates on the site.
 *
 * @author Yaron Koren
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

class SFTemplates extends SpecialPage {

	/**
	 * Constructor
	 */
	function SFTemplates() {
		SpecialPage::SpecialPage( 'Templates' );
		wfLoadExtensionMessages( 'SemanticForms' );
	}

	function execute( $query ) {
		$this->setHeaders();
		list( $limit, $offset ) = wfCheckLimits();
		$rep = new TemplatesPage();
		return $rep->doQuery( $offset, $limit );
	}
}

class TemplatesPage extends QueryPage {
	function getName() {
		return "Templates";
	}

	function isExpensive() { return false; }

	function isSyndicated() { return false; }

	function getPageHeader() {
		global $wgUser;
		
		wfLoadExtensionMessages( 'SemanticForms' );
		
		$sk = $wgUser->getSkin();
		$ct = SpecialPage::getPage( 'CreateTemplate' );
		$create_template_link = $sk->makeKnownLinkObj( $ct->getTitle(), $ct->getDescription() );
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

	function sortDescending() {
		return false;
	}

	function getCategoryDefinedByTemplate( $template_article ) {
		global $wgContLang;

		$template_text = $template_article->getContent();
		$cat_ns_name = $wgContLang->getNsText( 14 );
		if ( preg_match_all( "/\[\[(Category|$cat_ns_name):([^\]]*)\]\]/", $template_text, $matches ) ) {
			// get the last match - if there's more than one
			// category tag, there's a good chance that the last
			// one will be the relevant one - the others are
			// probably part of inline queries
			return trim( end( $matches[2] ) );
		}
		return "";
	}

	function formatResult( $skin, $result ) {
		wfLoadExtensionMessages( 'SemanticForms' );
		$title = Title::makeTitle( NS_TEMPLATE, $result->value );
		$text = $skin->makeLinkObj( $title, $title->getText() );
		$category = $this->getCategoryDefinedByTemplate( new Article( $title ) );
		if ( $category != '' )
			$text .= ' ' . wfMsg( 'sf_templates_definescat' ) . ' ' . SFUtils::linkText( NS_CATEGORY, $category );
		return $text;
	}
}
