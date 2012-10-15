<?php

/**
 * File defining the settings for the Push extension.
 * More info can be found at http://www.mediawiki.org/wiki/Extension:Push#Settings
 *
 *                          NOTICE:
 * Changing one of these settings can be done by copying or cutting it,
 * and placing it in LocalSettings.php, AFTER the inclusion of Push.
 *
 * @file Push_Settings.php
 * @ingroup Push
 *
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

# List of targets that can be pushed to.
# The array keys are the target names, and the values are the target urls (path to api.php without the '/api.php' part)
# Example: $egPushTargets['English Wikipedia'] = 'http://en.wikipedia.org/w'; 
$egPushTargets = array();

# Push rights.
//$wgGroupPermissions['*']['push'] = true;
$wgGroupPermissions['autoconfirmed']['push'] = true;
$wgGroupPermissions['sysop']['push'] = true;
$wgGroupPermissions['autoconfirmed']['bulkpush'] = true;
$wgGroupPermissions['sysop']['bulkpush'] = true;
$wgGroupPermissions['autoconfirmed']['filepush'] = true;
$wgGroupPermissions['sysop']['filepush'] = true;
// $wgGroupPermissions['sysop']['pushadmin'] = true;

$wgGroupPermissions['pusher']['push'] = true;

$wgGroupPermissions['bulkpusher']['bulkpush'] = true;
$wgGroupPermissions['bulkpusher']['push'] = true;

$wgGroupPermissions['filepusher']['filepush'] = true;
$wgGroupPermissions['filepusher']['push'] = true;

# Show the push action as a tab (if not, it's displayed in the actions dropdown).
# This only works for skins with an actions dropdown. For others push will always appear as a tab.
$egPushShowTab = false;

# You can choose to include templates when pushing a page.
# This is the default choice.
$egPushIncTemplates = false;

# You can choose to push files used in a page.
# This is the default choice.
$egPushIncFiles = false;

# Indicated if login options should be added to the push interface or not. 
$egPushAllowLogin = true;

# Default login data. When set, the values will always be used when there is
# no login interface. If there is, they will be filled in as default.
$egPushLoginUser = '';
$egPushLoginPass = '';

# Default login data per target. Overrides $egPushLoginUser and $egPushLoginPass when specified.
# Array keys should be the urls assigned in the $egPushTargets array.
# When set, the values will always be used when there is
# no login interface. If there is, they will be filled in as default.
$egPushLoginUsers = array();
$egPushLoginPasswords = array();

# The amount of push 'workers' (simultanious push requests) on Special:Push.
$egPushBulkWorkers = 3;

# The maximum amount of targets to push a page to in one go.
$egPushBatchSize = 3;

# Use direct file uploads (requires patch to MW 1.16 and 1.17).
# This is needed when pushing to a wiki that cannot access the source file
# (for example from a private wiki to a wiki on the internet).
$egPushDirectFileUploads = !$wgAllowCopyUploads;
