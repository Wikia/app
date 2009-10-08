<?php
/**
 * Special page for testing language fallback used in HTML e-mails
 *
 * @author Marooned
 * @package MediaWiki
 * @subpackage SpecialPage
 */

if (!defined('MEDIAWIKI'))
	die;

extAddSpecialPage( dirname(__FILE__) . '/MessageTestHelper.php', 'MessageTestHelper', 'MessageTestHelper' );
$wgGroupPermissions['staff']['messagetesthelper'] = true;

class MessageTestHelper extends UnlistedSpecialPage {

	function __construct() {
		parent::__construct( 'MessageTestHelper' );
	}

	function execute( $par ) {
		global $wgOut, $wgRequest, $wgMessageCache, $wgContLanguageCode, $wgLang, $wgUser;

		if(!$wgUser->isAllowed('messagetesthelper')) {
			$this->displayRestrictionError();
			return;
		}

		$resultHTML = "<table border='1' style='font-size:11px'>\n<tr><th>main msg</th><th>alternative msg</th><th>lang used</th><th>result plain msg</th><th>result HTML msg</th></tr>\n";
		$tableRow = "<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>\n";

		$messages = array(
			/* watchlist messages - with fallback to 'enotif_body' */
			'enotif_body', 'enotif_body_blogs_comment', 'enotif_body_delete', 'enotif_body_move', 'enotif_body_prl_chn', 'enotif_body_prl_rep', 'enotif_body_protect', 'enotif_body_restore', 'enotif_body_rights', 'enotif_body_unprotect',
			/* other messages */
			'passwordremindertext', 'reconfirmemail_body'
		);

		$result = array();
		foreach ($messages as $message) {
			$msgAlter = strpos($message, 'enotif_body') === false ? null : 'enotif_body';

			if (empty($msgAlter)) {
				$usedLang = $wgLang->getCode();
				list($body, $bodyHTML) = wfMsgHTMLwithLanguage($message, $usedLang);
			} else {
				$usedLang = $wgContLanguageCode;
				list($body, $bodyHTML) = wfMsgHTMLwithLanguageAndAlternative($message, $msgAlter, $wgContLanguageCode);
			}
			$resultHTML .= sprintf($tableRow, $message, $msgAlter, $usedLang, $body, $bodyHTML);
		}
		$resultHTML .= '</table>';

		$wgOut->setPageTitle( 'MessageTestHelper' );
		$wgOut->addHTML($resultHTML);
	}
}