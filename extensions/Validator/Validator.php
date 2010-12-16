<?php

/**
 * Initialization file for the Validator extension.
 * Extension documentation: http://www.mediawiki.org/wiki/Extension:Validator
 *
 * You will be validated. Resistance is futile.
 *
 * @file Validator.php
 * @ingroup Validator
 *
 * @author Jeroen De Dauw
 */

/**
 * This documenation group collects source code files belonging to Validator.
 *
 * Please do not use this group name for other code.
 *
 * @defgroup Validator Validator
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

define( 'Validator_VERSION', '0.4.2 rc1' );

// Register the internationalization file.
$wgExtensionMessagesFiles['Validator'] = dirname( __FILE__ ) . '/Validator.i18n.php';

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Validator',
	'version' => Validator_VERSION,
	'author' => array( '[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]' ),
	'url' => 'http://www.mediawiki.org/wiki/Extension:Validator',
	'descriptionmsg' => 'validator-desc',
);

// Autoload the classes.
$incDir = dirname( __FILE__ ) . '/includes/';
$wgAutoloadClasses['CriterionValidationResult']	= $incDir . 'CriterionValidationResult.php'; 
$wgAutoloadClasses['ItemParameterCriterion']	= $incDir . 'ItemParameterCriterion.php';
$wgAutoloadClasses['ItemParameterManipulation']	= $incDir . 'ItemParameterManipulation.php';
$wgAutoloadClasses['ListParameter'] 			= $incDir . 'ListParameter.php';
$wgAutoloadClasses['ListParameterCriterion']	= $incDir . 'ListParameterCriterion.php';
$wgAutoloadClasses['ListParameterManipulation']	= $incDir . 'ListParameterManipulation.php';
$wgAutoloadClasses['Parameter'] 				= $incDir . 'Parameter.php';
$wgAutoloadClasses['ParameterCriterion'] 		= $incDir . 'ParameterCriterion.php';
$wgAutoloadClasses['ParameterManipulation'] 	= $incDir . 'ParameterManipulation.php';
$wgAutoloadClasses['ParserHook'] 				= $incDir . 'ParserHook.php';
$wgAutoloadClasses['Validator'] 				= $incDir . 'Validator.php';
$wgAutoloadClasses['TopologicalSort'] 			= $incDir . 'TopologicalSort.php';
// No need to autoload this one, since it's directly included below.
//$wgAutoloadClasses['ValidationError']			= $incDir . 'ValidationError.php';
$wgAutoloadClasses['ValidationErrorHandler']	= $incDir . 'ValidationErrorHandler.php';

$wgAutoloadClasses['CriterionHasLength']		= $incDir . 'criteria/CriterionHasLength.php';
$wgAutoloadClasses['CriterionInArray']			= $incDir . 'criteria/CriterionInArray.php';
$wgAutoloadClasses['CriterionInRange']			= $incDir . 'criteria/CriterionInRange.php';
$wgAutoloadClasses['CriterionIsFloat']			= $incDir . 'criteria/CriterionIsFloat.php';
$wgAutoloadClasses['CriterionIsInteger']		= $incDir . 'criteria/CriterionIsInteger.php';
$wgAutoloadClasses['CriterionIsNumeric']		= $incDir . 'criteria/CriterionIsNumeric.php';
$wgAutoloadClasses['CriterionItemCount']		= $incDir . 'criteria/CriterionItemCount.php';
$wgAutoloadClasses['CriterionMatchesRegex']		= $incDir . 'criteria/CriterionMatchesRegex.php';
$wgAutoloadClasses['CriterionNotEmpty']			= $incDir . 'criteria/CriterionNotEmpty.php'; 
$wgAutoloadClasses['CriterionTrue']				= $incDir . 'criteria/CriterionTrue.php';
$wgAutoloadClasses['CriterionUniqueItems']		= $incDir . 'criteria/CriterionUniqueItems.php';

$wgAutoloadClasses['ParamManipulationBoolean']	= $incDir . 'manipulations/ParamManipulationBoolean.php';
$wgAutoloadClasses['ParamManipulationBoolstr']	= $incDir . 'manipulations/ParamManipulationBoolstr.php';
$wgAutoloadClasses['ParamManipulationFloat']	= $incDir . 'manipulations/ParamManipulationFloat.php';
$wgAutoloadClasses['ParamManipulationFunctions']= $incDir . 'manipulations/ParamManipulationFunctions.php';
$wgAutoloadClasses['ParamManipulationImplode']	= $incDir . 'manipulations/ParamManipulationImplode.php';
$wgAutoloadClasses['ParamManipulationInteger']	= $incDir . 'manipulations/ParamManipulationInteger.php';

$wgAutoloadClasses['ValidatorListErrors'] 		= $incDir . 'parserHooks/Validator_ListErrors.php';
unset( $incDir );

$wgExtensionFunctions[] = 'efValidatorSetup';

/**
 * Function for backwards compatibility with MW 1.15.x.
 * 
 * @since 0.4.2
 */
function efValidatorSetup() {
	// This function has been deprecated in 1.16, but needed for earlier versions.
	// It's present in 1.16 as a stub, but lets check if it exists in case it gets removed at some point.
	if ( function_exists( 'wfLoadExtensionMessages' ) ) {
		wfLoadExtensionMessages( 'Validator' );
	}
	
	return true;
}

// This file needs to be included directly, since Validator_Settings.php
// uses it, in some rare cases before autoloading is defined.
require_once 'includes/ValidationError.php' ;
// Include the settings file.
require_once 'Validator_Settings.php';
