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
$dir = dirname( __FILE__ );

//classes
$wgAutoloadClasses['WikiaRssModel'] =  $dir . '/WikiaRssModel.class.php';
$wgAutoloadClasses['WikiaRssHooks'] =  $dir . '/WikiaRssHooks.class.php';
$wgAutoloadClasses['WikiaRssHelper'] =  $dir . '/WikiaRssHelper.class.php';
$wgAutoloadClasses['WikiaRssExternalController'] =  $dir . '/WikiaRssExternalController.class.php';

//hooks
$wgHooks['ParserFirstCallInit'][] = 'WikiaRssHooks::onParserFirstCallInit';

//messages
$wgExtensionMessagesFiles['WikiaRss'] = $dir . '/WikiaRss.i18n.php';