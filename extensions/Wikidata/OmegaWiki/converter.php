<?php

require_once('type.php');
require_once('Attribute.php');
require_once('Transaction.php');

require_once("Wikidata.php");
interface Converter {
	public function getStructure();
	public function convert($record);
}

class ProjectConverter implements Converter {
	protected $structure;
	
	public function __construct($structure) {
		$this->structure = $structure;
	} 
	
	public function getStructure() {
		return $this->structure;
	}
	
	public function convert($record) {
		$result = new ArrayRecord($this->structure);
		
		foreach($this->structure->getStructure() as $attribute)
			$result->setAttributeValue($attribute, $record->getAttributeValue($attribute));
			
		return $result;
	}
}

class DefaultConverter implements Converter {
	protected $attribute;
	protected $structure;
	
	public function __construct($attribute) {
		$this->attribute = $attribute;
		$this->structure = new Structure($attribute);
	}
	
	public function convert($record) {
		$result = new ArrayRecord($this->structure);
		$result->setAttributeValue($this->attribute, convertToHTML($record->getAttributeValue($this->attribute), $this->attribute->type));
		
		return $result;
	}
	
	public function getStructure() {
		return $this->structure;
	}
}

class ExpressionIdConverter extends DefaultConverter {
	protected $attributes = array();
	
	public function __construct($attribute) {

		$o=OmegaWikiAttributes::getInstance();
			
		parent::__construct($attribute);
		$this->structure = new Structure($o->expression);
	}
	
	public function getStructure() {
		return $this->structure;
	}
	
	public function convert($record) {
		$dc=wdGetDataSetContext();


		$o=OmegaWikiAttributes::getInstance();
		
		$dbr =& wfGetDB(DB_SLAVE);
		$expressionId = $record->getAttributeValue($this->attribute);
		$queryResult = $dbr->query("SELECT language_id, spelling from {$dc}_expression WHERE expression_id=$expressionId" .
									" AND ". getLatestTransactionRestriction("{$dc}_expression"));
		$expression = $dbr->fetchObject($queryResult); 

		$expressionRecord = new ArrayRecord(new Structure($o->language, $o->spelling));
		$expressionRecord->language = $expression->language_id;
		$expressionRecord->spelling = $expression->spelling;

		$result = new ArrayRecord($this->structure);
		$result->expression = $expressionRecord;
	
		return $result;
	}
}


