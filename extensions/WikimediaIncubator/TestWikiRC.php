<?php
/*
* Recent changes for a specific test wiki, or for all project changes (or normal display)
*/

class TestWikiRC {
	static function onRcQuery( &$conds, &$tables, &$join_conds, $opts ) {
		global $wgUser, $wgRequest, $wmincPref;
		$projectvalue = strtolower( $wgRequest->getVal( 'rc-testwiki-project', $wgUser->getOption($wmincPref . '-project') ) );
		$codevalue = strtolower( $wgRequest->getVal( 'rc-testwiki-code', $wgUser->getOption($wmincPref . '-code') ) );
		$fullprefix = 'W' . $projectvalue . '/' . $codevalue;
		$opts->add( 'rc-testwiki-project', false );
		$opts->setValue( 'rc-testwiki-project', $projectvalue );
		$opts->add( 'rc-testwiki-code', false );
		$opts->setValue( 'rc-testwiki-code', $codevalue );
		if ( $projectvalue == 'none' OR $projectvalue == '' ) {
			// If "none" is selected, display normal recent changes
			return true;
		} elseif ( $projectvalue == 'inc' ) {
			// If "inc" (incubator) is selected, display all changes except test wiki changes
			$conds[] = 'rc_title not like \'W_/%%\' OR \'W_/%%/%%\'';
			return true;
		} else {
			// Else, display changes to the selected test wiki (in main, template and category namespace)
			$dbr = wfGetDB( DB_SLAVE );
			$namespaces = array( NS_MAIN, NS_TALK, NS_TEMPLATE, NS_TEMPLATE_TALK, NS_CATEGORY, NS_CATEGORY_TALK );
			$conds[] = 'rc_namespace IN (' . $dbr->makeList( $namespaces ) . ')';
			$conds[] = 'rc_title like ' . $dbr->addQuotes( $dbr->escapeLike( $fullprefix ) . '/%' ) . 
			' OR rc_title = ' . $dbr->addQuotes( $fullprefix );
			return true;
		}
	}

	static function onRcForm( &$items, $opts ) {
		global $wgUser, $wgRequest, $wmincPref;
		wfLoadExtensionMessages( 'WikimediaIncubator' );
		$projectvalue = $wgRequest->getVal( 'rc-testwiki-project', $wgUser->getOption($wmincPref . '-project') );
		$langcodevalue = $wgRequest->getVal( 'rc-testwiki-code', $wgUser->getOption($wmincPref . '-code') );
		$opts->consumeValue( 'rc-testwiki-project' );
		$opts->consumeValue( 'rc-testwiki-code' );
		$label = Xml::label( wfMsg( 'wminc-testwiki' ), 'rc-testwiki' );
		$select = new XmlSelect( 'rc-testwiki-project', 'rc-testwiki-project', $projectvalue );
		$select->addOption( wfMsg( 'wminc-testwiki-none' ), 'none' );
		$select->addOption( 'wikipedia', 'p' );
		$select->addOption( 'wikibooks', 'b' );
		$select->addOption( 'wiktionary', 't' );
		$select->addOption( 'wikiquote', 'q' );
		$select->addOption( 'wikinews', 'n' );
		$select->addOption( 'incubator', 'inc' );
		$langcode = Xml::input( 'rc-testwiki-code', 3, $langcodevalue, array( 'id' => 'rc-testwiki-code', 'maxlength' => 3 ) );
		$items['testwiki'] = array( $label, $select->getHTML() . ' ' . $langcode );
		return true;
	}
}
