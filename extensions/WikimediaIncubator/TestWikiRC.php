<?php
/**
 * Recent changes for a specific test wiki, or for all project changes (or normal display)
 *
 * @file
 * @ingroup Extensions
 * @author Robin Pepermans (SPQRobin)
 */

class TestWikiRC {
	static function getValues() {
		global $wgUser, $wmincPref, $wgRequest;
		$url = IncubatorTest::getUrlParam();
		$projectvalue = $url ? $url['project'] : $wgUser->getOption( $wmincPref . '-project' );
		$codevalue = $url ? $url['lang'] : $wgUser->getOption( $wmincPref . '-code' );
		$projectvalue = strtolower( $wgRequest->getVal( 'rc-testwiki-project', $projectvalue ) );
		$codevalue = strtolower( $wgRequest->getVal( 'rc-testwiki-code', $codevalue ) );
		return array( $projectvalue, $codevalue );
	}

	static function onRcQuery( &$conds, &$tables, &$join_conds, $opts ) {
		global $wmincProjectSite, $wmincTestWikiNamespaces;
		list( $projectvalue, $codevalue ) = self::getValues();
		$prefix = IncubatorTest::displayPrefix( $projectvalue, $codevalue );
		$opts->add( 'rc-testwiki-project', false );
		$opts->setValue( 'rc-testwiki-project', $projectvalue );
		$opts->add( 'rc-testwiki-code', false );
		$opts->setValue( 'rc-testwiki-code', $codevalue );
		if ( $projectvalue == 'none' || $projectvalue == '' ) {
			// If "none" is selected, display normal recent changes
			return true;
		} elseif ( $projectvalue == $wmincProjectSite['short'] ) {
			// If project site is selected, display all changes except test wiki changes
			$dbr = wfGetDB( DB_SLAVE );
			$conds[] = 'rc_title NOT ' . $dbr->buildLike( 'W', $dbr->anyChar(), '/', $dbr->anyString() );
		} elseif( IncubatorTest::validatePrefix( $prefix, true ) ) {
			// Else, display changes to the selected test wiki in the appropriate namespaces
			$dbr = wfGetDB( DB_SLAVE );
			$conds['rc_namespace'] = $wmincTestWikiNamespaces;
			$conds[] = 'rc_title ' . $dbr->buildLike( $prefix . '/', $dbr->anyString() ) .
			' OR rc_title = ' . $dbr->addQuotes( $prefix );
		} else {
			return true;
		}
		return true;
	}

	static function onRcForm( &$items, $opts ) {
		global $wmincProjects, $wmincProjectSite, $wmincLangCodeLength;
		
		list( $projectvalue, $codevalue ) = self::getValues();
		$opts->consumeValue( 'rc-testwiki-project' );
		$opts->consumeValue( 'rc-testwiki-code' );
		$label = Xml::label( wfMsg( 'wminc-testwiki' ), 'rc-testwiki' );
		$select = new XmlSelect( 'rc-testwiki-project', 'rc-testwiki-project', $projectvalue );
		$select->addOption( wfMsg( 'wminc-testwiki-none' ), 'none' );
		foreach( $wmincProjects as $prefix => $name ) {
			$select->addOption( $name, $prefix );
		}
		$select->addOption( $wmincProjectSite['name'], $wmincProjectSite['short'] );
		$langcode = Xml::input( 'rc-testwiki-code', (int)$wmincLangCodeLength, $codevalue,
			array( 'id' => 'rc-testwiki-code', 'maxlength' => (int)$wmincLangCodeLength ) );
		$items['testwiki'] = array( $label, $select->getHTML() . ' ' . $langcode );
		return true;
	}
}
