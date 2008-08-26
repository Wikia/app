<?php
	if (!defined('MEDIAWIKI')) die();

	require_once("WikiDataAPI.php"); // for bootstrapCollection
	require_once("Utilities.php"); 
	
	$wgGroupPermissions['bureaucrat']['importtsv'] = true;
	$wgAvailableRights[] = 'importtsv';
	$wgExtensionFunctions[] = 'wfSpecialImportTSV';

	function wfSpecialImportTSV() {
	        global $wgMessageCache;
                $wgMessageCache->addMessages(array('importtsv'=>'Wikidata: Import TSV'),'en');
                        
		class SpecialImportTSV extends SpecialPage {
			
			function SpecialImportTSV() {
				SpecialPage::SpecialPage('ImportTSV');
			}

			function execute($par) {

				global $wgOut, $wgUser, $wgRequest;

				$wgOut->setPageTitle("Import TSV");
				if (!$wgUser->isAllowed('importtsv')) {
					$wgOut->addHTML('You do not have permission to do a tsv import.');
					return false;
				}
				
				$dbr =& wfGetDB(DB_MASTER);
				$dc = wdGetDataSetcontext();
				$wgOut->setPageTitle('Importing TSV data');
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
							$wgOut->setPageTitle('Import failed');
							$wgOut->addHTML("<p>This doesn't appear to be a UTF-8 encoded file. The file <i>must</i> be UTF-8 encoded. ");
							$wgOut->addHTML("Make sure your application has saved or exported the file correctly.</p>");
							return false;
						}
						$maxLineLength = max($maxLineLength, strlen($myLine)+2);
					}
					
					// start from the beginning again. Check if the column names are valid
					rewind($file);
					$columns = fgetcsv($file, $maxLineLength, "\t");
					// somehow testing for $columns[0] fails sometimes. Byte Order Mark?
					if (!$columns || count($columns) <= 2 || $columns[1] != "defining expression") {
						$wgOut->setPageTitle('Import failed');
						$wgOut->addHTML("<p>This does not appear to be a valid tsv file.</p>");
						return false;
					}
					for ($i = 2; $i < count($columns); $i++) {
						$columnName = $columns[$i];
						$baseName = substr($columnName, 0, strrpos($columnName, '_'));
						if ($baseName == "definition" || $baseName == "translations") {
							$langCode = substr($columnName, strrpos($columnName, '_')+1);
							if (!getLanguageIdForIso639_3($langCode)) {
								$wgOut->setPageTitle('Import failed');
								$wgOut->addHTML("<p>Unknown or incorrect language: $langCode. <br />");
								$wgOut->addHTML("Languages must be ISO-639_3 language codes.</p>");
								return false;
							}
						}
						else { // column name does not start with definition or translations. 
								$wgOut->setPageTitle('Import failed');
								$wgOut->addHTML("<p>Incorrect column name<br />");
								$wgOut->addHTML("Columns should be named 'definition_iso' ");
								$wgOut->addHTML("or 'translations_iso', where iso is the language code.</p>");
								return false;
						}
						
					}
					
				
					//
					// All tests passed. lets get started
					//
					
					if ($testRun) {
						$wgOut->setPageTitle('Test run for importing TSV data');
					}
					else {	
						$wgOut->setPageTitle('Importing TSV data');
					}
					
					startNewTransaction($wgUser->getID(), wfGetIP(), "Bulk import via SpecialImportTSV", $dc);
					
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
						$wgOut->addHTML("<br />Nothing added");
						if ($testRun) {
							$wgOut->addHTML(" (you did a test run)");
						}
						$wgOut->addHTML(".<br />");
					}
					else {
						$wgOut->addHTML("<br />Added $definitions definitions and $translations translations.<br />");
					}
						
				}
				else {
					// render the page
					$wgOut->setPageTitle('Import definitions and translations.');
					$wgOut->addHTML('<p>Import translations and definitions from a a tab delimited text file that you may have exported from OpenOffice.org, ' .
							'Excel or other spreadsheet software.</p> ' .
							'<p>The format of the file must be the same as the files exported on the ExportTSV page. If you\'ve changed the column names, ' .
							'the import will fail. If you\'ve changed the id or the defining expression of any defined meaning, that line will be ignored. ' .
							'If you\'ve added columns, they must be in the form \'definitions_iso\' or \'translations_iso\', where iso is an ISO-639_3 language code.</p>');
					$wgOut->addHTML('<p>If the \'test run\' box is checked, any actions that would be taken are reported, but no changes are actually made. You are encouraged' .
							'to do a test run before you do an actual import.</p>');
					
					$wgOut->addHTML(getOptionPanelForFileUpload(
						array(
							'TSV File' => getFileField('tsvfile'),
							'Test run' => getCheckBox('testrun', true)
						),
						'',array('upload' => 'Upload')
					));
				}

			}
			
			
			/* HELPER METHODS START HERE */
			
			function getLanguage($columnName) {
				
			}
			
		}

		SpecialPage::addPage(new SpecialImportTSV);
	}

