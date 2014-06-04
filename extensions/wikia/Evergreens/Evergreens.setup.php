<?php

/**
 * @author Michał ‘Mix’ Roszka <mix@wikia-inc.com>
 */

if(!defined('MEDIAWIKI')) {
	exit(1);
}

$wgExtensionCredits['other'][] = array(
	'name' => 'Evergreens',
	'author' => 'Michał ‘Mix’ Roszka <mix@wikia-inc.com>'
);


$wgAutoloadClasses['EvergreensController'] = __DIR__ . 'EvergreensController.class.php';
