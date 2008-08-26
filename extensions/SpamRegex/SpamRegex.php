<?php

/* help displayed on the special page  */
define ('SPAMREGEX_PATH', '/');

/* for memcached - expiration time */
define ('SPAMREGEX_EXPIRE', 0);

/* two modes for two kinds of blocks */
define ('SPAMREGEX_TEXTBOX', 0);
define ('SPAMREGEX_SUMMARY', 1);

/* return the name of the table  */
function wfSpamRegexGetTable() {
	global $wgSharedDB;
	if ("" != $wgSharedDB) {
		return "{$wgSharedDB}.spam_regex";
	} else {
		return "spam_regex";
	}
}

/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if (!defined('MEDIAWIKI')) die();

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Spamregex'] = $dir . 'SpamRegex.i18n.php';

require_once ($IP.SPAMREGEX_PATH."extensions/SpamRegex/SpecialSpamRegex.php");
//will need more, maybe Core?
require_once ($IP.SPAMREGEX_PATH."extensions/SpamRegex/SpamRegexCore.php");
require_once ($IP.SPAMREGEX_PATH."extensions/SimplifiedRegex/SimplifiedRegex.php");
