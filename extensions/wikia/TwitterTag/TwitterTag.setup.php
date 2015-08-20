<?php

/**
 * TwitterTag
 *
 * Creates the <twitter> tag
 *
 * @author TyA <tyler@faceyspacies.com>
 * @date 2015-08-20
 *
 */
 
$wgExtensionCredits['other'][] = array(
	'name' => 'TwitterTag',
	'version' => '1.0',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/TwitterTag',
	'author' => '[http://community.wikia.com/wiki/User:TyA TyA]',
	'descriptionmsg' => 'twittertag-desc',
);

$dir = dirname( __FILE__ ) . '/';
 
$wgAutoloadClasses['TwitterTagHooks'] = $dir . "TwitterTagHooks.class.php";

$wgExtensionMessagesFiles['TwitterTag'] = $dir . 'TwitterTag.i18n.php';

$wgHooks['ParserFirstCallInit'][] = 'TwitterTagHooks::onParserFirstCallInit';