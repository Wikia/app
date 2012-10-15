<?php

class WikiaSpecialUnlockdb extends SpecialUnlockdb {
	public function __construct() {
		parent::__construct();
	}

	public function checkExecutePermissions( User $user ) {
		global $wgReadOnly;

		FormSpecialPage::checkExecutePermissions( $user );
		
		if ( empty( $wgReadOnly ) ) {
			throw new ErrorPageError( 'lockdb', 'databasenotlocked' );
		}
	}

	public function onSubmit( array $data ) {
		global $wgCityId;

		$res = true;
		if ( !$data['Confirm'] ) {
			return Status::newFatal( 'locknoconfirm' );
		}

		wfSuppressWarnings();	
		if ( !WikiFactory::setVarByName( 'wgReadOnly', $wgCityId, '' ) ) {
			wfDebug(__METHOD__ . ": cannot set wgReadOnly for Wikia: $wgCityId \n");
			$res = false;	
		} 
		
		if ( !WikiFactory::clearCache( $wgCityId ) ) {
			wfDebug(__METHOD__ . ": cannot clear cache for Wikia: $wgCityId \n");
			$res = false;	
		}
		wfRestoreWarnings();

		if ( $res ) {
			return Status::newGood();
		} else {
			return Status::newFatal ( 'unlockdb-wikifactory-error' );
		}
	}
}
