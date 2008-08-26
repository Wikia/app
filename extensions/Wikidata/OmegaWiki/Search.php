<?php

require_once("Wikidata.php");
require_once("Transaction.php");
require_once("RecordSet.php");
require_once("Editor.php");
require_once("WikiDataAPI.php");
require_once("OmegaWikiAttributes.php");
require_once("OmegaWikiRecordSets.php");
require_once("OmegaWikiEditors.php");
require_once("Wikidata.php");

class Search extends DefaultWikidataApplication {
	function view() {
		global
			$wgOut, $wgTitle;
		
		parent::view();

		$spelling = $wgTitle->getText();
		$wgOut->addHTML('<h1>Words matching <i>'. $spelling . '</i> and associated meanings</h1>');
		$wgOut->addHTML('<p>Showing only a maximum of 100 matches.</p>');
		$wgOut->addHTML($this->searchText($spelling));
	}
	
	function searchText($text) {
		$dc=wdGetDataSetContext();
		$dbr = &wfGetDB(DB_SLAVE);
		
		$sql = "SELECT INSTR(LCASE({$dc}_expression.spelling), LCASE(". $dbr->addQuotes("$text") .")) as position, {$dc}_syntrans.defined_meaning_id AS defined_meaning_id, {$dc}_expression.spelling AS spelling, {$dc}_expression.language_id AS language_id ".
				"FROM {$dc}_expression, {$dc}_syntrans ".
	            "WHERE {$dc}_expression.expression_id={$dc}_syntrans.expression_id AND {$dc}_syntrans.identical_meaning=1 " .
	            " AND " . getLatestTransactionRestriction("{$dc}_syntrans") .
	            " AND " . getLatestTransactionRestriction("{$dc}_expression") .
				" AND spelling LIKE " . $dbr->addQuotes("%$text%") .
				" ORDER BY position ASC, {$dc}_expression.spelling ASC limit 100";
		
		$queryResult = $dbr->query($sql);
		list($recordSet, $editor) = getSearchResultAsRecordSet($queryResult);
//		return $sql;
		return $editor->view(new IdStack("expression"), $recordSet);
	}
}

function getSearchResultAsRecordSet($queryResult) {

	$o=OmegaWikiAttributes::getInstance();
	global
		 $definedMeaningReferenceType;

	$dbr =& wfGetDB(DB_SLAVE);
	$spellingAttribute = new Attribute("found-word", "Found word", "short-text");
	$languageAttribute = new Attribute("language", "Language", "language");
	
	$expressionStructure = new Structure($spellingAttribute, $languageAttribute);
	$expressionAttribute = new Attribute("expression", "Expression", $expressionStructure);
	
	$definedMeaningAttribute = new Attribute("defined-meaning", "Defined meaning", $definedMeaningReferenceType);
	$definitionAttribute = new Attribute("definition", "Definition", "definition");
	
	$meaningStructure = new Structure($definedMeaningAttribute, $definitionAttribute);
	$meaningAttribute = new Attribute("meaning", "Meaning", $meaningStructure);

	$recordSet = new ArrayRecordSet(new Structure($o->definedMeaningId, $expressionAttribute, $meaningAttribute), new Structure($o->definedMeaningId));
	
	while ($row = $dbr->fetchObject($queryResult)) {
		$expressionRecord = new ArrayRecord($expressionStructure);
		$expressionRecord->setAttributeValue($spellingAttribute, $row->spelling);
		$expressionRecord->setAttributeValue($languageAttribute, $row->language_id);
		
		$meaningRecord = new ArrayRecord($meaningStructure);
		$meaningRecord->setAttributeValue($definedMeaningAttribute, getDefinedMeaningReferenceRecord($row->defined_meaning_id));
		$meaningRecord->setAttributeValue($definitionAttribute, getDefinedMeaningDefinition($row->defined_meaning_id));

		$recordSet->addRecord(array($row->defined_meaning_id, $expressionRecord, $meaningRecord));
	}			

	$expressionEditor = new RecordTableCellEditor($expressionAttribute);
	$expressionEditor->addEditor(new SpellingEditor($spellingAttribute, new SimplePermissionController(false), false));
	$expressionEditor->addEditor(new LanguageEditor($languageAttribute, new SimplePermissionController(false), false));

	$meaningEditor = new RecordTableCellEditor($meaningAttribute);
	$meaningEditor->addEditor(new DefinedMeaningReferenceEditor($definedMeaningAttribute, new SimplePermissionController(false), false));
	$meaningEditor->addEditor(new TextEditor($definitionAttribute, new SimplePermissionController(false), false, true, 75));

	$editor = createTableViewer(null);
	$editor->addEditor($expressionEditor);
	$editor->addEditor($meaningEditor);

	return array($recordSet, $editor);		
}


