<?php
/**
 * SpecialUserData
 *
 * A SpecialUserData extension for MediaWiki
 * Provides an interface for managing categories in article without editing whole article
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2011-01-20
 * @copyright Copyright (C) 2009 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     include("$IP/extensions/wikia/SpecialUserData/SpecialUserData.php");
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named SpecialUserData.\n";
	exit(1) ;
}

$wgSpecialPages['UserData'] = 'SpecialUserData';
$wgExtensionMessagesFiles['UserData'] = dirname(__FILE__) . '/SpecialUserData.i18n.php';
$wgExtensionCredits['special'][] = array(
	'name' => 'SpecialUserData',
	'author' => '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]',
	'description-msg' => 'specialuserdata-desc',
);

class SpecialUserData extends SpecialPage {
	public function __construct() {
		parent::__construct('UserData', 'userdata');
	}

	public function execute($subpage) {
		global $wgOut, $wgRequest, $wgUser, $wgCacheEpoch, $wgCityId;

		wfProfileIn(__METHOD__);

		$this->setHeaders();
		$this->mTitle = SpecialPage::getTitleFor('UserData');

		if ($this->isRestricted() && !$this->userCanExecute($wgUser)) {
			$this->displayRestrictionError();
			wfProfileOut(__METHOD__);
			return;
		}

		$result = '';
		$userId = $wgRequest->getInt('userId');
		if ($userId) {
			$user = User::newFromId($userId);
			if (!empty($user)) {
				//todo: add nicer result - right now only name and link to user page
				$result = Xml::element('a', array('href' => $user->getUserPage()->getLocalURL()), $user->getName(), false);
			}
		}

		$wgOut->addHTML(Xml::openElement('form', array('action' => $this->mTitle->getFullURL(), 'method' => 'get')));
		$wgOut->addHTML(Xml::inputLabel(wfMsg('userdata-userid-label'), 'userId', 'user-id', false, $userId));
		$wgOut->addHTML('<br>' . Xml::submitButton(wfMsg('userdata-submit')));
		$wgOut->addHTML(Xml::closeElement('form'));
		if ($result) {
			$wgOut->addHTML('<hr>' . $result);
		}

		wfProfileOut(__METHOD__);
	}
}