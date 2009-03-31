<?php
/**
 * CategoryWatch extension
 * - Extends watchlist functionality to include notification about membership changes of watched categories
 *
 * See http://www.mediawiki.org/Extension:CategoryWatch for installation and usage details
 * See http://www.organicdesign.co.nz/Extension_talk:CategoryWatch for development notes and disucssion
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Aran Dunkley [http://www.organicdesign.co.nz/nad User:Nad]
 * @copyright © 2008 Aran Dunkley
 * @licence GNU General Public Licence 2.0 or later
 */

if (!defined('MEDIAWIKI')) die('Not an entry point.');

define('CATEGORYWATCH_VERSION', '0.1.3, 2008-09-04');

$wgCategoryWatchNotifyEditor = true;

$wgExtensionFunctions[] = 'wfSetupCategoryWatch';
$wgExtensionCredits['other'][] = array(
	'name'           => 'CategoryWatch',
	'author'         => '[http://www.organicdesign.co.nz/User:Nad User:Nad]',
	'description'    => 'Extends watchlist functionality to include notification about membership changes of watched categories',
	'descriptionmsg' => 'categorywatch-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:CategoryWatch',
	'version'        => CATEGORYWATCH_VERSION,
);

$wgExtensionMessagesFiles['CategoryWatch'] =  dirname(__FILE__) . '/CategoryWatch.i18n.php';

class CategoryWatch {

	function __construct() {
		global $wgHooks;
		$wgHooks['ArticleSave'][] = $this;
		$wgHooks['ArticleSaveComplete'][] = $this;
	}

	/**
	 * Get a list of categories before article updated
	 */
	function onArticleSave(&$article, &$user, &$text) {
		$this->before = array();
		$dbr  = &wfGetDB(DB_SLAVE);
		$cl   = $dbr->tableName('categorylinks');
		$id   = $article->getID();
		$res  = $dbr->select($cl, 'cl_to', "cl_from = $id", __METHOD__, array('ORDER BY' => 'cl_sortkey'));
		while ($row = $dbr->fetchRow($res)) $this->before[] = $row[0];
		$dbr->freeResult($res);
		return true;
	}

	/**
	 * Find changes in categorisation and send messages to watching users
	 */
	function onArticleSaveComplete(&$article, &$user, &$text) {

		# Get cats after update
		$this->after = array();
		$dbr  = &wfGetDB(DB_SLAVE);
		$cl   = $dbr->tableName('categorylinks');
		$id   = $article->getID();
		$res  = $dbr->select($cl, 'cl_to', "cl_from = $id", __METHOD__, array('ORDER BY' => 'cl_sortkey'));
		while ($row = $dbr->fetchRow($res)) $this->after[] = $row[0];
		$dbr->freeResult($res);

		# Get list of added and removed cats
		$add = array_diff($this->after, $this->before);
		$sub = array_diff($this->before, $this->after);

		# Notify watchers of each cat about the addition or removal of this article
		if (count($add) > 0 || count($sub) > 0) {
			$page = $article->getTitle()->getText();
			if (count($add) == 1 && count($sub) == 1) {
				$add = array_shift($add);
				$sub = array_shift($sub);

				$title   = Title::newFromText($add, NS_CATEGORY);
				$message = wfMsg('categorywatch-catmovein', $page, $add, $sub);
				$this->notifyWatchers($title, $user, $message);

				$title   = Title::newFromText($sub, NS_CATEGORY);
				$message = wfMsg('categorywatch-catmoveout', $page, $sub, $add);
				$this->notifyWatchers($title, $user, $message);
			}
			else {

				foreach ($add as $cat) {
					$title   = Title::newFromText($cat, NS_CATEGORY);
					$message = wfMsg('categorywatch-catadd', $page, $cat);
					$this->notifyWatchers($title, $user, $message);
				}

				foreach ($sub as $cat) {
					$title   = Title::newFromText($cat, NS_CATEGORY);
					$message = wfMsg('categorywatch-catsub', $page, $cat);
					$this->notifyWatchers($title, $user, $message);
				}
			}
		}

		return true;
	}

	function notifyWatchers(&$title, &$editor, &$message) {
		global $wgLang, $wgEmergencyContact, $wgNoReplyAddress, $wgCategoryWatchNotifyEditor;

		# Get list of users watching this category
		$dbr = wfGetDB(DB_SLAVE);
		$conds = array('wl_title' => $title->getDBkey(), 'wl_namespace' => $title->getNamespace());
		if (!$wgCategoryWatchNotifyEditor) $conds[] = 'wl_user <> '.intval($editor->getId());
		$res = $dbr->select('watchlist', array('wl_user'), $conds, __METHOD__);

		# Wrap message with common body and send to each watcher
		$page    = $title->getText();
		$from    = new MailAddress($wgEmergencyContact, 'WikiAdmin');
		$replyto = new MailAddress($wgNoReplyAddress);
		foreach ($res as $row) {
			$watchingUser = User::newFromId($row->wl_user);
			if ($watchingUser->getOption('enotifwatchlistpages') && $watchingUser->isEmailConfirmed()) {
				$to = new MailAddress($watchingUser);
				$timecorrection = $watchingUser->getOption('timecorrection');
				$editdate =	$wgLang->timeanddate(wfTimestampNow(), true, false, $timecorrection);
				$editdat1 =	$wgLang->date(wfTimestampNow(), true, false, $timecorrection);
				$edittim2 =	$wgLang->time(wfTimestampNow(), true, false, $timecorrection);
				$body = wfMsg(
					'categorywatch-emailbody',
					$watchingUser->getName(),
					$page,
					$editdate,
					$editor->getName(),
					$message,
					$editdat1,
					$edittim2
				);
				if (function_exists('userMailer')) {
					userMailer(
						$to,
						$from,
						wfMsg('categorywatch-emailsubject', $page),
						$body,
						$replyto
					);
				}
				else {
					UserMailer::send(
						$to,
						$from,
						wfMsg('categorywatch-emailsubject', $page),
						$body,
						$replyto
					);
				}
			}
		}

		$dbr->freeResult($res);
	}

	/**
	 * Needed in some versions to prevent Special:Version from breaking
	 */
	function __toString() { return __CLASS__; }
}

function wfSetupCategoryWatch() {
	global $wgCategoryWatch;

	# Instantiate the CategoryWatch singleton now that the environment is prepared
	$wgCategoryWatch = new CategoryWatch();

	wfLoadExtensionMessages( 'CategoryWatch' );
}
