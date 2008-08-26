<?php

class CCFilters {

	public static function user( &$conds, &$tables, &$join_conds, &$opts ) {
		global $wgRequest;
		$opts->add( 'users', '' );
		$users = $wgRequest->getVal( 'users' );
		if ( $users === null ) return true;

		$idfilters = array();
		$userArr = explode( '|', $users );
		foreach ( $userArr as $u ) {
			$id = User::idFromName( $u );
			if ( $id !== null ) {
				$idfilters[] = $id;
			}
		}
		if ( count($idfilters) ) {
			$dbr = wfGetDB( DB_SLAVE );
			$conds[] = 'rc_user IN (' . $dbr->makeList( $idfilters ) . ')';
			$opts->setValue( 'users', $users );
		}

		return true;
	}

	public static function userForm( &$items, &$opts ) {
		wfLoadExtensionMessages( 'CleanChanges' );
		$opts->consumeValue( 'users' );
		global $wgRequest;

		$default = $wgRequest->getVal( 'users', '' );
		$items['users'] = Xml::inputLabelSep( wfMsg( 'cleanchanges-users') , 'users',
			'mw-users', 40, $default  );
		return true;
	}

	public static function trailer( &$conds, &$tables, &$join_conds, &$opts ) {
		global $wgRequest;
		$opts->add( 'trailer', '' );
		$trailer = $wgRequest->getVal( 'trailer' );
		if ( $trailer === null ) return true;

		$dbr = wfGetDB( DB_SLAVE );
		$conds[] = 'rc_title LIKE \'%%' . $dbr->escapeLike( $trailer ) . '\'';
		$opts->setValue( 'trailer', $trailer );

		return true;
	}

	public static function trailerForm( &$items, &$opts ) {
		wfLoadExtensionMessages( 'CleanChanges' );

		$opts->consumeValue( 'trailer' );

		global $wgRequest;
		$default = $wgRequest->getVal( 'trailer', '' );
		global $wgLang;
		if ( is_callable(array( 'LanguageNames', 'getNames' )) ) {
			$languages = LanguageNames::getNames( $wgLang->getCode(),
				LanguageNames::FALLBACK_NORMAL,
				LanguageNames::LIST_MW
			);
		} else {
			$languages = Language::getLanguageNames( false );
		}
		ksort( $languages );
		$options = Xml::option( wfMsg( 'cleanchanges-language-na' ), '', $default === '' );
		foreach( $languages as $code => $name ) {
			$selected = ("/$code" === $default);
			$options .= Xml::option( "$code - $name", "/$code", $selected ) . "\n";
		}
		$str =
		Xml::openElement( 'select', array(
			'name' => 'trailer',
			'class' => 'mw-language-selector',
			'id' => 'sp-rc-language',
		)) .
		$options .
		Xml::closeElement( 'select' );

		$items['tailer'] = array( wfMsgHtml( 'cleanchanges-language' ), $str );
		return true;
	}

}