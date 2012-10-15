<?php
/**
 * Internationalisation file for extension ConfigureWMF.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	// General
	'configurewmf-page'                      => 'Change wikis configuration',
	'configurewmf-desc'                      => 'Allow stewards to change configuration of Wikimedia wikis',
	'configurewmf-nav-rootpage'              => 'Change wikis configuration form',

	// Step 1
	'configurewmf-selectsite'                => 'Select a wiki to configure',
	'configurewmf-selectsite-help'           => 'Here you specify which wiki or group of wikis confiuration you want to change.
To change configuration of one wiki, enter its ID, like "enwiki", "dewikiversity", "incubatorwiki". To change configuration of all wikis, enter "default".
To change configuration of some site family, enter its name, like "wikibooks". Note that "wikipedia" will be rewritten to "wiki", and "wiki" settings
are applied to all Wikipedias and special projects which have "wiki" suffix (like "commonswiki").',
	'configurewmf-attentionnotice'           => 'Attention! Read ALL insturctions carefully, since many settings have very important details and invalid input may cause unexpected consequences.',
	'configurewmf-invalidwiki'               => 'Invalid wiki: $1',
	'configurewmf-site'                      => 'Site:',
	'configurewmf-select'                    => 'Select',

	// Step 2
	'configurewmf-chooseconfig'              => 'Choose setting to change',
	'configurewmf-chooseconfig-intro'        => 'Via this interface you may change:',

	// Step 3
	'configurewmf-change'                    => 'Set new site configuration',
	'configurewmf-seealso'                   => 'For more information see following pages on MediaWiki.org: $1',
	'configurewmf-reason'                    => 'Reason:',
	'configurewmf-submit'                    => 'Submit',
	'configurewmf-success'                   => 'Settings successfully changed',

	// Configuration names and variables
	'configurewmf-cfgname-sitename'          => 'Site name',
	'configurewmf-cfgname-metans'            => 'Project and project talk namespaces',
	'configurewmf-cfgname-readonly'          => 'Read only mode',
	'configurewmf-cfgname-patrol'            => 'Patrolling settings',
	'configurewmf-cfgname-importsrc'         => 'Import sources',
	'configurewmf-cfgname-enotif'            => 'Email notification settings',
	'configurewmf-cfgname-blockcfg'          => 'Blocking settings',
	'configurewmf-cfgname-logo'              => 'Site logo',
	'configurewmf-cfgname-timezone'          => 'Signature time zone',
	'configurewmf-cfgname-groupperms'        => 'Group permissions',
	'configurewmf-cfgname-chgrpperms'        => 'Group change permissions',
	'configurewmf-var-wgsitename'            => 'Site name',
	'configurewmf-var-wgmetanamespace'       => 'Project namespace name',
	'configurewmf-var-wgmetanamespacetalk'   => 'Project talk namespace name',
	'configurewmf-var-wgreadonly'            => 'Reason for read-only mode',
	'configurewmf-var-wgusenppatrol'         => 'Use new pages patrolling',
	'configurewmf-var-wgusercpatrol'         => 'Use recent changes patrolling',
	'configurewmf-var-wgimportsources'       => 'Import sources',
	'configurewmf-var-wgenotifusertalk'      => 'Email notification on user talk messages',
	'configurewmf-var-wgenotifwatchlist'     => 'Email notification on watchlist changes',
	'configurewmf-var-wgblockallowsutedit'   => 'User talk edits for blocked users',
	'configurewmf-var-wglocaltimezone'       => 'Signature time zone',
	'configurewmf-var-wglogo'                => 'Site logo',
	'configurewmf-var-wggrouppermissions'    => 'Group permissions',
	'configurewmf-var-wgaddgroups'           => 'May add groups',
	'configurewmf-var-wgremovegroups'        => 'May remove groups',

	// Helps for various configuration variables
	'configurewmf-help-sitename'             => 'Here you can change site name displayed in page title, page taglines, etc.',
	'configurewmf-help-metans'               => 'Here you can change project and project talk namespaces.
Note that project talk will be formed by "{project namespace}_talk" principle. Namespace names should be entered with "_" instead of spaces.',
	'configurewmf-help-readonly'             => 'Here you can switch read only mode for site. It is usually used for closing sites.
To disable read-only mode, just type empty string.',
	'configurewmf-help-patrol'               => 'Here you can switch recent changes and new pages patrolling features.',
	'configurewmf-help-importsrc'            => 'Here you can change import sources. They are specified in the format of interwiki prefix:
* If you want to enable import from Polish Wikipedia on Polish Wikibooks, you have to add "w" to the list
* If you want to enable import from English Wikibooks on Polish Wikibooks, you have to add "en" to the list
* If you want to enable import from English Wikipedia on Polish Wikibooks, you have to add "w:en" to the list
* If you want to enable import from Incubator on Polish Wikibooks, you have to add "incubator" to the list
Each import source should be placed on a separate line.',
	'configurewmf-help-enotif'               => 'Here you can enable or disable email notification. Note that it may serioursly affect performance
and therefore must not be enabled on large wikis.',
	'configurewmf-help-blockcfg'             => 'Here you can enable or disable user talk editing for blocked users.',
	'configurewmf-help-timezone'             => 'Here you can change time zone that is used in signatures.
Note that it is specified in POSIX-compatible format. For example:
* Use "CET" for Central European Time (UTC+1)
* Use "Europe/Moscow" for time zone used in Moscow (UTC+3)',
	'configurewmf-help-logo'                 => 'Here you can change site logo.',
	'configurewmf-help-groupperms'           => 'Here you can add or remove specific permissions from a specific group or create a new group.
Please note that groups may not be changed project-wide (e.g. for all Wikibooks), only for all projects (default) or a specific project',
	'configurewmf-help-chgrpperms'           => 'Here you can specify whether some group may add or remove other users permissions.
Note that "userrights" permission means user may add or remove all groups regardless of specified there.
Also note, that several groups like checkuser or oversight may be only appointed by stewards, because they requires legal identity.',

	// Variable-specific messages
	'configurewmf-stdlogo'                   => 'Standard logo (Wiki.png)',
	'configurewmf-otherlogo'                 => 'Other logo:',
	'configurewmf-grouptochange'             => 'Choose a group to change:',
	'configurewmf-creategroup'               => 'Create',
	'configurewmf-groupname'                 => 'Group name:',
	'configurewmf-changexistinggroups'       => 'Change existing groups',
	'configurewmf-createnewgroup'            => 'Create a new group',
	'configurewmf-permission'                => '$1 ($2)',

	// Rights
	'right-configure'   => 'Change wiki configuration',

	// Logging
	'configurewmf-log'                       => 'Configuration changes log',
	'configurewmf-log-header'                => 'This log contains all configuration changes made by stewards',
	'configurewmf-log-sitename'              => 'changed site name of $2 to $3',
	'configurewmf-log-metans'                => 'changed meta namespace name of $2 to $3 (talk: $4)',
	'configurewmf-log-readonly'              => 'changed read only mode for $2 to "$3"',
	'configurewmf-log-patrol'                => 'changed patrolling settings for $2 (new pages: $3, recent changes: $4)',
	'configurewmf-log-importsrc'             => 'changed import sources for $2 to $3',
	'configurewmf-log-enotif'                => 'changed email notification settings for $2 (on user talk edits: $3; on watchlist edits: $4)',
	'configurewmf-log-blockcfg'              => '$3 user talk editing for blocked users on $2',
	'configurewmf-log-timezone'              => 'changed signature time zone for $2 to $3',
	'configurewmf-log-logo'                  => 'changed site logo for $2 to "$3"',
	'configurewmf-log-groupperms'            => 'changed group permissions for $3 on $2: added $4; removed $5',
	'configurewmf-log-true'                  => 'enabled',
	'configurewmf-log-false'                 => 'disabled',
	'configurewmf-log-stdlogo'               => 'standard logo (Wiki.png)',
);
