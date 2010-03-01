<?php

/**
 * File defining the settings for the Validator extension
 *
 *                          NOTICE:
 * Changing one of these settings can be done by copieng or cutting it,
 * and placing it in LocalSettings.php, AFTER the inclusion of Validator.
 *
 * @file Validator_Settings.php
 * @ingroup Validator
 *
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

# Integer. The strictness of the parameter validation and resulting error report when using the ValidatorManager class.
# Validator_ERRORS_NONE  	: Validator will not show any errors, and make the best of the input it got.
# Validator_ERRORS_MINIMAL	: Validator will only show a warning when the output could not be generated.
# Validator_ERRORS_WARN		: Validator will make the best of the input it got, but will show a warning that there are errors.
# Validator_ERRORS_SHOW		: Validator will make the best of the input it got, but will show a list of all errors.
# Validator_ERRORS_STRICT	: Validator will only show regular output when there are no errors, if there are, a list of them will be shown.
$egValidatorErrorLevel = Validator_ERRORS_SHOW;