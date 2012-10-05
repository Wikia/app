<?php

/**
 * In Wiki Game
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

$wgExtensionCredits['other'][] = array(
	'name'			=> 'InWikiGame',
	'author'		=> 'Andrzej "nAndy" Łukaszewski, Marcin Maciejewski, Sebastian Marzjan',
	'description'	=> 'In Wiki Game enables to put an interactive game (i.e. in an iframe) to the wiki page',
	'version'		=> 1.0
);


// classes


// i18n mapping
$app->registerExtensionMessageFile('InWikiGame', $dir.'InWikiGame.i18n.php');
F::build('JSMessages')->registerPackage('InWikiGame', array('inwikigame-*'));
