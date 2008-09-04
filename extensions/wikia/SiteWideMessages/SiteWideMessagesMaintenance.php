<?php

/**
 * @package MediaWiki
 * @subpackage SiteWideMessages
 * @author Maciej Błaszkowski <marooned at wikia-inc.com> for Wikia.com
 * @copyright (C) 2008, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension and cannot be used standalone.\n";
	exit( 1 ) ;
}

define('MSG_TEXT_DB', wfSharedTable('messages_text'));
define('MSG_STATUS_DB', wfSharedTable('messages_status'));
define('MSG_MODE_ALL', '0');
define('MSG_MODE_SELECTED', '1');
define('MSG_STATUS_UNSEEN', '0');
define('MSG_STATUS_SEEN', '1');
define('MSG_STATUS_DISMISSED', '2');
define('MSG_REMOVED_NO', '0');
define('MSG_REMOVED_YES', '1');

/**
 * @name SiteWideMessagesMaintenance
 *
 * class used by maintenance/background script
 */
class SiteWideMessagesMaintenance {

	/**
	 * __construct
	 *
	 * constructor
	 *
	 */
	public function __construct() {
		#--- init stuffs here
	}

	/**
	 * execute
	 *
	 * Main entry point, only public function
	 * Function run from cron to remove not used anymore rows from DB (status of removed or expired messages)
	 *
	 * @author Marooned
	 * @access public
	 *
	 * @return status of operations
	 */
	public function execute() {
		require_once('commandLine.inc');
		$DB = wfGetDB(DB_MASTER);

		$dbResult = (boolean)$DB->Query (
			  'DELETE'
			. ' FROM ' . MSG_STATUS_DB
			. ' WHERE msg_id IN ('
			. '  SELECT msg_id'
			. '  FROM ' . MSG_TEXT_DB
			. '  WHERE'
			. '  msg_removed = ' . MSG_REMOVED_YES
			. '  OR msg_expire < ' . $DB->AddQuotes(date('Y-m-d H:i:s'))
			. ' );'
			, __METHOD__
		);

		wfDebug(basename(__FILE__) . ' || ' . __METHOD__ . " || result=" . ($dbResult ? 'true':'false') . "\n");
	}
}
?>