<?php
/**
 * SpecialCacheEpoch
 *
 * A SpecialCacheEpoch extension for MediaWiki
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
 *     include("$IP/extensions/wikia/SpecialCacheEpoch/SpecialCacheEpoch.php");
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named SpecialCacheEpoch.\n";
	exit(1) ;
}

$wgSpecialPages['CacheEpoch'] = 'SpecialCacheEpoch';
$wgExtensionMessagesFiles['CacheEpoch'] = dirname(__FILE__) . '/SpecialCacheEpoch.i18n.php';
$wgExtensionCredits['special'][] = array(
	'name' => 'SpecialCacheEpoch',
	'author' => '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]',
	'description-msg' => 'cacheepoch-desc',
);

// @todo FIXME: split off to class page.
class SpecialCacheEpoch extends SpecialPage {
	public function __construct() {
		parent::__construct('CacheEpoch', 'cacheepoch');
	}

	public function execute($subpage) {
		global $wgOut, $wgRequest, $wgUser, $wgCacheEpoch, $wgCityId;

		wfProfileIn(__METHOD__);

		$this->setHeaders();
		$this->mTitle = SpecialPage::getTitleFor('cacheepoch');

		if ($this->isRestricted() && !$this->userCanExecute($wgUser)) {
			$this->displayRestrictionError();
			wfProfileOut(__METHOD__);
			return;
		}

		//no WikiFactory (internal wikis)
		if (empty($wgCityId)) {
			$wgOut->addHTML(wfMsg('cacheepoch-no-wf'));
			wfProfileOut(__METHOD__);
			return;
		}

		if ($wgRequest->wasPosted()) {
			$wgCacheEpoch = wfTimestampNow();
			$status = WikiFactory::setVarByName('wgCacheEpoch', $wgCityId, $wgCacheEpoch, wfMsg('cacheepoch-wf-reason'));
			if ($status) {
				$wgOut->addHTML('<h2>' . wfMsg('cacheepoch-updated', $wgCacheEpoch) . '</h2>');
			} else {
				$wgOut->addHTML('<h2>' . wfMsg('cacheepoch-not-updated') . '</h2>');
			}
		} else {
			$wgOut->addHTML('<h2>' . wfMsg('cacheepoch-header') . '</h2>');
		}

		$wgOut->addHTML(Xml::openElement('form', array('action' => $this->mTitle->getFullURL(), 'method' => 'post')));
		$wgOut->addHTML(wfMsg('cacheepoch-value', $wgCacheEpoch) . '<br>');
		$wgOut->addHTML(Xml::submitButton(wfMsg('cacheepoch-submit')));
		$wgOut->addHTML(Xml::closeElement('form'));

		wfProfileOut(__METHOD__);
	}
}
