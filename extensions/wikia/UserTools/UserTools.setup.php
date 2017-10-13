<?php
/**
 * User Tools Customization enabled in
 * user toolbar as customize link (Oasis)
 *
 * @author Bogna 'bognix' Knychała
 */

$wgExtensionCredits['specialpage'][] =
	[
		"name" => "UserTools",
		"description" => "user-tools-desc",
		"author" => [
			'Bogna "bognix" Knychała',
		],
		"url" => "https://github.com/Wikia/app/tree/dev/extensions/wikia/UserTools"
	];

$wgAutoloadClasses['UserToolsController'] = __DIR__ . '/UserToolsController.class.php';
$wgExtensionMessagesFiles['UserTools'] = __DIR__ . '/UserTools.i18n.php';

