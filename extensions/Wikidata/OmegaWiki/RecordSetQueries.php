<?php

require_once('Transaction.php');

class TableColumnsToAttribute {
	protected $tableColumns;
	protected $attribute;
	
	public function __construct(array $tableColumns, Attribute $attribute) {
		$this->tableColumns = $tableColumns;
		$this->attribute = $attribute;
	}
	
	public function getTableColumns() {
		return $this->tableColumns;
	}
	
	public function getAttribute() {
		return $this->attribute;
	}
}

class TableColumnsToAttributesMapping {
	protected $tableColumnsToAttributes;
	
	public function __construct($tableColumnsToAttributes) {
		if (is_array($tableColumnsToAttributes))
			$this->tableColumnsToAttributes = $tableColumnsToAttributes; 
		else
			$this->tableColumnsToAttributes = func_get_args();
	}
	
	public function getSelectColumns() {
		$result = array();
		
		foreach ($this->tableColumnsToAttributes as $tableColumnToAttribute) 
			foreach($tableColumnToAttribute->getTableColumns() as $tableColumn)
				$result[] = $tableColumn;
		
		return $result;
	}

	public function getAttributes() {
		$result = array();
		
		foreach ($this->tableColumnsToAttributes as $tableColumnToAttribute) 
			$result[] = $tableColumnToAttribute->getAttribute();
		
		return $result;
	}
	
	public function getCount() {
		return count($this->tableColumnsToAttributes);
	}
	
	public function getMapping($index) {
		return $this->tableColumnsToAttributes[$index];
	}
}

function getTransactedSQL(QueryTransactionInformation $transactionInformation, array $selectFields, Table $table, array $restrictions, array $orderBy = array(), $count = -1, $offset = 0) {
	$tableNames = array($table->getIdentifier());

	if ($table->isVersioned) {
		$restrictions[] = $transactionInformation->getRestriction($table);
		$tableNames = array_merge($tableNames, $transactionInformation->getTables());
		$orderBy = array_merge($orderBy, $transactionInformation->versioningOrderBy());
		$groupBy = $transactionInformation->versioningGroupBy($table);
		$selectFields = array_merge($selectFields, $transactionInformation->versioningFields($table->getIdentifier()));
	}
	else 
		$groupBy = array();
	
	$query = 
		"SELECT ". implode(", ", $selectFields) . 
		" FROM ". implode(", ", $tableNames);

	if (count($restrictions) > 0)
		$query .= " WHERE ". implode(' AND ', $restrictions);
	
	if (count($groupBy) > 0)
		$query .= " GROUP BY " . implode(', ', $groupBy);

	if (count($orderBy) > 0)
		$query .= " ORDER BY " . implode(', ', $orderBy);
		
	if ($count != -1) 
		$query .= " LIMIT " . $offset . ", " . $count;
		
	return $query;
}

function getRecordFromRow($row, $columnIndex, Structure $structure) {
	$result = new ArrayRecord($structure);
	
	foreach ($structure->getAttributes() as $attribute) {
		$result->setAttributeValue($attribute, $row[$columnIndex]);
		$columnIndex++;
	}
	
	return $result;
}

function queryRecordSet($recordSetStructureId, QueryTransactionInformation $transactionInformation, Attribute $keyAttribute, TableColumnsToAttributesMapping $tableColumnsToAttributeMapping, Table $table, array $restrictions, array $orderBy = array(), $count = -1, $offset = 0) {
	$dbr =& wfGetDB(DB_SLAVE);
	
	$selectFields =  $tableColumnsToAttributeMapping->getSelectColumns();
	$attributes = $tableColumnsToAttributeMapping->getAttributes();

	if ($table->isVersioned) 
		$allAttributes = array_merge($attributes, $transactionInformation->versioningAttributes());
	else 
		$allAttributes = $attributes;
	
	$query = getTransactedSQL($transactionInformation, $selectFields, $table, $restrictions, $orderBy, $count, $offset);
	$queryResult = $dbr->query($query);
	
	if (!is_null($recordSetStructureId)) 	
		$structure = new Structure($recordSetStructureId, $allAttributes);
	else 
		$structure = new Structure($allAttributes);

	$recordSet = new ArrayRecordSet($structure, new Structure($keyAttribute));

	while ($row = $dbr->fetchRow($queryResult)) {
		$record = new ArrayRecord($structure);
		$columnIndex = 0;

		for ($i = 0; $i < $tableColumnsToAttributeMapping->getCount(); $i++) {
			$mapping = $tableColumnsToAttributeMapping->getMapping($i);
			$attribute = $mapping->getAttribute();
			$tableColumns = $mapping->getTableColumns();
			
			if (count($tableColumns) == 1)
				$value = $row[$columnIndex];
			else 
				$value = getRecordFromRow($row, $columnIndex, $attribute->type);
			
			$record->setAttributeValue($attribute, $value);
			$columnIndex += count($tableColumns);
		}
			
		$transactionInformation->setVersioningAttributes($record, $row);	
		$recordSet->add($record);
	} 
		
	return $recordSet;
}

function getUniqueIdsInRecordSet(RecordSet $recordSet, array $idAttributes) {
	$ids = array();
	
	for ($i = 0; $i < $recordSet->getRecordCount(); $i++) {
		$record = $recordSet->getRecord($i);
		
		foreach($idAttributes as $idAttribute) 
			$ids[] = $record->getAttributeValue($idAttribute);
	}
	
	return array_unique($ids);
}


