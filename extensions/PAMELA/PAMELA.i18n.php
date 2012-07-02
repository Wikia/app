<?php

/**
 * Internationalization file for the PAMELA extension.
 *
 * @file PAMELA.i18n.php
 * @ingroup PAMELA
 *
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

$messages = array();

/** English
 * @author Jeroen De Dauw
 */
$messages['en'] = array(
	'pamela-desc' => '[http://hackerspaces.be/Pamela PAMELA] client for MediaWiki.',

	'pamela-loading' => 'Loading PAMELA',

	// List widget
	'pamela-listwidget-desc' => 'Displays a list of occupants',
	'pamela-list-message' => 'There {{PLURAL:$1|is $1 person|are $1 people}} and $2 {{PLURAL:$2|machine|machines}} active in the space: $3',
	'pamela-list-open' => 'Open space is open!',	

	// Person widget
	'pamela-personwidget-desc' => 'Displays the status of a single person',
	'pamela-personwidget-online' => 'This person is currently in the space!',

	// Open widget
	'pamela-openwidget-desc' => 'Displays a banner indicating the precence of at least one occupant',
);