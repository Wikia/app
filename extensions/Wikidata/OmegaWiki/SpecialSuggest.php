<?php

if ( !defined( 'MEDIAWIKI' ) ) die();


class SpecialSuggest extends SpecialPage {
	function __construct() {
		parent::__construct( 'Suggest', 'UnlistedSpecialPage' );
	}

	function execute( $par ) {
		global $wgOut, $wgLang, $wgRequest, $IP,
			$wgDefinedMeaning, $wgDefinedMeaningAttributes,
			$wgOptionAttribute, $wgLinkAttribute;

		$wgOut->disable();
		require_once( "$IP/includes/Setup.php" );
		require_once( "Attribute.php" );
		require_once( "WikiDataBootstrappedMeanings.php" );
		require_once( "RecordSet.php" );
		require_once( "Editor.php" );
		require_once( "HTMLtable.php" );
		require_once( "Transaction.php" );
		require_once( "OmegaWikiEditors.php" );
		require_once( "Utilities.php" );
		require_once( "Wikidata.php" );
		require_once( "WikiDataTables.php" );
		require_once( "WikiDataGlobals.php" );

		$o = OmegaWikiAttributes::getInstance();

		$dc = wdGetDataSetContext();
		$search = ltrim( $wgRequest->getVal( 'search-text' ) );
		$prefix = $wgRequest->getVal( 'prefix' );
		$query = $wgRequest->getVal( 'query' );
		$definedMeaningId = $wgRequest->getVal( 'definedMeaningId' );
		$offset = $wgRequest->getVal( 'offset' );
		$attributesLevel = $wgRequest->getVal( 'attributesLevel' );
		$annotationAttributeId = $wgRequest->getVal( 'annotationAttributeId' );
		$syntransId = $wgRequest->getVal( 'syntransId' );
		$langCode = $wgLang->getCode();

		$sql = '';
		$dbr = wfGetDB( DB_SLAVE );

		$rowText = 'spelling';
		switch ( $query ) {
			case 'relation-type':
				$sqlActual = $this->getSQLForCollectionOfType( 'RELT', $langCode );
				$sqlFallback = $this->getSQLForCollectionOfType( 'RELT', 'en' );
				$sql = $this->constructSQLWithFallback( $sqlActual, $sqlFallback, array( "member_mid", "spelling", "collection_mid" ) );
				break;
			case 'class':
				// constructSQLWithFallback is a bit broken in this case, showing several time the same lines
				// so : not using it. The English fall back has been included in the SQL query
				$sql = $this->getSQLForClasses( $langCode );
				break;
			case $wgDefinedMeaningAttributes:
				$sql = $this->getSQLToSelectPossibleAttributes( $definedMeaningId, $attributesLevel, $syntransId, $annotationAttributeId, 'DM' );
				break;
			case 'text-attribute':
				$sql = $this->getSQLToSelectPossibleAttributes( $definedMeaningId, $attributesLevel, $syntransId, $annotationAttributeId, 'TEXT' );
				break;
			case 'translated-text-attribute':
				$sql = $this->getSQLToSelectPossibleAttributes( $definedMeaningId, $attributesLevel, $syntransId, $annotationAttributeId, 'TRNS' );
				break;
			case $wgLinkAttribute:
				$sql = $this->getSQLToSelectPossibleAttributes( $definedMeaningId, $attributesLevel, $syntransId, $annotationAttributeId, 'URL' );
				break;
			case $wgOptionAttribute:
				$sql = $this->getSQLToSelectPossibleAttributes( $definedMeaningId, $attributesLevel, $syntransId, $annotationAttributeId, 'OPTN' );
				break;
			case 'language':
				require_once( 'languages.php' );
				$sql = getSQLForLanguageNames( $langCode );
				$rowText = 'language_name';
				break;
			case $wgDefinedMeaning:
				$sql =
					"SELECT {$dc}_syntrans.defined_meaning_id AS defined_meaning_id, {$dc}_expression.spelling AS spelling, {$dc}_expression.language_id AS language_id " .
					" FROM {$dc}_expression, {$dc}_syntrans " .
					" WHERE {$dc}_expression.expression_id={$dc}_syntrans.expression_id " .
					" AND {$dc}_syntrans.identical_meaning=1 " .
					" AND " . getLatestTransactionRestriction( "{$dc}_syntrans" ) .
					" AND " . getLatestTransactionRestriction( "{$dc}_expression" );
				break;
			case 'class-attributes-level':
				$sql = $this->getSQLForLevels( $langCode );
				break;
			case 'collection':
				$sql = $this->getSQLForCollection( $langCode );
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
			if ( $query == 'transaction' ) {
				$searchCondition = " AND $rowText LIKE " . $dbr->addQuotes( "%$search%" );
			}
			elseif ( $query == 'class' ) {
				$searchCondition = " AND $rowText LIKE " . $dbr->addQuotes( "$search%" );
			}
			elseif ( $query == "$wgDefinedMeaningAttributes" or // should be 'relation-type' in html, there is a bug I cannot find
				$query == "$wgLinkAttribute" or
				$query == "$wgOptionAttribute" or
				$query == 'translated-text-attribute' or
				$query == 'text-attribute' )
			{
				$searchCondition = " HAVING $rowText LIKE " . $dbr->addQuotes( "$search%" );
			}
			elseif ( $query == 'language' ) {
				$searchCondition = " HAVING $rowText LIKE " . $dbr->addQuotes( "%$search%" );
			}
			elseif ( $query == 'relation-type' ) { // not sure in which case 'relation-type' happens...
				$searchCondition = " WHERE $rowText LIKE " . $dbr->addQuotes( "$search%" );
			}
			else {
				$searchCondition = " AND $rowText LIKE " . $dbr->addQuotes( "$search%" );
			}
		} else {
			$searchCondition = "";
		}
	
		if ( $query == 'transaction' ) {
			$orderBy = 'transaction_id DESC';
		} else {
			$orderBy = $rowText;
		}
	
		$sql .= $searchCondition . " ORDER BY $orderBy LIMIT ";
	
		if ( $offset > 0 ) {
			$sql .= " $offset, ";
		}

		// print only 10 results
		$sql .= "10";

		# == Actual query here
		// wfdebug("]]]".$sql."\n");
		$queryResult = $dbr->query( $sql );

		$o->id = new Attribute( "id", wfMsg( 'ow_ID' ), "id" );
	
		# == Process query
		switch( $query ) {
			case 'relation-type':
				list( $recordSet, $editor ) = $this->getRelationTypeAsRecordSet( $queryResult );
				break;
			case 'class':
				list( $recordSet, $editor ) = $this->getClassAsRecordSet( $queryResult );
				break;
			case "$wgDefinedMeaningAttributes":
				list( $recordSet, $editor ) = $this->getDefinedMeaningAttributeAsRecordSet( $queryResult );
				break;
			case 'text-attribute':
				list( $recordSet, $editor ) = $this->getTextAttributeAsRecordSet( $queryResult );
				break;
			case 'translated-text-attribute':
				list( $recordSet, $editor ) = $this->getTranslatedTextAttributeAsRecordSet( $queryResult );
				break;
			case "$wgLinkAttribute":
				list( $recordSet, $editor ) = $this->getLinkAttributeAsRecordSet( $queryResult );
				break;
			case "$wgOptionAttribute":
				list( $recordSet, $editor ) = $this->getOptionAttributeAsRecordSet( $queryResult );
				break;
			case "$wgDefinedMeaning":
				list( $recordSet, $editor ) = $this->getDefinedMeaningAsRecordSet( $queryResult );
				break;
			case 'class-attributes-level':
				list( $recordSet, $editor ) = $this->getClassAttributeLevelAsRecordSet( $queryResult );
				break;
			case 'collection':
				list( $recordSet, $editor ) = $this->getCollectionAsRecordSet( $queryResult );
				break;
			case 'language':
				list( $recordSet, $editor ) = $this->getLanguageAsRecordSet( $queryResult );
				break;
			case 'transaction':
				list( $recordSet, $editor ) = $this->getTransactionAsRecordSet( $queryResult );
				break;
		}

		$dbr->freeResult( $queryResult );
		$output = $editor->view( new IdStack( $prefix . 'table' ), $recordSet );

		echo $output;
	}

	/** Constructs a new SQL query from 2 other queries such that if a field exists
	 * in the fallback query, but not in the actual query, the field from the
	 * fallback query will be returned. Fields not in the fallback are ignored.
	 * You will need to state which fields in your query need to be returned.
	 * As a (minor) hack, the 0th element of $fields is assumed to be the key field.
	 */
	private function constructSQLWithFallback( $actual_query, $fallback_query, $fields ) {

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
	private function getSQLToSelectPossibleAttributes( $definedMeaningId, $attributesLevel, $syntransId, $annotationAttributeId, $attributesType ) {
		global $wgDefaultClassMids, $wgLang;

		$dc = wdGetDataSetContext();
		$dbr = wfGetDB( DB_SLAVE );

		$sql = ' ( SELECT language_id FROM language WHERE wikimedia_key = ' . $dbr->addQuotes( $wgLang->getCode() ) . ' LIMIT 1 ) ';
		$lang_res = $dbr->query( $sql );
		if ( $row = $dbr->fetchObject($lang_res) ) {
			$userlang = $row->language_id ;
		} else {
			$userlang = 85 ;
		}

		$classMids = $wgDefaultClassMids ;

		if ( $syntransId != 0 ) {
			// find the language of the syntrans and add attributes of that language by adding the language DM to the list of default classes
			// this first query returns the language_id
			$sql = 'SELECT language_id' .
				" FROM {$dc}_expression" .
				" WHERE {$dc}_expression.expression_id = (SELECT expression_id FROM {$dc}_syntrans WHERE {$dc}_syntrans.syntrans_sid = {$syntransId} LIMIT 1) " .
				" LIMIT 1 " ;
			$lang_res = $dbr->query( $sql );
			$language_id = $dbr->fetchObject( $lang_res )->language_id;

			// this second query finds the DM number for a given language_id
			// 145264 is the collection_id of the "ISO 639-3 codes" collection
			$sql = "SELECT member_mid FROM {$dc}_collection_contents, language" .
				" WHERE language.language_id = $language_id" .
				" AND {$dc}_collection_contents.collection_id = 145264" .
				" AND language.iso639_3 = {$dc}_collection_contents.internal_member_id" .
				' AND ' . getLatestTransactionRestriction( "{$dc}_collection_contents" ) .
				' LIMIT 1 ' ;
			$lang_res = $dbr->query( $sql );
			$language_dm_id = $dbr->fetchObject( $lang_res )->member_mid;

			$classMids = array_merge ( $wgDefaultClassMids , array($language_dm_id) ) ;
		}

		$classRestriction = "";
		if ( count( $classMids ) > 0 ) {
			$classRestriction = " OR {$dc}_class_attributes.class_mid IN (" . join( $classMids, ", " ) . ")";
		}

		$filteredAttributesRestriction = $this->getFilteredAttributesRestriction( $annotationAttributeId );


		// fallback is English, and second fallback is the DM id
		if ( $userlang != 85 ) {
			$sql = "SELECT object_id, attribute_mid, COALESCE( exp_lng.spelling, exp_en.spelling, attribute_mid ) AS spelling" ;
		} else {
			$sql = "SELECT object_id, attribute_mid, COALESCE( exp_en.spelling, attribute_mid ) AS spelling" ;
		}
		$sql .= " FROM {$dc}_bootstrapped_defined_meanings, {$dc}_class_attributes" ;
		if ( $userlang != 85 ) {
			$sql .= " LEFT JOIN ( {$dc}_syntrans synt_lng, {$dc}_expression exp_lng )" .
				" ON ( {$dc}_class_attributes.attribute_mid = synt_lng.defined_meaning_id" .
				" AND exp_lng.expression_id = synt_lng.expression_id" .
				" AND exp_lng.language_id = {$userlang} )" ;
		}
		$sql .= " LEFT JOIN ( {$dc}_syntrans synt_en, {$dc}_expression exp_en )" .
			" ON ( {$dc}_class_attributes.attribute_mid = synt_en.defined_meaning_id" .
			" AND exp_en.expression_id = synt_en.expression_id" .
			" AND exp_en.language_id = 85 )" ; // English

		$sql .= " WHERE {$dc}_bootstrapped_defined_meanings.name = " . $dbr->addQuotes( $attributesLevel ) .
			" AND {$dc}_bootstrapped_defined_meanings.defined_meaning_id = {$dc}_class_attributes.level_mid" .
			" AND {$dc}_class_attributes.attribute_type = " . $dbr->addQuotes( $attributesType ) .
			$filteredAttributesRestriction . " ";

		if ( $userlang != 85 ) {
			$sql .= " AND synt_lng.remove_transaction_id IS NULL" ;
		}
		$sql .= " AND synt_en.remove_transaction_id IS NULL" ;

		$sql .=
			' AND ' . getLatestTransactionRestriction( "{$dc}_class_attributes" ) .
			" AND ({$dc}_class_attributes.class_mid IN (" .
			' SELECT class_mid ' .
			" FROM   {$dc}_class_membership" .
			" WHERE  {$dc}_class_membership.class_member_mid = " . $definedMeaningId .
			' AND ' . getLatestTransactionRestriction( "{$dc}_class_membership" ) .
			' )' .
			$classRestriction .
			')';

		// group by to obtain unicity
		$sql .= ' GROUP BY object_id';

		return $sql;
	}

	private function getPropertyToColumnFilterForAttribute( $annotationAttributeId ) {
		global $wgPropertyToColumnFilters;
	
		$i = 0;
		$result = null;
	
		while ( $result == null && $i < count( $wgPropertyToColumnFilters ) )
			if ( $wgPropertyToColumnFilters[$i]->getAttribute()->id == $annotationAttributeId )
				$result = $wgPropertyToColumnFilters[$i];
			else
				$i++;

		return $result;
	}

	private function getFilteredAttributes( $annotationAttributeId ) {
		$propertyToColumnFilter = $this->getPropertyToColumnFilterForAttribute( $annotationAttributeId );
	
		if ( $propertyToColumnFilter != null )
			return $propertyToColumnFilter->attributeIDs;
		else
			return array();
	}

	private function getAllFilteredAttributes() {
		global $wgPropertyToColumnFilters;

		$result = array();
	
		foreach ( $wgPropertyToColumnFilters as $propertyToColumnFilter )
			$result = array_merge( $result, $propertyToColumnFilter->attributeIDs );
	
		return $result;
	}

	private function getFilteredAttributesRestriction( $annotationAttributeId ) {
		$dc = wdGetDataSetContext();

		$propertyToColumnFilter = $this->getPropertyToColumnFilterForAttribute( $annotationAttributeId );
	
		if ( $propertyToColumnFilter != null ) {
			$filteredAttributes = $propertyToColumnFilter->attributeIDs;

			if ( count( $filteredAttributes ) > 0 )
				$result = " AND {$dc}_class_attributes.attribute_mid IN (" . join( $filteredAttributes, ", " ) . ")";
			else
				$result = " AND 0 ";
		}
		else {
			$allFilteredAttributes = $this->getAllFilteredAttributes();

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
	private function getSQLForClasses( $language ) {
		$dc = wdGetDataSetContext();

		$dbr = wfGetDB( DB_SLAVE );
		$userlang = ' ( SELECT language_id FROM language WHERE wikimedia_key = ' . $dbr->addQuotes( $language ) . ' LIMIT 1 ) ';

		// exp.spelling, txt.text_text
		$sql = "SELECT member_mid, spelling " .
			" FROM {$dc}_collection_contents col_contents, {$dc}_collection col, {$dc}_syntrans synt," .
			" {$dc}_expression exp, {$dc}_defined_meaning dm" .
			" WHERE col.collection_type='CLAS' " .
			" AND col_contents.collection_id = col.collection_id " .
			" AND synt.defined_meaning_id = col_contents.member_mid " .
//			" AND synt.identical_meaning=1 " .
			" AND exp.expression_id = synt.expression_id " .
			" AND dm.defined_meaning_id = synt.defined_meaning_id " ;

		// fallback is English
		$sql .= " AND ( exp.language_id=$userlang " ;
		if ( $userlang != 85 ) {
			$sql .= ' OR ( ' .
				' language_id=85 ' .
				" AND NOT EXISTS ( SELECT * FROM {$dc}_syntrans synt2, {$dc}_expression exp2 WHERE synt2.defined_meaning_id = synt.defined_meaning_id AND exp2.expression_id = synt2.expression_id AND exp2.language_id=$userlang AND synt2.remove_transaction_id IS NULL LIMIT 1 ) ) " ;
		}
		$sql .= ' ) ' ;

		$sql .= " AND " . getLatestTransactionRestriction( "col" ) .
			" AND " . getLatestTransactionRestriction( "col_contents" ) .
			" AND " . getLatestTransactionRestriction( "synt" ) .
			" AND " . getLatestTransactionRestriction( "exp" ) .
			" AND " . getLatestTransactionRestriction( "dm" ) ;

		return $sql;
	}

	private function getSQLForCollectionOfType( $collectionType, $language = "<ANY>" ) {
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

	private function getSQLForCollection( $language ) {
		$dc = wdGetDataSetContext();
		$dbr = wfGetDB( DB_SLAVE );
		$userlang = ' ( SELECT language_id FROM language WHERE wikimedia_key = ' . $dbr->addQuotes( $language ) . ' LIMIT 1 ) ';

		$sql = "SELECT collection_id, spelling " .
			" FROM {$dc}_expression exp, {$dc}_collection col, {$dc}_syntrans synt, {$dc}_defined_meaning dm " .
			" WHERE exp.expression_id=synt.expression_id " .
			" AND synt.defined_meaning_id=col.collection_mid " .
			" AND dm.defined_meaning_id = synt.defined_meaning_id " ;
//			" AND synt.identical_meaning=1" .

		// fallback is English
		$sql .= " AND ( exp.language_id=$userlang " ;
		if ( $userlang != 85 ) {
			$sql .= ' OR ( ' .
				' language_id=85 ' .
				" AND NOT EXISTS ( SELECT * FROM {$dc}_syntrans synt2, {$dc}_expression exp2 WHERE synt2.defined_meaning_id = synt.defined_meaning_id AND exp2.expression_id = synt2.expression_id AND exp2.language_id=$userlang AND synt2.remove_transaction_id IS NULL LIMIT 1 ) ) " ;
		}
		$sql .= ' ) ' ;

		$sql .= " AND " . getLatestTransactionRestriction( "synt" ) .
			" AND " . getLatestTransactionRestriction( "exp" ) .
			" AND " . getLatestTransactionRestriction( "col" ) .
			" AND " . getLatestTransactionRestriction( "dm" );

		return $sql;
	}

	private function getSQLForLevels( $language = "<ANY>" ) {
		global $classAttributeLevels, $dataSet;

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

	private function getRelationTypeAsRecordSet( $queryResult ) {

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

	private function getDefinedMeaningAttributeAsRecordSet( $queryResult ) {
		global $wgDefinedMeaningAttributes;

		$o = OmegaWikiAttributes::getInstance();

		$dbr = wfGetDB( DB_SLAVE );
	
		$definedMeaningAttributeAttribute = new Attribute( $wgDefinedMeaningAttributes, wfMsgSc( "DefinedMeaningAttributes" ), "short-text" );
		$recordSet = new ArrayRecordSet( new Structure( $o->id, $definedMeaningAttributeAttribute ), new Structure( $o->id ) );
	
		while ( $row = $dbr->fetchObject( $queryResult ) )
			$recordSet->addRecord( array( $row->attribute_mid, $row->spelling ) );

		$editor = createSuggestionsTableViewer( null );
		$editor->addEditor( createShortTextViewer( $definedMeaningAttributeAttribute ) );

		return array( $recordSet, $editor );
	}

	private function getTextAttributeAsRecordSet( $queryResult ) {

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

	private function getLinkAttributeAsRecordSet( $queryResult ) {
		global $wgLinkAttribute;

		$o = OmegaWikiAttributes::getInstance();

		$dbr = wfGetDB( DB_SLAVE );

		$linkAttributeAttribute = new Attribute( $wgLinkAttribute, wfMsg( 'ow_LinkAttributeHeader' ), "short-text" );
		$recordSet = new ArrayRecordSet( new Structure( $o->id, $linkAttributeAttribute ), new Structure( $o->id ) );

		while ( $row = $dbr->fetchObject( $queryResult ) )
			$recordSet->addRecord( array( $row->attribute_mid, $row->spelling ) );

		$editor = createSuggestionsTableViewer( null );
		$editor->addEditor( createShortTextViewer( $linkAttributeAttribute ) );

		return array( $recordSet, $editor );
	}

	private function getTranslatedTextAttributeAsRecordSet( $queryResult ) {

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

	private function getOptionAttributeAsRecordSet( $queryResult ) {
		global $wgOptionAttribute;

		$o = OmegaWikiAttributes::getInstance();

		$dbr = wfGetDB( DB_SLAVE );

		$optionAttributeAttribute = new Attribute( $wgOptionAttribute, wfMsg( 'ow_OptionAttributeHeader' ), "short-text" );
		$recordSet = new ArrayRecordSet( new Structure( $o->id, $optionAttributeAttribute ), new Structure( $o->id ) );

		while ( $row = $dbr->fetchObject( $queryResult ) )
			$recordSet->addRecord( array( $row->object_id, $row->spelling ) );

		$editor = createSuggestionsTableViewer( null );
		$editor->addEditor( createShortTextViewer( $optionAttributeAttribute ) );

		return array( $recordSet, $editor );
	}

	private function getDefinedMeaningAsRecordSet( $queryResult ) {
		global $wgDefinedMeaning ;

		$o = OmegaWikiAttributes::getInstance();

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

	private function getClassAttributeLevelAsRecordSet( $queryResult ) {

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

	private function getCollectionAsRecordSet( $queryResult ) {

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

	private function getLanguageAsRecordSet( $queryResult ) {

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

	private function getTransactionAsRecordSet( $queryResult ) {

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
}
