<?php
	if (!defined('MEDIAWIKI')) die();

	require_once("WikiDataAPI.php"); // for bootstrapCollection
	require_once("Utilities.php"); 
	
	$wgGroupPermissions['bureaucrat']['exporttsv'] = true;
	$wgAvailableRights[] = 'exporttsv';
	$wgExtensionFunctions[] = 'wfSpecialExportTSV';

	function wfSpecialExportTSV() {
	        global $wgMessageCache;
                $wgMessageCache->addMessages(array('exporttsv'=>'Wikidata: Export TSV'),'en');
                        
		class SpecialExportTSV extends SpecialPage {
			
			function SpecialExportTSV() {
				SpecialPage::SpecialPage('ExportTSV');
			}

			function execute($par) {

				global $wgOut, $wgUser, $wgRequest;

				if (!$wgUser->isAllowed('exporttsv')) {
					$wgOut->addHTML('You do not have permission to do a tsv export.');
					return false;
				}
				
				$dbr =& wfGetDB(DB_SLAVE);
				$dc = wdGetDataSetcontext();
				
				if ($wgRequest->getText('collection') && $wgRequest->getText('languages')) {
					// render the tsv file
					
					require_once('WikiDataAPI.php');
					require_once('Transaction.php');
					// get the collection to export. Cut off the 'cid' part that we added
					// to make the keys strings rather than numbers in the array sent to the form.
					$collectionId = substr($wgRequest->getText('collection'), 3);
					// get the languages requested, turn into an array, trim for spaces.
					$isoCodes = explode(',', $wgRequest->getText('languages'));
					for($i = 0; $i < count($isoCodes); $i++) {
						$isoCodes[$i] = trim($isoCodes[$i]);
						if (!getLanguageIdForIso639_3($isoCodes[$i])) {
							$wgOut->setPageTitle('Export failed');
							$wgOut->addHTML("<p>Unknown or incorrect language: ".$isoCodes[$i].".<br />");
							$wgOut->addHTML("Languages must be ISO-639_3 language codes.</p>");
							return false;
						}
					}
					
					$wgOut->disable();
					
					$languages = $this->getLanguages($isoCodes);
					$isoLookup = $this->createIsoLookup($languages);
					$downloadFileName = $this->createFileName($isoCodes);
					
					// Force the browser into a download
					header('Content-Type: text/tab-separated-values;charset=utf-8');
					header('Content-Disposition: attachment; filename="'.$downloadFileName.'"'); // attachment
					
					// separator character used.
					$sc = "\t";
					
					echo(pack('CCC',0xef,0xbb,0xbf));
					// start the first row: column names
					echo('defined meaning id'.$sc.'defining expression');
					foreach ($isoCodes as $isoCode) {
						echo($sc.'definition_'.$isoCode.$sc.'translations_'.$isoCode);
					}
					echo("\r\n");
					
					// get all the defined meanings in the collection
					$query = "SELECT dm.defined_meaning_id, exp.spelling ";
					$query .= "FROM {$dc}_collection_contents col, {$dc}_defined_meaning dm, {$dc}_expression exp ";
					$query .= "WHERE col.collection_id=" . $collectionId . " ";
					$query .= "AND col.member_mid=dm.defined_meaning_id ";
					$query .= "AND dm.expression_id = exp.expression_id ";
					$query .= "AND ". getLatestTransactionRestriction("col");
					$query .= "AND ". getLatestTransactionRestriction("dm");
					$query .= "AND ". getLatestTransactionRestriction("exp");
					$query .= "ORDER BY exp.spelling";
					
					//wfDebug($query."\n");					
					
					$queryResult = $dbr->query($query);
					while ($row = $dbr->fetchRow($queryResult)) {
						$dm_id = $row['defined_meaning_id'];
						// echo the defined meaning id and the defining expression
						echo($dm_id);
						echo("\t".$row['spelling']);
						
						// First we'll fill an associative array with the definitions and
						// translations. Then we'll use the isoCodes array to put them in the
						// proper order.
						
						// the associative array holding the definitions and translations
						$data = array();
						
						// ****************************
						// query to get the definitions
						// ****************************
						$qry = 'SELECT txt.text_text, trans.language_id ';
						$qry .= "FROM {$dc}_text txt, {$dc}_translated_content trans, {$dc}_defined_meaning dm ";
						$qry .= 'WHERE txt.text_id = trans.text_id ';
						$qry .= 'AND trans.translated_content_id = dm.meaning_text_tcid ';
						$qry .= "AND dm.defined_meaning_id = $dm_id ";
						$qry .= 'AND trans.language_id IN (';
						for($i = 0; $i < count($languages); $i++) {
							$language = $languages[$i];
							if ($i > 0)
								$qry .= ",";
							$qry .= $language['language_id'];
						}
						$qry .= ') AND ' . getLatestTransactionRestriction('trans');
						$qry .= 'AND ' . getLatestTransactionRestriction('dm');
						
						//wfDebug($qry."\n"); // uncomment this if you accept having 1700+ queries in the log
												
						$definitions = $dbr->query($qry);
						while($row = $dbr->fetchRow($definitions)) {
							// $key becomes something like def_eng
							$key = 'def_'.$isoLookup['id'.$row['language_id']];
							$data[$key] = $row['text_text'];
						}
						$dbr->freeResult($definitions);
						
						// *****************************
						// query to get the translations
						// *****************************
						$qry = "SELECT exp.spelling, exp.language_id ";
						$qry .= "FROM {$dc}_expression exp ";
						$qry .= "INNER JOIN {$dc}_syntrans trans ON exp.expression_id=trans.expression_id ";
						$qry .= "WHERE trans.defined_meaning_id=$dm_id ";
						$qry .= "AND " . getLatestTransactionRestriction("exp");
						$qry .= "AND " . getLatestTransactionRestriction("trans");
						
						//wfDebug($qry."\n"); // uncomment this if you accept having 1700+ queries in the log
						
						$translations = $dbr->query($qry);
						while($row = $dbr->fetchRow($translations)) {
							// qry gets all languages, we filter them here. Saves an order 
							// of magnitude execution time.
							if (isset($isoLookup['id'.$row['language_id']])) {
								// $key becomes something like trans_eng
								$key = 'trans_'.$isoLookup['id'.$row['language_id']];
								if (!isset($data[$key]))
									$data[$key] = $row['spelling'];
								else
									$data[$key] = $data[$key].'|'.$row['spelling'];
							}
						}
						$dbr->freeResult($translations);
						
												
						
						// now that we have everything, output the row.
						foreach($isoCodes as $isoCode) {
							// if statements save a bunch of notices in the log about
							// undefined indices.	
							echo("\t");
							if (isset($data['def_'.$isoCode]))
								echo($this->escapeDelimitedValue($data['def_'.$isoCode]));
							echo("\t");
							if (isset($data['trans_'.$isoCode]))
								echo($data['trans_'.$isoCode]);
						}
						echo("\r\n");
					}
					
					
				}
				else {
					
					// Get the collections
					$colQuery = "SELECT col.collection_id, exp.spelling " .
								"FROM {$dc}_collection col INNER JOIN {$dc}_defined_meaning dm ON col.collection_mid=dm.defined_meaning_id " .
								"INNER JOIN {$dc}_expression exp ON dm.expression_id=exp.expression_id " .
								"WHERE " . getLatestTransactionRestriction('col');
					
					$collections = array();
					$colResults = $dbr->query($colQuery);
					while ($row = $dbr->fetchRow($colResults)) {
						$collections['cid'.$row['collection_id']] = $row['spelling'];
					}
										
					// render the page
					$wgOut->setPageTitle('Export a collection to tsv');
					$wgOut->addHTML('<p>Export a collection to a tab separated text format that you can import in Excell or other spreadsheet software.<br />');
					$wgOut->addHTML('Select a collection to export. In the languages text box, enter a comma separated list of ');
					$wgOut->addHTML('ISO 639-3 languages codes. Start with the languages that you will be translating from (pick as many as you like) and ');
					$wgOut->addHTML('finish with the ones you\'ll be translating to. Then click \'Create\' to create the file. </p>');
					
					$wgOut->addHTML(getOptionPanel(
						array(
							'Collection' => getSelect('collection', $collections, 'cid376322'),
							'Languages' => getTextBox('languages', 'ita, eng, deu, fra, cat'),
						),
						'',array('create' => 'Create')
					));
				}

			}
			
			
			/* HELPER METHODS START HERE */
			
			function escapeDelimitedValue($value) {
				$newValue = str_replace('"', '""', $value);
				// Unfortunately, excell doesn't handle line brakes correctly, even if they are in quotes.
				// we'll just remove them.
				$newValue = str_replace("\r\n", ' ', $value);
				$newValue = str_replace("\n", ' ', $value);
				// quoting the string is always allowed, so lets check for all possible separator characters
				if ($value != $newValue || strpos($value, ',') || strpos($value, ';') || strpos($value, '\t')) {
					$newValue = '"'.$newValue.'"';
				}
				return $newValue;
			}
			
			/**
			 * Get id and iso639_3 language names for the given comma-separated
			 * list of iso639_3 language names.
			 */
			function getLanguages($isoCodes) {
				// create query to look up the language codes.
				$langQuery = "SELECT language_id, iso639_3 FROM language WHERE ";
				foreach($isoCodes as $isoCode) {
					$isoCode = trim($isoCode);
					// if query does not end in WHERE , prepend OR.
					if (strpos($langQuery, "WHERE ")+6 < strlen($langQuery)) {
						$langQuery .= " OR ";
					}
					$langQuery .= "iso639_3='$isoCode'";
				}
				// Order by id so we can order the definitions and translations the same way.
				$langQuery .= " ORDER BY language_id";
				
				//wfDebug($langQuery."\n");
				
				$languages = array();
				$dbr =& wfGetDB(DB_SLAVE);
				$langResults = $dbr->query($langQuery);
				while($row = $dbr->fetchRow($langResults)) {
					$languages[] = $row;
				}
				
				return $languages;
			}
			
			function createIsoLookup($languages) {
				$lookup = array();
				foreach($languages as $language) {
					$lookup['id'.$language['language_id']] = $language['iso639_3'];
				}
				return $lookup;
			}
			
			/**
			 * Create the file name based on the languages requested. 
			 * Change file name prefix and suffix here.
			 */
			function createFileName($isoCodes) {
				$fileName = "destit_";
				for($i = 0; $i < count($isoCodes); $i++) {
					$isoCode = $isoCodes[$i];
					if ($i > 0) 
						$fileName .= '-';
					$fileName .= $isoCode;
				}
				$fileName .= ".txt";
				return $fileName;
			}
		}

		SpecialPage::addPage(new SpecialExportTSV);
	}

