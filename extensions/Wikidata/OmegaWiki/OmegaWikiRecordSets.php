<?php

require_once('OmegaWikiAttributes.php');
require_once('Record.php');
require_once('RecordSet.php');
require_once('WikiDataAPI.php');
require_once('Transaction.php');
require_once('WikiDataTables.php');
require_once('RecordSetQueries.php');
require_once('DefinedMeaningModel.php');
require_once('ViewInformation.php');


function getSynonymSQLForLanguage($languageId, array &$definedMeaningIds) {
	$dc=wdGetDataSetContext();
	
	# Query building
    $frontQuery = "SELECT {$dc}_defined_meaning.defined_meaning_id AS defined_meaning_id, {$dc}_expression.spelling AS label " .
		" FROM {$dc}_defined_meaning, {$dc}_syntrans, {$dc}_expression " .
		" WHERE " . getLatestTransactionRestriction("{$dc}_syntrans") .
		" AND " . getLatestTransactionRestriction("{$dc}_expression") .
		" AND " . getLatestTransactionRestriction("{$dc}_defined_meaning") .
		" AND {$dc}_expression.language_id=" . $languageId .
		" AND {$dc}_expression.expression_id={$dc}_syntrans.expression_id " .
		" AND {$dc}_defined_meaning.defined_meaning_id={$dc}_syntrans.defined_meaning_id " . 
		" AND {$dc}_syntrans.identical_meaning=1 " .
		" AND {$dc}_defined_meaning.defined_meaning_id = "; 
		
    # Build atomic queries
	$definedMeaningIdsCopy = $definedMeaningIds;
    foreach ($definedMeaningIdsCopy as &$value) {$value = $frontQuery . $value; }
    unset($value);
	# Union of the atoms
    return implode(' UNION ',$definedMeaningIdsCopy);
}

function getSynonymSQLForAnyLanguage(array &$definedMeaningIds) {
	$dc=wdGetDataSetContext();

	# Query building
    $frontQuery = "SELECT {$dc}_defined_meaning.defined_meaning_id AS defined_meaning_id, {$dc}_expression.spelling AS label " .
		" FROM {$dc}_defined_meaning, {$dc}_syntrans, {$dc}_expression " .
		" WHERE " . getLatestTransactionRestriction("{$dc}_syntrans") .
		" AND " . getLatestTransactionRestriction("{$dc}_expression") .
		" AND " . getLatestTransactionRestriction("{$dc}_defined_meaning") .
		" AND {$dc}_expression.expression_id={$dc}_syntrans.expression_id " .
		" AND {$dc}_defined_meaning.defined_meaning_id={$dc}_syntrans.defined_meaning_id " . 
		" AND {$dc}_syntrans.identical_meaning=1 " .
		" AND {$dc}_defined_meaning.defined_meaning_id = "; 

    # Build atomic queries
	$definedMeaningIdsCopy = $definedMeaningIds;
    foreach ($definedMeaningIdsCopy as &$value) {$value = $frontQuery . $value; }
    unset($value);
	# Union of the atoms
    return implode(' UNION ',$definedMeaningIdsCopy);
}

function getDefiningSQLForLanguage($languageId, array &$definedMeaningIds) {
	$dc=wdGetDataSetContext();

	# Query building
    $frontQuery = "SELECT {$dc}_defined_meaning.defined_meaning_id AS defined_meaning_id, {$dc}_expression.spelling AS label " .
		" FROM {$dc}_defined_meaning, {$dc}_syntrans, {$dc}_expression " .
		" WHERE ". getLatestTransactionRestriction("{$dc}_syntrans") .
		" AND " . getLatestTransactionRestriction("{$dc}_expression") .
		" AND " . getLatestTransactionRestriction("{$dc}_defined_meaning") .
		" AND {$dc}_expression.expression_id={$dc}_syntrans.expression_id " .
		" AND {$dc}_defined_meaning.defined_meaning_id={$dc}_syntrans.defined_meaning_id " . 
		" AND {$dc}_syntrans.identical_meaning=1 " .
		" AND {$dc}_defined_meaning.expression_id={$dc}_expression.expression_id " .
		" AND {$dc}_expression.language_id=" . $languageId .
		" AND {$dc}_defined_meaning.defined_meaning_id = "; 

    # Build atomic queries
	$definedMeaningIdsCopy = $definedMeaningIds;
    foreach ($definedMeaningIdsCopy as &$value) {$value = $frontQuery . $value; }
    unset($value);
	# Union of the atoms
    return implode(' UNION ',$definedMeaningIdsCopy);
}


function fetchDefinedMeaningReferenceRecords($sql, array &$definedMeaningIds, array &$definedMeaningReferenceRecords, $usedAs='defined-meaning') {
	$dc=wdGetDataSetContext();
	$o=OmegaWikiAttributes::getInstance();

	$foundDefinedMeaningIds = array();	

	$dbr =& wfGetDB(DB_SLAVE);
	$queryResult = $dbr->query($sql);

	while ($row = $dbr->fetchObject($queryResult)) {
		$definedMeaningId = $row->defined_meaning_id;

		$specificStructure=clone $o->definedMeaningReferenceStructure;
		$specificStructure->setStructureType($usedAs);		
		$record = new ArrayRecord($specificStructure);
		$record->definedMeaningId = $definedMeaningId;
		$record->definedMeaningLabel = $row->label;
				
		$definedMeaningReferenceRecords[$definedMeaningId] = $record;
		$foundDefinedMeaningIds[] = $definedMeaningId;
	}
	
	$definedMeaningIds = array_diff($definedMeaningIds, $foundDefinedMeaningIds);
}


function fetchDefinedMeaningDefiningExpressions(array &$definedMeaningIds, array &$definedMeaningReferenceRecords) {
	$o=OmegaWikiAttributes::getInstance();

	$dc=wdGetDataSetContext();
	
	$dbr =& wfGetDB(DB_SLAVE);
	
	# Query building
	$frontQuery = "SELECT {$dc}_defined_meaning.defined_meaning_id AS defined_meaning_id, {$dc}_expression.spelling" .
		" FROM {$dc}_defined_meaning, {$dc}_expression " .
		" WHERE {$dc}_defined_meaning.expression_id={$dc}_expression.expression_id " .
		" AND " . getLatestTransactionRestriction("{$dc}_defined_meaning") .
		" AND " . getLatestTransactionRestriction("{$dc}_expression") . 
		" AND {$dc}_defined_meaning.defined_meaning_id = ";

    # Build atomic queries
	$definedMeaningIdsCopy = $definedMeaningIds;
    unset($value);	
    foreach ($definedMeaningIdsCopy as &$value) {$value = $frontQuery . $value; }
    unset($value);
	# Union of the atoms
    $finalQuery = implode(' UNION ',$definedMeaningIdsCopy);
	
	$queryResult = $dbr->query($finalQuery);

	while ($row = $dbr->fetchObject($queryResult)) {
		if (isset($definedMeaningReferenceRecords[$row->defined_meaning_id]))
			$definedMeaningReferenceRecord = $definedMeaningReferenceRecords[$row->defined_meaning_id];
		else
			$definedMeaningReferenceRecord = null;
		
		if ($definedMeaningReferenceRecord == null) {
			$definedMeaningReferenceRecord = new ArrayRecord($o->definedMeaningReferenceStructure);
			$definedMeaningReferenceRecord->definedMeaningId = $row->defined_meaning_id;
			$definedMeaningReferenceRecord->definedMeaningLabel = $row->spelling;
			$definedMeaningReferenceRecords[$row->defined_meaning_id] = $definedMeaningReferenceRecord; 
		}
		
		$definedMeaningReferenceRecord->definedMeaningDefiningExpression = $row->spelling;
	}		
}

function getNullDefinedMeaningReferenceRecord() {

	$o=OmegaWikiAttributes::getInstance();
	
	$record = new ArrayRecord($o->definedMeaningReferenceStructure);
	$record->definedMeaningId = 0;
	$record->definedMeaningLabel = "";
	$record->definedMeaningDefiningExpression = "";
	
	return $record;
}

function getDefinedMeaningReferenceRecords(array $definedMeaningIds, $usedAs) {
	global
		$wgUser;
	
//	$startTime = microtime(true);

	$result = array();
	$definedMeaningIdsForExpressions = $definedMeaningIds;

	if (count($definedMeaningIds) > 0) {
		global $wgRecordSetLanguage;
		
		if ($wgRecordSetLanguage > 0) {
			$userLanguage = $wgRecordSetLanguage;
		}
		else {
			$userLanguage = getLanguageIdForCode($wgUser->getOption('language'));
		}
		
		if ($userLanguage > 0)
			$definingLanguage = $userLanguage;
		else
			$definingLanguage = 85;
			
		fetchDefinedMeaningReferenceRecords(
			getDefiningSQLForLanguage($definingLanguage, $definedMeaningIds),
			$definedMeaningIds,
			$result,
			$usedAs
		);
	
		if (count($definedMeaningIds) > 0) {
			if ($userLanguage > 0)
				fetchDefinedMeaningReferenceRecords(
					getSynonymSQLForLanguage($userLanguage, $definedMeaningIds),
					$definedMeaningIds,
					$result,
					$usedAs
					
				);
	
			if (count($definedMeaningIds) > 0) {
				fetchDefinedMeaningReferenceRecords(
					getSynonymSQLForLanguage(85, $definedMeaningIds),
					$definedMeaningIds,
					$result,
					$usedAs
				);
		
				if (count($definedMeaningIds) > 0) {
					fetchDefinedMeaningReferenceRecords(
						getSynonymSQLForAnyLanguage($definedMeaningIds),
						$definedMeaningIds,
						$result,
						$usedAs
					);
				}
			}
		}
		
		fetchDefinedMeaningDefiningExpressions($definedMeaningIdsForExpressions, $result);
		$result[0] = getNullDefinedMeaningReferenceRecord();
	}

//	$queriesTime = microtime(true) - $startTime;
//	echo "<!-- Defined meaning reference queries: " . $queriesTime . " -->\n";

	return $result;
}

function expandDefinedMeaningReferencesInRecordSet(RecordSet $recordSet, array $definedMeaningAttributes) {
	$definedMeaningReferenceRecords=array();

	foreach($definedMeaningAttributes as $dmatt) {
		$tmpArray = getDefinedMeaningReferenceRecords(getUniqueIdsInRecordSet($recordSet, array($dmatt)), $dmatt->id);
		$definedMeaningReferenceRecords+=$tmpArray;

	}

	for ($i = 0; $i < $recordSet->getRecordCount(); $i++) {
		$record = $recordSet->getRecord($i);
		foreach($definedMeaningAttributes as $definedMeaningAttribute)
			$record->setAttributeValue(
				$definedMeaningAttribute, 
				$definedMeaningReferenceRecords[$record->getAttributeValue($definedMeaningAttribute)]
			);
	} 
}

function expandTranslatedContentInRecord(Record $record, Attribute $idAttribute, Attribute $translatedContentAttribute, ViewInformation $viewInformation) {
	$record->setAttributeValue(
		$translatedContentAttribute, 
		getTranslatedContentValue($record->getAttributeValue($idAttribute), $viewInformation)
	);
}

function expandTranslatedContentsInRecordSet(RecordSet $recordSet, Attribute $idAttribute, Attribute $translatedContentAttribute, ViewInformation $viewInformation) {
	for ($i = 0; $i < $recordSet->getRecordCount(); $i++) 
		expandTranslatedContentInRecord($recordSet->getRecord($i), $idAttribute, $translatedContentAttribute, $viewInformation);
}									

function getExpressionReferenceRecords($expressionIds) {
	$o=OmegaWikiAttributes::getInstance();
	$dc=wdGetDataSetContext();

	if (count($expressionIds) > 0) {
		$dbr =& wfGetDB(DB_SLAVE);
		
        # Query building
		$frontQuery = "SELECT expression_id, language_id, spelling" .
			" FROM {$dc}_expression" .
			" WHERE expression_id = ";
		$queueQuery = " AND ". getLatestTransactionRestriction("{$dc}_expression");

        # Build atomic queries
        foreach ($expressionIds as &$value) {$value = $frontQuery . $value . $queueQuery; }
        unset($value);
		# Union of the atoms
        $finalQuery = implode(' UNION ',$expressionIds);
		
		$queryResult = $dbr->query($finalQuery);
		
		$result = array();
	
		while ($row = $dbr->fetchObject($queryResult)) {
			$record = new ArrayRecord($o->expressionStructure);
			$record->language = $row->language_id;
			$record->spelling = $row->spelling;
			
			$result[$row->expression_id] = $record;
		}
			
		return $result;
	}
	else
		return array();
}

function expandExpressionReferencesInRecordSet(RecordSet $recordSet, array $expressionAttributes) {
	$expressionReferenceRecords = getExpressionReferenceRecords(getUniqueIdsInRecordSet($recordSet, $expressionAttributes));

	for ($i = 0; $i < $recordSet->getRecordCount(); $i++) {
		$record = $recordSet->getRecord($i);
		
		foreach($expressionAttributes as $expressionAttribute)
			$record->setAttributeValue(
				$expressionAttribute, 
				$expressionReferenceRecords[$record->getAttributeValue($expressionAttribute)]
			);
	} 
}

function getExpressionSpellings(array $expressionIds) {
	$dc=wdGetDataSetContext();

	if (count($expressionIds) > 0) {
		$dbr =& wfGetDB(DB_SLAVE);
		
		# Prepare steady components
		$frontQuery = "SELECT expression_id, spelling FROM {$dc}_expression WHERE expression_id ="; 
        $queueQuery	= " AND ". getLatestTransactionRestriction("{$dc}_expression");
        # Build atomic queries
        foreach ($expressionIds as &$value) {$value = $frontQuery . $value . $queueQuery; }
        unset($value);
		# Union of the atoms
        $finalQuery = implode(' UNION ',$expressionIds);
		
		$queryResult = $dbr->query($finalQuery);
		
		$result = array();
	
		while ($row = $dbr->fetchObject($queryResult)) 
			$result[$row->expression_id] = $row->spelling;
			
		return $result;
	}
	else
		return array();
}

function expandExpressionSpellingsInRecordSet(RecordSet $recordSet, array $expressionAttributes) {
	$expressionSpellings = getExpressionSpellings(getUniqueIdsInRecordSet($recordSet, $expressionAttributes));

	for ($i = 0; $i < $recordSet->getRecordCount(); $i++) {
		$record = $recordSet->getRecord($i);
		
		foreach($expressionAttributes as $expressionAttribute)
			$record->setAttributeValue(
				$expressionAttribute, 
				$expressionSpellings[$record->getAttributeValue($expressionAttribute)]
			);
	} 
}

function getTextReferences(array $textIds) {
	$dc=wdGetDataSetContext();
	if (count($textIds) > 0) {
		$dbr =& wfGetDB(DB_SLAVE);
		
		# Query building
		$frontQuery = "SELECT text_id, text_text" .
			" FROM {$dc}_text" .
			" WHERE text_id = ";

        # Build atomic queries
        foreach ($textIds as &$value) {$value = $frontQuery . $value; }
        unset($value);
		# Union of the atoms
        $finalQuery = implode(' UNION ',$textIds);		
		
		$queryResult = $dbr->query($finalQuery);
		
		$result = array();
	
		while ($row = $dbr->fetchObject($queryResult)) 
			$result[$row->text_id] = $row->text_text;
			
		return $result;
	}
	else
		return array();
}

function expandTextReferencesInRecordSet(RecordSet $recordSet, array $textAttributes) {
	$textReferences = getTextReferences(getUniqueIdsInRecordSet($recordSet, $textAttributes));

	for ($i = 0; $i < $recordSet->getRecordCount(); $i++) {
		$record = $recordSet->getRecord($i);

		foreach($textAttributes as $textAttribute) {
			$textId = $record->getAttributeValue($textAttribute);
			
			if (isset($textReferences[$textId])) 
				$textValue = $textReferences[$textId]; 
			else
				$textValue = "";
			
			$record->setAttributeValue($textAttribute, $textValue);
		}
	} 
}

function getExpressionMeaningsRecordSet($expressionId, $exactMeaning, ViewInformation $viewInformation) {
	$o=OmegaWikiAttributes::getInstance();

	$dc=wdGetDataSetContext();
	$identicalMeaning = $exactMeaning ? 1 : 0;

	$recordSet = new ArrayRecordSet($o->expressionMeaningStructure, new Structure($o->definedMeaningId));

	$dbr =& wfGetDB(DB_SLAVE);
	$queryResult = $dbr->query(
		"SELECT defined_meaning_id FROM {$dc}_syntrans" .
		" WHERE expression_id=$expressionId AND identical_meaning=" . $identicalMeaning .
		" AND ". getLatestTransactionRestriction("{$dc}_syntrans")
	);

	while($definedMeaning = $dbr->fetchObject($queryResult)) {
		$definedMeaningId = $definedMeaning->defined_meaning_id;
		$dmModel=new DefinedMeaningModel($definedMeaningId, $viewInformation);
		$recordSet->addRecord(
			array(
				$definedMeaningId, 
				getDefinedMeaningDefinition($definedMeaningId), 
				$dmModel->getRecord()
			)
		);
	}

	return $recordSet;
}

function getExpressionMeaningsRecord($expressionId, ViewInformation $viewInformation) {
	$o=OmegaWikiAttributes::getInstance();
		
	$record = new ArrayRecord($o->expressionMeaningsStructure);
	$record->expressionExactMeanings = getExpressionMeaningsRecordSet($expressionId, true, $viewInformation);
	$record->expressionApproximateMeanings = getExpressionMeaningsRecordSet($expressionId, false, $viewInformation);
	
	return $record;
}

function getExpressionsRecordSet($spelling, ViewInformation $viewInformation, $dc=null) {
	$dc=wdGetDataSetContext($dc);
	$o=OmegaWikiAttributes::getInstance();

	$languageRestriction = $viewInformation->filterLanguageId != 0 ? " AND language_id=". $viewInformation->filterLanguageId : "";

	$dbr =& wfGetDB(DB_SLAVE);
	$sql=
		"SELECT expression_id, language_id " .
		" FROM {$dc}_expression" .
		" WHERE spelling=BINARY " . $dbr->addQuotes($spelling) .
		" AND " . getLatestTransactionRestriction("{$dc}_expression") .
		$languageRestriction .
		" AND EXISTS (" .
			"SELECT expression_id " .
			" FROM {$dc}_syntrans " .
			" WHERE {$dc}_syntrans.expression_id={$dc}_expression.expression_id" .
			" AND ". getLatestTransactionRestriction("{$dc}_syntrans") 
		.")";
	$queryResult = $dbr->query($sql);
	
	$result = new ArrayRecordSet($o->expressionsStructure, new Structure("expression-id", $o->expressionId));
	$languageStructure = new Structure("language", $o->language);

	while($expression = $dbr->fetchObject($queryResult)) {
		$expressionRecord = new ArrayRecord($languageStructure);
		$expressionRecord->language = $expression->language_id;

		$result->addRecord(array(
			$expression->expression_id, 
			$expressionRecord, 
			getExpressionMeaningsRecord($expression->expression_id, $viewInformation)
		));
	}

	return $result;
}

function getExpressionIdThatHasSynonyms($spelling, $languageId) {
	$dc=wdGetDataSetContext();

	$dbr =& wfGetDB(DB_SLAVE);
	$queryResult = $dbr->query(
		"SELECT expression_id, language_id " .
		" FROM {$dc}_expression" .
		" WHERE spelling=BINARY " . $dbr->addQuotes($spelling) .
		" AND " . getLatestTransactionRestriction("{$dc}_expression") .
		" AND language_id=$languageId" .
		" AND EXISTS (" .
			"SELECT expression_id " .
			" FROM {$dc}_syntrans " .
			" WHERE {$dc}_syntrans.expression_id={$dc}_expression.expression_id" .
			" AND ". getLatestTransactionRestriction("{$dc}_syntrans") 
		.")"
	);
	
	if ($expression = $dbr->fetchObject($queryResult)) 
		return $expression->expression_id;
	else
		return 0;
}
 

function getClassAttributesRecordSet($definedMeaningId, ViewInformation $viewInformation) {
	global
		$dataSet;

	$o=OmegaWikiAttributes::getInstance();

	$recordSet = queryRecordSet(
		$o->classAttributesStructure->getStructureType(),
		$viewInformation->queryTransactionInformation,
		$o->classAttributeId,
		new TableColumnsToAttributesMapping(
			new TableColumnsToAttribute(array('object_id'), $o->classAttributeId),
			new TableColumnsToAttribute(array('level_mid'), $o->classAttributeLevel),
			new TableColumnsToAttribute(array('attribute_mid'), $o->classAttributeAttribute),
			new TableColumnsToAttribute(array('attribute_type'),$o->classAttributeType)
		),
		$dataSet->classAttributes,
		array("class_mid=$definedMeaningId")
	);
	
	expandDefinedMeaningReferencesInRecordSet($recordSet, array($o->classAttributeLevel ,$o->classAttributeAttribute));
	expandOptionAttributeOptionsInRecordSet($recordSet, $o->classAttributeId, $viewInformation);

	return $recordSet;
}

function expandOptionAttributeOptionsInRecordSet(RecordSet $recordSet, Attribute $attributeIdAttribute, ViewInformation $viewInformation) {
	$o=OmegaWikiAttributes::getInstance();
	$recordSet->getStructure()->addAttribute($o->optionAttributeOptions);

	for ($i = 0; $i < $recordSet->getRecordCount(); $i++) {
		$record = $recordSet->getRecord($i);

		$record->optionAttributeOptions = getOptionAttributeOptionsRecordSet($record->getAttributeValue($attributeIdAttribute), $viewInformation);
	}
}

function getAlternativeDefinitionsRecordSet($definedMeaningId, ViewInformation $viewInformation) {
	global
		$dataSet;

	$o=OmegaWikiAttributes::getInstance();

	$recordSet = queryRecordSet(
		$o->alternativeDefinitionsStructure->getStructureType(),
		$viewInformation->queryTransactionInformation,
		$o->definitionId,
		new TableColumnsToAttributesMapping(
			new TableColumnsToAttribute(array('meaning_text_tcid'), $o->definitionId), 
			new TableColumnsToAttribute(array('source_id'), $o->source)
		),
		$dataSet->alternativeDefinitions,
		array("meaning_mid=$definedMeaningId")
	);

	$recordSet->getStructure()->addAttribute($o->alternativeDefinition);
	
	expandTranslatedContentsInRecordSet($recordSet, $o->definitionId, $o->alternativeDefinition, $viewInformation);									
	expandDefinedMeaningReferencesInRecordSet($recordSet, array($o->source));

	return $recordSet;
}

function getDefinedMeaningDefinitionRecord($definedMeaningId, ViewInformation $viewInformation) {
	$o=OmegaWikiAttributes::getInstance();
		
	$definitionId = getDefinedMeaningDefinitionId($definedMeaningId);
	$record = new ArrayRecord($o->definition->type);
	$record->translatedText = getTranslatedContentValue($definitionId, $viewInformation);
	
	$objectAttributesRecord = getObjectAttributesRecord($definitionId, $viewInformation, $o->objectAttributes->id);
	$record->objectAttributes = $objectAttributesRecord;
	
	applyPropertyToColumnFiltersToRecord($record, $objectAttributesRecord, $viewInformation);

	return $record;
}

function applyPropertyToColumnFiltersToRecord(Record $destinationRecord, Record $sourceRecord, ViewInformation $viewInformation) {
	foreach ($viewInformation->getPropertyToColumnFilters() as $propertyToColumnFilter) { 
		$destinationRecord->setAttributeValue(
			$propertyToColumnFilter->getAttribute(), 
			filterObjectAttributesRecord($sourceRecord, $propertyToColumnFilter->attributeIDs)
		);		
	}
}

function applyPropertyToColumnFiltersToRecordSet(RecordSet $recordSet, Attribute $sourceAttribute, ViewInformation $viewInformation) {
	for ($i = 0; $i < $recordSet->getRecordCount(); $i++) {
		$record = $recordSet->getRecord($i);
		$attributeValuesRecord = $recordSet->getAttributeValue($sourceAttribute);
		
		applyPropertyToColumnFiltersToRecord($record, $attributeValuesRecord, $viewInformation);
	}	
}

function getObjectAttributesRecord($objectId, ViewInformation $viewInformation, $structuralOverride = null) {
	$o=OmegaWikiAttributes::getInstance();

	if ($structuralOverride) 
		$record = new ArrayRecord(new Structure($structuralOverride, $o->definedMeaningAttributes->type->getAttributes()));
	else 
		$record = new ArrayRecord($o->definedMeaningAttributes->type);
	
	$record->objectId = $objectId;
	$record->relations = getDefinedMeaningAttributeValuesRecordSet(array($objectId), $viewInformation);
	$record->textAttributeValues = getTextAttributesValuesRecordSet(array($objectId), $viewInformation);
	$record->translatedTextAttributeValues = getTranslatedTextAttributeValuesRecordSet(array($objectId), $viewInformation);
	$record->linkAttributeValues = getLinkAttributeValuesRecordSet(array($objectId), $viewInformation);	
	$record->optionAttributeValues = getOptionAttributeValuesRecordSet(array($objectId), $viewInformation);	

	return $record;
}

function filterAttributeValues(RecordSet $sourceRecordSet, Attribute $attributeAttribute, array &$attributeIds) {
	$result = new ArrayRecordSet($sourceRecordSet->getStructure(), $sourceRecordSet->getKey());
	$i = 0; 
	
	while ($i < $sourceRecordSet->getRecordCount()) {
		$record = $sourceRecordSet->getRecord($i);
		
		if (in_array($record->getAttributeValue($attributeAttribute)->definedMeaningId, $attributeIds)) {
			$result->add($record);
			$sourceRecordSet->remove($i);		
		}
		else
			$i++;
	}
	
	return $result;
}

function filterObjectAttributesRecord(Record $sourceRecord, array &$attributeIds) {
	$o=OmegaWikiAttributes::getInstance();
	
	$result = new ArrayRecord($sourceRecord->getStructure());
	$result->objectId = $sourceRecord->objectId;
	
	$result->setAttributeValue($o->relations, filterAttributeValues(
		$sourceRecord->relations, 
		$o->relationType,
		$attributeIds
	));
	
	$result->setAttributeValue($o->textAttributeValues, filterAttributeValues(
		$sourceRecord->textAttributeValues, 
		$o->textAttribute,
		$attributeIds
	));
	
	$result->setAttributeValue($o->translatedTextAttributeValues, filterAttributeValues( 
		$sourceRecord->translatedTextAttributeValues,
		$o->translatedTextAttribute,
		$attributeIds
	));
	
	$result->setAttributeValue($o->linkAttributeValues, filterAttributeValues(
		$sourceRecord->linkAttributeValues, 
		$o->linkAttribute,
		$attributeIds
	));	
	
	$result->setAttributeValue($o->optionAttributeValues, filterAttributeValues(
		$sourceRecord->optionAttributeValues,
		$o->optionAttribute,
		$attributeIds
	));	
	
	return $result;
}

function getTranslatedContentValue($translatedContentId, ViewInformation $viewInformation) {
	$o=OmegaWikiAttributes::getInstance();
	
	if ($viewInformation->filterLanguageId == 0) {
		return getTranslatedContentRecordSet($translatedContentId, $viewInformation);
	
	} 
	else {
		$recordSet = getFilteredTranslatedContentRecordSet($translatedContentId, $viewInformation);
		
		if (count($viewInformation->queryTransactionInformation->versioningAttributes()) > 0) 
			return $recordSet;
		else {
			if ($recordSet->getRecordCount() > 0) 
				return $recordSet->getRecord(0)->text;
			else	
				return "";
		}
	}
}

function getTranslatedContentRecordSet($translatedContentId, ViewInformation $viewInformation) {
	global
		$dataSet;

	$o=OmegaWikiAttributes::getInstance();

	$recordSet = queryRecordSet(
		$o->translatedTextStructure->getStructureType(),
		$viewInformation->queryTransactionInformation,
		$o->language,
		new TableColumnsToAttributesMapping(
			new TableColumnsToAttribute(array('language_id'), $o->language), 
			new TableColumnsToAttribute(array('text_id'), $o->text)
		),
		$dataSet->translatedContent,
		array("translated_content_id=$translatedContentId")
	);
	
	expandTextReferencesInRecordSet($recordSet, array($o->text));
	
	return $recordSet;
} 

function getFilteredTranslatedContentRecordSet($translatedContentId, ViewInformation $viewInformation) {
	global
		$dataSet;
	
	$o=OmegaWikiAttributes::getInstance();

	$recordSet = queryRecordSet(
		null,
		$viewInformation->queryTransactionInformation,
		$o->language,
		new TableColumnsToAttributesMapping(
			new TableColumnsToAttribute(array('language_id'), $o->language), 
			new TableColumnsToAttribute(array('text_id'), $o->text)
		),
		$dataSet->translatedContent,
		array(
			"translated_content_id=$translatedContentId",
			"language_id=" . $viewInformation->filterLanguageId
		)
	);
	
	expandTextReferencesInRecordSet($recordSet, array($o->text));
	
	return $recordSet;
}

function getSynonymAndTranslationRecordSet($definedMeaningId, ViewInformation $viewInformation) {
	global
		$dataSet;

	$o=OmegaWikiAttributes::getInstance();
	$dc=wdGetDataSetContext();

	$restrictions = array("defined_meaning_id=$definedMeaningId");
	if ($viewInformation->filterLanguageId != 0) 
		$restrictions[] =
			"expression_id IN (" .
				"SELECT expressions.expression_id" .
				" FROM {$dc}_expression AS expressions" .
				" WHERE expressions.expression_id=expression_id" .
				" AND language_id=" . $viewInformation->filterLanguageId .
				" AND " . getLatestTransactionRestriction('expressions') .
			")";
	
	$recordSet = queryRecordSet(
		$o->synonymsTranslationsStructure->getStructureType(),
		$viewInformation->queryTransactionInformation,
		$o->syntransId,
		new TableColumnsToAttributesMapping(
			new TableColumnsToAttribute(array('syntrans_sid'), $o->syntransId), 
			new TableColumnsToAttribute(array('expression_id'), $o->expression),
			new TableColumnsToAttribute(array('identical_meaning'),$o->identicalMeaning)
		),
		$dataSet->syntrans,
		$restrictions
	);
	
	if ($viewInformation->filterLanguageId == 0)
		expandExpressionReferencesInRecordSet($recordSet, array($o->expression));
	else
		expandExpressionSpellingsInRecordSet($recordSet, array($o->expression));

	expandObjectAttributesAttribute($recordSet, $o->objectAttributes, $o->syntransId, $viewInformation);
	return $recordSet;
}

function expandObjectAttributesAttribute(RecordSet $recordSet, Attribute $attributeToExpand, Attribute $objectIdAttribute, ViewInformation $viewInformation) {
	$o=OmegaWikiAttributes::getInstance();
		
	$recordSetStructure = $recordSet->getStructure();
	$recordSetStructure->addAttribute($attributeToExpand);
	
	foreach ($viewInformation->getPropertyToColumnFilters() as $propertyToColumnFilter)
		$recordSetStructure->addAttribute($propertyToColumnFilter->getAttribute());
			
	$objectAttributesRecordStructure = $attributeToExpand->type;
	$objectIds = getUniqueIdsInRecordSet($recordSet, array($objectIdAttribute));
	
	if (count($objectIds) > 0) {
		for ($i = 0; $i < count($objectIds); $i++) 
			if (isset($objectIds[$i])) {
				$record = new ArrayRecord($objectAttributesRecordStructure);
				$objectAttributesRecords[$objectIds[$i]] = $record;
			}

		// Defined meaning attributes		
		$allDefinedMeaningAttributeValuesRecordSet = getDefinedMeaningAttributeValuesRecordSet($objectIds, $viewInformation); 
		$definedMeaningAttributeValuesRecordSets = 
			splitRecordSet(
				$allDefinedMeaningAttributeValuesRecordSet,
				$o->relationType
			);	
			
		$emptyDefinedMeaningAttributesRecordSet = new ArrayRecordSet($allDefinedMeaningAttributeValuesRecordSet->getStructure(), $allDefinedMeaningAttributeValuesRecordSet->getKey());
		
		// Text attributes		
		$allTextAttributeValuesRecordSet = getTextAttributesValuesRecordSet($objectIds, $viewInformation); 
		$textAttributeValuesRecordSets = 
			splitRecordSet(
				$allTextAttributeValuesRecordSet,
				$o->textAttributeObject
			);	
			
		$emptyTextAttributesRecordSet = new ArrayRecordSet($allTextAttributeValuesRecordSet->getStructure(), $allTextAttributeValuesRecordSet->getKey());
		
		// Translated text attributes	
		$allTranslatedTextAttributeValuesRecordSet = getTranslatedTextAttributeValuesRecordSet($objectIds, $viewInformation); 
		$translatedTextAttributeValuesRecordSets = 
			splitRecordSet(
				$allTranslatedTextAttributeValuesRecordSet,
				$o->attributeObject
			);	
			
		$emptyTranslatedTextAttributesRecordSet = new ArrayRecordSet($allTranslatedTextAttributeValuesRecordSet->getStructure(), $allTranslatedTextAttributeValuesRecordSet->getKey());

		// Link attributes		
		$allLinkAttributeValuesRecordSet = getLinkAttributeValuesRecordSet($objectIds, $viewInformation); 
		$linkAttributeValuesRecordSets = 
			splitRecordSet(
				$allLinkAttributeValuesRecordSet,
				$o->linkAttributeObject
			);	
			
		$emptyLinkAttributesRecordSet = new ArrayRecordSet($allLinkAttributeValuesRecordSet->getStructure(), $allLinkAttributeValuesRecordSet->getKey());
		
		// Option attributes		
		$allOptionAttributeValuesRecordSet = getOptionAttributeValuesRecordSet($objectIds, $viewInformation); 
		$optionAttributeValuesRecordSets = 
			splitRecordSet(
				$allOptionAttributeValuesRecordSet,
				$o->optionAttributeObject
			);	
			
		
		$emptyOptionAttributesRecordSet = new ArrayRecordSet($allOptionAttributeValuesRecordSet->getStructure(), $allOptionAttributeValuesRecordSet->getKey());
		
		for ($i = 0; $i < $recordSet->getRecordCount(); $i++) {
			$record = $recordSet->getRecord($i);
			$objectId = $record->getAttributeValue($objectIdAttribute);
			
			// Defined meaning attributes
			if (isset($definedMeaningAttributeValuesRecordSets[$objectId]))
				$definedMeaningAttributeValuesRecordSet = $definedMeaningAttributeValuesRecordSets[$objectId];
			else 
				$definedMeaningAttributeValuesRecordSet = $emptyDefinedMeaningAttributesRecordSet;

			// Text attributes
			if (isset($textAttributeValuesRecordSets[$objectId]))
				$textAttributeValuesRecordSet = $textAttributeValuesRecordSets[$objectId];
			else 
				$textAttributeValuesRecordSet = $emptyTextAttributesRecordSet;

			// Translated text attributes
			if (isset($translatedTextAttributeValuesRecordSets[$objectId]))
				$translatedTextAttributeValuesRecordSet = $translatedTextAttributeValuesRecordSets[$objectId];				
			else 
				$translatedTextAttributeValuesRecordSet = $emptyTranslatedTextAttributesRecordSet;

			// Link attributes
			if (isset($linkAttributeValuesRecordSets[$objectId]))
				$linkAttributeValuesRecordSet = $linkAttributeValuesRecordSets[$objectId];
			else 
				$linkAttributeValuesRecordSet = $emptyLinkAttributesRecordSet;

			// Option attributes
			if (isset($optionAttributeValuesRecordSets[$objectId]))
				$optionAttributeValuesRecordSet = $optionAttributeValuesRecordSets[$objectId]; 
			else
				$optionAttributeValuesRecordSet = $emptyOptionAttributesRecordSet;

			$objectAttributesRecord = new ArrayRecord($objectAttributesRecordStructure);
			$objectAttributesRecord->objectId = $objectId;
			$objectAttributesRecord->relations = $definedMeaningAttributeValuesRecordSet;
			$objectAttributesRecord->textAttributeValues = $textAttributeValuesRecordSet;
			$objectAttributesRecord->translatedTextAttributeValues = $translatedTextAttributeValuesRecordSet;
			$objectAttributesRecord->linkAttributeValues = $linkAttributeValuesRecordSet;
			$objectAttributesRecord->optionAttributeValues = $optionAttributeValuesRecordSet;
			
			$record->setAttributeValue($attributeToExpand, $objectAttributesRecord);
			applyPropertyToColumnFiltersToRecord($record, $objectAttributesRecord, $viewInformation);
		}
	}	
}

function getDefinedMeaningReferenceRecord($definedMeaningId) {
	$o=OmegaWikiAttributes::getInstance();
	
	$record = new ArrayRecord($o->definedMeaningReferenceStructure);
	$record->definedMeaningId = $definedMeaningId;
	$record->definedMeaningLabel = definedMeaningExpression($definedMeaningId);
	$record->definedMeaningDefiningExpression = definingExpression($definedMeaningId);
	
	return $record;
}

function getDefinedMeaningAttributeValuesRecordSet(array $objectIds, ViewInformation $viewInformation) {
	global
		$dataSet;

	$o=OmegaWikiAttributes::getInstance();

	$recordSet = queryRecordSet(
		$o->relationStructure->getStructureType(),
		$viewInformation->queryTransactionInformation,
		$o->relationId,
		new TableColumnsToAttributesMapping(
			new TableColumnsToAttribute(array('relation_id'), $o->relationId), 
			new TableColumnsToAttribute(array('relationtype_mid'), $o->relationType), 
			new TableColumnsToAttribute(array('meaning2_mid'), $o->otherDefinedMeaning)
		),
		$dataSet->meaningRelations,
		array("meaning1_mid IN (" . implode(", ", $objectIds) . ")"),
		array('add_transaction_id')
	);
	
	expandDefinedMeaningReferencesInRecordSet($recordSet, array($o->relationType, $o->otherDefinedMeaning));
	expandObjectAttributesAttribute($recordSet, $o->objectAttributes, $o->relationId, $viewInformation);
	
	return $recordSet;
}

function getDefinedMeaningReciprocalRelationsRecordSet($definedMeaningId, ViewInformation $viewInformation) {
	global
		$dataSet;

	$o=OmegaWikiAttributes::getInstance();
	$recordSet = queryRecordSet(
		$o->reciprocalRelations->id,
		$viewInformation->queryTransactionInformation,
		$o->relationId,
		new TableColumnsToAttributesMapping(
			new TableColumnsToAttribute(array('relation_id'), $o->relationId), 
			new TableColumnsToAttribute(array('relationtype_mid'), $o->relationType), 
			new TableColumnsToAttribute(array('meaning1_mid'), $o->otherDefinedMeaning)
		),
		$dataSet->meaningRelations,
		array("meaning2_mid=$definedMeaningId"),
		array('relationtype_mid')
	);
	
	expandDefinedMeaningReferencesInRecordSet($recordSet, array($o->relationType, $o->otherDefinedMeaning));
	expandObjectAttributesAttribute($recordSet, $o->objectAttributes, $o->relationId, $viewInformation);
	
	return $recordSet;
}

function getGotoSourceRecord($record) {
	$o=OmegaWikiAttributes::getInstance();
		
	$result = new ArrayRecord($o->gotoSourceStructure);
	$result->collectionId = $record->collectionId;
	$result->sourceIdentifier = $record->sourceIdentifier;
	
	return $result;
}

function getDefinedMeaningCollectionMembershipRecordSet($definedMeaningId, ViewInformation $viewInformation) {
	global
		$dataSet;

	$o=OmegaWikiAttributes::getInstance();

	$recordSet = queryRecordSet(
		$o->collectionMembershipStructure->getStructureType(),
		$viewInformation->queryTransactionInformation,
		$o->collectionId,
		new TableColumnsToAttributesMapping(
			new TableColumnsToAttribute(array('collection_id'), $o->collectionId),
			new TableColumnsToAttribute(array('internal_member_id'), $o->sourceIdentifier)
		),
		$dataSet->collectionMemberships,
		array("member_mid=$definedMeaningId")
	);

	$structure = $recordSet->getStructure();
	$structure->addAttribute($o->collectionMeaning);
	$structure->addAttribute($o->gotoSource);

	for ($i = 0; $i < $recordSet->getRecordCount(); $i++) {
		$record = $recordSet->getRecord($i);
		$record->collectionMeaning = getCollectionMeaningId($record->collectionId);
		$record->gotoSource = getGotoSourceRecord($record);	
	}
	
	expandDefinedMeaningReferencesInRecordSet($recordSet, array($o->collectionMeaning));
	
	return $recordSet;
}

function getTextAttributesValuesRecordSet(array $objectIds, ViewInformation $viewInformation) {
	global
		$dataSet;

	$o=OmegaWikiAttributes::getInstance();

	$recordSet = queryRecordSet(
		$o->textAttributeValuesStructure->getStructureType(),
		$viewInformation->queryTransactionInformation,
		$o->textAttributeId,
		new TableColumnsToAttributesMapping(
			new TableColumnsToAttribute(array('value_id'), $o->textAttributeId),
			new TableColumnsToAttribute(array('object_id'), $o->textAttributeObject),
			new TableColumnsToAttribute(array('attribute_mid'), $o->textAttribute),
			new TableColumnsToAttribute(array('text'), $o->text)
		),
		$dataSet->textAttributeValues,
		array("object_id IN (" . implode(", ", $objectIds) . ")")
	);
	
	expandDefinedMeaningReferencesInRecordSet($recordSet, array($o->textAttribute));
	expandObjectAttributesAttribute($recordSet, $o->objectAttributes, $o->textAttributeId, $viewInformation);	
	
	return $recordSet;
}

function getLinkAttributeValuesRecordSet(array $objectIds, ViewInformation $viewInformation) {
	global
		$dataSet;

	$o=OmegaWikiAttributes::getInstance();
	$recordSet = queryRecordSet(
		$o->linkAttributeValuesStructure->getStructureType(),
		$viewInformation->queryTransactionInformation,
		$o->linkAttributeId,
		new TableColumnsToAttributesMapping(
			new TableColumnsToAttribute(array('value_id'), $o->linkAttributeId),
			new TableColumnsToAttribute(array('object_id'), $o->linkAttributeObject),
			new TableColumnsToAttribute(array('attribute_mid'), $o->linkAttribute),
			new TableColumnsToAttribute(array('label', 'url'), $o->link)
		),
		$dataSet->linkAttributeValues,
		array("object_id IN (" . implode(", ", $objectIds) . ")")
	);
	
	expandDefinedMeaningReferencesInRecordSet($recordSet, array($o->linkAttribute));
	expandObjectAttributesAttribute($recordSet, $o->objectAttributes, $o->linkAttributeId, $viewInformation);	
	
	return $recordSet;
}

function getTranslatedTextAttributeValuesRecordSet(array $objectIds, ViewInformation $viewInformation) {
	global
		 $dataSet;

	$o=OmegaWikiAttributes::getInstance();

	$recordSet = queryRecordSet(
		$o->translatedTextAttributeValuesStructure->getStructureType(),
		$viewInformation->queryTransactionInformation,
		$o->translatedTextAttributeId,
		new TableColumnsToAttributesMapping(
			new TableColumnsToAttribute(array('value_id'), $o->translatedTextAttributeId),
			new TableColumnsToAttribute(array('object_id'), $o->attributeObject),
			new TableColumnsToAttribute(array('attribute_mid'), $o->translatedTextAttribute),
			new TableColumnsToAttribute(array('value_tcid'), $o->translatedTextValueId)
		),
		$dataSet->translatedContentAttributeValues,
		array("object_id IN (" . implode(", ", $objectIds) . ")")
	);
	
	$recordSet->getStructure()->addAttribute($o->translatedTextValue);
	
	expandTranslatedContentsInRecordSet($recordSet, $o->translatedTextValueId, $o->translatedTextValue, $viewInformation);
	expandDefinedMeaningReferencesInRecordSet($recordSet, array($o->translatedTextAttribute));
	expandObjectAttributesAttribute($recordSet, $o->objectAttributes, $o->translatedTextAttributeId, $viewInformation);
	return $recordSet;
}

function getOptionAttributeOptionsRecordSet($attributeId, ViewInformation $viewInformation) {
	global
		$dataSet;

	$o=OmegaWikiAttributes::getInstance();
	$recordSet = queryRecordSet(
		null,
		$viewInformation->queryTransactionInformation,
		$o->optionAttributeOptionId,
		new TableColumnsToAttributesMapping(
			new TableColumnsToAttribute(array('option_id'), $o->optionAttributeOptionId),
			new TableColumnsToAttribute(array('attribute_id'), $o->optionAttribute),
			new TableColumnsToAttribute(array('option_mid'), $o->optionAttributeOption),
			new TableColumnsToAttribute(array('language_id'), $o->language)
		),
		$dataSet->optionAttributeOptions,
		array('attribute_id = ' . $attributeId)
	);

	expandDefinedMeaningReferencesInRecordSet($recordSet, array($o->optionAttributeOption));

	return $recordSet;
}

function getOptionAttributeValuesRecordSet(array $objectIds, ViewInformation $viewInformation) {
	global
		$dataSet;

	$o=OmegaWikiAttributes::getInstance();
	$recordSet = queryRecordSet(
		$o->optionAttributeValuesStructure->getStructureType(),
		$viewInformation->queryTransactionInformation,
		$o->optionAttributeId,
		new TableColumnsToAttributesMapping(
			new TableColumnsToAttribute(array('value_id'), $o->optionAttributeId),
			new TableColumnsToAttribute(array('object_id'), $o->optionAttributeObject),
			new TableColumnsToAttribute(array('option_id'), $o->optionAttributeOptionId)
		),
		$dataSet->optionAttributeValues,
		array("object_id IN (" . implode(", ", $objectIds) . ")")
	);

	expandOptionsInRecordSet($recordSet, $viewInformation);
	expandDefinedMeaningReferencesInRecordSet($recordSet, array($o->optionAttribute, $o->optionAttributeOption));
	expandObjectAttributesAttribute($recordSet, $o->objectAttributes, $o->optionAttributeId, $viewInformation);

	return $recordSet;
}

/* XXX: This can probably be combined with other functions. In fact, it probably should be. Do it. */
function expandOptionsInRecordSet(RecordSet $recordSet, ViewInformation $viewInformation) {
	global
		$dataSet;

	$o=OmegaWikiAttributes::getInstance();

	$recordSet->getStructure()->addAttribute($o->optionAttributeOption);
	$recordSet->getStructure()->addAttribute($o->optionAttribute);

	for ($i = 0; $i < $recordSet->getRecordCount(); $i++) {
		$record = $recordSet->getRecord($i);

		$optionRecordSet = queryRecordSet(
			null,
			$viewInformation->queryTransactionInformation,
			$o->optionAttributeOptionId,
			new TableColumnsToAttributesMapping(
				new TableColumnsToAttribute(array('attribute_id'), $o->optionAttributeId),
				new TableColumnsToAttribute(array('option_mid'), $o->optionAttributeOption)
			),
			$dataSet->optionAttributeOptions,
			array('option_id = ' . $record->optionAttributeOptionId)
		);

		$optionRecord = $optionRecordSet->getRecord(0);
		$record->optionAttributeOption = $optionRecord->optionAttributeOption;

		$optionRecordSet = queryRecordSet(
			null,
			$viewInformation->queryTransactionInformation,
			$o->optionAttributeId,
			new TableColumnsToAttributesMapping(new TableColumnsToAttribute(array('attribute_mid'), $o->optionAttribute)),
			$dataSet->classAttributes,
			array('object_id = ' . $optionRecord->optionAttributeId)
		);
	
		$optionRecord = $optionRecordSet->getRecord(0);
		$record->optionAttribute = $optionRecord->optionAttribute;
	} 
}

function getDefinedMeaningClassMembershipRecordSet($definedMeaningId, ViewInformation $viewInformation) {
	global
		$dataSet;

	$o=OmegaWikiAttributes::getInstance();

	$recordSet = queryRecordSet(
		$o->classMembershipStructure->getStructureType(),
		$viewInformation->queryTransactionInformation,
		$o->classMembershipId,
		new TableColumnsToAttributesMapping(
			new TableColumnsToAttribute(array('class_membership_id'), $o->classMembershipId), 
			new TableColumnsToAttribute(array('class_mid'), $o->class)
		),
		$dataSet->classMemberships,
		array("class_member_mid=$definedMeaningId")
	);
	
	expandDefinedMeaningReferencesInRecordSet($recordSet, array($o->class));
	
	return $recordSet;
}

function getDefiningExpressionRecord($definedMeaningId) {

		$o=OmegaWikiAttributes::getInstance();

		$definingExpression=definingExpressionRow($definedMeaningId);
		$definingExpressionRecord = new ArrayRecord($o->definedMeaningCompleteDefiningExpression->type);
		$definingExpressionRecord->expressionId = $definingExpression[0];
		$definingExpressionRecord->definedMeaningDefiningExpression = $definingExpression[1];
		$definingExpressionRecord->language = $definingExpression[2];
		return $definingExpressionRecord;
}
