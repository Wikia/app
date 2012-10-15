<?php

/**
 * Frequent Pattern Tag Cloud Plug-in
 * TagCloud
 * 
 * @author Tobias Beck, University of Heidelberg
 * @author Andreas Fay, University of Heidelberg
 * @version 1.0
 */

include_once("exceptions/InvalidAttributeException.php");
include_once("Tag.php");

class TagCloud {
	/**
	 * Attribute name for tag cloud
	 *
	 * @var string 
	 */
	private $_attribute;
	
	/**
	 * Attribute-Id
	 *
	 * @var int 
	 *
	 */
	private $_attributeId;
	
	/**
	 * Constructor
	 *
	 * @param string $attribute Attribute name for constructing tag cloud
	 * @return TagCloud
	 * @throws InvalidAttributeException If attribute is not valid, i.e. present in database
	 */
	public function __construct($attribute) {
		// Check if attribute is correct
		if (!$this->checkAttribute($attribute)) {
			throw new InvalidAttributeException($attribute);
		}
		
		$this->_attribute = $attribute;
	}
	
	
	/**
	 * Checks whether attribute is correct, i.e. it exists in database; if yes it fetches the id of the attribute
	 *
	 * @param string $attribute Attribute
	 * @return bool 
	 */
	private function checkAttribute($attribute) {
		// Category
		if (wfMsg("fptc-categoryname") == $attribute) {
			return true;
		}
		
		$dbr =& wfGetDB( DB_SLAVE );
		
		$res = $dbr->query("SELECT smw_id
					FROM ".$dbr->tableName("smw_ids")."
					WHERE smw_namespace = 102
					AND LENGTH(smw_iw) = 0
					AND smw_title = '".mysql_real_escape_string($attribute)."'");
		
		if ($res->numRows() == 0) {
			// Attribute not found
			return false;
		}
		
		$row = $res->fetchRow();
		
		// Assign id
		$this->_attributeId = $row[0];
		
		$res->free();
		
		return true;
	}
	
	/**
	 * Gets tags
	 *
	 * @return array Array of Tag
	 */
	public function getTags() {
		// Get all tags (i.e. possible values for the attribute) and count them
		$dbr =& wfGetDB( DB_SLAVE );
		
		// Get overall number of attribute values
		if (!$this->_attributeId) {
			$res = $dbr->query("SELECT SUM(cat_pages)
						FROM ".$dbr->tableName("category"));
		} else {
			$res = $dbr->query("SELECT COUNT(1)
						FROM ".$dbr->tableName("smw_rels2")."
						WHERE p_id = ".mysql_real_escape_string($this->_attributeId));
		}
		
		$row = $res->fetchRow();
		$numValues = $row[0];
		$res->free();
		
		if ($numValues == 0) {
			// Abort because no tags available
			return array();
		}
		
		// Get tags
		if (!$this->_attributeId) {
			$res = $dbr->query("SELECT smw_id, smw_title, (SELECT cat_pages FROM ".$dbr->tableName("category")." WHERE cat_title = smw_title)/$numValues AS rate
						FROM ".$dbr->tableName("smw_ids")."
						WHERE smw_namespace = 14
						AND LENGTH(smw_iw) = 0
						ORDER BY smw_title");
		} else {
			$res = $dbr->query("SELECT smw_id, smw_title, (SELECT COUNT(1) FROM ".$dbr->tableName("smw_rels2")." WHERE o_id = smw_id AND p_id = ".mysql_real_escape_string($this->_attributeId).")/$numValues AS rate
						FROM ".$dbr->tableName("smw_ids")."
						WHERE smw_namespace = 0
						AND LENGTH(smw_iw) = 0
						AND smw_id <> ".mysql_real_escape_string($this->_attributeId)."
						ORDER BY smw_title");
		}
		
		$tags = array();
		while ($row = $res->fetchRow()) {
			if (floatval($row['rate']) > 0) {
				// Only consider relevant tags (because query also fetches tags that do not belong to desired attribute
				$tags[] = new Tag(intval($row['smw_id']), $row['smw_title'], floatval($row['rate']));
			}
		}
		$res->free();
		
		return $tags;
	}
}