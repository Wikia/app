<?php

/*
 * Created on 8 nov 2007
 *
 * API for WikiData
 *
 * Copyright (C) 2007 Edia <info@edia.nl>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */
 
if (!defined('MEDIAWIKI')) {
	// Eclipse helper - will be ignored in production
	require_once ('ApiBase.php');
}

class ApiWikiData extends ApiBase {
	
	private $printer;
	private $rintseIsRight = false;

	public function __construct($main, $action) {
		parent :: __construct($main, $action, 'wd');
	}

	public function execute() {
		$type = null;
		$expression = null;
		$dmid = null;
		$dataset = null;
		$languages = null;
		$explanguage = null;
		$deflanguage = null;
		$resplanguage = null;
		$sections = null;
		$format = null;
		$collection = null;
		$collection_id = null;
		$relation = null;
		$relleft = null;
		$relright = null;
		$translanguage = null;
		$deflanguage = null;
		
		// read the request parameters
		extract($this->extractRequestParams());
		
		$datasets = wdGetDataSets();
		if (!isset($datasets[$dataset])) {
			$this->dieUsage("Unknown data set: $dataset", 'unknown_dataset');
		}
		
		// **********************************
		// create and configure the formatter
		// **********************************
		$printer = $this->getCustomPrinter();
		
		$printer->setFormat($format);
		
		// Figure out what to output
		if ($sections != null) { // default is to show everything
			$printer->excludeAll();
			foreach ($sections as $section) {
				if ($section == 'syntrans') {
					$printer->setIncludeSynTrans(true);
				}
				else if ($section == 'syntransann') {
					$printer->setIncludeSynTransAnnotations(true);
				}
				else if ($section == 'def') {
					$printer->setIncludeDefinitions(true);
				}
				else if ($section == 'altdef') {
					$printer->setIncludeAltDefinitions(true);
				}
				else if ($section == 'ann') {
					$printer->setIncludeAnnotations(true);
				}
				else if ($section == 'classatt') {
					$printer->setIncludeClassAttributes(true);
				}
				else if ($section == 'classmem') {
					$printer->setIncludeClassMembership(true);
				}
				else if ($section == 'colmem') {
					$printer->setIncludeCollectionMembership(true);
				}
				else if ($section == 'rel') {
					$printer->setIncludeRelations(true);
				}
				else {
					$printer->addErrorMessage("Unknown section: $section");
				}
				
			}
		}
		
		// Figure out which languages to output
		if ($languages != null) {
			//echo $languages;
			$langCodes = explode('|', $languages);
			foreach ($langCodes as $langCode) {
				$langId = getLanguageIdForIso639_3($langCode);
				if ($langId != null) {
					$printer->addOutputLanguageId($langId);
				}
				else {
					$printer->addErrorMessage($langCode.' is not an ISO 639-3 language code.');
				}
			}
		}
		
		// The response language
		global $wgRecordSetLanguage;
		$wgRecordSetLanguage = getLanguageIdForIso639_3($resplanguage);
		
		// *************************
		// Handle the actual request
		// *************************
		if ($type == 'definedmeaning') {
			$dmModel = new DefinedMeaningModel($dmid, null, $datasets[$dataset]);
			$dmModel->loadRecord();
			$record = $dmModel->getRecord();
			$printer->addDefinedMeaningRecord($record);
		}
		// *******************
		// QUERY BY EXPRESSION
		// *******************
		else if ($type == 'expression') {
			$dmIds = array();
			if ($explanguage == null) {
				$dmIds = getExpressionMeaningIds($expression, $dataset);
			}
			else {
				$srcLanguages = array();
				$srcLanguages[] = getLanguageIdForIso639_3($explanguage);
				$dmIds = getExpressionMeaningIdsForLanguages($expression, $srcLanguages, $dataset);
			}
			
			$uniqueDmIds = array();
			foreach ($dmIds as $dmId) {
				// Should we return duplicates? If Rintse is right, we should.
				if (!$this->rintseIsRight && in_array($dmId, $uniqueDmIds)) {
					continue;
				}
				$uniqueDmIds[] = $dmId;
				
				$dmModel = new DefinedMeaningModel($dmId, null, $datasets[$dataset]);
				$dmModel->loadRecord();
				$record = $dmModel->getRecord();
				$printer->addDefinedMeaningRecord($record);
			}
			
		}
		// **********************
		// RANDOM DEFINED MEANING
		// **********************
		// Why is this a section marked with a comment, rather than a proper function?
		else if ($type == 'randomdm' or $type=='dump') {
		 
			
			// I want all the allowed parameters for this type of query to work in combination. 
			// So a client can, for example, get a random defined meaning from the destiazione 
			// italia collection that has a definition and translation in spanish and that has 
			// a 'part of theme' relationship with some other defined meaning.  
			// We'll build one monster query for all these parameters. I've seen this take up
			// to one second on a development machine.
			
			$query =  "SELECT dm.defined_meaning_id " .
			          "FROM {$dataset}_defined_meaning dm ";
			
			// JOINS GO HERE 
			// dm must have a translation in given language
			if ($translanguage != null) {
				$query .= "INNER JOIN {$dataset}_syntrans st ON dm.defined_meaning_id=st.defined_meaning_id " .
			              "INNER JOIN {$dataset}_expression exp ON st.expression_id=exp.expression_id ";
			}
			
			// dm must have a definition in given language
			if ($deflanguage != null) {
				$query .= "INNER JOIN {$dataset}_translated_content tc ON dm.meaning_text_tcid=tc.translated_content_id ";
			}
			
			// dm must be part of given collection
			if ($collection != null) {
				$query .= "INNER JOIN {$dataset}_collection_contents col on dm.defined_meaning_id=col.member_mid ";
			}
					
			// dm must be related to another dm
			if ($relation != null && ($relleft != null || $relright != null)) {
				if ($relright != null) {
					$query .= "INNER JOIN {$dataset}_meaning_relations rel ON dm.defined_meaning_id=rel.meaning1_mid ";
				}
				else {
					$query .= "INNER JOIN {$dataset}_meaning_relations rel ON dm.defined_meaning_id=rel.meaning2_mid ";
				}
			}
			
			// WHERE CLAUSE GOES HERE
			$query .= "WHERE dm.remove_transaction_id is null ";
			
			// dm must have a translation in given language
			if ($translanguage != null) {
				$query .= "AND st.remove_transaction_id is null " .
			              "AND exp.remove_transaction_id is null " .
			              "AND exp.language_id=".getLanguageIdForIso639_3($translanguage)." ";
			}
			
			// dm must have a definition in given language
			if ($deflanguage != null) {
				$query .= "AND tc.remove_transaction_id is null " .
			              "AND tc.language_id=".getLanguageIdForIso639_3($deflanguage)." ";
			}
			
			// dm must be part of given collection
			if ($collection != null) {
				$query .= "AND col.remove_transaction_id is null " .
			              "AND col.collection_id=$collection ";
			}
			
			// dm must be related to another dm
			if ($relation != null && ($relleft != null || $relright != null)) {
				$query .= "AND rel.remove_transaction_id is null " .
			              "AND rel.relationtype_mid=$relation ";
				if ($relright != null) {
					$query .= "AND rel.meaning2_mid=$relright ";
				}
				else {
					$query .= "AND rel.meaning1_mid=$relleft ";
				}  
			}
			
			// We may get doubles for multiple expressions or relations. Pretty trivial, but affects probability
			$query .= "GROUP BY dm.defined_meaning_id ";
			// pick one at random
			if ($type=="randomdm"){
				$query .= "ORDER BY RAND() ";
			} 

			#var_dump($dump_start, $dump_items);
			$query .= "LIMIT $dump_start, $dump_items";
			#echo $query;
			
			$dbr =& wfGetDB(DB_SLAVE);
			$result = $dbr->query($query);
			for ($i=0; $i< $dbr->numRows($result); $i++) {
				$row = $dbr->fetchRow($result);
				$dmModel = new DefinedMeaningModel($row[0], null, $datasets[$dataset]);
				$dmModel->loadRecord();
				$record = $dmModel->getRecord();
				$printer->addDefinedMeaningRecord($record);	
			}
			
		}
		else if ($type == 'relation') {
			if ($relation != null || $relleft != null || $relright != null) {
				$related = 	getRelationDefinedMeanings($relation, $relleft, $relright, $datasets[$dataset]);
				if (count($related) > 0) {
					foreach ($related as $dmId) {
						$dmModel = new DefinedMeaningModel($dmId, null, $datasets[$dataset]);
						$dmModel->loadRecord();
						$record = $dmModel->getRecord();
						$printer->addDefinedMeaningRecord($record);
					}
				}
				else {
					$printer->addErrorMessage("Your relations query did not return any results.");
				}
			}
			else {
				$printer->addErrorMessage('To get relations you must at least specify a left or right hand side dmid and optionally a relation type dmid.');
			}
			
		} elseif ($type == 'collection') {
			try {
				$printer->suppress_output();
				print $this->collection($collection_id, $languages);
				#throw new Exception("bla");
			} catch (Exception $exception) {
				$printer->addErrorMessage($exception->getTraceAsString());
			}
		} elseif($type == 'translation') {
			try { # effin error handler suxx0rs. This way at least I see what I'm doing wrong
				$printer->suppress_output();	# this is prolly not the best solution ^^;;
				print $this->translation($dmid, $languages);
			} catch (Exception $exception) {
				$printer->addErrorMessage($exception->getTraceAsString());
			}
		} elseif($type == 'listCollections') {
			try { # effin error handler suxx0rs. This way at least I see what I'm doing wrong
				$printer->suppress_output();	# this is prolly not the best solution ^^;;
				print $this->listCollections();
			} catch (Exception $exception) {
				$printer->addErrorMessage($exception->getTraceAsString());
			}

		}
		
	}
	
	public function & getCustomPrinter() {
		if (is_null($this->printer)) {
			$this->printer = new ApiWikiDataFormatXml($this->getMain());
		}
		return $this->printer;
	}
	
	protected function getAllowedParams() {
		return array (
			'type' => array (
				ApiBase :: PARAM_DFLT => 'expression',
				ApiBase :: PARAM_TYPE => array (
					'expression',
					'definedmeaning',
					'randomdm',
					'relation',
					'dump',
					'collection',
					'translation',
					'listCollections'
				)
			),
			'expression' => null,
			'explanguage' => null,
			'dmid' => null,
			'collection' => null,
			'collection_id' => null,
			'relation' => null,
			'relleft' => null,
			'relright' => null,
			'translanguage' => null,
			'deflanguage' => null,
			'dataset' => 'uw',
			'resplanguage' => 'eng',
			'languages' => null,
			'dump_start' => 0,
			'dump_items' => 1,
			'sections' => array (
				ApiBase :: PARAM_DFLT => null,
				ApiBase :: PARAM_ISMULTI => true,
				ApiBase :: PARAM_TYPE => array (
					'def',
					'altdef',
					'syntrans',
					'syntransann',
					'ann',
					'classatt',
					'classmem',
					'colmem',
					'rel'
				)
			),
			'format' => array (
				ApiBase :: PARAM_DFLT => 'plain',
				ApiBase :: PARAM_TYPE => array ('plain', 'tbx')
			)
		);
	}

	protected function getParamDescription() {
		return array (
			'type' => array (
				'Query type.',
				'expression:		query an expression.',
				'definedmeaning:	defined meaning by id',
				'randomdm:		a random defined meaning',
				'relation:		find relations or related defined meanings',
				'dump:			provide partial xml dumps (parameters are same as for random_dm)',
				'collection:		a listing of collection members (defined meaning id only)',
				'translation:		defined meaning by id, but only translated text and synonyms/translations (faster query)',
				'listCollections:	provide a list of collections: id, name (defined meaning dmid, defining expression spelling) , count (number of items in collection)'
			),
			'expression' => 'For type \'expression\': the expression.',
			'explanguage' => 'For type \'expression\': the expression language. Omit to search all languages.',
			'dmid' => 'For type \'definedmeaning\': the defined meaning id.',
			'collection' => 'For type \'randomdm\': the collection (by dmid) to pick a defined meaning from.',
			'relation' => 'For type \'randomdm\'or \'relation\': the relation (by relationtype dmid) to another defined meaning, given in wdrelleft or wdrelright.',
			'relleft' => 'When looking for a related defined meaning: the left hand side of the relation by dmid.',
			'relright' => 'When looking for a related defined meaning: the right hand side of the relation by dmid.',
			'translanguage' => 'For type \'randomdm\': a translation in this language must be present. ISO 639-3 language code.',
			'deflanguage' => 'For type \'randomdm\': a definition in this language must be present. ISO 639-3 language code.',
			'dataset' => 'The dataset to query.',
			'resplanguage' => 'Response language: language strings in the response document are set in this language. ISO 639-3 language code.',
			'languages' => array (
				'Output languages.',
				'Values (separate with \'|\'): any ISO 639-3 language code'
			),
			'sections' => array(
				'Which sections to include in the output. If omitted, everything is returned. ',
				'def:          include definitions',
				'altdef:       include alternative definitions',
				'syntrans:     include synonyms and translations',
				'syntransann:  include annotations of synonyms and translations such as part of speech',
				'ann:          include annotations of defined meanings such as part of theme',
				'classatt:     include class attributes',
				'classmem:     include class membership',
				'colmem:       include collection membership',
				'rel:          include relations'
			),
			'format' => 'The output format.',
			'dump_start' => 'Starting defined meaning in the dump, counting from 0. A value of 5 is just the 6th item in the dump, (not dmid 5)',
			'dump_items' => 'How many defined meanings to dump. A value of 10 means to dump 10 items (not dump \'till dmid 10 or \'till item 10). If you start at the 5th item, you will end up dumping items 5 through 15'
		);
	}

	protected function getDescription() {
		return array (
			'This module provides an API to WikiData.'
		);
	}
	
	protected function getExamples() {
		return array(
			'api.php?action=wikidata&wdexpression=bier&wdexplanguage=nld&wdsections=def|syntrans&wdlanguages=deu|eng|fra',
			'api.php?action=wikidata&wdtype=definedmeaning&wddmid=6715&wdformat=tbx',
			'api.php?action=wikidata&wdtype=randomdm&wdtranslanguage=nld&wddeflanguage=nld&wdcollection=376322',
			'api.php?action=wikidata&wdtype=relation&wdrelation=3&wdrelleft=6715',
			'api.php?action=wikidata&wdtype=relation&wdrelleft=339',
			'api.php?action=wikidata&wdtype=randomdm&wdrelation=3&wdrelright=339',
			'api.php?action=wikidata&wdtype=randomdm&wdformat=tbx&wdresplanguage=nld'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: $';
	}

	public function collection($collection_id, $languages) {
		$id_safe=mysql_real_escape_string($collection_id);

		$language_list="";
		
		if (@is_string($languages)) {
			#clean it
			$unsafe_language_list=explode("|",$languages);

			$query="SELECT a1.member_mid FROM";
			$queryb=$query;
			$a=0;
			foreach ($unsafe_language_list as $language) {
				$a+=1;
				$s= mysql_real_escape_string($language);
				$s_language="AND language.iso639_3='$s'";
				$query=$queryb;
				$query.="(
					SELECT member_mid
					FROM uw_collection_contents, uw_syntrans, uw_expression, language 
					WHERE collection_id=$id_safe 
					AND uw_collection_contents.member_mid=uw_syntrans.defined_meaning_id
					AND uw_syntrans.expression_id=uw_expression.expression_id
					AND uw_expression.language_id=language.language_id
					".$s_language."
					GROUP BY member_mid".
					") a$a";
				if ($a>1) {
					$aless1=$a-1;
					$query.= " ON  a$a.member_mid=a$aless1.member_mid";
				}
				$queryb=$query;
				$queryb.=" INNER JOIN ";
			} 
		} else {
			$query="SELECT member_mid FROM uw_collection_contents WHERE collection_id=$id_safe";
		}

				$dbr =& wfGetDB(DB_SLAVE);

		$result = $dbr->query($query);
		$xml=new SimpleXMLElement("<collection></collection>");
		while ($row=mysql_fetch_assoc($result)) {
			$dm=$xml->addChild("defined-meaning");
			$dm->addAttribute("defined-meaning-id",$row["member_mid"]);
		}

		return $xml->asXML();
	}		

	# db structure: 
	# uw_defined_meaning.meaning_text_tcid -> uw_translated_content.translated_content_id
	# uw_translated_content.text_id -> uw_text.text_id
	# uw_translated_content.langauge_id -> languages.language_id

	/** return defined meaning xml, containing just translated_text and syntrans, 
	 	see also: any example full defined meaning xml output 
		Uses custom query to go fast (hopefully)*/
	public function translation($dmid,$languages) {
		$dmid_safe=mysql_real_escape_string($dmid);
		$language_list="";
		
		if (@is_string($languages)) {
			#clean it
			$unsafe_language_list=explode("|",$languages);
			$s_language=array();
			foreach ($unsafe_language_list as $language) {
				$s= mysql_real_escape_string($language);
				$s_language[]="language.iso639_3='$s'";
			}
			
			#then use it
			$language_list.= " AND (";
			$language_list.= implode(" OR ", $s_language);
			$language_list .=")";
		}

		$dbr=& wfGetDB(DB_SLAVE);

		$xml=new SimpleXMLElement("<wikidata></wikidata>");
		$body=$xml->addChild('body');
		$defined_meaning=$body->addChild("defined-meaning");
		$defined_meaning->addAttribute("defined-meaning-id","$dmid");
		

		# translated-text-list
		$query="SELECT iso639_3, text_text FROM uw_defined_meaning, uw_translated_content, uw_text, language
			WHERE	uw_defined_meaning.defined_meaning_id=\"$dmid\"
			AND	uw_defined_meaning.meaning_text_tcid = uw_translated_content.translated_content_id
			AND	uw_translated_content.text_id = uw_text.text_id
			AND	uw_translated_content.language_id = language.language_id
			".$language_list;
		try {
			$result=$dbr->query($query);
		} catch (Exception $e) {echo $e->getTraceAsString(); echo mysql_error();}
		$definition=$defined_meaning->addChild("definition");
		$translated_text_list=$definition->addChild("translated-text-list");
		while ($row=mysql_fetch_assoc($result)) {
			$translated_text=$translated_text_list->addChild("translated-text",$row["text_text"]);
			$translated_text->addAttribute("language",$row["iso639_3"]);
		}

		#synonyms-translations-list
		$query="SELECT syntrans_sid, identical_meaning, iso639_3, spelling FROM uw_syntrans, uw_expression, language
			WHERE	uw_syntrans.defined_meaning_id=\"$dmid\"
			AND	uw_syntrans.expression_id=uw_expression.expression_id
			AND	uw_expression.language_id = language.language_id
			".$language_list;
		try {
			$result=$dbr->query($query);
		} catch (Exception $e) {echo $e->getTraceAsString(); echo mysql_error();}
		$synonyms_translations_list=$defined_meaning->addChild("synonyms-translations-list");
		while($row=mysql_fetch_assoc($result)) {
			$synonyms_translations=$synonyms_translations_list->addChild("synonyms-translations");
			$synonyms_translations->addAttribute("syntrans-id",$row["syntrans_sid"]);
			$synonyms_translations->addAttribute("identical-meaning",$row["identical_meaning"]);
			$expression=$synonyms_translations->addChild("expression", $row["spelling"]);
			$expression->addAttribute("language",$row["iso639_3"]);
		}

		return $xml->asXML();
	}

	public function listCollections() {

		$xml=new SimpleXMLElement("<wikidata></wikidata>");
		$body=$xml->addChild('body');
	
		#query
		$query="SELECT uw_collection.collection_id, collection_mid, spelling, counts.total FROM  
				uw_collection, uw_defined_meaning, uw_expression,
				( 
				SELECT collection_id,count(*) AS total FROM uw_collection_contents 
				GROUP by collection_id
				) counts 
			WHERE uw_collection.collection_id=counts.collection_id 
			AND uw_collection.collection_mid=uw_defined_meaning.defined_meaning_id 
			AND uw_expression.expression_id=uw_defined_meaning.expression_id  
			ORDER BY spelling
			";

		$dbr=& wfGetDB(DB_SLAVE);
		try {
			$result=$dbr->query($query);
		} catch (Exception $e) {echo $e->getTraceAsString(); echo mysql_error();}
		
		$collections_list=$body->addchild("collections_list");
		while($row=mysql_fetch_assoc($result)) {
			$collection=$collections_list->addChild("collection");
			$collection->addAttribute("id",$row["collection_id"]);
			$name=$collection->addChild("name",$row["spelling"]);
			$name->addAttribute("dmid",$row["collection_mid"]);
			$collection->addChild("count",$row["total"]);

		}

		return $xml->asXML();
	}

}
?>
