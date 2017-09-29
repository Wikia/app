<?php
/**
 * WikiaHomePage
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Hyun Lim
 * @author Marcin Maciejewski
 * @author Saipetch Kongkatong
 * @author Sebastian Marzjan
 * @author Damian Jóźwiak
 */

$wgExtensionCredits['other'][] = array(
	'name'			  => 'CityVisualization',
	'author'		  => array('Andrzej "nAndy" Łukaszewski', 'Hyun Lim', 'Marcin Maciejewski', 'Saipetch Kongkatong', 'Sebastian Marzjan', 'Damian Jóźwiak'),
	'url'             => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/CityVisualization',
	'version'		  => 1.0
);

// getdata helpers
$wgAutoloadClasses['PromoImage'] = __DIR__ . '/classes/PromoImage.class.php';

//classes
$wgAutoloadClasses['WikiaHomePageHelper'] =  __DIR__ . '/helpers/WikiaHomePageHelper.class.php';
