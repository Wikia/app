<?php
/**
 * StoriesLinkTag
 *
 * @author Saipetch Kongkatong, Piotr Gabryjeluk
 */

$wgExtensionCredits['storieslinktag'][] = array(
	'name' => 'StoriesLinkTag',
	'author' => [
		'Saipetch Kongkatong',
		'Piotr Gabryjeluk',
	],
	'descriptionmsg' => 'storieslink-tag-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/StoriesLinkTag'
);

$dir = dirname( __FILE__ ) . '/';

/**
 * controllers
 */
$wgAutoloadClasses['StoriesLinkTagController'] =  $dir . 'StoriesLinkTagController.class.php';

/**
 * classes
 */
$wgAutoloadClasses['StoriesLinkTagHelper'] =  $dir . 'StoriesLinkTagHelper.class.php';

/**
 * hooks
 */
$wgHooks['ParserFirstCallInit'][] = 'StoriesLinkTagController::onParserFirstCallInit';
$wgHooks['ParserAfterTidy'][] = 'StoriesLinkTagController::onParserAfterTidy';
$wgHooks['ArticleAsJsonBeforeEncode'][] = 'StoriesLinkTagController::onArticleAsJsonBeforeEncode';

/**
 * messages
 */
$wgExtensionMessagesFiles['StoriesLinkTag'] = $dir . 'StoriesLinkTag.i18n.php';
