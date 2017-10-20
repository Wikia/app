<?php

/**
  * @brief JSSnippets simplify loading and execution of on demand JS files
  * @details Allows to specify list of JS dependencies to be loaded and callback function to be executed
  *
  * MW1.19 ResourceLoader provides an interface for defining list of modules to be loaded for a given article
  * TODO: use ResourceLoader instead of JSSnippets
  *
  * @ingroup Extensions
  *
  * @author Maciej Brencz (macbre) <macbre at wikia-inc.com>
  * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
  */

$wgExtensionCredits[ 'other' ][ ] = array(
	'name' => 'JSSnippets',
	'author' => array(
		'Maciej Brencz (macbre) <macbre at wikia-inc.com>',
		'Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>'
	),
	'descriptionmsg' => 'jssnippets-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/JSSnippets',
);

$dir = dirname(__FILE__);

//i18n
$wgExtensionMessagesFiles['JSSnippets'] = $dir . '/JSSnippets.i18n.php';

// classes
$wgAutoloadClasses['JSSnippets'] =  $dir . '/JSSnippets.class.php';

// hooks
$wgHooks['WikiaSkinTopScripts'][] = 'JSSnippets::onMakeGlobalVariablesScript';
