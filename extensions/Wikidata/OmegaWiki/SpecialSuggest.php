<?php

if ( !defined( 'MEDIAWIKI' ) ) die();


$wgExtensionFunctions[] = 'wfSpecialSuggest';
function wfSpecialSuggest() {
	class SpecialSuggest extends SpecialPage {
		function SpecialSuggest() {
			SpecialPage::SpecialPage( 'Suggest', 'UnlistedSpecialPage' );
	
		}

		function execute( $par ) {
			global
				$wgOut,	$IP;

			$wgOut->disable();
			require_once( "$IP/includes/Setup.php" );
			require_once( "Attribute.php" );
			require_once( "WikiDataBootstrappedMeanings.php" );
			require_once( "RecordSet.php" );
			require_once( "Editor.php" );
			require_once( "HTMLtable.php" );
			# require_once("WikiDataAPI.php");
			require_once( "Transaction.php" );
			require_once( "OmegaWikiEditors.php" );
			require_once( "Utilities.php" );
			require_once( "Wikidata.php" );
			require_once( "WikiDataTables.php" );
			require_once( "WikiDataGlobals.php" );
			echo getSuggestions();
		}
	}

	SpecialPage::addPage( new SpecialSuggest() );
}

/**
 * Creates and runs the appropriate SQL query when a combo box is clicked
 * the combo box table is filled with the SQL query results
 */
function getSuggestions() {
	$o = OmegaWikiAttributes::getInstance();
	global $wgUser;
	global
		$wgDefinedMeaning,
		$wgDefinedMeaningAttributes,
		$wgOptionAttribute,
		$wgLinkAttribute;

	$dc = wdGetDataSetContext();
	@$search = ltrim( $_GET['search-text'] );
	@$prefix = $_GET['prefix'];
	@$query = $_GET['query'];
	@$definedMeaningId = $_GET['definedMeaningId'];
	@$offset = $_GET['offset'];
	@$attributesLevel = $_GET['attributesLevel'];
	@$annotationAttributeId = $_GET['annotationAttributeId'];
	$syntransId = $_GET["syntransId"];

	$sql = '';

	$dbr = wfGetDB( DB_SLAVE );
	$rowText = 'spelling';
	switch ( $query ) {
		case 'relation-type':
			$sqlActual = getSQLForCollectionOfType( 'RELT', $wgUser->getOption( 'language' ) );
			$sqlFallback = getSQLForCollectionOfType( 'RELT', 'en' );
			$sql = constructSQLWithFallback( $sqlActual, $sqlFallback, array( "member_mid", "spelling", "collection_mid" ) );
			break;
		case 'class':
			// constructSQLWithFallback is a bit broken in this case, showing several time the same lines
			// so : not using it. The English fall back has been included in the SQL query
			$sql = getSQLForClasses( $wgUser->getOption( 'language' ) );
			break;
		case "$wgDefinedMeaningAttributes":
			$sql = getSQLToSelectPossibleAttributes( $definedMeaningId, $attributesLevel, $syntransId, $annotationAttributeId, 'DM' );
			break;
		case 'text-attribute':
			$sql = getSQLToSelectPossibleAttributes( $definedMeaningId, $attributesLevel, $syntransId, $annotationAttributeId, 'TEXT' );
			break;
		case 'translated-text-attribute':
			$sql = getSQLToSelectPossibleAttributes( $definedMeaningId, $attributesLevel, $syntransId, $annotationAttributeId, 'TRNS' );
			break;
		case "$wgLinkAttribute":
			$sql = getSQLToSelectPossibleAttributes( $definedMeaningId, $attributesLevel, $syntransId, $annotationAttributeId, 'URL' );
			break;
		case "$wgOptionAttribute":
			$sql = getSQLToSelectPossibleAttributes( $definedMeaningId, $attributesLevel, $syntransId, $annotationAttributeId, 'OPTN' );
			break;
		case 'language':
			require_once( 'languages.php' );
			$sql = getSQLForLanguageNames( $wgUser->getOption( 'language' ) );
			$rowText = 'language_name';
			break;
		case "$wgDefinedMeaning":
			$sql =
				"SELECT {$dc}_syntrans.defined_meaning_id AS defined_meaning_id, {$dc}_expression.spelling AS spelling, {$dc}_expression.language_id AS language_id " .
				" FROM {$dc}_expression, {$dc}_syntrans " .
	            " WHERE {$dc}_expression.expression_id={$dc}_syntrans.expression_id " .
	            " AND {$dc}_syntrans.identical_meaning=1 " .
	            " AND " . getLatestTransactionRestriction( "{$dc}_syntrans" ) .
	            " AND " . getLatestTransactionRestriction( "{$dc}_expression" );
	        break;
	    case 'class-attributes-level':
	    	$sql = getSQLForLevels( $wgUser->getOption( 'language' ) );
	    	break;
	    case 'collection':
	 	$sqlActual = getSQLForCollection( $wgUser->getOption( 'language' ) );
	 	$sqlFallback = getSQLForCollection( 'en' );
		$sql = constructSQLWithFallback( $sqlActual, $sqlFallback, array( "collection_id", "spelling" ) );
	    	break;
	    case 'transaction':
	    	$sql =
				"SELECT transaction_id, user_id, user_ip, " .
	    		" CONCAT(SUBSTRING(timestamp, 1, 4), '-', SUBSTRING(timestamp, 5, 2), '-', SUBSTRING(timestamp, 7, 2), ' '," .
	    		" SUBSTRING(timestamp, 9, 2), ':', SUBSTRING(timestamp, 11, 2), ':', SUBSTRING(timestamp, 13, 2)) AS time, comment" .
	    		" FROM {$dc}_transactions WHERE 1";
	    		
	    	$rowText = "CONCAT(SUBSTRING(timestamp, 1, 4), '-', SUBSTRING(timestamp, 5, 2), '-', SUBSTRING(timestamp, 7, 2), ' '," .
	    			" SUBSTRING(timestamp, 9, 2), ':', SUBSTRING(timestamp, 11, 2), ':', SUBSTRING(timestamp, 13, 2))";
	    	break;
	}

	if ( $search != '' ) {
		if ( $query == 'transaction' )
			$searchCondition = " AND $rowText LIKE " . $dbr->addQuotes( "%$search%" );
		else if ( $query == 'class' )
			$searchCondition = " AND $rowText LIKE " . $dbr->addQuotes( "$search%" );
		else if ( $query == 'language' or
			$query == "$wgDefinedMeaningAttributes" or // should be 'relation-type' in html, there is a bug I cannot find
			$query == "$wgLinkAttribute" or
			$query == "$wgOptionAttribute" or
			$query == 'translated-text-attribute' or
			$query == 'text-attribute' )
			$searchCondition = " HAVING $rowText LIKE " . $dbr->addQuotes( "$search%" );
		else if ( $query == 'relation-type' or // not sure in which case 'relation-type' happens...
			$query == 'collection' )
			$searchCondition = " WHERE $rowText LIKE " . $dbr->addQuotes( "$search%" );
		else
			$searchCondition = " AND $rowText LIKE " . $dbr->addQuotes( "$search%" );
	}
	else
		$searchCondition = "";
	
	if ( $query == 'transaction' )
		$orderBy = 'transaction_id DESC';
	else
		$orderBy = $rowText;
	
	$sql .= $searchCondition . " ORDER BY $orderBy LIMIT ";
	
	if ( $offset > 0 )
		$sql .= " $offset, ";
		
	// print only 10 results
	$sql .= "10";
	
	# == Actual query here
	// wfdebug("]]]".$sql."\n");
	$queryResult = $dbr->query( $sql );
	
	$o->id = new Attribute( "id", wfMsg( 'ow_ID' ), "id" );
	
	# == Process query
	switch( $query ) {
		case 'relation-type':
			list( $recordSet, $editor ) = getRelationTypeAsRecordSet( $queryResult );
			break;
		case 'class':
			list( $recordSet, $editor ) = getClassAsRecordSet( $queryResult );
			break;
		case "$wgDefinedMeaningAttributes":
			list( $recordSet, $editor ) = getDefinedMeaningAttributeAsRecordSet( $queryResult );
			break;
		case 'text-attribute':
			list( $recordSet, $editor ) = getTextAttributeAsRecordSet( $queryResult );
			break;
		case 'translated-text-attribute':
			list( $recordSet, $editor ) = getTranslatedTextAttributeAsRecordSet( $queryResult );
			break;
		case "$wgLinkAttribute":
			list( $recordSet, $editor ) = getLinkAttributeAsRecordSet( $queryResult );
			break;
		case "$wgOptionAttribute":
			list( $recordSet, $editor ) = getOptionAttributeAsRecordSet( $queryResult );
			break;
		case "$wgDefinedMeaning":
			list( $recordSet, $editor ) = getDefinedMeaningAsRecordSet( $queryResult );
			break;
		case 'class-attributes-level':
			list( $recordSet, $editor ) = getClassAttributeLevelAsRecordSet( $queryResult );
			break;
		case 'collection':
			list( $recordSet, $editor ) = getCollectionAsRecordSet( $queryResult );
			break;
		case 'language':
			list( $recordSet, $editor ) = getLanguageAsRecordSet( $queryResult );
			break;
		case 'transaction':
			list( $recordSet, $editor ) = getTransactionAsRecordSet( $queryResult );
			break;
	}
	ob_start();
	var_dump( $queryResult );
	var_dump( $recordSet );
	var_dump( $editor );
	wfDebug( ob_get_contents() );
	ob_end_clean();

	$output = $editor->view( new IdStack( $prefix . 'table' ), $recordSet );
	// $output="<table><tr><td>HELLO ERIK!</td></tr></table>";
	// wfDebug($output);
	return $output;
}

# Constructs a new SQL query from 2 other queries such that if a field exists
# in the fallback query, but not in the actual query, the field from the
# fallback query will be returned. Fields not in the fallback are ignored.
# You will need to state which fields in your query need to be returned.
# As a (minor) hack, the 0th element of $fields is assumed to be the key field. 
function constructSQLWithFallback( $actual_query, $fallback_query, $fields ) {

	# if ($actual_query==$fallback_query)
	#	return $actual_query; 

	$sql = "SELECT * FROM (SELECT ";

	$sql_with_comma = $sql;
	foreach ( $fields as $field ) {
		$sql = $sql_with_comma;
		$sql .= "COALESCE(actual.$field, fallback.$field) as $field";
		$sql_with_comma = $sql;
		$sql_with_comma .= ", ";
	}
		
	$sql .= " FROM ";
	$sql .=	" ( $fallback_query ) AS fallback";
	$sql .=	" LEFT JOIN ";
	$sql .=	" ( $actual_query ) AS actual";
	
	$field0 = $fields[0]; # slightly presumptuous
	$sql .=  " ON actual.$field0 = fallback.$field0";
	$sql .= ") as coalesced";
	return $sql;
}

/**
 * Returns the list of attributes of a given $attributesType (DM, TEXT, TRNS, URL, OPTN)
 * in the user language or in English
 *
 * @param $language the 2 letter wikimedia code
 */

function getSQLToSelectPossibleAttributes( $definedMeaningId, $attributesLevel, $syntransId, $annotationAttributeId, $attributesType ) {

	global $wgDefaultClassMids, $wgUser;

	$dc = wdGetDataSetContext();
	$dbr = wfGetDB( DB_SLAVE );

	$language = $wgUser->getOption( 'language' ) ;
	$lng = ' ( SELECT language_id FROM language WHERE wikimedia_key = ' . $dbr->addQuotes( $language ) . ' ) ';

	$classMids = $wgDefaultClassMids ;

	if ( $syntransId != 0 ) {
		// find the language of the syntrans and add attributes of that language by adding the language DM to the list of default classes
		// this first query returns the language_id
		$sql = 'SELECT language_id' .
				" FROM {$dc}_syntrans" .
				" JOIN {$dc}_expression ON {$dc}_expression.expression_id = {$dc}_syntrans.expression_id" .
				" WHERE {$dc}_syntrans.syntrans_sid = " . $syntransId .
				' AND ' . getLatestTransactionRestriction( "{$dc}_syntrans" ) .
				' AND ' . getLatestTransactionRestriction( "{$dc}_expression" );
		$lang_res = $dbr->query( $sql );
		$language_id = $dbr->fetchObject( $lang_res )->language_id;

		// this second query finds the DM number for a given language_id
		// 145264 is the collection_id of the "ISO 639-3 codes" collection
		$sql = "SELECT member_mid FROM {$dc}_collection_contents, language" .
				" WHERE language.language_id = $language_id" .
				" AND {$dc}_collection_contents.collection_id = 145264" .
				" AND language.iso639_3 = {$dc}_collection_contents.internal_member_id" .
				' AND ' . getLatestTransactionRestriction( "{$dc}_collection_contents" );
		$lang_res = $dbr->query( $sql );
		$language_dm_id = $dbr->fetchObject( $lang_res )->member_mid;

		$classMids = array_merge ( $wgDefaultClassMids , array($language_dm_id) ) ;
	}

	if ( count( $classMids ) > 0 )
		$defaultClassRestriction = " OR {$dc}_class_attributes.class_mid IN (" . join( $classMids, ", " ) . ")";
	else
		$defaultClassRestriction = "";

	$filteredAttributesRestriction = getFilteredAttributesRestriction( $annotationAttributeId );

	$sql =
		'SELECT attribute_mid, MAX(spelling) as spelling FROM (' .
		'SELECT attribute_mid, spelling' .
		" FROM {$dc}_bootstrapped_defined_meanings, {$dc}_class_attributes, {$dc}_syntrans, {$dc}_expression" .
		" WHERE {$dc}_bootstrapped_defined_meanings.name = " . $dbr->addQuotes( $attributesLevel ) .
		" AND {$dc}_bootstrapped_defined_meanings.defined_meaning_id = {$dc}_class_attributes.level_mid" .
		" AND {$dc}_class_attributes.attribute_type = " . $dbr->addQuotes( $attributesType ) .
		" AND {$dc}_syntrans.defined_meaning_id = {$dc}_class_attributes.attribute_mid" .
		" AND {$dc}_expression.expression_id = {$dc}_syntrans.expression_id" .
		$filteredAttributesRestriction . " ";

	$sql .=
	" AND ( language_id=$lng " .
		' OR ( ' .
		' language_id=85 ' .
		" AND {$dc}_syntrans.defined_meaning_id NOT IN ( SELECT defined_meaning_id FROM {$dc}_syntrans synt, {$dc}_expression exp WHERE exp.expression_id = synt.expression_id AND exp.language_id=$lng ) " .
	' ) ) ' ;

	$sql .=
		' AND ' . getLatestTransactionRestriction( "{$dc}_class_attributes" ) .
		' AND ' . getLatestTransactionRestriction( "{$dc}_expression" ) .
		' AND ' . getLatestTransactionRestriction( "{$dc}_syntrans" ) .
		" AND ({$dc}_class_attributes.class_mid IN (" .
			' SELECT class_mid ' .
			" FROM   {$dc}_class_membership" .
			" WHERE  {$dc}_class_membership.class_member_mid = " . $definedMeaningId .
			' AND ' . getLatestTransactionRestriction( "{$dc}_class_membership" ) .
			' )' .
			$defaultClassRestriction .
		')';

	$sql .= ') AS filtered GROUP BY attribute_mid';

	return $sql ;
}

function getPropertyToColumnFilterForAttribute( $annotationAttributeId ) {
	global
		$wgPropertyToColumnFilters;
	
	$i = 0;
	$result = null;
	
	while ( $result == null && $i < count( $wgPropertyToColumnFilters ) )
		if ( $wgPropertyToColumnFilters[$i]->getAttribute()->id == $annotationAttributeId )
			$result = $wgPropertyToColumnFilters[$i];
		else
			$i++;

	return $result;
}

function getFilteredAttributes( $annotationAttributeId ) {
	$propertyToColumnFilter = getPropertyToColumnFilterForAttribute( $annotationAttributeId );
	
	if ( $propertyToColumnFilter != null )
		return $propertyToColumnFilter->attributeIDs;
	else
		return array();
}

function getAllFilteredAttributes() {
	global
		$wgPropertyToColumnFilters;

	$result = array();
	
	foreach ( $wgPropertyToColumnFilters as $propertyToColumnFilter )
		$result = array_merge( $result, $propertyToColumnFilter->attributeIDs );
	
	return $result;
}

function getFilteredAttributesRestriction( $annotationAttributeId ) {
	$dc = wdGetDataSetContext();

	$propertyToColumnFilter = getPropertyToColumnFilterForAttribute( $annotationAttributeId );
	
	if ( $propertyToColumnFilter != null ) {
		$filteredAttributes = $propertyToColumnFilter->attributeIDs;

		if ( count( $filteredAttributes ) > 0 )
			$result = " AND {$dc}_class_attributes.attribute_mid IN (" . join( $filteredAttributes, ", " ) . ")";
		else
			$result = " AND 0 ";
	}
	else {
		$allFilteredAttributes = getAllFilteredAttributes();

		if ( count( $allFilteredAttributes ) > 0 )
			$result = " AND {$dc}_class_attributes.attribute_mid NOT IN (" . join( $allFilteredAttributes, ", " ) . ")";
		else
			$result = "";
	}
	
	return $result;
}


/**
 * Returns the name of all classes and their spelling in the user language or in English
 *
 * @param $language the 2 letter wikimedia code
 */
function getSQLForClasses( $language ) {
	$dc = wdGetDataSetContext();

  $dbr = wfGetDB( DB_SLAVE );
  $lng = '( SELECT language_id FROM language WHERE wikimedia_key = ' . $dbr->addQuotes( $language ) . ' )';

  // exp.spelling, txt.text_text
	$sql = "SELECT member_mid, spelling " .
		" FROM {$dc}_collection_contents col_contents, {$dc}_collection col, {$dc}_syntrans synt," .
		" {$dc}_expression exp, {$dc}_defined_meaning dm" .
		" WHERE col.collection_type='CLAS' " .
		" AND col_contents.collection_id = col.collection_id " .
 		" AND synt.defined_meaning_id = col_contents.member_mid " .
//		" AND synt.identical_meaning=1 " .
		" AND exp.expression_id = synt.expression_id " .
		" AND dm.defined_meaning_id = synt.defined_meaning_id " .
		" AND ( " .
			" exp.language_id=$lng " .
			" OR (" .
				" exp.language_id=85 " .
				" AND dm.defined_meaning_id NOT IN " .
					" ( SELECT defined_meaning_id FROM {$dc}_syntrans synt_bis, {$dc}_expression exp_bis " .
					" WHERE exp_bis.expression_id = synt_bis.expression_id AND exp_bis.language_id=$lng " .
					" AND synt_bis.remove_transaction_id IS NULL AND exp_bis.remove_transaction_id IS NULL ) " .
				" ) " .
			" ) " .
		" AND " . getLatestTransactionRestriction( "col" ) .
		" AND " . getLatestTransactionRestriction( "col_contents" ) .
		" AND " . getLatestTransactionRestriction( "synt" ) .
		" AND " . getLatestTransactionRestriction( "exp" ) .
		" AND " . getLatestTransactionRestriction( "dm" ) ;

	return $sql;
}

function getSQLForCollectionOfType( $collectionType, $language = "<ANY>" ) {
	$dc = wdGetDataSetContext();
	$sql = "SELECT member_mid, spelling, collection_mid " .
        " FROM {$dc}_collection_contents, {$dc}_collection, {$dc}_syntrans, {$dc}_expression " .
        " WHERE {$dc}_collection_contents.collection_id={$dc}_collection.collection_id " .
        " AND {$dc}_collection.collection_type='$collectionType' " .
        " AND {$dc}_syntrans.defined_meaning_id={$dc}_collection_contents.member_mid " .
        " AND {$dc}_expression.expression_id={$dc}_syntrans.expression_id " .
        " AND {$dc}_syntrans.identical_meaning=1 " .
        " AND " . getLatestTransactionRestriction( "{$dc}_syntrans" ) .
        " AND " . getLatestTransactionRestriction( "{$dc}_expression" ) .
        " AND " . getLatestTransactionRestriction( "{$dc}_collection" ) .
        " AND " . getLatestTransactionRestriction( "{$dc}_collection_contents" );
	if ( $language != "<ANY>" ) {
		$dbr = wfGetDB( DB_SLAVE );
		$sql .=
			' AND language_id=( ' .
				' SELECT language_id' .
				' FROM language' .
				' WHERE wikimedia_key = ' . $dbr->addQuotes( $language ) .
				' )';
	}
	return $sql;
}

function getSQLForCollection( $language = "<ANY>" ) {
	$dc = wdGetDataSetContext();
	$sql =
		"SELECT collection_id, spelling " .
		" FROM {$dc}_expression, {$dc}_collection, {$dc}_syntrans " .
		" WHERE {$dc}_expression.expression_id={$dc}_syntrans.expression_id" .
		" AND {$dc}_syntrans.defined_meaning_id={$dc}_collection.collection_mid " .
		" AND {$dc}_syntrans.identical_meaning=1" .
		" AND " . getLatestTransactionRestriction( "{$dc}_syntrans" ) .
		" AND " . getLatestTransactionRestriction( "{$dc}_expression" ) .
		" AND " . getLatestTransactionRestriction( "{$dc}_collection" );
	
	if ( $language != "<ANY>" ) {
		$dbr = wfGetDB( DB_SLAVE );
		$sql .=
			' AND language_id=( ' .
				' SELECT language_id' .
				' FROM language' .
				' WHERE wikimedia_key = ' . $dbr->addQuotes( $language ) .
				' )';
	}

	return $sql;
}

function getSQLForLevels( $language = "<ANY>" ) {
	global
		$classAttributeLevels, $dataSet;
	
	$o = OmegaWikiAttributes::getInstance();
	// TO DO: Add support for multiple languages here
	return
		selectLatest(
			array( $dataSet->bootstrappedDefinedMeanings->definedMeaningId, $dataSet->expression->spelling ),
			array( $dataSet->definedMeaning, $dataSet->expression, $dataSet->bootstrappedDefinedMeanings ),
			array(
				'name IN (' . implodeFixed( $classAttributeLevels ) . ')',
				equals( $dataSet->definedMeaning->definedMeaningId, $dataSet->bootstrappedDefinedMeanings->definedMeaningId ),
				equals( $dataSet->definedMeaning->expressionId, $dataSet->expression->expressionId )
			)
		);
}

function getRelationTypeAsRecordSet( $queryResult ) {

	$o = OmegaWikiAttributes::getInstance();

	$dbr = wfGetDB( DB_SLAVE );
	
	$relationTypeAttribute = new Attribute( "relation-type", wfMsg( 'ow_RelationType' ), "short-text" );
	$collectionAttribute = new Attribute( "collection", wfMsg( 'ow_Collection' ), "short-text" );

	$recordSet = new ArrayRecordSet( new Structure( $o->id, $relationTypeAttribute, $collectionAttribute ), new Structure( $o->id ) );

	while ( $row = $dbr->fetchObject( $queryResult ) )
		$recordSet->addRecord( array( $row->member_mid, $row->spelling, definedMeaningExpression( $row->collection_mid ) ) );

	$editor = createSuggestionsTableViewer( null );
	$editor->addEditor( createShortTextViewer( $relationTypeAttribute ) );
	$editor->addEditor( createShortTextViewer( $collectionAttribute ) );
	
	return array( $recordSet, $editor );
}

/**
 * Writes an html table from a sql table corresponding to the list of classes, as shown by
 * http://www.omegawiki.org/index.php?title=Special:Suggest&query=class
 *
 * @param $queryResult the result of a SQL query to be made into an html table
 */
function getClassAsRecordSet( $queryResult ) {

	$o = OmegaWikiAttributes::getInstance();
	
	$dbr = wfGetDB( DB_SLAVE );
	// Setting the two column, with titles
	$classAttribute = new Attribute( "class", wfMsg( 'ow_Class' ), "short-text" );
	$definitionAttribute = new Attribute( "definition", wfMsg( 'ow_Definition' ), "short-text" );

	$recordSet = new ArrayRecordSet( new Structure( $o->id, $classAttribute, $definitionAttribute ), new Structure( $o->id ) );

	while ( $row = $dbr->fetchObject( $queryResult ) ) {
		$recordSet->addRecord( array( $row->member_mid, $row->spelling, getDefinedMeaningDefinition( $row->member_mid ) ) );
  }

	$editor = createSuggestionsTableViewer( null );
	$editor->addEditor( createShortTextViewer( $classAttribute ) );
	$editor->addEditor( createShortTextViewer( $definitionAttribute ) );

	return array( $recordSet, $editor );
}

function getDefinedMeaningAttributeAsRecordSet( $queryResult ) {
	$o = OmegaWikiAttributes::getInstance();
	global $wgDefinedMeaningAttributes;

	$dbr = wfGetDB( DB_SLAVE );
	
	$definedMeaningAttributeAttribute = new Attribute( $wgDefinedMeaningAttributes, wfMsgSc( "DefinedMeaningAttributes" ), "short-text" );
	$recordSet = new ArrayRecordSet( new Structure( $o->id, $definedMeaningAttributeAttribute ), new Structure( $o->id ) );
	
	while ( $row = $dbr->fetchObject( $queryResult ) )
		$recordSet->addRecord( array( $row->attribute_mid, $row->spelling ) );

	$editor = createSuggestionsTableViewer( null );
	$editor->addEditor( createShortTextViewer( $definedMeaningAttributeAttribute ) );

	return array( $recordSet, $editor );
}

function getTextAttributeAsRecordSet( $queryResult ) {

	$o = OmegaWikiAttributes::getInstance();
	
	$dbr = wfGetDB( DB_SLAVE );
	
	$textAttributeAttribute = new Attribute( "text-attribute", wfMsg( 'ow_TextAttributeHeader' ), "short-text" );
	$recordSet = new ArrayRecordSet( new Structure( $o->id, $textAttributeAttribute ), new Structure( $o->id ) );
	
	while ( $row = $dbr->fetchObject( $queryResult ) )
		$recordSet->addRecord( array( $row->attribute_mid, $row->spelling ) );

	$editor = createSuggestionsTableViewer( null );
	$editor->addEditor( createShortTextViewer( $textAttributeAttribute ) );

	return array( $recordSet, $editor );
}

function getLinkAttributeAsRecordSet( $queryResult ) {
	$o = OmegaWikiAttributes::getInstance();
	global $wgLinkAttribute;

	$dbr = wfGetDB( DB_SLAVE );
	
	$linkAttributeAttribute = new Attribute( $wgLinkAttribute, wfMsg( 'ow_LinkAttributeHeader' ), "short-text" );
	$recordSet = new ArrayRecordSet( new Structure( $o->id, $linkAttributeAttribute ), new Structure( $o->id ) );
	
	while ( $row = $dbr->fetchObject( $queryResult ) )
		$recordSet->addRecord( array( $row->attribute_mid, $row->spelling ) );

	$editor = createSuggestionsTableViewer( null );
	$editor->addEditor( createShortTextViewer( $linkAttributeAttribute ) );

	return array( $recordSet, $editor );
}

function getTranslatedTextAttributeAsRecordSet( $queryResult ) {

	$o = OmegaWikiAttributes::getInstance();
	
	$dbr = wfGetDB( DB_SLAVE );
	$translatedTextAttributeAttribute = new Attribute( "translated-text-attribute", "Translated text attribute", "short-text" );
	
	$recordSet = new ArrayRecordSet( new Structure( $o->id, $translatedTextAttributeAttribute ), new Structure( $o->id ) );
	
	while ( $row = $dbr->fetchObject( $queryResult ) )
		$recordSet->addRecord( array( $row->attribute_mid, $row->spelling ) );

	$editor = createSuggestionsTableViewer( null );
	$editor->addEditor( createShortTextViewer( $translatedTextAttributeAttribute ) );

	return array( $recordSet, $editor );
}

function getOptionAttributeAsRecordSet( $queryResult ) {
	$o = OmegaWikiAttributes::getInstance();
	global $wgOptionAttribute;

	$dbr = wfGetDB( DB_SLAVE );
	
	$optionAttributeAttribute = new Attribute( $wgOptionAttribute, wfMsg( 'ow_OptionAttributeHeader' ), "short-text" );
	$recordSet = new ArrayRecordSet( new Structure( $o->id, $optionAttributeAttribute ), new Structure( $o->id ) );
	
	while ( $row = $dbr->fetchObject( $queryResult ) )
		$recordSet->addRecord( array( $row->attribute_mid, $row->spelling ) );

	$editor = createSuggestionsTableViewer( null );
	$editor->addEditor( createShortTextViewer( $optionAttributeAttribute ) );

	return array( $recordSet, $editor );
}

function getDefinedMeaningAsRecordSet( $queryResult ) {

	$o = OmegaWikiAttributes::getInstance();
	global $wgDefinedMeaning ;

	$dbr = wfGetDB( DB_SLAVE );
	$spellingAttribute = new Attribute( "spelling", wfMsg( 'ow_Spelling' ), "short-text" );
	$languageAttribute = new Attribute( "language", wfMsg( 'ow_Language' ), "language" );
	
	$expressionStructure = new Structure( $wgDefinedMeaning, $spellingAttribute, $languageAttribute );
	$definedMeaningAttribute = new Attribute( null, wfMsg( 'ow_DefinedMeaning' ), $expressionStructure );
	$definitionAttribute = new Attribute( "definition", wfMsg( 'ow_Definition' ), "definition" );
	
	$recordSet = new ArrayRecordSet( new Structure( $o->id, $definedMeaningAttribute, $definitionAttribute ), new Structure( $o->id ) );
	
	while ( $row = $dbr->fetchObject( $queryResult ) ) {
		$definedMeaningRecord = new ArrayRecord( $expressionStructure );
		$definedMeaningRecord->setAttributeValue( $spellingAttribute, $row->spelling );
		$definedMeaningRecord->setAttributeValue( $languageAttribute, $row->language_id );
		
		$recordSet->addRecord( array( $row->defined_meaning_id, $definedMeaningRecord, getDefinedMeaningDefinition( $row->defined_meaning_id ) ) );
	}

	$expressionEditor = new RecordTableCellEditor( $definedMeaningAttribute );
	$expressionEditor->addEditor( createShortTextViewer( $spellingAttribute ) );
	$expressionEditor->addEditor( createLanguageViewer( $languageAttribute ) );

	$editor = createSuggestionsTableViewer( null );
	$editor->addEditor( $expressionEditor );
	$editor->addEditor( new TextEditor( $definitionAttribute, new SimplePermissionController( false ), false, true, 75 ) );

	return array( $recordSet, $editor );
}

function getClassAttributeLevelAsRecordSet( $queryResult ) {

	$o = OmegaWikiAttributes::getInstance();
	
	$dbr = wfGetDB( DB_SLAVE );

	$classAttributeLevelAttribute = new Attribute( "class-attribute-level", wfMsg( 'ow_ClassAttributeLevel' ), "short-text" );
	$recordSet = new ArrayRecordSet( new Structure( $o->id, $classAttributeLevelAttribute ), new Structure( $o->id ) );

	while ( $row = $dbr->fetchObject( $queryResult ) )
		$recordSet->addRecord( array( $row->defined_meaning_id, $row->spelling ) );

	$editor = createSuggestionsTableViewer( null );
	$editor->addEditor( createShortTextViewer( $classAttributeLevelAttribute ) );
	
	return array( $recordSet, $editor );
}

function getCollectionAsRecordSet( $queryResult ) {

	$o = OmegaWikiAttributes::getInstance();

	$dbr = wfGetDB( DB_SLAVE );
	$collectionAttribute = new Attribute( "collection", wfMsg( 'ow_Collection' ), "short-text" );
	
	$recordSet = new ArrayRecordSet( new Structure( $o->id, $collectionAttribute ), new Structure( $o->id ) );
	
	while ( $row = $dbr->fetchObject( $queryResult ) )
		$recordSet->addRecord( array( $row->collection_id, $row->spelling ) );

	$editor = createSuggestionsTableViewer( null );
	$editor->addEditor( createShortTextViewer( $collectionAttribute ) );

	return array( $recordSet, $editor );
}

function getLanguageAsRecordSet( $queryResult ) {

	$o = OmegaWikiAttributes::getInstance();

	$dbr = wfGetDB( DB_SLAVE );
	$languageAttribute = new Attribute( "language", wfMsg( 'ow_Language' ), "short-text" );
	
	$recordSet = new ArrayRecordSet( new Structure( $o->id, $languageAttribute ), new Structure( $o->id ) );
	
	while ( $row = $dbr->fetchObject( $queryResult ) )  {
		$recordSet->addRecord( array( $row->row_id, $row->language_name ) );
	}
	$editor = createSuggestionsTableViewer( null );
	$editor->addEditor( createShortTextViewer( $languageAttribute ) );

	return array( $recordSet, $editor );
}

function getTransactionAsRecordSet( $queryResult ) {

	$o = OmegaWikiAttributes::getInstance();
	
	$dbr = wfGetDB( DB_SLAVE );
	
	$userAttribute = new Attribute( "user", wfMsg( 'ow_User' ), "short-text" );
	$timestampAttribute = new Attribute( "timestamp", wfMsg( 'ow_Time' ), "timestamp" );
	$summaryAttribute = new Attribute( "summary", wfMsg( 'ow_transaction_summary' ), "short-text" );
	
	$recordSet = new ArrayRecordSet( new Structure( $o->id, $userAttribute, $timestampAttribute, $summaryAttribute ), new Structure( $o->id ) );
	
	while ( $row = $dbr->fetchObject( $queryResult ) )
		$recordSet->addRecord( array( $row->transaction_id, getUserLabel( $row->user_id, $row->user_ip ), $row->time, $row->comment ) );
	
	$editor = createSuggestionsTableViewer( null );
	$editor->addEditor( createShortTextViewer( $timestampAttribute ) );
	$editor->addEditor( createShortTextViewer( $o->id ) );
	$editor->addEditor( createShortTextViewer( $userAttribute ) );
	$editor->addEditor( createShortTextViewer( $summaryAttribute ) );

	return array( $recordSet, $editor );
}


