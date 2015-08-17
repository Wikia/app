<?php
/**
 * WikiaStyleGuide
 *
 * @author Hyun Lim, Kyle Florence
 *
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'WikiaStyleGuide',
	'author' => array(
		'Hyun Lim',
		'Kyle Florence'
	),
	'descriptionmsg' => 'wikiastyleguide-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WikiaStyleGuide'
);

$dir = dirname(__FILE__) . '/';

// classes
$wgAutoloadClasses['WikiaStyleGuideSpecialController'] =  $dir . 'WikiaStyleGuideSpecialController.class.php';

// special pages
$wgSpecialPages['WikiaStyleGuide'] = 'WikiaStyleGuideSpecialController';

// JS Messages
JSMessages::registerPackage('VideoPage', array(
  'videohandler-remove-video-modal-*',
));

