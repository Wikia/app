<?php

if ( !defined( 'MEDIAWIKI' ) ) die();

require_once( "Wikidata.php" );
require_once( "WikiDataGlobals.php" );

class SpecialSelect extends SpecialPage {
	function SpecialSelect() {
		parent::__construct( 'Select', 'UnlistedSpecialPage' );
	}

	function execute( $par ) {
		require_once( 'languages.php' );
		require_once( 'Transaction.php' );
		global $wgOut, $wgLang, $wgRequest, $wgOptionAttribute;

		$wgOut->disable();

		$dc = wdGetDataSetContext();
		$optionAttribute = $wgRequest->getVal( $wgOptionAttribute );
		$attributeObject = $wgRequest->getVal( 'attribute-object' );
		$lang_code = $wgLang->getCode();

		$dbr = wfGetDB( DB_SLAVE );
		$sql = 'SELECT language_id' .
				" FROM {$dc}_syntrans" .
				" JOIN {$dc}_expression ON {$dc}_expression.expression_id = {$dc}_syntrans.expression_id" .
				" WHERE {$dc}_syntrans.syntrans_sid = " . $attributeObject .
				' AND ' . getLatestTransactionRestriction( "{$dc}_syntrans" ) .
				' AND ' . getLatestTransactionRestriction( "{$dc}_expression" );
		$lang_res = $dbr->query( $sql );
		$objectLanguage = $dbr->fetchObject( $lang_res )->language_id;
		// language is not always defined, for example for a DM Option Attribute
		if ( ! $objectLanguage ) $objectLanguage = 0 ;

		$sql = "SELECT {$dc}_option_attribute_options.option_id,{$dc}_option_attribute_options.option_mid" .
				" FROM {$dc}_option_attribute_options" .
				" WHERE {$dc}_option_attribute_options.attribute_id = " . $optionAttribute .
				" AND ({$dc}_option_attribute_options.language_id = " . $objectLanguage .
				" OR {$dc}_option_attribute_options.language_id = 0)" .
				' AND ' . getLatestTransactionRestriction( "{$dc}_option_attribute_options" ) ;
		$options_res = $dbr->query( $sql );

		$optionsString = '';
		$optionsArray = array() ;
		while ( $options_row = $dbr->fetchObject( $options_res ) ) {
			/* Use a simpler query if the user's language is English. */
			if ( $lang_code == 'en' || !( $lang_id = getLanguageIdForCode( $lang_code ) ) ) {
				$sql = "SELECT {$dc}_expression.spelling" .
						" FROM {$dc}_syntrans" .
						" JOIN {$dc}_expression ON {$dc}_expression.expression_id = {$dc}_syntrans.expression_id" .
						" WHERE {$dc}_syntrans.defined_meaning_id = " . $options_row->option_mid .
						" AND {$dc}_expression.language_id = " . getLanguageIdForCode( 'en' ) .
						' AND ' . getLatestTransactionRestriction( "{$dc}_syntrans" ) .
						' AND ' . getLatestTransactionRestriction( "{$dc}_expression" );
			}
			/* Fall back on English in cases where an option name is not present in the
				user's preferred language. */
			else {
				/* XXX: This setup is really hacked together. It NEEDS to be improved. */
				$sql = "SELECT {$dc}_expression.spelling" .
						" FROM {$dc}_syntrans" .
						" JOIN {$dc}_expression ON {$dc}_expression.expression_id = {$dc}_syntrans.expression_id" .
						" WHERE {$dc}_syntrans.defined_meaning_id = " . $options_row->option_mid .
						" AND {$dc}_expression.language_id = " . $lang_id .
						' AND ' . getLatestTransactionRestriction( "{$dc}_syntrans" ) .
						' AND ' . getLatestTransactionRestriction( "{$dc}_expression" );
				$res = $dbr->query( $sql );
				if ( !$dbr->fetchObject( $res )->spelling )
					$sql = "SELECT {$dc}_expression.spelling" .
							" FROM {$dc}_syntrans" .
							" JOIN {$dc}_expression ON {$dc}_expression.expression_id = {$dc}_syntrans.expression_id" .
							" WHERE {$dc}_syntrans.defined_meaning_id = " . $options_row->option_mid .
							" AND {$dc}_expression.language_id = " . getLanguageIdForCode( 'en' ) .
							' AND ' . getLatestTransactionRestriction( "{$dc}_syntrans" ) .
							' AND ' . getLatestTransactionRestriction( "{$dc}_expression" );
			}

			$spelling_res = $dbr->query( $sql );
			$spelling_row = $dbr->fetchObject( $spelling_res );

			$optionsArray[$options_row->option_id] = $spelling_row->spelling ;
		}

		asort( $optionsArray ) ;
		foreach ($optionsArray as $option_id => $spelling ) {
			if ( $optionsString != '' ) $optionsString .= "\n";
			$optionsString .= $option_id . ';' . $spelling ;
		}

	echo $optionsString;
	}
}
