<?php

/**
 * Extension that enables the submission and management of DMCA requests.
 *
 * @author Daniel Grunwell (Grunny) <grunny@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['specialpage'][] = [
	'path' => __FILE__,
	'name' => 'DMCARequest',
	'descriptionmsg' => 'dmcarequest-desc',
	'author' => [
		'[http://community.wikia.com/wiki/User:Grunny Daniel Grunwell (Grunny)]'
	],
	'license-name' => 'GPLv2',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/DMCARequest',
];

$wgAutoloadClasses['DMCARequest\DMCARequestHelper'] =  __DIR__ . '/DMCARequestHelper.class.php';
$wgAutoloadClasses['DMCARequestSpecialController'] =  __DIR__ . '/DMCARequestSpecialController.class.php';
$wgAutoloadClasses['DMCARequestManagementSpecialController'] =  __DIR__ . '/DMCARequestManagementSpecialController.class.php';
$wgAutoloadClasses['DMCARequest\ChillingEffectsClient'] =  __DIR__ . '/ChillingEffectsClient.class.php';

$wgExtensionMessagesFiles['DMCARequest'] = __DIR__ . '/DMCARequest.i18n.php' ;

$wgSpecialPages['DMCARequest'] = 'DMCARequestSpecialController';
$wgSpecialPages['DMCARequestManagement'] = 'DMCARequestManagementSpecialController';
$wgSpecialPageGroups['DMCARequest'] = 'wikia';

$wgResourceModules['ext.dmcaRequest'] = [
	'localBasePath' => __DIR__ . '/styles',
	'remoteExtPath' => 'wikia/DMCARequest/styles',
	'styles' => 'ext.dmcaRequest.scss',
];
