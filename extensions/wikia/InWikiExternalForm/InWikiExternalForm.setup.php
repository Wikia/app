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
	'name'		    	=> 'InWikiExternalForm',
	'author'		    => 'Andrzej "nAndy" Łukaszewski, Marcin Maciejewski, Sebastian Marzjan',
	'descriptionmsg'	=> 'inwikiexternalform-desc',
	'version'		    => 1.0,
	'url'               => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/InWikiExternalForm'
);


$dir = dirname(__FILE__);
$app = F::app();

//i18n
$wgExtensionMessagesFiles['InWikiExternalForm'] = $dir . '/InWikiExternalForm.i18n.php';

// classes
$wgAutoloadClasses['InWikiExternalFormController'] =  $dir . '/InWikiExternalFormController.class.php';

// pages
$wgSpecialPages['Play'] = 'InWikiExternalFormController';

