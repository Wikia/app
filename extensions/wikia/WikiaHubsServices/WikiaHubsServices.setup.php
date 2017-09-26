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

$wgAutoloadClasses['WikiaHubsServicesHelper'] =  $dir . 'WikiaHubsServicesHelper.class.php';

//message files
$wgExtensionMessagesFiles['WikiaHubsServices'] = $dir . 'WikiaHubsServices.i18n.php';
