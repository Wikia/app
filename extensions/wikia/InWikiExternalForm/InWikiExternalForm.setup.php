<?php

/**
 * In Wiki External Form
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

$wgExtensionCredits['other'][] = array(
	'name'			=> 'InWikiExternalForm',
	'author'		=> 'Andrzej "nAndy" Łukaszewski, Marcin Maciejewski, Sebastian Marzjan',
	'description'	=> 'In Wiki External Form - putting an external form under specific URL',
	'version'		=> 1.0
);


$dir = dirname(__FILE__);
$app = F::app();

// classes
$wgAutoloadClasses['InWikiExternalFormController'] =  $dir . '/InWikiExternalFormController.class.php';

// pages
$wgSpecialPages['Play'] = 'InWikiExternalFormController';
