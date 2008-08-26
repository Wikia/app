<?php
$IP = getenv( 'MW_INSTALL_PATH' );
if ( !$IP ) {
	exit;
}
require_once( $IP . '/maintenance/commandLine.inc' );

$dbr = wfGetDB( DB_SLAVE );
$fname = 'voterList.php';
$maxUser = $dbr->selectField( 'user', 'MAX(user_id)', false );
$server = str_replace( 'http://', '', $wgServer );
$listFile = fopen( "voter-list", "a" );

for ( $user = 1; $user <= $maxUser; $user++ ) {
	$oldEdits = $dbr->selectField( 
		'revision', 
		'COUNT(*)',
		array( 
			'rev_user' => $user,
			"rev_timestamp < '200803010000'"
		), 
		$fname
	);
	$newEdits = $dbr->selectField( 
		'revision', 
		'COUNT(*)',
		array( 
			'rev_user' => $user,
			"rev_timestamp BETWEEN '200801010000' AND '200805285959'"
		), 
		$fname
	);
	if ( $oldEdits >= 600 && $newEdits >= 50 ) {
		$userObj = User::newFromId( $user );
		$props = array();
		if ( $userObj->isAllowed( 'bot' ) ) {
			$props[] = 'bot';
		}
		$isBlocked = $userObj->isBlocked();
		if ( $userObj->isBlocked() 
			&& $userObj->mBlock->mExpiry == 'infinity' )
		{
			$props[] = 'indefblocked';
		}
		$props = implode( ',', $props );
		$email = $userObj->getEmail();
		$editCount = $userObj->getEditCount();
		$name = $userObj->getName();

		fwrite( $listFile, "$wgDBname\t$server\t$name\t" . 
			"$email\t$editCount\t$props\n" );
	}
}
fclose( $listFile );

?>
