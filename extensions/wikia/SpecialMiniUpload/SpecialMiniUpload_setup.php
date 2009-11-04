<?php
if(!defined('MEDIAWIKI')) {
	die();
}

$wgExtensionCredits['other'][] = array(
        'name' => 'MiniUpload',
        'author' => 'Inez Korczynski',
        'description' => 'Allow users to upload new files directly from editpage',
);

$dir = dirname(__FILE__);
$wgAutoloadClasses['MiniUpload'] = $dir . '/SpecialMiniUpload_body.php';
$wgExtensionMessagesFiles['MiniUpload'] = $dir . '/SpecialMiniUpload.i18n.php';
$wgSpecialPages['MiniUpload'] = 'MiniUpload';
