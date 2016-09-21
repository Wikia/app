<?php
/**
 * CrosslinkTag
 *
 * @author Saipetch Kongkatong, Piotr Gabryjeluk
 */

$wgExtensionCredits['crosslinktag'][] = array(
	'name' => 'CrosslinkTag',
	'author' => [
		'Saipetch Kongkatong',
		'Piotr Gabryjeluk',
	],
	'descriptionmsg' => 'crosslink-tag-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/CrosslinkTag'
);

$dir = dirname( __FILE__ ) . '/';

/**
 * controllers
 */
$wgAutoloadClasses['CrosslinkTagController'] =  $dir . 'CrosslinkTagController.class.php';

/**
 * classes
 */
$wgAutoloadClasses['CrosslinkTagHelper'] =  $dir . 'CrosslinkTagHelper.class.php';

/**
 * hooks
 */
$wgHooks['ParserFirstCallInit'][] = 'CrosslinkTagController::onParserFirstCallInit';
$wgHooks['ParserAfterTidy'][] = 'CrosslinkTagController::onParserAfterTidy';
$wgHooks['ArticleAsJsonBeforeEncode'][] = 'CrosslinkTagController::onArticleAsJsonBeforeEncode';

/**
 * messages
 */
$wgExtensionMessagesFiles['CrosslinkTag'] = $dir . 'CrosslinkTag.i18n.php';
