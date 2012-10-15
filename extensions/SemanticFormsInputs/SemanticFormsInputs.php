<?php
/**
 * Additional input types for [http://www.mediawiki.org/wiki/Extension:SemanticForms Semantic Forms].
 *
 * @defgroup SFI Semantic Forms Inputs
 * 
 * @author Stephan Gambke
 * @author Yaron Koren
 * @author Jeroen de Dauw 
 * @author Sanyam Goyal
 * 
 * @version 0.5
 */

/**
 * The main file of the Semantic Forms Inputs extension
 *
 * @file
 * @ingroup SFI
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is part of a MediaWiki extension, it is not a valid entry point.' );
}

if ( !defined( 'SF_VERSION' ) ) {
	die( '<b>Error:</b> <a href="https://www.mediawiki.org/wiki/Extension:Semantic_Forms_Inputs">Semantic Forms Inputs</a> is a Semantic Forms extension. You need to install <a href="https://www.mediawiki.org/wiki/Extension:Semantic_Forms">Semantic Forms</a> first.' );
}

if ( version_compare( SF_VERSION, '2.3.1', 'lt' ) ) {
	die( '<b>Error:</b> This version of <a href="https://www.mediawiki.org/wiki/Extension:Semantic_Forms_Inputs">Semantic Forms Inputs</a> is only compatible with Semantic Forms 2.3.1 or above. You need to upgrade <a href="https://www.mediawiki.org/wiki/Extension:Semantic_Forms">Semantic Forms</a> first.' );
}

define( 'SFI_VERSION', '0.5' );

// create and initialize settings
$sfigSettings = new SFISettings();

// register extension
$wgExtensionCredits[defined( 'SEMANTIC_EXTENSION_TYPE' ) ? 'semantic' : 'other'][] = array(
	'path' => __FILE__,
	'name' => 'Semantic Forms Inputs',
	'author' => array( '[http://www.mediawiki.org/wiki/User:F.trott Stephan Gambke]', 'others' ),
	'url' => 'http://www.mediawiki.org/wiki/Extension:Semantic_Forms_Inputs',
	'descriptionmsg' => 'semanticformsinputs-desc',
	'version' => SFI_VERSION,
);

$dir = dirname( __FILE__ );

// load user settings
require_once( $dir . '/includes/SFI_Settings.php' );

$wgExtensionMessagesFiles['SemanticFormsInputs'] = $dir . '/SemanticFormsInputs.i18n.php';
$wgHooks['ParserFirstCallInit'][] = 'wfSFISetup';

$wgAutoloadClasses['SFIUtils'] = $dir . '/includes/SFI_Utils.php';
$wgAutoloadClasses['SFIDatePicker'] = $dir . '/includes/SFI_DatePicker.php';
$wgAutoloadClasses['SFITimePicker'] = $dir . '/includes/SFI_TimePicker.php';
$wgAutoloadClasses['SFIDateTimePicker'] = $dir . '/includes/SFI_DateTimePicker.php';
$wgAutoloadClasses['SFIMenuSelect'] = $dir . '/includes/SFI_MenuSelect.php';
$wgAutoloadClasses['SFIRegExp'] = $dir . '/includes/SFI_RegExp.php';

/**
 * Class to encapsulate all settings
 */
class SFISettings {
	// general settings
	public $scriptPath;

	// settings for input type datepicker
	public $datePickerFirstDate;
	public $datePickerLastDate;
	public $datePickerDateFormat;
	public $datePickerWeekStart;
	public $datePickerShowWeekNumbers;
	public $datePickerDisableInputField;
	public $datePickerShowResetButton;
	public $datePickerDisabledDaysOfWeek;
	public $datePickerHighlightedDaysOfWeek;
	public $datePickerDisabledDates;
	public $datePickerHighlightedDates;
	public $datePickerMonthNames;
	public $datePickerDayNames;
}

/**
 * Registers the input types with Semantic Forms.
 */
function wfSFISetup() {
	global $sfgFormPrinter, $wgVersion;

	$sfgFormPrinter->registerInputType( 'SFIDatePicker' );
	$sfgFormPrinter->registerInputType( 'SFITimePicker' );
	$sfgFormPrinter->registerInputType( 'SFIDateTimePicker' );
	$sfgFormPrinter->registerInputType( 'SFIMenuSelect' );
	$sfgFormPrinter->registerInputType( 'SFIRegExp' );
	
	// This function has been deprecated in 1.16, but needed for earlier versions.
	if ( version_compare( $wgVersion, '1.16', '<' ) ) {
		wfLoadExtensionMessages( 'SemanticFormsInputs' );
	}
	
	return true;
}
