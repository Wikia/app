<?php

require_once( "extensions/Wikidata/OmegaWiki/WikiDataAPI.php" );

function ConvertIsoToEpoch( $iso ){
	// 01234567890123456789
	// 2007-05-01-T00:00:00
    return substr( $iso, 0, 4 ) . substr( $iso, 5, 2 ) . substr( $iso, 8, 2 ) . substr( $iso, 12, 2 ) . substr( $iso, 15, 2 ) . substr( $iso, 18, 2 );
}

function ConvertEpochToIso( $epoch ){
	// 01234567890123456789
	// 20070501000000
	return substr( $epoch, 0, 4 ) . "-" . substr( $epoch, 4, 2 ) . "-" . substr( $epoch, 6, 2 ) . "-T" . substr( $epoch, 8, 2 ) . ":" . substr( $epoch, 10, 2 ) . ":" . substr( $epoch, 12, 2 ); 
}

function getDefinedMeaning( $dc, $textId ){
	// translate the text id to a translated text id	
	$dbr = &wfGetDB(DB_SLAVE);
	$queryResult = $dbr->query( "select translated_content_id from {$dc}_translated_content where text_id = $textId and remove_transaction_id is NULL" );
	if ( $row = $dbr->fetchObject( $queryResult ) ){
		$tcid = $row->translated_content_id;
	}
	else{
		return -1;
	}

	// try the definition first
	$queryResult = $dbr->query( "select defined_meaning_id from uw_defined_meaning where meaning_text_tcid = $tcid" );
	if ( $row = $dbr->fetchObject( $queryResult ) ){
		$definedMeaningId = $row->defined_meaning_id;
		return $definedMeaningId;
	}
	
	// try the translated text attributes
	$queryResult = $dbr->query( "select object_id from uw_translated_content_attribute_values where value_tcid = $tcid" );
	if ( $row = $dbr->fetchObject( $queryResult ) ){
		$definedMeaningId = $row->object_id;
		return $definedMeaningId;
	}

	// try the text attributes
	$queryResult = $dbr->query( "select object_id from uw_text_attribute_values where value_id = $tcid" );
	if ( $row = $dbr->fetchObject( $queryResult ) ){
		$definedMeaningId = $row->object_id;
		return $definedMeaningId;
	}

	return -1;
}

function getInternalIdentifier( $dc, $definedMeaningId, $languageId ){
	$collectionName = "uw";

	$dbr = &wfGetDB(DB_SLAVE);
	$query = "SELECT collection_id, internal_member_id FROM {$dc}_collection_contents where member_mid = $definedMeaningId";
	$queryResult = $dbr->query( "SELECT collection_id, internal_member_id FROM {$dc}_collection_contents where member_mid = $definedMeaningId" );
	if ( $row = $dbr->fetchObject( $queryResult ) ){
		$internalMemberId = $row->internal_member_id;

		$collectionDefinedMeaningId = getCollectionMeaningId( $row->collection_id );
		$queryResult = $dbr->query( "SELECT meaning_text_tcid FROM {$dc}_defined_meaning  where defined_meaning_id = $collectionDefinedMeaningId" );
		if ( $row = $dbr->fetchObject( $queryResult ) ){
			$queryResult = $dbr->query( "SELECT text_id FROM {$dc}_translated_content where translated_content_id = $row->meaning_text_tcid" );
			if ( $row = $dbr->fetchObject( $queryResult ) ){
				$queryResult = $dbr->query( "SELECT text_text FROM {$dc}_text where text_id = $row->text_id" );
				if ( $row = $dbr->fetchObject( $queryResult ) ){
					if ( $row->text_text == "Swiss-Prot" ){
						$collectionName = "uniprot";
					}
				}
			}
		}

		return $collectionName . '/' . $internalMemberId;
	}
	else{
		return "";
	}
	
}

function getTextForId( $dc, $text_id ){
	$dbr = &wfGetDB(DB_SLAVE);
	$textResult = $dbr->query( "select text_text from {$dc}_text where text_id = $text_id" );
	if ( $textRecord = $dbr->fetchObject($textResult) ){
		return $textRecord->text_text;
	}
	else {
		return( "" );
	}
}

function getDefinedMeaningTitle( $dc, $definedMeaningId ){
	$dbr = &wfGetDB(DB_SLAVE);
	$result = $dbr->query( "SELECT meaning_text_tcid FROM {$dc}_defined_meaning  where defined_meaning_id = $definedMeaningId" );
	if ( $record = $dbr->fetchObject($result) ){
		$result = $dbr->query( "SELECT text_id FROM {$dc}_translated_content where translated_content_id = $record->meaning_text_tcid and remove_transaction_id IS NULL" );
		if ( $record = $dbr->fetchObject($result) ){
			return getTextForId( $dc, $record->text_id ) . "_(" . $definedMeaningId . ")";
		}
	}
	return( "" );
}

function getUser( $user_id ){
	$dbr = &wfGetDB(DB_SLAVE);
	$queryResult = $dbr->query( "SELECT user_name FROM `user` u where user_id = $user_id" );
	if ( $row = $dbr->fetchObject( $queryResult ) ){
		return $row->user_name;
	}
	return "unknown";		
}

// XML Entity Mandatory Escape Characters
function xmlentities($string) {
   return str_replace ( array ( '&', '"', "'", '<', '>', '�' ), array ( '&amp;' , '&quot;', '&apos;' , '&lt;' , '&gt;', '&apos;' ), $string );
}

require (dirname(__FILE__) . '/includes/WebStart.php');
global $wgSitename;

// Verify that the API has not been disabled
if (!$wgEnableAPI) {
	echo 'MediaWiki API is not enabled for this site. Add the following line to your LocalSettings.php';
	echo '<pre><b>$wgEnableAPI=true;</b></pre>';
	die(-1);
}

// indicate here the dataset that contains the community version
$dc 			= "uw";

// read the parameters passed as arguments to the alert program
$responseType 	= $_GET["output"];
$epochStartDate = $_GET["startDate"];
$startDate 		= ConvertIsoToEpoch( $epochStartDate );
$epochEndDate 	= $_GET["endDate"];

if ( $epochStartDate == "" ){
	echo 'This alert utility requires a start date in ISO format to be specified as parameter<br />';
	echo 'Usage: alert.php?startDate=2007-05-01-T00:00:00[&endDate=2007-06-31-T00:00:00][&output=(xml|raw)]<br />';
	die(-1);
}

if ( $epochEndDate != "" ){
	$endDate = ConvertIsoToEpoch( $epochEndDate );
	$endClause = " AND timestamp <= $endDate ";
}
else {
	$endClause = "";
}

$dbr = &wfGetDB(DB_SLAVE);

$queryResult = $dbr->query( "select language_id from language where wikimedia_key='en'" );
$languageId = $dbr->fetchObject($queryResult)->language_id;

$transactionResult = $dbr->query( "select transaction_id, user_id, timestamp from {$dc}_transactions where timestamp >= $startDate $endClause" );
if ( $responseType == "xml" ){
	echo "<edits startdate='$epochStartDate'";
	if ( $epochEndDate != "" ){
		echo " enddate='$epochEndDate'";
	}
	echo ">";
}

while ($transactionRecord = $dbr->fetchObject($transactionResult)) {
	$transaction_id = $transactionRecord->transaction_id;
	$timestamp = $transactionRecord->timestamp;
	$user = getUser( $transactionRecord->user_id );

	$translatedContentResult = $dbr->query( "SELECT text_id FROM {$dc}_translated_content WHERE add_transaction_id = $transaction_id AND language_id=$languageId and remove_transaction_id IS NULL" );
	while ($tranlatedContentRecord = $dbr->fetchObject($translatedContentResult)) {
		$definedMeaningId = getDefinedMeaning( $dc, $tranlatedContentRecord->text_id );
		$text = xmlentities( getTextForId( $dc, $tranlatedContentRecord->text_id ) );
		$internalIdentifier = getInternalIdentifier( $dc, $definedMeaningId, $languageId );
		if ( $internalIdentifier != "" ){
			$definedMeaningTitle = getDefinedMeaningTitle( $dc, $definedMeaningId );
			$epochDate = ConvertEpochToIso($timestamp);
			if ( $responseType == "xml" ){
				echo "<record><knowletid>$internalIdentifier</knowletid><text>$text</text><user>$user</user><timestamp>$epochDate</timestamp><definedmeaning>$definedMeaningTitle</definedmeaning><site>$wgSitename</site></record>";			
			}
			else {
				echo "$internalIdentifier|$text|$user|$epochDate|$definedMeaningTitle|$wgSitename\n";
			}
		}
	}
}
if ( $responseType == "xml" ){
	echo "</edits>";
}


?>