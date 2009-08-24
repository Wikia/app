<?php
	if (!defined('MEDIAWIKI')) die();

	require_once("WikiDataAPI.php"); // for bootstrapCollection
	require_once("Utilities.php"); 
	
	$wgGroupPermissions['bureaucrat']['importtsv'] = true;
	$wgAvailableRights[] = 'importtsv';
	$wgExtensionFunctions[] = 'wfSpecialImportTSV';

	function wfSpecialImportTSV() {
	        #global $wgMessageCache;
            #    $wgMessageCache->addMessages(array('importtsv'=>'Wikidata: Import TSV'),'en');
                        
		class SpecialImportTSV extends SpecialPage {
			
			function SpecialImportTSV() {
				SpecialPage::SpecialPage('ImportTSV');
			}

			function execute($par) {

				global $wgOut, $wgUser, $wgRequest;

				$wgOut->setPageTitle(wfMsg('ow_importtsv_title1'));
				if (!$wgUser->isAllowed('importtsv')) {
					$wgOut->addHTML(wfMsg('ow_importtsv_not_allowed'));
					return false;
				}
				
				$dbr =& wfGetDB(DB_MASTER);
				$dc = wdGetDataSetcontext();
				$wgOut->setPageTitle(wfMsg('ow_importtsv_importing'));
				setlocale(LC_ALL, 'en_US.UTF-8');				
				if ($wgRequest->getFileName('tsvfile')) {
					
					// *****************
					//    process tsv
					// *****************
					
					require_once('WikiDataAPI.php');
					require_once('Transaction.php');
					
					$testRun = $wgRequest->getCheck('testrun');
					
					// lets do some tests first. Is this even a tsv file? 
					// It is _very_ important that the file is utf-8 encoded.
					// also, this is a good time to determine the max line length for the 
					// fgetcsv function.
					$file = fopen($wgRequest->getFileTempname('tsvfile'),'r');
					$myLine = "";
					$maxLineLength = 0;
					while ($myLine = fgets($file)) {
						if (!preg_match('/./u', $myLine)) {
							$wgOut->setPageTitle(wfMsg('ow_importtsv_import_failed'));
							$wgOut->addHTML(wfMsg('ow_importtsv_not_utf8'));
							return false;
						}
						$maxLineLength = max($maxLineLength, strlen($myLine)+2);
					}
					
					// start from the beginning again. Check if the column names are valid
					rewind($file);
					$columns = fgetcsv($file, $maxLineLength, "\t");
					// somehow testing for $columns[0] fails sometimes. Byte Order Mark?
					if (!$columns || count($columns) <= 2 || $columns[1] != "defining expression") {
						$wgOut->setPageTitle(wfMsg('ow_importtsv_import_failed'));
						$wgOut->addHTML(wfMsg('ow_importtsv_not_tsv'));
						return false;
					}
					for ($i = 2; $i < count($columns); $i++) {
						$columnName = $columns[$i];
						$baseName = substr($columnName, 0, strrpos($columnName, '_'));
						if ($baseName == "definition" || $baseName == "translations") {
							$langCode = substr($columnName, strrpos($columnName, '_')+1);
							if (!getLanguageIdForIso639_3($langCode)) {
								$wgOut->setPageTitle(wfMsg('ow_importtsv_import_failed'));
								$wgOut->addHTML(wfMsg('ow_impexptsv_unknown_lang', $langCode));
								return false;
							}
						}
						else { // column name does not start with definition or translations. 
								$wgOut->setPageTitle(wfMsg('ow_importtsv_import_failed'));
								$wgOut->addHTML(wfMsg('ow_importtsv_bad_columns', $columnName));
								return false;
						}
						
					}
					
				
					//
					// All tests passed. lets get started
					//
					
					if ($testRun) {
						$wgOut->setPageTitle(wfMsg('ow_importtsv_test_run_title'));
					}
					else {	
						$wgOut->setPageTitle(wfMsg('ow_importtsv_importing'));
					}
					
					startNewTransaction($wgUser->getID(), wfGetIP(), "Bulk import via Special:ImportTSV", $dc);	# this string shouldn't be localized because it will be stored in the db
					
					$row = "";
					$line = 1; // actually 2, 1 was the header, but increased at the start of while
					$definitions = 0; // definitions added
					$translations = 0; // translations added
							
					while($row = fgetcsv($file, $maxLineLength, "\t")) { 
						$line++; 
						
						$dmid = $row[0];
						$exp = $row[1];
						
						// find the defined meaning record
						$qry = "SELECT dm.meaning_text_tcid, exp.spelling ";
						$qry .= "FROM {$dc}_defined_meaning dm INNER JOIN {$dc}_expression exp ON dm.expression_id=exp.expression_id ";
						$qry .= "WHERE dm.defined_meaning_id=$dmid ";
						$qry .= "AND " . getLatestTransactionRestriction('dm');
						$qry .= "AND " . getLatestTransactionRestriction('exp');
						
						$dmResult = $dbr->query($qry);
						$dmRecord = null;
						// perfomr some tests
						if ($dmRecord = $dbr->fetchRow($dmResult)) {
							if ($dmRecord['spelling'] != $exp) {
								$wgOut->addHTML("Skipped line $line: defined meaning id $dmid does not match defining expression. Should be '{$dmRecord['spelling']}', found '$exp'.<br />");
								continue;
							}
						}
						else {
							$wgOut->addHTML("Skipped line $line: unknown defined meaning id $dmid. The id may have been altered in the imported file, or the defined meaning or defining expression was removed from the database.<br />");
							continue; 
						}
						
						
						// all is well. Get the translated content id
						$tcid = $dmRecord['meaning_text_tcid'];
						
						
						for ($columnIndex = 2; $columnIndex < count($columns); $columnIndex++) {
							
							// Google docs removes empty columns at the end of a row,
							// so if column index is higher than the length of the row, we can break
							// and move on to the next defined meaning.
							if (columnIndex >= count($row)) {
								break;
							}
							
							$columnValue = $row[$columnIndex];
							if (!$columnValue) {
								continue;
							}
						
							$columnName = $columns[$columnIndex];
							$langCode = substr($columnName, strrpos($columnName, '_')+1);
							$langId = getLanguageIdForIso639_3($langCode);
							if (strpos($columnName, 'definition') === 0) {
								if (!translatedTextExists($tcid, $langId)) {
									if ($testRun) {
										$wgOut->addHTML("Would add definition for $exp ($dmid) in $langCode: $columnValue.<br />");
									} else {
										addTranslatedText($tcid, $langId, $columnValue);
										$wgOut->addHTML("Added definition for $exp ($dmid) in $langCode: $columnValue.<br />");
										$definitions++;
									}
								}
							}
							if (strpos($columnName, 'translation') === 0) {
								$spellings = explode('|', $columnValue);
								foreach ($spellings as $spelling) {
									$spelling = trim($spelling);
									$expression = findExpression($spelling, $langId);
									if (!$expression) { // expression does not exist
										if ($testRun) {
											$wgOut->addHTML("Would add translation for $exp ($dmid) in $langCode: $spelling. Would also add new page.<br />");
										}
										else {
											$expression = createExpression($spelling, $langId);
											$expression->bindToDefinedMeaning($dmid, 1);
	
											// not nescesary to check page exists, createPage does that.
											$title = getPageTitle($spelling);
											createPage(16, $title);
	
											$wgOut->addHTML("Added translation for $exp ($dmid) in $langCode: $spelling. Also added new page.<br />");
											$translations++;
										}
									} 
									else { // expression exists, but may not be bound to this defined meaning.
										if (!$expression->isBoundToDefinedMeaning($dmid)) {
											if ($testRun) {
												$wgOut->addHTML("Would add translation for $exp ($dmid) in $langCode: $spelling.<br />");
											}
											else {
												$expression->bindToDefinedMeaning($dmid, 1);
												$wgOut->addHTML("Added translation for $exp ($dmid) in $langCode: $spelling.<br />");
												$translations++;
											}
										}
									}
								}
							}
						}
					}
					
					if ($definitions == 0 && $translations == 0) {
						$wgOut->addHTML("<br />");
						if ($testRun) {
							$wgOut->addHTML(wfMsg('ow_importtsv_nothing_added_test'));
						}
						else {
							$wgOut->addHTML(wfMsg('ow_importtsv_nothing_added'));
						}
						$wgOut->addHTML("<br />");
					}
					else {
						$wgOut->addHTML("<br />" . wfMsgExt('ow_importtsv_results', 'parsemag', $definitions, $translations) . "<br />");
					}
						
				}
				else {
					// render the page
					$wgOut->setPageTitle(wfMsg('ow_importtsv_title2'));
					$wgOut->addHTML(wfMsg('ow_importtsv_header'));
					
					$wgOut->addHTML(getOptionPanelForFileUpload(
						array(
							wfMsg('ow_importtsv_file') => getFileField('tsvfile'),
							wfMsg('ow_importtsv_test_run') => getCheckBox('testrun', true)
						)
					));
				}

			}
			
			
			/* HELPER METHODS START HERE */
			
			function getLanguage($columnName) {
				
			}
			
		}

		SpecialPage::addPage(new SpecialImportTSV);
	}

