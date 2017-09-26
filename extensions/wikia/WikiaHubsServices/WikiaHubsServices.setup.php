<?php
/**
 * WikiaHubs services and classes used in Special:EditHub and WikiaHomePage
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Damian Jóźwiak
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 */

$dir = dirname(__FILE__) . '/';
$app = F::app();

$wgExtensionCredits[ 'other' ][ ] = array(
	'name' => 'WikiaHubsServices',
	'author' => array(
		'Andrzej \'nAndy\' Łukaszewski',
		'Damian Jóźwiak',
		'Marcin Maciejewski',
		'Sebastian Marzjan'
	),
	'descriptionmsg' => 'wikia-hub-services-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WikiaHubsServices',
);

$wgAutoloadClasses['WikiaHubsExploreModel'] =  $dir . 'models/WikiaHubsExploreModel.class.php';
$wgAutoloadClasses['WikiaHubsFeaturedvideoModel'] =  $dir . 'models/WikiaHubsFeaturedvideoModel.class.php';
$wgAutoloadClasses['WikiaHubsPollsModel'] =  $dir . 'models/WikiaHubsPollsModel.class.php';
$wgAutoloadClasses['WikiaHubsPopularvideosModel'] =  $dir . 'models/WikiaHubsPopularvideosModel.class.php';
$wgAutoloadClasses['WikiaHubsSliderModel'] =  $dir . 'models/WikiaHubsSliderModel.class.php';
$wgAutoloadClasses['WikiaHubsFromthecommunityModel'] =  $dir . 'models/WikiaHubsFromthecommunityModel.class.php';
$wgAutoloadClasses['WikiaHubsImageModel'] =  $dir . 'models/WikiaHubsImageModel.class.php';
$wgAutoloadClasses['WikiaHubsWAMModel'] =  $dir . 'models/WikiaHubsWAMModel.class.php';

$wgAutoloadClasses['WikiaHubsServicesHelper'] =  $dir . 'WikiaHubsServicesHelper.class.php';

//message files
$wgExtensionMessagesFiles['WikiaHubsServices'] = $dir . 'WikiaHubsServices.i18n.php';
