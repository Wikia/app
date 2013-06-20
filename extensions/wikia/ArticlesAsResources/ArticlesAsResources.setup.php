<?php
/**
 * An extension to Resource Loader that lets the community serve
 * up multiple Articles as resources in a single request.
 *
 * This allows several different resources:
 * - JS or CSS articles on the same wiki
 * - JS or CSS articles on different wikia wikis.
 *
 * JS files from the current wiki can be mixed in the same request with JS files from other wikis
 * but JS and CSS files can not be mixed in the same request as each other.
 *
 * All the magic begins when mode= parameter is given in the URL.
 * Article list should be present in articles= argument.
 *
 * Example usage URL:
 *
 * /load.php?skin=oasis&lang=en&debug=true&only=scripts&mode=articles
 *     &articles=u:dev.wikia.com:ShowHide/code.js|u:dev.wikia.com:CollapsibleInfobox/code.js
 *     |u:dev.wikia.com:AjaxRC/code.js|u:dev.wikia.com:BackToTopButton/code.js
 *     |u:dev.wikia.com:OasisToolbarButtons/code.js|u:dev.wikia.com:AutoEditDropdown/code.js
 *     |u:dev.wikia.com:PurgeButton/code.js|w:glee:MediaWiki:Common.js/displayTimer.js&*
 *
 *
 * NOTE: I don't think it's safe to have this module pull completly-external resources (as opposed
 * to articles on other wikis) because pulling arbitrary URLs is probably not good in our environment.
 * For instance, a developer was recently downloading a 4gb file from their personal dropbox to a devbox
 * and it crashed varnish.
 *
 * @author Sean Colombo
 * @author Wladyslaw Bodzek
 * @author Kyle Florence
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'ArticlesAsResources',
	'version' => '1.0',
	'author' => array(
		'Sean Colombo',
		'Wladyslaw Bodzek',
		'Kyle Florence'
	),
	'description' => 'Serves multiple MediaWiki articles combined together (and minified) as JS or CSS resources.',
);

$dir = dirname(__FILE__);

// classes
$wgAutoloadClasses['ArticlesAsResources'] =  $dir . '/ArticlesAsResources.class.php';

// hooks
$wgHooks['ResourceLoaderBeforeRespond'][] = 'ArticlesAsResources::onResourceLoaderBeforeRespond';