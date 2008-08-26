<?php

if (!defined('MEDIAWIKI')) die();

$wgExtensionFunctions[] = 'wfSpecialSelect';
require_once("Wikidata.php");


function wfSpecialSelect() {
	class SpecialSelect extends SpecialPage {
		function SpecialSelect() {
			SpecialPage::SpecialPage('Select','UnlistedSpecialPage');
		}

		function execute( $par ) {
			require_once('languages.php');
			require_once('Transaction.php');
			global
				$wgOut,	$IP;

			$wgOut->disable();

			echo getSelectOptions();
		}
	}

	SpecialPage::addPage(new SpecialSelect());
}

function getSelectOptions() {
	global
		$wgUser;

	$dc=wdGetDataSetContext();
	$optionAttribute = $_GET['option-attribute'];
	$attributeObject = $_GET['attribute-object'];
	$lang_code = $wgUser->getOption('language');

	$dbr =& wfGetDB(DB_SLAVE);
	$sql = 'SELECT language_id' .
			" FROM {$dc}_syntrans" .
			" JOIN {$dc}_expression ON {$dc}_expression.expression_id = {$dc}_syntrans.expression_id" .
			" WHERE {$dc}_syntrans.syntrans_sid = " . $attributeObject .
			' AND ' . getLatestTransactionRestriction("{$dc}_syntrans") .
			' AND ' . getLatestTransactionRestriction("{$dc}_expression");
	$lang_res = $dbr->query($sql);
	$objectLanguage = $dbr->fetchObject($lang_res)->language_id;

	$sql = "SELECT {$dc}_option_attribute_options.option_id,{$dc}_option_attribute_options.option_mid" .
			" FROM {$dc}_option_attribute_options" .
			" JOIN {$dc}_class_attributes ON {$dc}_class_attributes.object_id = {$dc}_option_attribute_options.attribute_id" .
			" WHERE {$dc}_class_attributes.attribute_mid = " . $optionAttribute .
			" AND ({$dc}_option_attribute_options.language_id = " . $objectLanguage .
			" OR {$dc}_option_attribute_options.language_id = 0)" .
			' AND ' . getLatestTransactionRestriction("{$dc}_option_attribute_options") .
			' AND ' . getLatestTransactionRestriction("{$dc}_class_attributes");
	$options_res = $dbr->query($sql);

	$optionsString = '';
	while ($options_row = $dbr->fetchObject($options_res)) {
		/* Use a simpler query if the user's language is English. */
		if ($lang_code == 'en' || !($lang_id = getLanguageIdForCode($lang_code))) {
			$sql = "SELECT {$dc}_expression.spelling" .
					" FROM {$dc}_syntrans" .
					" JOIN {$dc}_expression ON {$dc}_expression.expression_id = {$dc}_syntrans.expression_id" .
					" WHERE {$dc}_syntrans.defined_meaning_id = " . $options_row->option_mid .
					" AND {$dc}_expression.language_id = " . getLanguageIdForCode('en') .
					' AND ' . getLatestTransactionRestriction("{$dc}_syntrans") .
					' AND ' . getLatestTransactionRestriction("{$dc}_expression");
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
					' AND ' . getLatestTransactionRestriction("{$dc}_syntrans") .
					' AND ' . getLatestTransactionRestriction("{$dc}_expression");
			$res = $dbr->query($sql);
			if (!$dbr->fetchObject($res)->spelling)
				$sql = "SELECT {$dc}_expression.spelling" .
						" FROM {$dc}_syntrans" .
						" JOIN {$dc}_expression ON {$dc}_expression.expression_id = {$dc}_syntrans.expression_id" .
						" WHERE {$dc}_syntrans.defined_meaning_id = " . $options_row->option_mid .
						" AND {$dc}_expression.language_id = " . getLanguageIdForCode('en') .
						' AND ' . getLatestTransactionRestriction("{$dc}_syntrans") .
						' AND ' . getLatestTransactionRestriction("{$dc}_expression");
		}

		$spelling_res = $dbr->query($sql);
		$spelling_row = $dbr->fetchObject($spelling_res);
		if ($optionsString != '')
			$optionsString .= "\n";
		$optionsString .= $options_row->option_id . ';' . $spelling_row->spelling;
	}

	return $optionsString;
}


