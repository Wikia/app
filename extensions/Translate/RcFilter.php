<?php

class TranslateRcFilter {

	public static function translationFilter( &$conds, &$tables, &$join_conds, $opts ) {
		global $wgRequest, $wgTranslateMessageNamespaces;
		$translations = $wgRequest->getVal( 'translations', '' );
		$opts->add( 'translations', false );
		$opts->setValue( 'translations', $translations );


		$dbr = wfGetDB( DB_SLAVE );

		$namespaces = array();
		foreach ( $wgTranslateMessageNamespaces as $index ) {
			$namespaces[] = $index;
			$namespaces[] = $index + 1; // Talk too
		}

		if ( $translations === 'only' ) {
			$conds[] = 'rc_namespace IN (' . $dbr->makeList( $namespaces ) . ')';
			$conds[] = 'rc_title like \'%%/%%\'';
		} elseif ( $translations === 'filter' ) {
			$conds[] = 'rc_namespace NOT IN (' . $dbr->makeList( $namespaces ) . ')';
		} elseif ( $translations === 'site' ) {
			$conds[] = 'rc_namespace IN (' . $dbr->makeList( $namespaces ) . ')';
			$conds[] = 'rc_title not like \'%%/%%\'';
		}
		return true;
	}

	public static function translationFilterForm( &$items, $opts ) {
		global $wgRequest;
		wfLoadExtensionMessages( 'Translate' );
		$opts->consumeValue( 'translations' );
		$default = $wgRequest->getVal( 'translations', '' );


		$label = Xml::label( wfMsg( 'translate-rc-translation-filter' ), 'mw-translation-filter' );
		$select = new XmlSelect( 'translations', 'mw-translation-filter', $default );
		$select->addOption( wfMsg( 'translate-rc-translation-filter-no' ), '' );
		$select->addOption( wfMsg( 'translate-rc-translation-filter-only' ), 'only' );
		$select->addOption( wfMsg( 'translate-rc-translation-filter-filter' ), 'filter' );
		$select->addOption( wfMsg( 'translate-rc-translation-filter-site' ), 'site' );

		$items['translations'] = array( $label, $select->getHTML() );
		return true;
	}


}