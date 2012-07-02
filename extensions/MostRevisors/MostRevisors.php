<?php
/**
 * A special page to show pages with most revisors.
 *
 */

// If this is run directly from the web die as this is not a valid entry point.
if ( !defined( 'MEDIAWIKI' ) ) die( 'Invalid entry point.' );

// Extension credits.
$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'MostRevisors',
	'version'        => '2.0',
	'author'         => 'Al Maghi',
	'email'          => 'alfred.maghi@gmail.com',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:MostRevisors',
	'descriptionmsg' => 'mostrevisors-desc',
);

$wgMostRevisorsPagesLimit = 25;
$wgMostRevisorsLinkContributors = True;
// Set extension files.
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['MostRevisors'] = $dir . 'MostRevisors.i18n.php';
$wgExtensionMessagesFiles['MostRevisorsAlias'] = $dir . 'MostRevisors.alias.php';
$wgAutoloadClasses['MostRevisors'] = $dir . 'MostRevisors_body.php';
$wgSpecialPages['MostRevisors'] = 'MostRevisors';
$wgSpecialPageGroups['MostRevisors'] = 'wiki';
