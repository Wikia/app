<?php
/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Chris Stafford <uberfuzzy@wikia-inc.com> for Wikia Inc
 * @version: 0.0
 */

if (!defined('MEDIAWIKI')) {
	echo "This is a MediaWiki extension.\n";
	exit(1);
}

$dir = dirname(__FILE__);

/* when you need THIS class, load THIS file */
$wgAutoloadClasses['WikiFactoryRedirPage'] = $dir . '/SpecialWikiFactoryRedir.body.php';

/* When you need to hit THIS special pagename, use THIS class */
$wgSpecialPages['WikiFactory'] = 'WikiFactoryRedirPage';

/* put THIS special pagename in THIS group */
$wgSpecialPageGroups['WikiFactory'] = 'redirects';
