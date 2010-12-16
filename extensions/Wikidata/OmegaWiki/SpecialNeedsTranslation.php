<?php
	if ( !defined( 'MEDIAWIKI' ) ) die();

	$wgExtensionFunctions[] = 'wfSpecialNeedsTranslation';

	require_once( "Wikidata.php" );

	function wfSpecialNeedsTranslation() {
		class SpecialNeedsTranslation extends SpecialPage {
			function SpecialNeedsTranslation() {
				SpecialPage::SpecialPage( 'NeedsTranslation' );
			}

			function execute( $par ) {
				global $wgOut, $wgRequest;

				require_once( "forms.php" );
				require_once( "type.php" );
				require_once( "OmegaWikiAttributes.php" );
				require_once( "ViewInformation.php" );

				initializeOmegaWikiAttributes( new ViewInformation() );
				$wgOut->setPageTitle( wfMsg( 'ow_needs_xlation_title' ) );

				$destinationLanguageId = array_key_exists( 'to-lang', $_GET ) ? $_GET['to-lang']:'';
				$collectionId = array_key_exists( 'collection', $_GET ) ? $_GET['collection'] : '';
				$sourceLanguageId = array_key_exists( 'from-lang', $_GET ) ? $_GET['from-lang'] : '';
                                                                
				$wgOut->addHTML( getOptionPanel(
					array(
						wfMsg( 'ow_needs_xlation_dest_lang' ) => getSuggest( 'to-lang', 'language', array(), $destinationLanguageId, languageIdAsText( $destinationLanguageId ) ),
						wfMsg( 'ow_needs_xlation_source_lang' ) => getSuggest( 'from-lang', 'language', array(), $sourceLanguageId, languageIdAsText( $sourceLanguageId ) ),
						wfMsg( 'ow_Collection_colon' ) => getSuggest( 'collection', 'collection', array(), $collectionId, collectionIdAsText( $collectionId ) )
					)
				) );

				if ( $destinationLanguageId == '' )
					$wgOut->addHTML( '<p>' . wfMsg( 'ow_needs_xlation_no_dest_lang' ) . '</p>' );
				else
					$this->showExpressionsNeedingTranslation( $sourceLanguageId, $destinationLanguageId, $collectionId );
			}

			protected function showExpressionsNeedingTranslation( $sourceLanguageId, $destinationLanguageId, $collectionId ) {

				$o = OmegaWikiAttributes::getInstance();

				$dc = wdGetDataSetContext();
				require_once( "Transaction.php" );
				require_once( "OmegaWikiAttributes.php" );
				require_once( "RecordSet.php" );
				require_once( "Editor.php" );
				require_once( "WikiDataAPI.php" );

				$dbr = wfGetDB( DB_SLAVE );

				$sqlcount = 'SELECT COUNT(*)' .
					" FROM ({$dc}_syntrans source_syntrans, {$dc}_expression source_expression)";

				if ( $collectionId != '' )
					$sqlcount .= " JOIN {$dc}_collection_contents ON source_syntrans.defined_meaning_id = member_mid";

				$sqlcount .= ' WHERE source_syntrans.expression_id = source_expression.expression_id';

				if ( $sourceLanguageId != '' )
					$sqlcount .= ' AND source_expression.language_id = ' . $sourceLanguageId;
				if ( $collectionId != '' )
					$sqlcount .= " AND {$dc}_collection_contents.collection_id = " . $collectionId .
						' AND ' . getLatestTransactionRestriction( "{$dc}_collection_contents" );

				$sqlcount .= ' AND NOT EXISTS (' .
					" SELECT * FROM {$dc}_syntrans destination_syntrans, {$dc}_expression destination_expression" .
					' WHERE destination_syntrans.expression_id = destination_expression.expression_id AND destination_expression.language_id = ' . $destinationLanguageId .
					' AND source_syntrans.defined_meaning_id = destination_syntrans.defined_meaning_id' .
					' AND ' . getLatestTransactionRestriction( 'destination_syntrans' ) .
					' AND ' . getLatestTransactionRestriction( 'destination_expression' ) .
					')' .
					' AND ' . getLatestTransactionRestriction( 'source_syntrans' ) .
					' AND ' . getLatestTransactionRestriction( 'source_expression' ) ;

				$queryResultCount_r = mysql_query( $sqlcount );
				$queryResultCount_a = mysql_fetch_row( $queryResultCount_r );
				$queryResultCount = $queryResultCount_a[0];
				$nbshown = min ( 100, $queryResultCount ) ;


				$sql = 'SELECT source_expression.expression_id AS source_expression_id, source_expression.language_id AS source_language_id, source_expression.spelling AS source_spelling, source_syntrans.defined_meaning_id AS source_defined_meaning_id' .
					" FROM ({$dc}_syntrans source_syntrans, {$dc}_expression source_expression)";

				if ( $collectionId != '' )
					$sql .= " JOIN {$dc}_collection_contents ON source_syntrans.defined_meaning_id = member_mid";

				$sql .= ' WHERE source_syntrans.expression_id = source_expression.expression_id';

				if ( $sourceLanguageId != '' )
					$sql .= ' AND source_expression.language_id = ' . $sourceLanguageId;
				if ( $collectionId != '' )
					$sql .= " AND {$dc}_collection_contents.collection_id = " . $collectionId .
						' AND ' . getLatestTransactionRestriction( "{$dc}_collection_contents" );

				$sql .= ' AND NOT EXISTS (' .
					" SELECT * FROM {$dc}_syntrans destination_syntrans, {$dc}_expression destination_expression" .
					' WHERE destination_syntrans.expression_id = destination_expression.expression_id AND destination_expression.language_id = ' . $destinationLanguageId .
					' AND source_syntrans.defined_meaning_id = destination_syntrans.defined_meaning_id' .
					' AND ' . getLatestTransactionRestriction( 'destination_syntrans' ) .
					' AND ' . getLatestTransactionRestriction( 'destination_expression' ) .
					')' .
					' AND ' . getLatestTransactionRestriction( 'source_syntrans' ) .
					' AND ' . getLatestTransactionRestriction( 'source_expression' ) ;

				if ( $queryResultCount > 100 ) {
					$startnumber = rand ( 0 , $queryResultCount - 100 ) ;
					$sql .= " LIMIT $startnumber,100";
				} else {
					$sql .= ' LIMIT 100';
				}

				$queryResult = $dbr->query( $sql );


				$definitionAttribute = new Attribute( "definition", wfMsg( "ow_Definition" ), "definition" );

				$recordSet = new ArrayRecordSet( new Structure( $o->definedMeaningId, $o->expressionId, $o->expression, $definitionAttribute ), new Structure( $o->definedMeaningId, $o->expressionId ) );

				while ( $row = $dbr->fetchObject( $queryResult ) ) {
					$expressionRecord = new ArrayRecord( $o->expressionStructure );
					$expressionRecord->language = $row->source_language_id;
					$spellingAsLink = definedMeaningReferenceAsLink( $row->source_defined_meaning_id, $row->source_spelling, $row->source_spelling );
					$expressionRecord->spelling = $spellingAsLink ;

					$definition = getDefinedMeaningDefinitionForLanguage( $row->source_defined_meaning_id, $row->source_language_id ) ;
					if ( $definition == "" ) {
						$definition = getDefinedMeaningDefinition( $row->source_defined_meaning_id ) ;
					}

					$recordSet->addRecord( array( $row->source_defined_meaning_id, $row->source_expression_id, $expressionRecord, $definition ) );
				}

				$expressionEditor = new RecordTableCellEditor( $o->expression );
				$expressionEditor->addEditor( new LanguageEditor( $o->language, new SimplePermissionController( false ), false ) );
				$expressionEditor->addEditor( new ShortTextNoEscapeEditor( $o->spelling, new SimplePermissionController( false ), false ) );

				$editor = new RecordSetTableEditor( null, new SimplePermissionController( false ), new ShowEditFieldChecker( true ), new AllowAddController( false ), false, false, null );
				$editor->addEditor( $expressionEditor );
				$editor->addEditor( new TextEditor( $definitionAttribute, new SimplePermissionController( false ), false, true, 75 ) );

				global $wgOut;

				$wgOut->addHTML( "Showing $nbshown out of $queryResultCount" ) ;
				$wgOut->addHTML( $editor->view( new IdStack( "expression" ), $recordSet ) );
			}
		}

		SpecialPage::addPage( new SpecialNeedsTranslation );
	}


