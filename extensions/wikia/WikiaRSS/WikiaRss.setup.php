<?php
/**
 * Wikia RSS
 *
 * User Message Wall for MediaWiki
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 */
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Wikia RSS feed',
	'author' => array("Andrzej 'nAndy' Łukaszewski"),
	'url' => 'http://www.wikia.com',
	'descriptionmsg' => 'wikia-rss-desc',
);

/**
 * @var WikiaApp
 */
$app = F::app();
$dir = dirname( __FILE__ );

//classes
$app->registerClass('WikiaRssModel', $dir . '/WikiaRssModel.class.php');
$app->registerClass('WikiaRssHooks', $dir . '/WikiaRssHooks.class.php');
$app->registerClass('WikiaRssHelper', $dir . '/WikiaRssHelper.class.php');
$app->registerClass('WikiaRssExternalController', $dir . '/WikiaRssExternalController.class.php');

//hooks
$app->registerHook('ParserFirstCallInit', 'WikiaRssHooks', 'onParserFirstCallInit');

//messages
$app->registerExtensionMessageFile('WikiaRss', $dir . '/WikiaRss.i18n.php');