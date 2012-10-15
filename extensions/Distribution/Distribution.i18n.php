<?php

/**
 * Internationalization file for the Distribution extension.
 *
 * @file Distribution.i18n.php
 * @ingroup Distribution
 *
 * @author Chad Horohoe
 * @author Jeroen De Dauw
 */

$messages = array();

/** English
 * @author Jeroen De Dauw
 */
$messages['en'] = array(
	// General
	'distribution-desc' => 'Extension that serves as a package distribution system for MediaWiki and extensions',

	'releasemanager' => 'MediaWiki release manager',
	'releasemanager-header' => 'Welcome to the MediaWiki release manager. Use the options below to manage the releases',
	'releasemanager-add' => 'Add new release',
	'releasemanager-supported-til-eol' => 'Supported until End of Life date, currently: $1', // $1 is yes/no
	'releasemanager-supported-overriden' => 'Support overridden, currently: $1', // $1 is yes/no
	'releasemanager-doesnotexist' => 'The specified release does not exist',
	'releasemanager-delete-confirm' => 'Are you sure you want to delete this release?',
	'downloadmediawiki' => 'Download MediaWiki',
	'mwr-field-name' => 'Name',
	'mwr-field-number' => 'Number',
	'mwr-field-eoldate' => 'End of Life date',
	'mwr-field-reldate' => 'Release date',
	'mwr-field-announcement' => 'Announcement URL',
	'mwr-field-supported' => 'Supported flag',
	'mwr-field-tag' => 'Tag name',
	'mwr-field-branch' => 'Branch name',
);
