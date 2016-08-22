<?php
/**
 * Those classes need to be loaded for community.wikia.com if there exist
 * one wiki with $wgEnableContributionAppreciationExt enabled.
 */
$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses[ 'ContributionAppreciationCommonHooks' ] = $dir . 'ContributionAppreciationCommonHooks.class.php';

$wgHooks['SendGridPostbackLogEvents'][] = 'ContributionAppreciationCommonHooks::onSendGridPostbackLogEvents';
