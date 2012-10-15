<?php

define( 'NS_EXPRESSION', 16 );
define( 'NS_DEFINEDMEANING', 24 );

require_once( "Wikidata.php" );

// Ids
// Work in progress: (Kip)
// global variables here should be created for each Attribute in OmegaWikiAttributes.php
// sometimes, other php files have to be adapted...

global $wgOptionSuffix;
$wgOptionSuffix = "Optn" ;


global
	$wgAlternativeDefinition,
	$wgAlternativeDefinitions,
	$wgClassAttributes,
	$wgClassMembership,
	$wgCollectionMembership,
	$wgDefinedMeaning,
	$wgDefinedMeaningAttributes,
	$wgDefinition,
	$wgExpression,
	$wgExpressionApproximateMeanings,
	$wgExpressionExactMeanings,
	$wgExpressionMeanings,
	$wgIncomingRelations,
	$wgLinkAttribute,
	$wgLinkAttributeValues,
	$wgObjectAttributes,
	$wgOptionAttribute,
	$wgOptionAttributeOption,
	$wgOptionAttributeValues,
	$wgOtherDefinedMeaning,
	$wgRelations,
	$wgSynonymsAndTranslations,
	$wgTextAttributeValues,
	$wgTranslatedText;


	$wgAlternativeDefinition = "altDef";
	$wgAlternativeDefinitions = "altDefs";
	$wgClassAttributes = "classAtt";
	$wgClassMembership = "classMembers";
	$wgCollectionMembership = "colMembers";
	$wgDefinedMeaning = "dm";
	$wgDefinedMeaningAttributes = "dmAtt";
	$wgDefinition = "def";
	$wgExpression = "exp";
	$wgExpressionApproximateMeanings = "approx" ;
	$wgExpressionExactMeanings = "exact" ;
	$wgExpressionMeanings = "meanings";
	$wgIncomingRelations = "incomingRel";
	$wgLinkAttribute = "linkAtt";
	$wgLinkAttributeValues = $wgLinkAttribute."Val";
	$wgObjectAttributes = "objAtt";
	$wgOptionAttribute = "optnAtt"; // must be the same in suggest.js
	$wgOptionAttributeOption = $wgOptionAttribute.$wgOptionSuffix;
	$wgOptionAttributeValues = $wgOptionAttribute."Val";
	$wgOtherDefinedMeaning = "otherDm";
	$wgRelations = "rel";
	$wgSynonymsAndTranslations = "syntrans";
	$wgTextAttributeValues = "txtAttVal";
	$wgTranslatedText = "transl" ;



// Defined meaning editor

global
	$wdDefinedMeaningAttributesOrder;
	
$wdDefinedMeaningAttributesOrder = array(
	$wgDefinition,
	$wgClassAttributes,
	$wgAlternativeDefinitions,
	$wgSynonymsAndTranslations,
	$wgIncomingRelations,
	$wgClassMembership,
	$wgCollectionMembership,
	$wgDefinedMeaningAttributes
);

// Go to source templates

require_once( "GotoSourceTemplate.php" );

global
	$wgGotoSourceTemplates;

$wgGotoSourceTemplates = array();	// Map of collection id => GotoSourceTemplate

// Page titles

global
	$wgDefinedMeaningPageTitlePrefix,
	// $wgExpressionPageTitlePrefix;
	$wgUseExpressionPageTitlePrefix;
	
$wgDefinedMeaningPageTitlePrefix = "";
// $wgExpressionPageTitlePrefix = "Multiple meanings"; # Now it's localizable
$wgUseExpressionPageTitlePrefix = true;	# malafaya: Use the expression prefix "Multiple meanings:" from message ow_Multiple_meanings

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

require_once( "PropertyToColumnFilter.php" );

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

// Hook: replace the proposition to "create new page" by a custom, allowing to create new expression as well
$wgHooks[ 'SpecialSearchNogomatch' ][] = 'owNoGoMatchHook';

function owNoGoMatchHook( &$title ) {
	global $wgOut,$wgDisableTextSearch;
	$wgOut->addWikiMsg( 'search-nonefound' );
	$wgOut->addWikiMsg( 'ow_searchnoresult', wfEscapeWikiText( $title ) );
//	$wgOut->addWikiMsg( 'ow_searchnoresult', $title );

	$wgDisableTextSearch = true ;
	return true;
}



// Hook: The Go button should search (first) in the Expression namespace instead of Article namespace
$wgHooks[ 'SearchGetNearMatchBefore' ][] = 'owGoClicked';

function owGoClicked( $allSearchTerms, &$title ) {
	$term = $allSearchTerms[0] ;
	$title = Title::newFromText( $term ) ;
	if ( is_null( $title ) ){
		return true;
	}

	# Replace normal namespace with expression namespace
	if ( $title->getNamespace() == NS_MAIN ) {
		$title = Title::newFromText( $term, NS_EXPRESSION ) ; // $expressionNamespaceId ) ;
	}

	if ( $title->exists() ) {
		return false; // match!
	}
	return true; // no match
}

?>
