<?php
/**
 * WikiaStyleGuide
 *
 * @author Hyun Lim, Kyle Florence
 *
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'WikiaStyleGuide',
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

