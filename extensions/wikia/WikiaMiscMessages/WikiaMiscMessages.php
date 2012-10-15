<?php
/*
 * Simple faux extension to enable TWN export/import of misc messages
 */

$wgExtensionMessagesFiles['wikiamiscmessages'] = dirname( __FILE__ ) . '/WikiaMiscMessages.i18n.php';

// additional hooks can be added if new messages are added
$wgHooks['MsgHTMLwithLanguageAndAlternativeBefore'][] = 'efAddWikiaMiscMessages';

function efAddWikiaMiscMessages() {
	return true;
}
