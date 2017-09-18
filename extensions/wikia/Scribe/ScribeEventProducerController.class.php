<?php

class ScribeEventProducerController {

	static public function onSaveComplete(
		WikiPage $oPage, User $oUser, $text, $summary, $minor, $undef1, $undef2,
		$flags, $oRevision, Status &$status, $baseRevId
	): bool {
		wfProfileIn( __METHOD__ );

		$key = ( isset( $status->value['new'] ) && $status->value['new'] == 1 ) ? 'create' : 'edit';
		$is_archive = !empty( $undef1 );

 		$oScribeProducer = new ScribeEventProducer( $key, $is_archive );
		if ( $oScribeProducer->buildEditPackage( $oPage, $oUser, $oRevision ) ) {
			$oScribeProducer->sendLog();
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	static public function onSaveRevisionComplete( $oPage, $oRevision, $revision_id, $oUser, $allow = true ) {
		wfProfileIn( __METHOD__ );

		# producer
		if ( $allow ) {
			$oScribeProducer = new ScribeEventProducer( 'edit' );

			if ( $oScribeProducer->buildEditPackage( $oPage, $oUser, $oRevision ) ) {
				$oScribeProducer->sendLog();
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}


	static public function onDeleteComplete( WikiPage $oPage, User $oUser, $reason, $page_id ): bool {
		wfProfileIn( __METHOD__ );

 		$oScribeProducer = new ScribeEventProducer( 'delete' );
		if ( $oScribeProducer->buildRemovePackage ( $oPage, $oUser, $page_id ) ) {
			$oScribeProducer->sendLog();
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	static public function onRevisionUndeleted( Title $oTitle, Revision $oRevision, $page_id ) {
		wfProfileIn( __METHOD__ );


		$oPage = WikiPage::factory( $oTitle );
		$oUser = User::newFromId( $oRevision->getUser() );

 		$oScribeProducer = new ScribeEventProducer( 'edit' );
		if ( $oScribeProducer->buildEditPackage( $oPage, $oUser, $oRevision ) ) {
			$oScribeProducer->sendLog();
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	static public function onArticleUndelete( Title $oTitle, $created = false ) {
		wfProfileIn( __METHOD__ );

 		$oScribeProducer = new ScribeEventProducer( 'undelete' );
		if ( $oScribeProducer->buildUndeletePackage( $oTitle, $created ) ) {
			$oScribeProducer->sendLog();
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	static public function onMoveComplete(
		Title $oOldTitle, Title $oNewTitle, User $oUser, $page_id, $redirect_id = 0
	): bool {
		wfProfileIn( __METHOD__ );

 		$oScribeProducer = new ScribeEventProducer( 'edit' );
		if ( $oScribeProducer->buildMovePackage( $oNewTitle, $oUser, $page_id ) ) {
			$oScribeProducer->sendLog();
		}

		if ( !empty( $redirect_id ) ) {
			$oScribeProducer = new ScribeEventProducer( 'edit' );
			if ( $oScribeProducer->buildMovePackage( $oOldTitle, $oUser, null, $redirect_id ) ) {
				$oScribeProducer->sendLog();
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	static public function notifyPageHasChanged( $oPage ) {
		wfProfileIn( __METHOD__ );

		$username = $oPage->getUserText();
		if ( empty( $username ) ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe: invalid username" );
			wfProfileOut( __METHOD__ );
			return true;
		}

		$oUser = User::newFromName( $username );
		if ( !$oUser instanceof User ) {
			Wikia::log( __METHOD__, "error", "Cannot send log using scribe: invalid user object" );
			wfProfileOut( __METHOD__ );
			return true;
		}

		$oScribeProducer = new ScribeEventProducer( 'edit' );
		if ( is_object( $oScribeProducer ) ) {
			if ( $oScribeProducer->buildEditPackage( $oPage, $oUser) ) {
				$oScribeProducer->sendLog();
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}
}
