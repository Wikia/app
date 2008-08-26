<?php

require_once("Wikidata.php"); 
// Attribute names (OLD)
// deprecated/ legacy code
// these definitions can now be found in App.php
// would replace all now, but I'd also need to go through
// OmegaWikiEditors.php with a fine-toothed comb, which I don't
// feel like doing right now:-P
//do not use for new items

global
	$wgAlternativeDefinitionAttributeName,
	$wgAlternativeDefinitionsAttributeName,
	$wgAnnotationAttributeName,
	$wgApproximateMeaningsAttributeName,
	$wgClassAttributeAttributeAttributeName,
	$wgClassAttributesAttributeName,
	$wgClassAttributeLevelAttributeName,
	$wgClassAttributeTypeAttributeName,
	$wgClassMembershipAttributeName,
	$wgCollectionAttributeName,
	$wgCollectionMembershipAttributeName,
	$wgDefinedMeaningAttributesAttributeName,
	$wgDefinedMeaningAttributeName,
	$wgDefinedMeaningReferenceAttributeName,
	$wgDefinitionAttributeName,
	$wgLanguageAttributeName,
	$wgExactMeaningsAttributeName,
	$wgExpressionAttributeName,
	$wgExpressionMeaningsAttributeName,
	$wgExpressionsAttributeName,
	$wgGotoSourceAttributeName,
	$wgIdenticalMeaningAttributeName,
	$wgIncomingRelationsAttributeName, 
	$wgLevelAnnotationAttributeName,
	$wgLinkAttributeAttributeName,
	$wgLinkAttributeValuesAttributeName,
	$wgOptionAttributeOptionAttributeName,
	$wgOptionAttributeOptionsAttributeName,
	$wgOptionAttributeValuesAttributeName,
	$wgOtherDefinedMeaningAttributeName,
	$wgPopupAnnotationName, 
	$wgRelationsAttributeName, 
	$wgRelationTypeAttributeName, 
	$wgSourceAttributeName,
	$wgSourceIdentifierAttributeName,
	$wgSpellingAttributeName,
	$wgSynonymsAttributeName,
	$wgSynonymsAndTranslationsAttributeName,
	$wgTextAttributeAttributeName,
	$wgTextAttributeName,
	$wgTextAttributeValuesAttributeName,
	$wgTranslatedTextAttributeAttributeName,
	$wgTranslatedTextAttributeName,
	$wgTranslatedTextAttributeValueAttributeName,
	$wgTranslatedTextAttributeValuesAttributeName;

$wgAlternativeDefinitionAttributeName = "Alternative definition";
$wgAlternativeDefinitionsAttributeName = "Alternative definitions";	
$wgAnnotationAttributeName = "Annotation";
$wgApproximateMeaningsAttributeName = "Approximate meanings";	
$wgClassAttributeAttributeAttributeName = "Attribute";
$wgClassAttributesAttributeName = "Class attributes";
$wgClassAttributeLevelAttributeName = "Level";
$wgClassAttributeTypeAttributeName = "Type";
$wgClassMembershipAttributeName = "Class membership";
$wgCollectionAttributeName = "Collection";
$wgCollectionMembershipAttributeName = "Collection membership";
$wgDefinitionAttributeName = "Definition";
$wgDefinedMeaningAttributesAttributeName = "Annotation";
$wgDefinedMeaningAttributeName = "Defined meaning";
$wgDefinedMeaningReferenceAttributeName = "Defined meaning";
$wgExactMeaningsAttributeName = "Exact meanings";
$wgExpressionAttributeName = "Expression";
$wgExpressionMeaningsAttributeName = "Expression meanings";
$wgExpressionsAttributeName = "Expressions";
$wgIdenticalMeaningAttributeName = "Identical meaning?";
$wgIncomingRelationsAttributeName = "Incoming relations";
$wgGotoSourceAttributeName = "Go to source";
$wgLanguageAttributeName = "Language";
$wgLevelAnnotationAttributeName = "Annotation";
$wgOptionAttributeAttributeName = "Property";
$wgOptionAttributeOptionAttributeName = "Option";
$wgOptionAttributeOptionsAttributeName = "Options";
$wgOptionAttributeValuesAttributeName = "Options";
$wgOtherDefinedMeaningAttributeName = "Other defined meaning";
$wgPopupAnnotationName = "Annotation";
$wgRelationsAttributeName = "Relations";
$wgRelationTypeAttributeName = "Relation type";
$wgSpellingAttributeName = "Spelling";
$wgSynonymsAttributeName = "Synonyms"; 
$wgSynonymsAndTranslationsAttributeName = "Synonyms and translations";
$wgSourceAttributeName = "Source";
$wgSourceIdentifierAttributeName = "Source identifier";
$wgTextAttributeAttributeName = "Property";
$wgTextAttributeName = "Text";
$wgTextAttributeValuesAttributeName = "Plain texts";
$wgTranslatedTextAttributeAttributeName = "Property";
$wgTranslatedTextAttributeName = "Translated text";
$wgTranslatedTextAttributeValueAttributeName = "Text";
$wgTranslatedTextAttributeValuesAttributeName = "Translatable texts";
$wgLinkAttributeAttributeName = "Property";
$wgLinkAttributeValuesAttributeName = "Links";

// Attribute Ids

global
	$wgAlternativeDefinitionsAttributeId,
	$wgClassAttributesAttributeId,
	$wgClassMembershipAttributeId,
	$wgCollectionMembershipAttributeId,
	$wgDefinedMeaningAttributesAttributeId,
	$wgDefinitionAttributeId,
	$wgIncomingRelationsAttributeId,
	$wgRelationsAttributeId, 
	$wgSynonymsAndTranslationsAttributeId;
	
$wgAlternativeDefinitionsAttributeId = "alternative-definitions";
$wgClassAttributesAttributeId = "class-attributes";
$wgClassMembershipAttributeId = "class-membership";
$wgCollectionMembershipAttributeId = "collection-membership";
$wgDefinedMeaningAttributesAttributeId = "defined-meaning-attributes";
$wgDefinitionAttributeId = "definition";
$wgIncomingRelationsAttributeId = "reciprocal-relations";
$wgRelationsAttributeId = "relations"; 
$wgSynonymsAndTranslationsAttributeId = "synonyms-translations";

// Defined meaning editor

global
	$wdDefinedMeaningAttributesOrder;
	
$wdDefinedMeaningAttributesOrder = array(
	$wgDefinitionAttributeId,
	$wgClassAttributesAttributeId,
	$wgAlternativeDefinitionsAttributeId,
	$wgSynonymsAndTranslationsAttributeId,
	$wgIncomingRelationsAttributeId,
	$wgClassMembershipAttributeId,
	$wgCollectionMembershipAttributeId,
	$wgDefinedMeaningAttributesAttributeId
);

// Go to source templates

require_once("GotoSourceTemplate.php");

global
	$wgGotoSourceTemplates;

$wgGotoSourceTemplates = array();	// Map of collection id => GotoSourceTemplate

// Page titles

global
	$wgDefinedMeaningPageTitlePrefix,
	$wgExpressionPageTitlePrefix;
	
$wgDefinedMeaningPageTitlePrefix = "";
$wgExpressionPageTitlePrefix = "Multiple meanings";

// Search page

global
	$wgSearchWithinExternalIdentifiersDefaultValue,
	$wgSearchWithinWordsDefaultValue,
	$wgShowSearchWithinExternalIdentifiersOption,
	$wgShowSearchWithinWordsOption;

$wgSearchWithinExternalIdentifiersDefaultValue = true;
$wgSearchWithinWordsDefaultValue = true;
$wgShowSearchWithinExternalIdentifiersOption = true;
$wgShowSearchWithinWordsOption = true;

// Annotation to column filtering

require_once("PropertyToColumnFilter.php"); 

global
	$wgPropertyToColumnFilters;
	
/** 
 * $wgPropertyToColumnFilters is an array of property to column filters 
 * 
 * Example:
 *   $wgPropertyToColumnFilters = array(
 *     new PropertyToColumnFilter("references", "References", array(1000, 2000, 3000)) // Defined meaning ids are the attribute ids to filter
 *   )
 * 
 */	
$wgPropertyToColumnFilters = array(); 
?>
