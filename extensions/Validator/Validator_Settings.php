<?php

/**
 * File defining the settings for the Validator extension
 *
 *                          NOTICE:
 * Changing one of these settings can be done by copying or cutting it,
 * and placing it in LocalSettings.php, AFTER the inclusion of Validator.
 *
 * @file Validator_Settings.php
 * @ingroup Validator
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

# Maps actions to error severity.
# ACTION_LOG will cause the error to be logged
# ACTION_WARN will cause a notice that there is an error to be shown inline
# ACTION_SHOW will cause an error message to be shown inline
# ACTION_DEMAND will cause an error message to be shown inline and prevent rendering of the regular output
$egErrorActions = array(
	ValidationError::SEVERITY_MINOR => ValidationError::ACTION_LOG,
	ValidationError::SEVERITY_LOW => ValidationError::ACTION_WARN,
	ValidationError::SEVERITY_NORMAL => ValidationError::ACTION_SHOW,
	ValidationError::SEVERITY_HIGH => ValidationError::ACTION_DEMAND,
);

$egValidatorErrListMin = 'minor';
