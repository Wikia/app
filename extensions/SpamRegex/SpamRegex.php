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
	return wfSharedTable('spam_regex', false);
}

/* return the proper db key for Memc */
function wfSpamRegexGetMemcDB () {
	global $wgSharedDB, $wgExternalSharedDB, $wgDBname ;
	if (!empty( $wgExternalSharedDB )) {
		return $wgExternalSharedDB;
	} elseif (!empty( $wgSharedDB )) {
		return $wgSharedDB;
	} else {
		return $wgDBname;	
	}
}

/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if (!defined('MEDIAWIKI')) die();

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['SpamRegex'] = $dir . 'SpamRegex.i18n.php';

require_once ($IP.SPAMREGEX_PATH."extensions/SpamRegex/SpecialSpamRegex.php");
//will need more, maybe Core?
require_once ($IP.SPAMREGEX_PATH."extensions/SpamRegex/SpamRegexCore.php");
require_once ($IP.SPAMREGEX_PATH."extensions/SimplifiedRegex/SimplifiedRegex.php");
