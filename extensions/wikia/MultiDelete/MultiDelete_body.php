<?php

/**
 * MultiDelete
 *
 * A MultiDelete extension for MediaWiki
 * Deletes batch of pages on selected wikis
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @author Bartek Łapiński <bartek at wikia-inc.com>
 * @date 2009-01-09
 * @copyright Copyright (C) 2009 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage SpecialPage
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/MultiDelete/MultiDelete.php");
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named MultiDelete.\n";
	exit(1);
}

define('CHUNK_SIZE', 500);

class MultiDelete extends SpecialPage {
	/**
	 * contructor
	 */
	function  __construct() {
		parent::__construct('MultiDelete' /*class*/, 'multidelete' /*restriction*/);
	}

	function execute($subpage) {
		global $wgUser, $wgOut, $wgRequest, $wgTitle, $wgParser;

		if(!$wgUser->isAllowed('multidelete')) {
			$wgOut->permissionRequired('multidelete');
			return;
		}

		wfLoadExtensionMessages('MultiDelete');

		if ($wgRequest->wasPosted() && $wgUser->matchEditToken($wgRequest->getVal('mEditToken'))) {
			$formData['errMsg'] = $this->doSubmit();
			if (empty($formData['errMsg'])) {
				return;
			}
		}

		$formData['wikiInbox'] = $wgRequest->getText('mWikiInbox');
		$formData['titles'] = $wgRequest->getText('mTitles');
		$formData['mode'] = $wgRequest->getVal('mMode');
		$formData['modes'] = array(
			'script' => wfMsg('multidelete-select-script'),
			'you' => wfMsg('multidelete-select-yourself')
		);
		$formData['range'] = $wgRequest->getVal('mRange');
		$formData['rangeHidden'] = $formData['range'] == 'selected' ? '' : 'display: none;';
		$formData['ranges'] = array(
			'one' => wfMsg('multidelete-this-wiki'),
			'all' => wfMsg('multidelete-all-wikis'),
			'selected' => wfMsg('multidelete-selected-wikis'),
			'lang:pt-br' => wfMsg('multidelete-brazilian-portuguese-wikis'),
			'lang:he' => wfMsg('multidelete-hebrew-wikis'),
			'lang:zh' => wfMsg('multidelete-chinese-wikis'),
			'lang:pl' => wfMsg('multidelete-polish-wikis'),
			'lang:cs' => wfMsg('multidelete-czech-wikis'),
			'lang:pt' => wfMsg('multidelete-portuguese-wikis'),
			'lang:nl' => wfMsg('multidelete-dutch-wikis'),
			'lang:it' => wfMsg('multidelete-italian-wikis'),
			'lang:ru' => wfMsg('multidelete-russian-wikis'),
			'lang:en' => wfMsg('multidelete-english-wikis'),
			'lang:ja' => wfMsg('multidelete-japanese-wikis'),
			'lang:fi' => wfMsg('multidelete-finnish-wikis'),
			'lang:es' => wfMsg('multidelete-spanish-wikis'),
			'lang:fr' => wfMsg('multidelete-french-wikis'),
			'lang:sv' => wfMsg('multidelete-swedish-wikis'),
			'lang:de' => wfMsg('multidelete-german-wikis')
		);

		$formData['editToken'] = htmlspecialchars($wgUser->editToken());

		$wgOut->SetPageTitle(wfMsg('multidelete-title'));

		$oTmpl = new EasyTemplate(dirname( __FILE__ ) . '/templates/');
		$oTmpl->set_vars( array(
				'title' => $wgTitle,
				'formData' => $formData
			));
		$wgOut->addHTML($oTmpl->execute('main'));
	}

	function doSubmit() {
		global $wgCityId, $wgRequest, $wgUser, $wgOut, $wgTitle;
		$mTitles = trim($wgRequest->getText('mTitles'));
		if ($mTitles == '') {
			return wfMsg('multidelete-error-empty-pages');
		}
		$mMode = $wgRequest->getVal('mMode');
		$mRange = $wgRequest->getVal('mRange');
		$mWikiInbox = trim($wgRequest->getText('mWikiInbox'));

		$mTitles = explode("\n", $mTitles);
		$username = $mMode == 'script' ? 'delete page script' : $wgUser->getName();
		$wikis = array();

		$wgOut->SetPageTitle(wfMsg('multidelete-title'));

		switch ($mRange) {
			case 'one':
				$wikis[$wgCityId] = '';
				$wikis = $this->getWikisWithTitles($wikis, $mTitles);
				$this->deletePagesOnWikis($wikis, $mTitles, $username, 'single');
				break;

			case 'all':
				if (count($mTitles) > 1) {
					return wfMsg('multidelete-error-multi-page');
				}

				$dbr = wfGetDB(DB_SLAVE);

				//get selected wikis
				$res = $dbr->select(
					array(wfSharedTable('city_list'), wfSharedTable('city_domains')),
					array('city_list.city_id', 'city_domain'),
					array('city_list.city_id = city_domains.city_id'),
					__METHOD__
				);

				foreach ($res as $row) {
					$wikis[$row->city_id] = $row->city_domain;
				}
				$dbr->freeResult($res);

				$wikisWithTitle = $this->getWikisWithTitles($wikis, $mTitles);

				$formData['editToken'] = htmlspecialchars($wgUser->editToken());
				$formData['wikis'] = $wikisWithTitle;
				$formData['mTitles'] = $mTitles;

				$oTmpl = new EasyTemplate(dirname( __FILE__ ) . '/templates/');
				$oTmpl->set_vars( array(
						'title' => $wgTitle,
						'formData' => $formData
					));
				$wgOut->addHTML($oTmpl->execute('selection'));
				break;

			case 'confirmed':
				$mTitles = unserialize(htmlspecialchars_decode($mTitles[0]));
				$wikis = $wgRequest->getArray('mSelectedWikis');
				if (count($wikis)) {
					$this->deletePagesOnWikis($wikis, $mTitles, $username);
				} else {
					$wgOut->addHtml(wfMsg('multidelete-task-none-selected'));
				}
				break;

			case 'selected':
				if ($mWikiInbox == '') {
					return wfMsg('multidelete-error-empty-selection');
				}
				if (count($mTitles) > 1) {
					return wfMsg('multidelete-error-multi-page');
				}

				$dbr = wfGetDB(DB_SLAVE);

				$selectedWikis = explode(',', $mWikiInbox);
				array_walk($selectedWikis, create_function('&$item, $key', '$item = "\'" . mysql_real_escape_string(trim($item)) . "\'";'));
				$selectedWikis = implode(',', $selectedWikis);

				//get selected wikis
				$res = $dbr->select(
					array(wfSharedTable('city_list'), wfSharedTable('city_domains')),
					array('city_list.city_id', 'city_domain'),
					array('city_list.city_id = city_domains.city_id', "city_domain IN ($selectedWikis)"),
					__METHOD__
				);

				foreach ($res as $row) {
					$wikis[$row->city_id] = $row->city_domain;
				}
				$dbr->freeResult($res);

				//get wikis with selected titles
				$wikisWithTitle = $this->getWikisWithTitles($wikis, $mTitles);

				$formData['editToken'] = htmlspecialchars($wgUser->editToken());
				$formData['wikis'] = $wikisWithTitle;
				$formData['mTitles'] = $mTitles;

				$oTmpl = new EasyTemplate(dirname( __FILE__ ) . '/templates/');
				$oTmpl->set_vars( array(
						'title' => $wgTitle,
						'formData' => $formData
					));
				$wgOut->addHTML($oTmpl->execute('selection'));
				break;

			default:
				if (strpos($mRange, 'lang:') !== false) {
					if (count($mTitles) > 1) {
						return wfMsg('multidelete-error-multi-page');
					}
					$lang = substr($mRange, 5);

					//get selected wikis
					$dbr = wfGetDB(DB_SLAVE);
					$res = $dbr->select(
						array(wfSharedTable('city_list'), wfSharedTable('city_domains')),
						array('city_list.city_id', 'city_domain'),
						array('city_list.city_id = city_domains.city_id', "city_lang = '$lang'"),
						__METHOD__
					);
					foreach ($res as $row) {
						$wikis[$row->city_id] = $row->city_domain;
					}
					$dbr->freeResult($res);

					//get wikis with selected titles
					$wikisWithTitle = $this->getWikisWithTitles($wikis, $mTitles);

					$formData['editToken'] = htmlspecialchars($wgUser->editToken());
					$formData['wikis'] = $wikisWithTitle;
					$formData['mTitles'] = $mTitles;

					$oTmpl = new EasyTemplate(dirname( __FILE__ ) . '/templates/');
					$oTmpl->set_vars( array(
							'title' => $wgTitle,
							'formData' => $formData
						));
					$wgOut->addHTML($oTmpl->execute('selection'));
				}
				break;
		}
	}

	function getWikisWithTitles($wikis, $titles) {
		$wikisArr = array();
		$dbr = wfGetDBExt(DB_SLAVE);
		foreach ($titles as $title) {
			list($title, $reason) = explode('|', $title, 2);
			$page = Title::newFromText($title);
			if (!is_object($page)) {
				continue;
			}
			$namespace = $page->getNamespace();
			$titleName = $page->getText();

			$res = $dbr->select(
				'pages',
				'DISTINCT page_wikia_id',
				array(	'page_namespace' => $namespace,
					'page_title' => $titleName,
					'page_wikia_id IN (' . implode(',', array_keys($wikis)) . ')'
				),
				__METHOD__
			);
			foreach ($res as $row) {
				$wikisArr[$row->page_wikia_id][] = array('namespace' => $namespace, 'title' => $titleName, 'reason' => $reason, 'domain' => $wikis[$row->page_wikia_id]);
			}
			$dbr->freeResult($res);
		}
		return $wikisArr;
	}

	function deletePagesOnWikis($wikis, $titles, $username, $mode = 'multi') {
		global $wgUser, $wgOut;
		$chunks = array();
		$chunkId = $chunkCount = 0;
		if ($mode == 'multi') {		//many wiki, single title
			list($title, $reason) = explode('|', $titles[0], 2);
			$page = Title::newFromText($title);
			if (!is_object($page)) {
				$wgOut->addHtml(wfMsg('multidelete-task-error'));
				return;
			}
			$namespace = $page->getNamespace();
			$titleName = $page->getText();

			foreach ($wikis as $wikiId) {
				if ($chunkCount >= CHUNK_SIZE) {
					$chunkId++;
					$chunkCount = 0;
				}
				$chunks[$chunkId][$wikiId][] = array('namespace' => $namespace, 'title' => $titleName, 'reason' => $reason);
				$chunkCount++;
			}
		} else {					//single wiki, many titles
			foreach ($wikis as $wikiId => $titles) {
				foreach ($titles as $titleData) {
					if ($chunkCount >= CHUNK_SIZE) {
						$chunkId++;
						$chunkCount = 0;
					}
					$chunks[$chunkId][$wikiId][] = array('namespace' => $titleData['namespace'], 'title' => $titleData['title'], 'reason' => $titleData['reason']);
					$chunkCount++;
				}
			}
		}

		foreach ($chunks as $chunk) {
			$thisTask = new MultiDeleteTask;
			$thisTask->mArguments = $chunk;
			$thisTask->mMode = 'multi';
			$thistask->mAdmin = $wgUser->getName();
			$thisTask->mUsername = $username;
			$submit_id = $thisTask->submitForm();
			if ($submit_id !== false) {
				$wgOut->addHtml("<br/>". wfMsg('multidelete-task-added', $submit_id). "<br/>" );
			} else {
				$wgOut->addHtml("<br/>". wfMsg('multidelete-task-error'). "<br/>" );
			}
		}
		$wgOut->SetPageTitle(wfMsg('multidelete-title'));
	}
}
