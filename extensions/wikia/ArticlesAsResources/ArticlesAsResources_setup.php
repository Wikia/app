<?php
/**
 * A publicly-accessible Nirvana endpoint which lets the community serve
 * up multiple Articles as resources in a single request.
 * 
 * This allows several different resources:
 * - JS or CSS articles on the same wiki
 * - JS or CSS articles on different wikia wikis.
 *
 * JS files from the current wiki can be mixed in the same request with JS files from other wikis
 * but JS and CSS files can not be mixed in the same request as each other.
 *
 * NOTE: I don't think it's safe to have this module pull completly-external resources (as opposed
 * to articles on other wikis) because pulling arbitrary URLs is probably not good in our environment.
 * For instance, a developer was recently downloading a 4gb file from their personal dropbox to a devbox
 * and it crashed varnish.
 *
 * @author Sean Colombo, Wladek Bodzek
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'ArticlesAsResources',
	'version' => '1.0',
	'author' => 'Sean Colombo, Wladek Bodzek',
	'description' => 'Serves multiple MediaWiki articles combined together (and minified) as JS or CSS resources.',
);

$dir = dirname(__FILE__);

// WikiaApp
$app = WF::build('App');

// classes
$app->registerClass('ArticlesAsResources', $dir . '/ArticlesAsResources.class.php');
$app->registerClass('ArticlesAsResourcesController', $dir . '/ArticlesAsResourcesController.class.php');

// hooks

// register instances
//F::setInstance('ArticlesAsResources', new ArticlesAsResources());
