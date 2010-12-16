<?php

require_once( "Attribute.php" );
require_once( "WikiDataGlobals.php" );
require_once( "ViewInformation.php" );
require_once( "Utilities.php" );

/**
 *
 * This file models the structure of the OmegaWiki database in a
 * database-independent fashion. To do so, it follows a simplified
 * relational model, consisting of Attribute objects which are hierarchically
 * grouped together using Structure objects. See Attribute.php for details.
 *
 * The actual data is stored in Records, grouped together as RecordSets.
 * See Record.php and RecordSet.php for details.
 *
 * OmegawikiAttributes2.php was running out of date already, so
 * merging here.
 *
 * TODO:
 * - Records and RecordSets are currently capable of storing most (not all)
 * data, but can't actually commit them to the database again. To achieve
 * proper separation of architectural layers, the Records should learn
 * to talk directly with the DB layer.
 # - This is not a pure singleton, because it relies on the existence of
 #   of viewInformation, and a message cache. We now defer lookups in these
 #   to as late as possible, to make sure these items are actually initialized.
 */
function initializeOmegaWikiAttributes( ViewInformation $viewInformation ) {
	$init_and_discard_this = OmegaWikiAttributes::getInstance( $viewInformation );
}


class OmegaWikiAttributes {

	/** pseudo-Singleton, if viewinformation changes, will construct new instance*/
	static function getInstance( ViewInformation $viewInformation = null ) {
		static $instance = array();
		if ( !is_null( $viewInformation ) ) {
			if ( !array_key_exists( $viewInformation->hashCode(), $instance ) ) {
				$instance["last"] = new OmegaWikiAttributes( $viewInformation );
				$instance[$viewInformation->hashCode()] = $instance["last"];
			}
		}
		if ( !array_key_exists( "last", $instance ) ) {
			$instance["last"] = new OmegaWikiAttributes( new ViewInformation() );
		}
		return $instance["last"];
	}


	protected $attributes = array();
	protected $setup_completed = False;
	protected $in_setup = False; # for use by functions doing the setup itself (currently hardValues) 
	protected $viewInformation = null;

	function __construct( ViewInformation $viewInformation ) {
		$this->setup( $viewInformation );
	}

	protected function setup( ViewInformation $viewInformation = null ) {
		if ( $this->in_setup or $this->setup_completed )
			return True;

		if ( !is_null( $viewInformation ) ) {
			$this->viewInformation = $viewInformation;
		}
		$viewInformation = $this->viewInformation;

		if ( !is_null( $viewInformation ) ) {
			if ( !$this->setup_completed ) {
				$this->hardValues( $viewInformation );
			}
			$this->setup_completed = True;
			return True;
		}
		return False;
	}

	/** Hardcoded schema for now. Later refactor to load from file or DB 
	 * 
	 * Naming: keys are previous name minus -"Attribute"
	 * 	(-"Structure" is retained, -"Attributes" is retained)
	*/
	private function hardValues( viewInformation $viewInformation ) {
	
		assert ( !is_null( $viewInformation ) );
		$t = $this; # <-keep things short to declutter

		$t->in_setup = True;
		$t->language = new Attribute( "language", wfMsgSc( "Language" ), "language" );
		$t->spelling = new Attribute( "spelling", wfMsgSc( "Spelling" ), "spelling" );
		$t->text = new Attribute( "text", wfMsgSc( "Text" ), "text" );

		global
			$wgAlternativeDefinition, $wgAlternativeDefinitions,
			$wgClassAttributes,
			$wgClassMembership,
			$wgCollectionMembership,
			$wgDefinedMeaning, $wgDefinedMeaningAttributes,
			$wgDefinition,
			$wgExpression, $wgExpressionApproximateMeanings, $wgExpressionExactMeanings, $wgExpressionMeanings,
			$wgIncomingRelations,
			$wgLinkAttribute, $wgLinkAttributeValues,
			$wgObjectAttributes,
			$wgOptionAttribute, $wgOptionAttributeOption, $wgOptionAttributeValues,
			$wgOtherDefinedMeaning,
			$wgRelations,
			$wgSynonymsAndTranslations,
			$wgTextAttributeValues,
			$wgTranslatedText;

		$t->definedMeaningAttributes = new Attribute( $wgDefinedMeaningAttributes, wfMsgSc( "DefinedMeaningAttributes" ), "will-be-specified-below" );
		$t->objectAttributes = new Attribute( $wgObjectAttributes, wfMsgSc( "Annotation" ), "will-be-specified-below" );
		$t->expressionId = new Attribute( "expression-id", "Expression Id", "expression-id" );
		$t->identicalMeaning = new Attribute( "identMeaning", wfMsgSc( "IdenticalMeaning" ), "boolean" );

		if ( $viewInformation->filterOnLanguage() )
			$t->expression = new Attribute( $wgExpression, wfMsgSc( "Spelling" ), "spelling" );
		else {
			$t->expressionStructure = new Structure( $wgExpression, $t->language, $t->spelling );
			$t->expression = new Attribute( $wgExpression, wfMsgSc( "Expression" ), $t->expressionStructure );
		}

		$t->definedMeaningId = new Attribute( "defined-meaning-id", "Defined meaning identifier", "defined-meaning-id" );
		$t->definedMeaningDefiningExpression = new Attribute( "defined-meaning-defining-expression", "Defined meaning defining expression", "short-text" );
		$t->definedMeaningCompleteDefiningExpressionStructure =
			new Structure( "defined-meaning-complete-defining-expression",
				  $t->definedMeaningDefiningExpression,
				  $t->expressionId,
				  $t->language
			);
		# try this
		$t->definedMeaningCompleteDefiningExpressionStructure->setStructureType( $wgExpression );
		$t->definedMeaningCompleteDefiningExpression = new Attribute( null, "Defining expression", $t->definedMeaningCompleteDefiningExpressionStructure );

		global $definedMeaningReferenceType;

		$t->definedMeaningLabel = new Attribute( "defined-meaning-label", "Defined meaning label", "short-text" );
		$t->definedMeaningReferenceStructure = new Structure( $wgDefinedMeaning, $t->definedMeaningId, $t->definedMeaningLabel, $t->definedMeaningDefiningExpression );
		$definedMeaningReferenceType = $t->definedMeaningReferenceStructure;
		$t->definedMeaningReference = new Attribute( null, wfMsgSc( "DefinedMeaningReference" ), $definedMeaningReferenceType );
		$t->collectionId = new Attribute( "collection", "Collection", "collection-id" );
		$t->collectionMeaning = new Attribute( "collection-meaning", wfMsgSc( "Collection" ), $t->definedMeaningReferenceStructure );
		$t->sourceIdentifier = new Attribute( "source-identifier", wfMsgSc( "SourceIdentifier" ), "short-text" );
		$t->gotoSourceStructure = new Structure( "goto-source", $t->collectionId, $t->sourceIdentifier );
		$t->gotoSource = new Attribute( null, wfMsgSc( "GotoSource" ), $t->gotoSourceStructure );

		$t->collectionMembershipStructure = new Structure( $wgCollectionMembership, $t->collectionId, $t->collectionMeaning, $t->sourceIdentifier );
		$t->collectionMembership = new Attribute( null, wfMsgSc( "CollectionMembership" ), $t->collectionMembershipStructure );

		$t->classMembershipId = new Attribute( "class-membership-id", "Class membership id", "integer" );
		$t->class = new Attribute( "class", wfMsg( 'ow_Class' ), $t->definedMeaningReferenceStructure );
		$t->classMembershipStructure = new Structure( $wgClassMembership, $t->classMembershipId, $t->class );
		$t->classMembership = new Attribute( null, wfMsgSc( "ClassMembership" ), $t->classMembershipStructure );

		global $relationTypeType;

		$t->relationId = new Attribute( "relation-id", "Relation identifier", "object-id" );
		$t->relationType = new Attribute( "relation-type", wfMsgSc( "RelationType" ), $t->definedMeaningReferenceStructure );
		$t->otherDefinedMeaning = new Attribute( $wgOtherDefinedMeaning, wfMsgSc( "OtherDefinedMeaning" ), $definedMeaningReferenceType );

		$t->relationStructure = new Structure( $wgRelations, $t->relationId, $t->relationType, $t->otherDefinedMeaning );
		$t->relations = new Attribute( $wgRelations, wfMsgSc( "Relations" ), $t->relationStructure );
		$t->reciprocalRelations = new Attribute( $wgIncomingRelations, wfMsgSc( "IncomingRelations" ), $t->relationStructure );
		$t->translatedTextId = new Attribute( "translated-text-id", "Translated text ID", "integer" );
		$t->translatedTextStructure = new Structure( $wgTranslatedText, $t->language, $t->text );

		$t->definitionId = new Attribute( "definition-id", "Definition identifier", "integer" );

		if ( $viewInformation->filterOnLanguage() && !$viewInformation->hasMetaDataAttributes() )
			$t->alternativeDefinition = new Attribute( $wgAlternativeDefinition, wfMsgSc( "AlternativeDefinition" ), "text" );
		else
			$t->alternativeDefinition = new Attribute( $wgAlternativeDefinition, wfMsgSc( "AlternativeDefinition" ), $t->translatedTextStructure );
		
		$t->source = new Attribute( "source-id", wfMsgSc( "Source" ), $definedMeaningReferenceType );
		
		$t->alternativeDefinitionsStructure =  new Structure( $wgAlternativeDefinitions, $t->definitionId, $t->alternativeDefinition, $t->source );
		$t->alternativeDefinitions = new Attribute( null, wfMsgSc( "AlternativeDefinitions" ), $t->alternativeDefinitionsStructure );
		
		if ( $viewInformation->filterOnLanguage() )
			$synonymsAndTranslationsCaption = wfMsgSc( "Synonyms" );
		else
			$synonymsAndTranslationsCaption = wfMsgSc( "SynonymsAndTranslations" );

		$t->syntransId = new Attribute( "syntrans-id", "$synonymsAndTranslationsCaption identifier", "integer" );
		$t->synonymsTranslationsStructure = new Structure( $wgSynonymsAndTranslations, $t->syntransId, $t->expression, $t->identicalMeaning );
		$t->synonymsAndTranslations = new Attribute( null, "$synonymsAndTranslationsCaption", $t->synonymsTranslationsStructure );
		$t->translatedTextAttributeId = new Attribute( "translated-text-attribute-id", "Attribute identifier", "object-id" );
		$t->translatedTextAttribute = new Attribute( "translated-text-attribute", wfMsgSc( "TranslatedTextAttribute" ), $definedMeaningReferenceType );
		$t->translatedTextValueId = new Attribute( "translated-text-value-id", "Translated text value identifier", "translated-text-value-id" );
		
		$t->attributeObjectId = new Attribute( "attributeObjectId", "Attribute object", "object-id" );

		if ( $viewInformation->filterOnLanguage() && !$viewInformation->hasMetaDataAttributes() )
			$t->translatedTextValue = new Attribute( "translated-text-value", wfMsgSc( "TranslatedTextAttributeValue" ), "text" );
		else
			$t->translatedTextValue = new Attribute( "translated-text-value", wfMsgSc( "TranslatedTextAttributeValue" ), $t->translatedTextStructure );
		
		$t->translatedTextAttributeValuesStructure = new Structure( "translated-text-attribute-values", $t->translatedTextAttributeId, $t->attributeObjectId, $t->translatedTextAttribute, $t->translatedTextValueId, $t->translatedTextValue );
		$t->translatedTextAttributeValues = new Attribute( null, wfMsgSc( "TranslatedTextAttributeValues" ), $t->translatedTextAttributeValuesStructure );
		$t->attributeObject = new Attribute( "attribute-object-id", "Attribute object", "object-id" );

		$t->textAttributeId = new Attribute( "text-attribute-id", "Attribute identifier", "object-id" );
		$t->textAttributeObject = new Attribute( "text-attribute-object-id", "Attribute object", "object-id" );
		$t->textAttribute = new Attribute( "text-attribute", wfMsgSc( "TextAttribute" ), $t->definedMeaningReferenceStructure );
		$t->textAttributeValuesStructure = new Structure( $wgTextAttributeValues, $t->textAttributeId, $t->textAttributeObject, $t->textAttribute, $t->text );
		$t->textAttributeValues = new Attribute( null, wfMsgSc( "TextAttributeValues" ), $t->textAttributeValuesStructure );
		
		$t->linkLabel = new Attribute( "label", wfMsg( 'ow_Label' ), "short-text" );
		$t->linkURL = new Attribute( "url", wfMsg( 'ow_URL' ), "url" );
		$t->link = new Attribute( "link", wfMsg( 'ow_Link' ), new Structure( $t->linkLabel, $t->linkURL ) );
		$t->linkAttributeId = new Attribute( "link-attribute-id", "Attribute identifier", "object-id" );
		$t->linkAttributeObject = new Attribute( "link-attribute-object-id", "Attribute object", "object-id" );
		$t->linkAttribute = new Attribute( $wgLinkAttribute, wfMsgSc( "LinkAttribute" ), $t->definedMeaningReferenceStructure );
		$t->linkAttributeValuesStructure = new Structure( $wgLinkAttributeValues, $t->linkAttributeId, $t->linkAttributeObject, $t->linkAttribute, $t->link );
		$t->linkAttributeValues = new Attribute( null, wfMsgSc( "LinkAttributeValues" ), $t->linkAttributeValuesStructure );
		
		$t->optionAttributeId = new Attribute( "option-attribute-id", "Attribute identifier", "object-id" );
		$t->optionAttributeObject = new Attribute( "option-attribute-object-id", "Attribute object", "object-id" );
		$t->optionAttribute = new Attribute( $wgOptionAttribute, wfMsgSc( "OptionAttribute" ), $definedMeaningReferenceType );
		$t->optionAttributeOption = new Attribute( $wgOptionAttributeOption, wfMsgSc( "OptionAttributeOption" ), $definedMeaningReferenceType );
		$t->optionAttributeValuesStructure = new Structure( $wgOptionAttributeValues, $t->optionAttributeId, $t->optionAttribute, $t->optionAttributeObject, $t->optionAttributeOption );
		$t->optionAttributeValues = new Attribute( null, wfMsgSc( "OptionAttributeValues" ), $t->optionAttributeValuesStructure );
		$t->optionAttributeOptionId = new Attribute( "option-attribute-option-id", "Option identifier", "object-id" );
		$t->optionAttributeOptionsStructure = new Structure( "option-attribute-options", $t->optionAttributeOptionId, $t->optionAttribute, $t->optionAttributeOption, $t->language );
		$t->optionAttributeOptions = new Attribute( null, wfMsgSc( "OptionAttributeOptions" ), $t->optionAttributeOptionsStructure );
		
		if ( $viewInformation->filterOnLanguage() && !$viewInformation->hasMetaDataAttributes() )
			$t->translatedText = new Attribute( $wgTranslatedText, wfMsgSc( "Text" ), "text" );
		else
			$t->translatedText = new Attribute( $wgTranslatedText, wfMsgSc( "TranslatedText" ), $t->translatedTextStructure );
			

		$t->definition = new Attribute( null, wfMsgSc( "Definition" ), new Structure( $wgDefinition, $t->translatedText ) );

		$t->classAttributeId = new Attribute( "class-attribute-id", "Class attribute identifier", "object-id" );
		$t->classAttributeAttribute = new Attribute( "class-attribute-attribute", wfMsgSc( "ClassAttributeAttribute" ), $t->definedMeaningReferenceStructure );
		$t->classAttributeLevel = new Attribute( "class-attribute-level", wfMsgSc( "ClassAttributeLevel" ), $t->definedMeaningReferenceStructure );
		$t->classAttributeType = new Attribute( "class-attribute-type", wfMsgSc( "ClassAttributeType" ), "short-text" );
		$t->classAttributesStructure = new Structure( $wgClassAttributes, $t->classAttributeId, $t->classAttributeAttribute, $t->classAttributeLevel, $t->classAttributeType, $t->optionAttributeOptions );
		$t->classAttributes = new Attribute( null, wfMsgSc( "ClassAttributes" ), $t->classAttributesStructure );

		$t->definedMeaning = new Attribute( null, wfMsgSc( "DefinedMeaning" ),
			new Structure(
				$wgDefinedMeaning,
				$t->definedMeaningId,
				$t->definedMeaningCompleteDefiningExpression,
				$t->definition,
				$t->classAttributes,
				$t->alternativeDefinitions,
				$t->synonymsAndTranslations,
				$t->reciprocalRelations,
				$t->classMembership,
				$t->collectionMembership,
				$t->definedMeaningAttributes
			)
		);

		$t->expressionMeaningStructure = new Structure( $t->definedMeaningId, $t->text, $t->definedMeaning );
		$t->expressionExactMeanings = new Attribute( $wgExpressionExactMeanings, wfMsgSc( "ExactMeanings" ), $t->expressionMeaningStructure );
		$t->expressionApproximateMeanings = new Attribute( $wgExpressionApproximateMeanings, wfMsgSc( "ApproximateMeanings" ), $t->expressionMeaningStructure );
		$t->expressionMeaningsStructure = new Structure( $wgExpressionMeanings, $t->expressionExactMeanings, $t->expressionApproximateMeanings );
		$t->expressionMeanings = new Attribute( null, wfMsgSc( "ExpressionMeanings" ), $t->expressionMeaningsStructure );
		$t->expressionsStructure = new Structure( "expressions", $t->expressionId, $t->expression, $t->expressionMeanings );
		$t->expressions = new Attribute( null, wfMsgSc( "Expressions" ), $t->expressionsStructure );
		
		$t->objectId = new Attribute( "object-id", "Object identifier", "object-id" );
		$t->objectAttributesStructure = new Structure( "object-attributes",
			$t->objectId,
			$t->relations,
			$t->textAttributeValues,
			$t->translatedTextAttributeValues,
			$t->linkAttributeValues,
			$t->optionAttributeValues
		);
		
		$t->objectAttributes->setAttributeType( $t->objectAttributesStructure );
		$t->definedMeaningAttributes->setAttributeType( $t->objectAttributesStructure );
		
		$annotatedAttributes = array(
			$t->definedMeaning,
			$t->definition,
			$t->synonymsAndTranslations,
			$t->relations,
			$t->reciprocalRelations,
			$t->textAttributeValues,
			$t->linkAttributeValues,
			$t->translatedTextAttributeValues,
			$t->optionAttributeValues
		);
		
		foreach ( $annotatedAttributes as $annotatedAttribute )
			$annotatedAttribute->type->addAttribute( $t->objectAttributes );
		
		foreach ( $viewInformation->getPropertyToColumnFilters() as $propertyToColumnFilter ) {
			$attribute = $propertyToColumnFilter->getAttribute();
			$attribute->setAttributeType( $t->objectAttributesStructure );
			
			foreach ( $annotatedAttributes as $annotatedAttribute )
				$annotatedAttribute->type->addAttribute( $attribute );
		}
		
		# transaction stuff 
		$t->transactionId = new Attribute( 'transaction-id', 'Transaction ID', 'integer' );
		$t->user = new Attribute( 'user', wfMsg( 'ow_User' ), 'user' );
		$t->userIP = new Attribute( 'user-ip', 'User IP', 'IP' );
		$t->timestamp = new Attribute( 'timestamp', wfMsg( 'ow_Time' ), 'timestamp' );
		$t->summary = new Attribute( 'summary', 'Summary', 'text' );
		$t->transactionStructure = new Structure( $t->transactionId, $t->user, $t->userIP, $t->timestamp, $t->summary );
		$t->transaction = new Attribute( 'transaction', 'Transaction', $t->transactionStructure );

		$t->addTransaction = new Attribute( 'add-transaction', wfMsg( 'ow_added' ), $t->transactionStructure );
		$t->removeTransaction = new Attribute( 'remove-transaction', wfMsg( 'ow_removed' ), $t->transactionStructure );

		$t->recordLifeSpanStructure = new Structure( $t->addTransaction, $t->removeTransaction );
		$t->recordLifeSpan = new Attribute( 'record-life-span', wfMsg( 'ow_RecordLifeSpan' ), $t->recordLifeSpanStructure );

		$t->in_setup = False;
	}

	public function __set( $key, $value ) {
		if ( !$this->setup() )
			throw new Exception( "OmegaWikiAttributes accessed, but was not properly initialized" );
		$attributes =& $this->attributes;
		$attributes[$key] = $value;
	}
	
	public function __get( $key ) {
		if ( !$this->setup() )
			throw new MwException( "OmegaWikiAttributes accessed, but was not properly initialized" );
		$attributes =& $this->attributes;
		if ( !array_key_exists( $key, $attributes ) ) {
			throw new MwException( "Key does not exist: " . $key );
		}
		return $attributes[$key];
	}
}



