<?php

/**
 * Settings file for the Deployment extension.
 * Extension documentation: http://www.mediawiki.org/wiki/Extension:Deployment
 *
 * @file Deployment_Settings.php
 * @ingroup Deployment
 *
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

 /**
 * The location of the MediaWiki package repository to use.
 *
 * @since 1.17
 * @var string
 */
$wgRepositoryApiLocation = 'http://www.mediawiki.org/w/api.php';

/**
 * The location of the remote web interface for the selected repository.
 *
 * @since 1.17
 * @var string
 */
$wgRepositoryLocation = 'http://www.mediawiki.org/wiki/Special:Repository';

/**
 * List of package states to filter update detection and extension listing on.
 *
 * @since 1.17
 * @var array
 */
$wgRepositoryPackageStates = array(
	//'dev',
	//'alpha',
	'beta',
	//'rc',
	'stable',
	//'deprecated',
);
