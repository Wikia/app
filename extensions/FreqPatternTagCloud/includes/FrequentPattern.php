<?php

/**
 * Frequent Pattern Tag Cloud Plug-in
 * Frequent pattern functions
 * 
 * @author Tobias Beck, University of Heidelberg
 * @author Andreas Fay, University of Heidelberg
 * @version 1.0
 */

include_once("computation/FrequentPatternApriori.php");
include_once("exceptions/SQLException.php");

abstract class FrequentPattern {
	/**
	 * Minimum confidence
	 * 
	 * @var float
	 */
	public static $min_confidence = 0.1;
	
	/**
	 * Minimum support
	 * 
	 * @var float
	 */
	public static $min_support = 0.05;
	
	
	/**
	 * Computes all rules
	 *
	 * @return void 
	 * @throws SQLException  
	 */
	public static function computeAllRules() {
		$dbr =& wfGetDB( DB_SLAVE );
		
		$res = $dbr->query("(SELECT smw_id
					FROM ".$dbr->tableName("smw_ids")."
					WHERE smw_namespace = 102
					AND LENGTH(smw_iw) = 0) UNION (SELECT 0)");
		while ($row = $res->fetchRow()) {
			self::computeRules($row['smw_id']);
		}
		
		$res->free();
	}
	
	/**
	 * Computes rules for attribute of id <code>$attributeId</code>
	 *
	 * @param int $attributeId Attribute
	 * @return void 
	 * @throws SQLException  
	 */
	public static function computeRules($attributeId) {
		global $wgFreqPatternTagCloudMinSupport, $wgFreqPatternTagCloudMinConfidence;
		
		// Configuration
		if (isset($wgFreqPatternTagCloudMinSupport)) {
			FrequentPattern::$min_support = $wgFreqPatternTagCloudMinSupport;
		}
		if (isset($wgFreqPatternTagCloudMinConfidence)) {
			FrequentPattern::$min_confidence = $wgFreqPatternTagCloudMinConfidence;
		}
		
		$dbr =& wfGetDB( DB_SLAVE );
		$dbw =& wfGetDB( DB_MASTER );
		
		// Compile items = all possible o_ids
		if (!$attributeId) {
			$res = $dbr->query("SELECT GROUP_CONCAT(smw_id)
						FROM ".$dbr->tableName("smw_ids")."
						WHERE smw_namespace = 14
						AND LENGTH(smw_iw) = 0
						GROUP BY smw_namespace");
		} else {
			$res = $dbr->query("SELECT GROUP_CONCAT(DISTINCT o_id)
						FROM ".$dbr->tableName("smw_rels2")."
						WHERE p_id = ".mysql_real_escape_string($attributeId)."
						GROUP BY p_id");
		}
		$row = $res->fetchRow();
		$items = explode(",", $row[0]);
		$res->free();
		
		// Compile transactions = all corelated o_ids (by s_id)
		if (!$attributeId) {
			$res = $dbr->query("SELECT GROUP_CONCAT(smw_id)
						FROM ".$dbr->tableName("smw_ids")." ids, ".$dbr->tableName("categorylinks")." catlinks
						WHERE ids.smw_title = catlinks.cl_to
						AND ids.smw_namespace = 14
						GROUP BY catlinks.cl_from");
		} else {
			$res = $dbr->query("SELECT GROUP_CONCAT(o_id)
						FROM ".$dbr->tableName("smw_rels2")."
						WHERE p_id = ".mysql_real_escape_string($attributeId)."
						GROUP BY s_id");
		}
		$transactions = array();
		while ($row = $res->fetchRow()) {
			$transactions[] = explode(",", $row[0]);
		}
		$res->free();
		
		// Run algorithm
		$algorithm = new FrequentPatternApriori();
		$rules = $algorithm->computeRules($items, $transactions, self::$min_support, self::$min_confidence);
		foreach ($rules as $rule) {
			// Push rules to db
			$dbw->query("INSERT INTO ".$dbw->tableName("fptc_associationrules")." (p_id, rule_support, rule_confidence)
						VALUES (".mysql_real_escape_string($attributeId).", ".mysql_real_escape_string($rule->getSupport()).", ".mysql_real_escape_string($rule->getConfidence()).")");
			$ruleId = $dbw->insertId();
			
			foreach ($rule->getAssumption() as $item) {
				$dbw->query("INSERT INTO ".$dbw->tableName("fptc_items")." (o_id, rule_id, item_order)
							VALUES (".mysql_real_escape_string($item).", ".mysql_real_escape_string($ruleId).", 0)");
			}
			
			foreach ($rule->getConclusion() as $item) {
				$dbw->query("INSERT INTO ".$dbw->tableName("fptc_items")." (o_id, rule_id, item_order)
							VALUES (".mysql_real_escape_string($item).", ".mysql_real_escape_string($ruleId).", 1)");
			}
		}
		
		$dbw->commit();
	}
	
	/**
	 * Deletes all rules
	 *
	 * @return void
	 * @throws SQLException  
	 */
	public static function deleteAllRules() {
		$dbw =& wfGetDB( DB_MASTER );
		
		$dbw->query("DELETE FROM ".$dbw->tableName("fptc_associationrules"));
		$dbw->query("DELETE FROM ".$dbw->tableName("fptc_items"));
	}
	
	/**
	 * Gets conclusions of rules for attribute <code>$attribute</code> and assumption <code>$assumption</code>
	 * 
	 * @param string $attribute
	 * @param string $assumption
	 * @return array Array of strings
	 * @throws SQLException 
	 */
	public static function getConclusions($attribute, $assumption) {
		$dbr =& wfGetDB( DB_SLAVE );
		
		// Get id of attribute
		if (wfMsg("fptc-categoryname") == $attribute) {
			$res = $dbr->query("SELECT 0");
		} else {
			$res = $dbr->query("SELECT smw_id
						FROM ".$dbr->tableName("smw_ids")."
						WHERE smw_title = '".mysql_real_escape_string($attribute)."'
						AND smw_namespace = 102
						AND LENGTH(smw_iw) = 0");
		}
		$row = $res->fetchRow();
		$attributeId = $row[0];
		$res->free();
		
		// Get id of assumption
		if (wfMsg("fptc-categoryname") == $attribute) {
			$res = $dbr->query("SELECT smw_id
						FROM ".$dbr->tableName("smw_ids")."
						WHERE smw_title = '".mysql_real_escape_string($assumption)."'
						AND smw_namespace = 14
						AND LENGTH(smw_iw) = 0");
		} else {
			$res = $dbr->query("SELECT smw_id
						FROM ".$dbr->tableName("smw_ids")."
						WHERE smw_title = '".mysql_real_escape_string($assumption)."'
						AND smw_namespace = 0
						AND LENGTH(smw_iw) = 0");
		}	
		$row = $res->fetchRow();
		$assumptionId = $row[0];
		$res->free();
		
		// Get rules (only those where assumption is single item)
		$res = $dbr->query("SELECT rules.rule_id, rule_support, rule_confidence
					FROM ".$dbr->tableName("fptc_associationrules")." rules, ".$dbr->tableName("fptc_items")." items
					WHERE rules.rule_id = items.rule_id
					AND item_order = 0
					AND o_id = ".mysql_real_escape_string($assumptionId)."
					AND NOT EXISTS( SELECT 1 FROM ".$dbr->tableName("fptc_items")." WHERE rule_id = rules.rule_id AND item_order = 0 AND o_id != items.o_id )
					ORDER BY rule_support DESC, rule_confidence DESC");
		$conclusions = array();
		while ($row = $res->fetchRow()) {
			// Get conclusions
			$resItems = $dbr->query("SELECT smw_title
						FROM ".$dbr->tableName("smw_ids")." ids, ".$dbr->tableName("fptc_items")." items
						WHERE ids.smw_id = items.o_id
						AND item_order = 1
						AND rule_id = ".mysql_real_escape_string($row['rule_id']));
			
			// Only consider rules with single conclusion
			if ($resItems->numRows() > 1) {
				continue;
			}
			$rowItem = $resItems->fetchRow();
			$conclusions[] = $rowItem['smw_title'];
			
			$resItems->free();
		}
		$res->free();
		
		return $conclusions;
	}
	
	/**
	 * Shows all rules (for debugging purposes)
	 *
	 * @return void 
	 * @throws SQLException 
	 */
	public static function showAllRules() {
		global $wgOut;
		
		$dbr =& wfGetDB( DB_SLAVE );
		
		// Get rules
		$res = $dbr->query("SELECT smw_title, rule_id, rule_support, rule_confidence
					FROM ".$dbr->tableName("smw_ids")." ids, ".$dbr->tableName("fptc_associationrules")." rules
					WHERE ids.smw_id = rules.p_id");
		while ($row = $res->fetchRow()) {
			// Get items
			$resItems = $dbr->query("SELECT smw_title, item_order
						FROM ".$dbr->tableName("smw_ids")." ids, ".$dbr->tableName("fptc_items")." items
						WHERE ids.smw_id = items.o_id
						AND rule_id = ".mysql_real_escape_string($row['rule_id']));
			$assumption = array();
			$conclusion = array();
			while ($rowItem = $resItems->fetchRow()) {
				if ($rowItem['item_order'] == '0') {
					$assumption[] = $rowItem['smw_title'];
				} else {
					$conclusion[] = $rowItem['smw_title'];
				}
			}
			
			// Display rule
			$wgOut->addWikiText(sprintf("%s: '%s' =&gt; '%s' (Sup: %0.2f, Conf: %0.2f)\n", $row['smw_title'], implode(",", $assumption), implode(",", $conclusion), $row['rule_support'], $row['rule_confidence']));
		}
		$res->free();
	}
}