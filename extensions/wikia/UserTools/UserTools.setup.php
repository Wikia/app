<?php
/**
 * User Tools Customization enabled in
 * user toolbar as customize link (Oasis)
 * and in article navigation as customize link (Venus)
 *
 * @author Bogna 'bognix' Knychała
 */

$wgExtensionCredits['specialpage'][] =
	[
		"name" => "UserTools",
		"description" => "Customization of user tools enabled in user's toolbar and article navigation",
		"author" => [
			'Bogna "bognix" Knychała',
		]
	];

$wgAutoloadClasses['UserToolsController'] = __DIR__ . '/UserToolsController.class.php';
$wgExtensionMessagesFiles['UserTools'] = __DIR__ . '/UserTools.i18n.php';

