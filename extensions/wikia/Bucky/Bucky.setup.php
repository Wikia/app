<?php
/**
 * Real User Monitoring
 *
 * @author wladek
 */

$wgExtensionCredits[ 'specialpage' ][ ] = array(
	'name' => 'Bucky',
	'author' => 'wladek',
	'descriptionmsg' => 'bucky-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Bucky',
);

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['Bucky'] =  $dir . 'Bucky.class.php';

$wgHooks['MakeGlobalVariablesScript'][] = 'Bucky::onMakeGlobalVariablesScript';

//i18n
