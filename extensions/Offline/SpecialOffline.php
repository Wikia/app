<?php
/**
 * Special:Offline
 *   Configuration and status reporting for standalone mode.
 * Checks that dependencies are installed correctly and the database
 * dumps have been prepared.
 */

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Wikipedia Offline Patch',
	'author' => 'Adam Wight', 
	'status' => 'beta',
	'url' => 'http://code.google.com/p/wikipedia-offline-patch', 
	'version' => '0.6',
	'descriptionmsg' => 'offline_special_desc'
);

$dir = dirname(__FILE__);
$wgExtensionMessagesFiles['SpecialOffline'] = $dir.'/SpecialOffline.i18n.php';

class SpecialOffline extends SpecialPage
{
	function SpecialOffline() {
		parent::__construct('offline' /*, 'editinterface' */);
	}

	function execute($param) {
		global $wgOut, $wgTitle;

		$this->setHeaders();
		$this->outputHeader();

		$this->runTests();

		//TODO report and explain wgOfflineIgnoreLiveData
	}

	function runTests() {
		global $wgOut, $wgTitle;

		$wgOut->wrapWikiMsg('<h1>$1</h1>', 'offline_heading_status');

		$wgOut->addHTML('<ul>');
		// lookup a real article in the index can be searched
		$results = DumpReader::index_search(wfMsg('offline_test_article'));
		if (count($results) > 0)
			list ($bz_file, $offset, $entry_title) = $results[0];

		$test_index = isset($bz_file);
		$this->printTest($test_index, 'offline_index_test');
		if (!$test_index) {
			$this->diagnoseIndex();
			return;
		}

		// tests that bz2 dumpfiles can be opened and read
		$xml = DumpReader::load_bz($bz_file, $entry_title);
		$test_bz = isset($xml);
		$this->printTest($test_bz, 'offline_bzload_test');
		if (!$test_bz) {
			$this->diagnoseBzload($bz_file);
			return;
		}
			//report subdirectory setting
//                if (substr($bz_file, 0, 1) == 'x') {
//                    $subdir = dirname($bz_file); //TODO strip absolute components if needed
//                    $wgOut->addWikiMsg('offline_subdir-status', $subdir);
//                    $wgOut->addHTML(
//                        '<label>' .  wfMsg('offline_change-subdir') .
//                        '<input type=text size=20 name="subdir" value="'.$subdir.'">
//                        <input type=submit name="subdir" value="Change">
//                        </label/>'
//                    );
//                }

		// TODO report language settings and availabilities

		//test that a specific article can be loaded
		$article_wml = DumpReader::load_article($entry_title);
		$test_article = isset($article_wml);
		$this->printTest($test_article, 'offline_article_test');
		if (!$test_article) {
			//TODO diagnose
			return;
		}
		//TODO test that the wml has not been padded or truncated

		//test that our handler is still hooked in
		$mw_api_article = new Article(Title::newFromText($entry_title));
		$mw_api_article->loadContent();
		$content = $mw_api_article->getContent();
//wfDebug('got '.strlen($mw_api_article->mContent).' bytes of wml from cache');
		$test_hooks = $mw_api_article->mContentLoaded;
		// TODO false positive
		$this->printTest($test_hooks, 'offline_hooks_test');
		if (!$test_hooks) {
			$this->diagnoseHooks();
			return;
		}

		//TODO test Templates

		$wgOut->addHTML('</ul>');

		$wgOut->wrapWikiMsg('<i>$1</i>', 'offline_all_tests_pass');
		//TODO div collapse or load on demand
		//$wgOut->addWikiText($content);
	}

	function diagnoseIndex() {
		global $wgOut, $wgOfflineWikiPath;

		if (!isset($wgOfflineWikiPath)) {
			$this->printDiagnostic('offlinewikipath_not_configured');
		}
		elseif (!is_dir($wgOfflineWikiPath)) {
			$this->printDiagnostic(array('offlinewikipath_not_found', $wgOfflineWikiPath));
		}
		elseif (!is_dir("$wgOfflineWikiPath/db") || !file_exists("$wgOfflineWikiPath/db/termlist.DB")) {
			$this->printDiagnostic(array('offline_dbdir_not_found', $wgOfflineWikiPath));
		} else {
			$this->printDiagnostic('offline_unknown_index_error');
		}
	}

	function diagnoseBzload($bz_file) {
		global $wgOut, $wgOfflineWikiPath;
		
		$full_path = $wgOfflineWikiPath.'/'.$bz_file;
		if (!extension_loaded('bz2')) {
			$this->printDiagnostic('offline_bz2_ext_needed');
		}
		if (!file_exists($full_path)) {
			$this->printDiagnostic(array('offline_bz2_file_gone', $full_path));
		}
		else {
			$this->printDiagnostic(array('offline_unknown_bz2_error', $full_path));
		}
	}

	function diagnoseHooks() {
		global $wgOut, $wgMemc;
		$key = wfMemcKey('offline','trial');
		$wgMemc->set($key, true);
		if (!$wgMemc->get($key)) {
			$this->printDiagnostic('offline_cache_needed');
		}
		// check that passing revisiontext through cache will work
	}

	function printTest($bool, $msg) {
		global $wgOut;
		if ($bool)
			$wgOut->wrapWikiMsg('<div class="result-pass"><li>$1</div>', $msg.'_pass');
		else
			$wgOut->wrapWikiMsg('<div class="error"><li>$1</div>', $msg.'_fail');
	}

	function printDiagnostic($msg) {
		global $wgOut;
		$wgOut->wrapWikiMsg('<div class="errorbox">$1</div>', $msg);
	}
}
