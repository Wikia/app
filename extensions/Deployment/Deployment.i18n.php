<?php

/**
 * Internationalization file for the Deployment extension.
 *
 * @file Deployment.i18n.php
 * @ingroup Deployment
 *
 * @author Jeroen De Dauw
 */

$messages = array();

/** English
 * @author Jeroen De Dauw
 */
$messages['en'] = array(
	// General
	'deployment-desc' => 'Provides a way to [[Special:Install|install MediaWiki extensions]] and [[Special:Update|update MediaWiki and MediaWiki extensions]]',
	'extension' => 'Extension',
	'extension-name-missing' => '[no name]',
	'version-unknown' => 'unknown',

	// Special pages
	'specialpages-group-administration' => 'Wiki administration',

	'special-dashboard' => 'Administration dashboard',
	'special-extensions' => 'Manage extensions',
	'special-update' => 'Update wiki and extensions',
	'special-install' => 'Install extensions',

	'dashboard-title' => 'Dashboard',
	'extensions-title' => 'Extensions',
	'update-title' => 'MediaWiki updates',
	'install-title' => 'Install extensions',

	// Special:Extensions and Special:Install extension lists
	'extensionlist-name' => 'Name',
	'extensionlist-version' => 'Version',
	'extensionlist-version-number' => 'Version $1',
	'extensionlist-stability' => 'Stability',
	'extensionlist-rating' => 'Rating',
	'extensionlist-description' => 'Description',
	'extensionlist-details' => 'Details',
	'extensionlist-download' => 'Download',
	'extensionlist-installnow' => 'Install now',
	'extensionlist-createdby' => 'By $1',
	'extensionlist-deactivate' => 'Deactivate',
	'extensionlist-activate' => 'Activate',
	'extensionlist-delete' => 'Delete',

	// Special:Dashboard

	// Special:Extensions
	'add-new-extensions' => 'Add new',
	'extension-type-all' => 'All',
	'extension-bulk-actions' => 'Bulk Actions',
	'extension-page-explanation' => 'This page lists the installed extensions on this wiki.
For more info about this wiki installation, see [[Special:Version|{{int:version}}]].',
	'extension-none-installed' => 'There are currently no extensions installed.
You can [[$1|add new ones]].',
	'extension-empty-category' => 'There are no extensions of type \'\'$1\'\' installed.',
	'extension-invalid-category' => 'Could not filter on extension type \'\'$1\'\'. 
All extensions are shown instead.',

	// Special:Update
	'mediawiki-up-to-date' => 'You have the latest version of MediaWiki installed.',
	'mediawiki-up-to-date-long' => 'You have the latest version of MediaWiki [[Special:Version|installed]].
You do not need to update.',
	'mediawiki-update-available' => 'A new version of MediaWiki is available!',
	'mediawiki-update-available-long' => 'MediaWiki version $1 is available.
[$2 Update now] to keep your wiki secure and get the new features in this release.',
	'extensions-up-to-date' => '[[Special:Extensions|Your extensions]] are all up to date.',
	'extensions-updates-available' => 'The following extensions have new versions available.
Check the ones you want to update and then click “Update Extensions”.',
	'special-update-extensions' => 'Extensions',
	'update-extensions-button' => 'Update extensions',
	'select-all-extensions' => 'Select all',
	'extension-update-text' => 'You have version $1 installed. Update to $2.',
	'extension-update-compatibility' => 'Compatibility with your current installation: $1 (according to its author)',

	// Special:Install
	'extensions-description' => 'Extensions extend and expand the functionality of MediaWiki.
You can browse and search extensions that are in the [$1 MediaWiki Extension Repository] to install via this page.',
	'search-extensions' => 'Search',
	'search-extensions-long' => 'Search for extensions by keyword, author or tag.',
	'search-term' => 'Term',
	'search-author' => 'Author',
	'search-tag' => 'Tag',
	'search-extensions-button' => 'Search extensions',
	'popular-extension-tags' => 'Popular tags',
	'popular-extension-tags-long' => 'You may also browse based on the most popular tags in the MediaWiki Extension Repository:',

	'stability-alpha' => 'Alpha',
	'stability-beta' => 'Beta',
	'stability-dev' => 'Experimental',
	'stability-rc' => 'Release candidate',
	'stability-stable' => 'Stable',
	'stability-deprecated' => 'Deprecated',

	// Filesystem: FTP
	'deploy-ftp-not-loaded' => 'The FTP PHP extension is not available',
	'deploy-ftp-ssl-not-loaded' => 'The loaded FTP PHP extension does not support SSL',
	'deploy-ftp-username-required' => 'FTP username is required',
	'deploy-ftp-password-required' => 'FTP password is required',
	'deploy-ftp-hostname-required' => 'FTP hostname is required',
	'deploy-ftp-connect-failed' => 'Failed to connect to FTP server $1:$2.',

	// Filesystem: FTP
	'deploy-ssh-not-loaded' => 'The FTP SSH2 extension is not available',
	'deploy-ssh2-no-stream-get-contents'  => 'The SSH2 PHP extension is available, however, the PHP5 function stream_get_contents() is also required',
	'deploy-ssh2-username-required' => 'SSH username is required',
	'deploy-ssh2-password-required' => 'SSH password or private key is required',
	'deploy-ssh2-hostname-required' => 'SSH hostname is required',
	'deploy-ssh2-connect-failed' => 'Failed to connect to SSH2 server $1:$2.',
	'deploy-ssh2-key-authentication-failed' => 'Public and private keys are incorrect for username "$1".',
	'deploy-ssh2-password-authentication-failed' => 'Username or password incorrect for username "$1".',
	'deploy-ssh2-command-failed' => 'Unable to perform command: $1',
);
