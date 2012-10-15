<?php
/**
 * Internationalisation file for extension TableData.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Daniel Friesen
 */
$messages['en'] = array(
	'tabledata-desc' => "Implements a parser tag that can accept data in a variety of formats such as CSV and format it into a table potentially using templates to format it.",
	
	// Errors
	'datatable-error-formatnotdefined' => 'DataTable Error: A valid format for the input data was not defined.',
	'datatable-error-invalidformat' => 'DataTable Error: There is no parser for the "$1" format of input data.',
	'datatable-error-invalidtemplatetitle' => 'DataTable Error: "$2" is not a valid template title to use in the $1 attribute.',
	'datatable-error-noseparator' => 'DataTable Error: A separator was not defined for the separated input format.',
	'datatable-error-invalidseparator' => 'DataTable Error: The separator "$1" does not exist.',
);
