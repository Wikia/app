<?php
/**
 * TextRegex - A special page with the interface for blocking, and unblocking of unwanted phrases in any text
 *
 * @ingroup Extensions
 * @author Piotr Molski (moli at wikia-inc.com)
 * @version 1.0
 */

if ( !defined('MEDIAWIKI') ) die();

// Extension credits
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Regular Expression Any Text Block',
	'version' => '1.0',
	'author' => 'Moli',
	'description' => 'A special page with the interface for blocking, and unblocking of unwanted phrases in any text',
	'descriptionmsg' => 'textregex-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/TextRegex'
);

// Set up the new special page
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['TextRegex'] = $dir . 'TextRegex.i18n.php';
$wgExtensionMessagesFiles['TextRegexAliases'] = $dir . 'TextRegex.alias.php';

$wgAutoloadClasses['TextRegex'] = $dir . 'SpecialTextRegex.php';
$wgAutoloadClasses['TextRegexCore'] = $dir . 'SpecialTextRegex.php';

$wgSpecialPages['TextRegex'] = 'TextRegex';
$wgSpecialPageGroups['TextRegex'] = 'pagetools';
