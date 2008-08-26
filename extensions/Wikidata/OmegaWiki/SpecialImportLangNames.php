<?php
	if (!defined('MEDIAWIKI')) die();

	require_once("Wikidata.php");
	$wgGroupPermissions['bureaucrat']['languagenames'] = true;
	$wgAvailableRights[] = 'languagenames';

	$wgExtensionFunctions[] = 'wfSpecialImportLangNames';
	function wfSpecialImportLangNames() {

	global $wgMessageCache;
	$wgMessageCache->addMessages(array('importlangnames'=>'Wikidata: Import language names'),'en');

		class SpecialImportLangNames extends SpecialPage {
			function SpecialImportLangNames() {
				SpecialPage::SpecialPage('ImportLangNames');
			}

			function execute($par) {
				global $wgOut, $wgUser;
				// These operations should always be on the community database.
				$dc="uw";
				require_once('Transaction.php');

				$wgOut->setPageTitle('Import Language Names');

				if (!$wgUser->isAllowed('languagenames')) {
					$wgOut->addHTML('You do not have permission to import language names.');
					return false;
				}

				$dbr = &wfGetDB(DB_MASTER);

				/* Get collection ID for "ISO 639-3 codes" collection. */
				$sql = "SELECT collection_id FROM {$dc}_collection" .
					" JOIN {$dc}_defined_meaning ON defined_meaning_id = collection_mid" .
					" JOIN {$dc}_expression ON" .
					" {$dc}_defined_meaning.expression_id = {$dc}_expression.expression_id" .
					' WHERE spelling LIKE "ISO 639-3 codes"' .
					' AND ' . getLatestTransactionRestriction("{$dc}_collection") .
					' LIMIT 1';
				$collection_id_res = $dbr->query($sql);
				$collection_id = $this->fetchResult($dbr->fetchRow($collection_id_res));

				/* Get defined meaning IDs and ISO codes for languages in collection. */
				$sql = "SELECT member_mid,internal_member_id FROM {$dc}_collection_contents" .
					' WHERE collection_id = ' . $collection_id .
					' AND ' . getLatestTransactionRestriction("{$dc}_collection_contents");
				$lang_res = $dbr->query($sql);
				$editable = '';
				$first = true;
				while ($lang_row = $dbr->fetchRow($lang_res)) {
					$iso_code = $lang_row['internal_member_id'];
					$dm_id = $lang_row['member_mid'];
		
					/*	Get the language ID for the current language. */
					$sql = 'SELECT language_id FROM language' .
						' WHERE iso639_3 LIKE ' . $dbr->addQuotes($iso_code) .
						' LIMIT 1';
					$lang_id_res = $dbr->query($sql);
					if ($dbr->numRows($lang_id_res)) {
						if (!$first)
							$wgOut->addHTML('<br />' . "\n");
						else
							$first = false;
						$wgOut->addHTML('Language names for "' . $iso_code . '" added.');

						/* Add current language to list of portals/DMs. */
						$sql = "SELECT spelling FROM {$dc}_expression" .
							" JOIN {$dc}_defined_meaning ON {$dc}_defined_meaning.expression_id = {$dc}_expression.expression_id" .
							' WHERE defined_meaning_id = ' . $dm_id .
							' LIMIT 1';
						$dm_expr_res = $dbr->query($sql);
						$dm_expr = $this->fetchResult($dbr->fetchRow($dm_expr_res));
						if ($editable != '')
							$editable .= "\n";
						$editable .= '*[[Portal:' . $iso_code . ']] - [[DefinedMeaning:' . $dm_expr . ' (' . $dm_id . ')]]';
					}
					else {
						if (!$first)
							$wgOut->addHTML('<br />' . "\n");
						else
							$first = false;
						$wgOut->addHTML('<strong>No language entry for "' . $iso_code . '" found! </strong>');
						continue;
					}
					$lang_id = $this->fetchResult($dbr->fetchRow($lang_id_res));

					/*	Delete all language names that match current language ID. */
					$sql = 'DELETE FROM language_names' .
						' WHERE language_id = ' . $lang_id;
					$dbr->query($sql);

					/*	Get syntrans expressions for names of language and IDs for the languages the names are in. */
					$sql = "SELECT spelling,language_id FROM {$dc}_expression" .
						" JOIN {$dc}_syntrans" .
						" ON {$dc}_expression.expression_id = {$dc}_syntrans.expression_id" .
						' WHERE defined_meaning_id = ' . $dm_id .
						' AND ' . getLatestTransactionRestriction("{$dc}_expression") .
						' AND ' . getLatestTransactionRestriction("{$dc}_syntrans") .
						' GROUP BY language_id ORDER BY NULL';
					$syntrans_res = $dbr->query($sql);
					while ($syntrans_row = $dbr->fetchRow($syntrans_res)) {
						$sql = 'INSERT INTO language_names' .
							' (`language_id`,`name_language_id`,`language_name`)' .
							' VALUES(' . $lang_id . ', ' .
							$syntrans_row['language_id'] . ', ' .
							$dbr->addQuotes($syntrans_row['spelling']) . ')';
						$dbr->query($sql);
					}
				}
				$this->addDMsListToPage($editable,'Editable_languages');
			}

			/* XXX: This is probably NOT the proper way to do this. It should be refactored. */
			function addDMsListToPage($content,$page) {
				$dbr = &wfGetDB(DB_MASTER);

				/* Get ID of the page we want to put the list on. */
				$sql = 'SELECT page_id FROM page' .
					' WHERE page_title LIKE ' . $dbr->addQuotes($page) .
					' LIMIT 1';
				$page_res = $dbr->query($sql);
				$page_id = $this->fetchResult($dbr->fetchRow($page_res));

				/* Don't do anything if the old content is the same as the new. */
				$sql = 'SELECT old_text FROM text' .
					' JOIN revision ON rev_text_id = old_id' .
					' WHERE rev_page = ' . $page_id .
					' LIMIT 1';
				$current_res = $dbr->query($sql);
				$current = $this->fetchResult($dbr->fetchRow($current_res));
				if ($content == $current)
					return;

				/* Insert new text and grab new row ID. */
				$sql = 'INSERT INTO text (`old_text`,`old_flags`)' .
					' VALUES(' . $dbr->addQuotes($content) . ',' .
					$dbr->addQuotes('utf-8') . ')';
				$dbr->query($sql);
				$text_id = $dbr->insertId();

				/* Add new revision to database and update page entry. */
				$time = wfTimestamp(TS_MW);
				$sql = 'INSERT INTO revision (`rev_page`,`rev_text_id`,' .
					'`rev_comment`,`rev_user_text`,`rev_timestamp`)' .
					' VALUES(' . $page_id . ',' . $text_id . ',' .
					$dbr->addQuotes('Set to latest DefinedMeanings list') .
					',' . $dbr->addQuotes('ImportLangNames') . ','. $time . ')';
				$dbr->query($sql);
				$rev_id = $dbr->insertId();
				$sql = 'UPDATE page SET page_latest = ' . $rev_id . ',page_touched = ' .
					$time . ',page_is_new = 0,page_len = ' . strlen($content) .
					' WHERE page_id = ' . $page_id;
				$dbr->query($sql);
			}

			/* Return first field in row. */
			function fetchResult($row) {
				return $row[0];
			}

		}

		SpecialPage::addPage(new SpecialImportLangNames);
	}

