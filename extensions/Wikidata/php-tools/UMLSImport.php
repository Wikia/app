<?php
define('MEDIAWIKI', true );
require_once("../../../LocalSettings.php");
require_once("../OmegaWiki/WikiDataAPI.php");

require_once("ProgressBar.php");
require_once("Setup.php");

class UMLSImportResult {
	public $umlsCollectionId;
	public $sourceAbbreviations = array();
}

/* 
 * Import UMLS entirely. Be sure to have started a transaction first!
 */
function importUMLSFromDatabase($server, $databaseName, $userName, $password, $sources = null) {
	$result = new UMLSImportResult;

	openDatabase($server, $databaseName, $userName, $password);
	
	$languageId = 85;
	echo "Creating UMLS collections\n";
	$umlsCollectionId = bootstrapCollection("UMLS", $languageId, "");
	$result->umlsCollectionId = $umlsCollectionId;
	
	$relationCollectionId = bootstrapCollection("UMLS Relation Types 2005", $languageId, "RELT");
	addDefinedMeaningToCollection(getCollectionMeaningId($relationCollectionId), $umlsCollectionId, "rel");
	$relationAttributesCollectionId = bootstrapCollection("UMLS Relation Attributes 2005", $languageId, "RELT");
	addDefinedMeaningToCollection($relationAttributesCollectionId, $umlsCollectionId, "rela");
	$semanticNetworkSemanticTypesCollectionId = bootstrapCollection("Semantic Network 2005AC Semantic Types", $languageId, "CLAS");
	addDefinedMeaningToCollection(getCollectionMeaningId($semanticNetworkSemanticTypesCollectionId), $umlsCollectionId, "STY");
	$semanticNetworkRelationTypesCollectionId = bootstrapCollection("Semantic Network 2005AC Relation Types", $languageId, "RELT");
	addDefinedMeaningToCollection(getCollectionMeaningId($semanticNetworkRelationTypesCollectionId), $umlsCollectionId, "RL");
	
	echo "Loading source abbreviations\n";
	$sourceAbbreviations = loadSourceAbbreviations($sources);
	
	echo "Loading languages\n";
	$isoLanguages = loadIsoLanguages();
	
	echo "Importing UMLS terms per source\n";
	$i = 1;
	foreach ($sourceAbbreviations as $sab => $source) {
		$collectionId = bootstrapCollection($source, $languageId, "");
		$result->sourceAbbreviations[$sab] = $collectionId;
		echo "  $i: $sab - $source\n";
		importUMLSTerms($sab, $umlsCollectionId, $collectionId, $languageId, $isoLanguages);
		$i++;				
	}
	
	echo "Importing UMLS definitions per source\n";
	$i = 1;
	foreach ($sourceAbbreviations as $sab => $source) {
		echo "  $i: $sab - $source\n";
		importUMLSDefinitions($sab, $umlsCollectionId, $result->sourceAbbreviations[$sab], $languageId);
		$i++;				
	}
	
	echo "Importing UMLS relation types\n";
	importUMLSRelationTypes($relationCollectionId, $languageId);
	
	echo "Importing UMLS attribute types\n";
	importUMLSRelationAttributes($relationAttributesCollectionId, $languageId);
	
	echo "Importing UMLS relations per source\n";
	$relationCollection = getCollectionContents($relationCollectionId);
	$relationAttributesCollection = getCollectionContents($relationAttributesCollectionId);
	$i = 1;
	
	foreach ($sourceAbbreviations as $sab => $source) {
		echo "  $i: $sab - $source\n";
		
		$query = "select cui1, cui2, rel from MRREL where sab like '$sab'";
		importUMLSRelations($umlsCollectionId , $relationCollection, $query);
		
		$query = "select cui1, cui2, rela from MRREL where sab like '$sab' and rela!=''";
		importUMLSRelations($umlsCollectionId , $relationAttributesCollection, $query);
		$i++;	 		
	}
	
	echo "Importing semantic network types\n";
	importSNTypes($semanticNetworkSemanticTypesCollectionId, "SELECT semtypeab,type,definition FROM srdef WHERE type='STY'", $languageId);
	importSNTypes($semanticNetworkRelationTypesCollectionId, "SELECT semtypeab,type,definition FROM srdef WHERE type='RL'", $languageId);
	
	echo "Importing semantic network relations\n";
	importSemanticTypeRelations($semanticNetworkSemanticTypesCollectionId, $relationCollection, "SELECT SEMTYPE1, RELATION, SEMTYPE2 from semtypehier");
	importSemanticTypeRelations($semanticNetworkRelationTypesCollectionId, $relationCollection, "SELECT RELTYPE1, RELATION, RELTYPE2 from semrelhier");
	
	echo "Importing UMLS semantic type relations per source\n";
	$attributeTypes = getCollectionContents($semanticNetworkSemanticTypesCollectionId);
	$i = 1;
	foreach ($sourceAbbreviations as $sab => $source) {
		echo "  " . $i++ . ": $sab - $source\n";
		importUMLSSemanticTypes($sab, $umlsCollectionId, $attributeTypes);	 		
	}
	
	return $result;
}

function openDatabase($server, $databaseName, $userName, $password) {
	global
		$db;
	
	if ($db = mysql_connect($server, $userName, $password, true))
		mysql_select_db($databaseName, $db);
}

function loadIsoLanguages(){
	$dbr = &wfGetDB(DB_SLAVE);
	$sql = "select language_id, iso639_2 from language";

	$languages = array();
	
	$queryResult = $dbr->query($sql);
	while ($language = $dbr->fetchObject($queryResult)) {
	   $languages[$language->iso639_2] = $language->language_id;
	}

	return $languages;  	
}

function loadSourceAbbreviations($sources = null) {
	global
		$db;
	
	$sourceAbbreviations = array();	
	$queryResult = mysql_query("select RSAB, SON from MRSAB", $db);
	
	while ($sab = mysql_fetch_object($queryResult)) 
   		if ($sources == null || in_array($sab->RSAB, $sources))
   			$sourceAbbreviations[$sab->RSAB] = str_replace('_', '-', $sab->SON);
		
	mysql_free_result($queryResult);
	
	return $sourceAbbreviations;  
}

function getSourceName($sourceAbbreviation) {
	global
		$db;
	
	$sourceAbbreviations = array();	
	$queryResult = mysql_query("select SON from MRSAB WHERE RSAB='$source'", $db);
	
	$sab = mysql_fetch_object($queryResult); 
	$result = $sab->SON;
		
	mysql_free_result($queryResult);
	
	return $result;  
}

function importUMLSTerms($sab, $umlsCollectionId, $sourceCollectionId, $languageId, $isoLanguages) {
	global
		$db;

	$queryResult = mysql_query("select str, cui, lat, code from MRCONSO where sab like '$sab'", $db);
	
	$progressBar = new ProgressBar(mysql_num_rows($queryResult), 100);

	$collectionMeaningId = getCollectionMeaningId($sourceCollectionId);

	while ($umlsTerm = mysql_fetch_object($queryResult)) {
		$definedMeaningId = getDefinedMeaningFromCollection($umlsCollectionId, $umlsTerm->cui);
		$string = str_replace('_', ' ', substr(trim($umlsTerm->str), 0, 240));
		$expression = findOrCreateExpression($string, $isoLanguages[strtolower($umlsTerm->lat)]);
		
		if (!$definedMeaningId) {
			$definedMeaningId = addDefinedMeaning($expression->id);
			addDefinedMeaningToCollection($definedMeaningId, $umlsCollectionId, $umlsTerm->cui);
		}

		$expression->assureIsBoundToDefinedMeaning($definedMeaningId, true);
		addDefinedMeaningToCollectionIfNotPresent($definedMeaningId, $sourceCollectionId, $umlsTerm->code);
		$progressBar->advance(1);
	}
	
	mysql_free_result($queryResult);
	$progressBar->clear();
}

function importUMLSDefinitions($sab, $umlsCollectionId, $sourceCollectionId, $languageId) {
	global
		$db;
	
	$queryResult = mysql_query("select def, cui from MRDEF where sab = '$sab'", $db);
	$progressBar = new ProgressBar(mysql_num_rows($queryResult), 100);

	$collectionMeaningId = getCollectionMeaningId($sourceCollectionId);

	while ($definition = mysql_fetch_object($queryResult)) {
		$definedMeaningId = getDefinedMeaningFromCollection($umlsCollectionId, $definition->cui);
		
		if ($definedMeaningId) {
			if (!getDefinedMeaningDefinitionId($definedMeaningId)) 
				addDefinedMeaningDefiningDefinition($definedMeaningId, $languageId, $definition->def);

			addDefinedMeaningAlternativeDefinition($definedMeaningId, $languageId, $definition->def, $collectionMeaningId);
		}
		
		$progressBar->advance(1);
	}
	
	mysql_free_result($queryResult);
	$progressBar->clear();
}

function importUMLSRelationTypes($relationCollectionId, $languageId) {
	global
		$db;
		
	$queryResult = mysql_query("select ABBREV, FULL from rel where ABBREV!='CHD' and ABBREV!='PAR' and ABBREV!='SUBX'", $db);
	while ($relationType = mysql_fetch_object($queryResult)) {
		$definedMeaningId = getDefinedMeaningFromCollection($relationCollectionId, $relationType->ABBREV);
		$expression = findOrCreateExpression(trim($relationType->FULL), $languageId);
		
		if (!$definedMeaningId) {
			$definedMeaningId = addDefinedMeaning($expression->id);
			$expression->assureIsBoundToDefinedMeaning($definedMeaningId, true);
			addDefinedMeaningToCollection($definedMeaningId, $relationCollectionId, $relationType->ABBREV);		
		}
	}
	
	mysql_free_result($queryResult);  
}

function importUMLSRelationAttributes($relationAttributesCollectionId, $languageId) {
	global
		$db;
		
	$queryResult = mysql_query("select ABBREV, FULL from rela", $db);
	while ($relationType = mysql_fetch_object($queryResult)) {
		$definedMeaningId = getDefinedMeaningFromCollection($relationAttributesCollectionId, $relationType->ABBREV);
		$expression = findOrCreateExpression(trim($relationType->FULL), $languageId);
		if(!$definedMeaningId) {
			$definedMeaningId = addDefinedMeaning($expression->id);
			$expression->assureIsBoundToDefinedMeaning($definedMeaningId, true);
			addDefinedMeaningToCollection($definedMeaningId, $relationAttributesCollectionId, $relationType->ABBREV);		
		}
	}
	
	mysql_free_result($queryResult);  	
}

function importUMLSRelations($umlsCollectionId, $relationCollectionContents, $query) {
	global
		$db;

	$queryResult = mysql_query($query, $db);
	$progressBar = new ProgressBar(mysql_num_rows($queryResult), 100);
	
	while ($relation = mysql_fetch_row($queryResult)) {
		$relationType = $relation[2];
		if(strcmp($relationType, 'CHD') == 0) {
			$relationType='RN';			
		}
		elseif(strcmp($relationType, 'PAR') == 0) {
			$relationType='RB';
		}
		
		//echo "$definedMeaningId1 = $relation[0]\n";
		$definedMeaningId1 = getDefinedMeaningFromCollection($umlsCollectionId, $relation[0]);
		$definedMeaningId2 = getDefinedMeaningFromCollection($umlsCollectionId, $relation[1]);
		$relationMeaningId = $relationCollectionContents[$relationType];

//		echo "$definedMeaningId1 = $relation[0]\n";
//		echo "$definedMeaningId1 = $relation[1]\n";
//		echo "umlsCollectionId = $umlsCollectionId\n";
		
		if(!$definedMeaningId1){
			echo "Unknown cui $relation[0]\n";
			print_r($relation);
		}
		if(!$definedMeaningId2){
			echo "Unknown cui $relation[1]\n";
			print_r($relation);
		}
		if(!$relationMeaningId){
			echo "Unknown relation $relationType\n";
			print_r($relationCollectionContents);
			print_r($relation);
		}
		
		if ($definedMeaningId2 > 0 && $definedMeaningId1 > 0 && $relationMeaningId > 0)
			addRelation($definedMeaningId2, $relationMeaningId, $definedMeaningId1);
				
		$progressBar->advance(1);	
	}	
	
	$progressBar->clear();
}

function importSNTypes($collectionId, $query, $languageId) {
	global
		$db;
	
	$queryResult = mysql_query($query, $db);
	while ($semanticNetworkType = mysql_fetch_object($queryResult)) {
		$expressionText = $semanticNetworkType->semtypeab;
		$expressionText = strtolower(str_replace("_", " ", $expressionText));
		$definedMeaningId = getDefinedMeaningFromCollection($collectionId, $semanticNetworkType->semtypeab);
		$expression = findOrCreateExpression($expressionText, $languageId);
		if(!$definedMeaningId) {
			$definedMeaningId = createNewDefinedMeaning($expression->id, $languageId, $semanticNetworkType->definition);
			addDefinedMeaningToCollection($definedMeaningId, $collectionId, $semanticNetworkType->semtypeab);		
		}
	}
	
	mysql_free_result($queryResult);  	
}

function importSemanticTypeRelations($collectionId, $relationCollectionContents, $query) {
	global
		$db;

	$queryResult = mysql_query($query, $db);
	while ($relation = mysql_fetch_row($queryResult)) {
		$relationType = $relation[1];
		
		$definedMeaningId1 = getDefinedMeaningFromCollection($collectionId, $relation[0]);
		$definedMeaningId2 = getDefinedMeaningFromCollection($collectionId, $relation[2]);
		$relationMeaningId = $relationCollectionContents[$relationType];
		
		if(!$relationMeaningId){
			echo "Unknown relation $relationType\n";
			print_r($relationCollectionContents);
			print_r($relation);
		}
		if(!$definedMeaningId1){
			echo "Unknown semantic type $relation[0]\n";
			print_r($relation);
		}
		if(!$definedMeaningId2){
			echo "Unknown semantic type $relation[2]\n";
			print_r($relation);
		}
	
		if ($definedMeaningId2 > 0 && $definedMeaningId1 > 0 && $relationMeaningId > 0)
			addRelation($definedMeaningId2, $relationMeaningId, $definedMeaningId1);		
	}	
}

function importUMLSSemanticTypes($sab, $collectionId, $attributeTypes) {
	global
		$db;

	$query = "SELECT MRSTY.CUI, MRSTY.STY FROM MRCONSO,MRSTY where MRCONSO.SAB like '$sab' and MRCONSO.CUI=MRSTY.CUI";

	if ($queryResult = mysql_query($query, $db)) {
		$progressBar->initialize(mysql_num_rows($queryResult), 100);
		
		while ($attribute = mysql_fetch_object($queryResult)) {
			$definedMeaningId = getDefinedMeaningFromCollection($collectionId, $attribute->CUI);
			$attributeMeaningId = $attributeTypes[$attribute->STY];
	
			if(!$definedMeaningId){
				echo "Unknown cui $attribute->CUI\n";
				print_r($attribute);
				echo "get definedmeaning from collection = $collectionId, $attribute->CUI\n";
				die;
			}
			if(!$attributeMeaningId){
				echo "Unknown attribute $attribute->STY\n";
				print_r($attribute);
				echo "get definedmeaning from collection = $collectionId, $attribute->CUI\n";
				die;
			}
		
			if ($definedMeaningId > 0 && $attributeMeaningId > 0)
				addClassMembership($definedMeaningId, $attributeMeaningId);
				
			$progressBar->advance(1);
		}
		
		$progressBar->clear();
	}	
}

?>
