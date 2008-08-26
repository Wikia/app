<?php
if(!defined('MEDIAWIKI')) {
	die();
}

$wgExtensionCredits['other'][] = array(
        'name' => 'MiniUpload',
        'author' => 'Inez Korczynski',
        'description' => 'Allow users to upload new files directly from editpage',
);

$wgAutoloadClasses['MiniUpload'] = dirname(__FILE__) . '/SpecialMiniUpload_body.php';
$wgHooks['LoadAllMessages'][] = 'MiniUpload::loadMessages';
$wgSpecialPages['MiniUpload'] = 'MiniUpload';
