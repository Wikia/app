<?php

require_once('Attribute.php');
require_once('Record.php');
require_once('RecordSet.php');
require_once('Wikidata.php');

/** 
 * Transaction.php
 *
 * Manage internal transactions (NOT mysql transactions... confuzzeled yet?)
 *
 * To use: 
 * 
 * startNewTransaction($userId, $userIP, $comment, $dc) 
 * then do a getUpdateTransactionId() to find the id you need for
 * add_transaction_id.
 * 
 * Since this is not a mysql transaction, I don't THINK you need
 * to close it. If you do, it wasn't documented.
 *
 * There's also something to do with restrictions. This is the only
 * documentation you get so far. You're on your own now :-P
 * (Please document anything else that's really needed for anything)
 */


interface QueryTransactionInformation {
	public function getRestriction(Table $table);
	public function getTables();
	public function versioningAttributes();
	public function versioningFields($tableName);
	public function versioningOrderBy();
	public function versioningGroupBy(Table $table);
	public function setVersioningAttributes(Record $record, $row);
}

class DefaultQueryTransactionInformation implements QueryTransactionInformation {
	public function getRestriction(Table $table) {
		return "1";
	}
	
	public function getTables() {
		return array();
	}

	public function versioningAttributes() {
		return array();
	}
	
	public function versioningFields($tableName) {
		return array();
	}
	
	public function versioningOrderBy() {
		return array();
	}
	
	public function versioningGroupBy(Table $table) {
		return array();
	}
	
	public function setVersioningAttributes(Record $record, $row) {
	}

	public function __toString() {
		return "QueryTransactionInformation (...)";
	}
}

class QueryLatestTransactionInformation extends DefaultQueryTransactionInformation {
	public function getRestriction(Table $table) {
		return getLatestTransactionRestriction($table->getIdentifier());
	}
	
	public function setVersioningAttributes(Record $record, $row) {
	}
}

class QueryHistoryTransactionInformation extends DefaultQueryTransactionInformation {
	public function versioningAttributes() {

		$o=OmegaWikiAttributes::getInstance();
			
		return array($o->recordLifeSpan);
	}

	public function versioningFields($tableName) {
		return array($tableName . '.add_transaction_id', $tableName . '.remove_transaction_id', $tableName . '.remove_transaction_id IS NULL AS is_live');
	}

	public function versioningOrderBy() {
		return array('is_live DESC', 'add_transaction_id DESC');
	}
	
	public function setVersioningAttributes(Record $record, $row) {

		$o=OmegaWikiAttributes::getInstance();
			
		$record->recordLifeSpan = getRecordLifeSpanTuple($row['add_transaction_id'], $row['remove_transaction_id']);
	}
}

class QueryAtTransactionInformation extends DefaultQueryTransactionInformation {
	protected $transactionId;
	protected $addAttributes;
	
	public function __construct($transactionId, $addAttributes) {
		$this->transactionId = $transactionId;
		$this->addAttributes = $addAttributes;
	}
	
	public function getRestriction(Table $table) {
		return getAtTransactionRestriction($table->getIdentifier(), $this->transactionId);
	}
	
	public function versioningAttributes() {

		$o=OmegaWikiAttributes::getInstance();
		
		if ($this->addAttributes)	
			return array($o->recordLifeSpan);
		else
			return array();
	}
	
	public function versioningFields($tableName) {
		return array($tableName . '.add_transaction_id', $tableName . '.remove_transaction_id', $tableName . '.remove_transaction_id IS NULL AS is_live');
	}
	
	public function setVersioningAttributes(Record $record, $row) {

		$o=OmegaWikiAttributes::getInstance();
			
		if ($this->addAttributes)	
			$record->recordLifeSpan = getRecordLifeSpanTuple($row['add_transaction_id'], $row['remove_transaction_id']);
	}
}

class QueryUpdateTransactionInformation extends DefaultQueryTransactionInformation {
	protected $transactionId;
	
	public function __construct($transactionId) {
		$this->transactionId = $transactionId;
	}
	
	public function getRestriction(Table $table) {
		return 
			" " . $table->getIdentifier() . ".add_transaction_id =". $this->transactionId . 
			" OR " . $table->getIdentifier() . ".removeTransactionId =" . $this->transactionId;
	}
	
//	public function versioningAttributes() {
//		global
//			$recordLifeSpanAttribute;
//			
//		return array();
//	}
	
//	public function versioningFields($tableName) {
//		return array($tableName . '.add_transaction_id', $tableName . '.remove_transaction_id', $tableName . '.remove_transaction_id IS NULL AS is_live');
//	}
	
//	public function setVersioningAttributes($record, $row) {
//		global
//			$recordLifeSpanAttribute;
//			
//		$record->setAttributeValue($recordLifeSpanAttribute, getRecordLifeSpanTuple($row['add_transaction_id'], $row['remove_transaction_id']));
//	}
}


global
	$updateTransactionId;

function startNewTransaction($userID, $userIP, $comment, $dc=null) {

	global
		$updateTransactionId;

	if(is_null($dc)) {
		$dc=wdGetDataSetContext();
	} 

	$dbr =& wfGetDB(DB_MASTER);
	$timestamp = wfTimestampNow();
	
	$dbr->query("INSERT INTO {$dc}_transactions (user_id, user_ip, timestamp, comment) VALUES (". $userID . ', ' . $dbr->addQuotes($userIP) . ', ' . $timestamp . ', ' . $dbr->addQuotes($comment) . ')');
	$updateTransactionId = $dbr->insertId();
}

function getUpdateTransactionId() {
	global
		$updateTransactionId;

	return $updateTransactionId;	
}

function getLatestTransactionId() {
	$dc=wdGetDataSetContext();
	$dbr =& wfGetDB(DB_SLAVE);
	$queryResult = $dbr->query("SELECT max(transaction_id) AS transaction_id FROM {$dc}_transactions");

	if ($transaction = $dbr->fetchObject($queryResult)) 
		return $transaction->transaction_id;
	else
		return 0;
}

function getLatestTransactionRestriction($table) {
	return ' '. $table . '.remove_transaction_id IS NULL ';
}

function getAtTransactionRestriction($table, $transactionId) {
	return ' '. $table . '.add_transaction_id <= '. $transactionId . ' AND ('.		
				$table . '.remove_transaction_id > '. $transactionId . ' OR ' . $table . '.remove_transaction_id IS NULL) ';
}

function getViewTransactionRestriction($table) {
	global
		$wgRequest;
	
	$action = $wgRequest->getText('action');
	
	if ($action == 'edit')
		return getLatestTransactionRestriction($table);
	else if ($action == 'history')
		return '1';
	else 
		return getLatestTransactionRestriction($table);		
}

function getOperationSelectColumn($table, $transactionId) {
	return " IF($table.add_transaction_id=$transactionId, 'Added', 'Removed') AS operation "; 
}

function getInTransactionRestriction($table, $transactionId) {
	return " ($table.add_transaction_id=$transactionId OR $table.remove_transaction_id=$transactionId) ";
}


function getUserName($userId) {
	$dbr =& wfGetDB(DB_SLAVE);
	$queryResult = $dbr->query("SELECT user_name FROM user WHERE user_id=$userId");
	
	if ($user = $dbr->fetchObject($queryResult))
		return $user->user_name;
	else
		return "";
}

function getUserLabel($userId, $userIP) {
	if ($userId > 0)
		return getUserName($userId);
	else if ($userIP != "")
		return $userIP;
	else
		return "Unknown"; 
}

function expandUserIDsInRecordSet(RecordSet $recordSet, Attribute $userID, Attribute $userIP) {
	for ($i = 0; $i < $recordSet->getRecordCount(); $i++) { 
		$record = $recordSet->getRecord($i);
		$record->setAttributeValue(
			$userIDAttribute, 
			getUserLabel(
				$record->$userIDAttribute,
				$record->$userIP
			)
		);
	}
}								

function expandTransactionIdsInRecordSet(RecordSet $recordSet) {
	for ($i = 0; $i < $recordSet->getRecordCount(); $i++) { 
		$record = $recordSet->getRecord($i);
		$record->transaction = getTransactionRecord($record->transactionId);
	}
}	

function getTransactionRecord($transactionId) {

	$o=OmegaWikiAttributes::getInstance();
	
	$dc=wdGetDataSetContext();
	$result = new ArrayRecord($o->transactionStructure);
	$result->transactionId = $transactionId;
	
	if ($transactionId > 0) {
		$dbr =& wfGetDB(DB_SLAVE);
		$queryResult = $dbr->query("SELECT user_id, user_ip, timestamp, comment FROM {$dc}_transactions WHERE transaction_id=$transactionId");
		
		if ($transaction = $dbr->fetchObject($queryResult)) {
			$result->user = getUserLabel($transaction->user_id, $transaction->user_ip);	
			$result->timestamp = $transaction->timestamp;
			$result->summary = $transaction->comment;
		}
	}
	else {
		if ($transactionId != null)
			$result->user = "Unknown";
		else
			$result->user = "";	
				
		$result->timestamp = "";
		$result->summary = "";
	}

	return $result;
}

function getRecordLifeSpanTuple($addTransactionId, $removeTransactionId) {

	$o=OmegaWikiAttributes::getInstance();
	
	$result = new ArrayRecord($o->recordLifeSpanStructure);
	$result->addTransaction = getTransactionRecord($addTransactionId);
	$result->removeTransaction = getTransactionRecord($removeTransactionId);
	
	return $result;
}

function getTransactionLabel($transactionId) {

	$o=OmegaWikiAttributes::getInstance();
	
	if ($transactionId > 0) {
		$record = getTransactionRecord($transactionId);
		
		$label = 
			timestampAsText($record->timestamp) . ', ' .
			$record->user;
			
		$summary = $record->summary;
		
		if ($summary != "")
			$label .= ', ' . $summary;
			
		return $label;
	}
	else 
		return "";
}


