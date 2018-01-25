<?php

use Wikia\Logger\WikiaLogger;

class DataWarehouseEventProducerController {

	static public function onSaveComplete(
		WikiPage $oPage, User $oUser, $text, $summary, $minor, $undef1, $undef2,
		$flags, $oRevision, Status &$status, $baseRevId
	): bool {
		wfProfileIn( __METHOD__ );

		$key = ( isset( $status->value['new'] ) && $status->value['new'] == 1 ) ? 'create' : 'edit';
		$is_archive = !empty( $undef1 );

 		$oEventProducer = new DataWarehouseEventProducer( $key, $is_archive );
		if ( $oEventProducer->buildEditPackage( $oPage, $oUser, $oRevision ) ) {
			$oEventProducer->sendLog();
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	static public function onSaveRevisionComplete( $oPage, $oRevision, $revision_id, $oUser, $allow = true ) {
		wfProfileIn( __METHOD__ );

		# producer
		if ( $allow ) {
			$oEventProducer = new DataWarehouseEventProducer( 'edit' );

			if ( $oEventProducer->buildEditPackage( $oPage, $oUser, $oRevision ) ) {
				$oEventProducer->sendLog();
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}


	static public function onDeleteComplete( WikiPage $oPage, User $oUser, $reason, $page_id ): bool {
		wfProfileIn( __METHOD__ );

 		$oEventProducer = new DataWarehouseEventProducer( 'delete' );
		if ( $oEventProducer->buildRemovePackage ( $oPage, $oUser, $page_id ) ) {
			$oEventProducer->sendLog();
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	static public function onRevisionUndeleted( Title $oTitle, Revision $oRevision, $page_id ) {
		wfProfileIn( __METHOD__ );


		$oPage = WikiPage::factory( $oTitle );
		$oUser = User::newFromId( $oRevision->getUser() );

 		$oEventProducer = new DataWarehouseEventProducer( 'edit' );
		if ( $oEventProducer->buildEditPackage( $oPage, $oUser, $oRevision ) ) {
			$oEventProducer->sendLog();
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	static public function onArticleUndelete( Title $oTitle, $created = false ) {
		wfProfileIn( __METHOD__ );

 		$oEventProducer = new DataWarehouseEventProducer( 'undelete' );
		if ( $oEventProducer->buildUndeletePackage( $oTitle, $created ) ) {
			$oEventProducer->sendLog();
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	static public function onMoveComplete(
		Title $oOldTitle, Title $oNewTitle, User $oUser, $page_id, $redirect_id = 0
	): bool {
		wfProfileIn( __METHOD__ );

 		$oEventProducer = new DataWarehouseEventProducer( 'edit' );
		if ( $oEventProducer->buildMovePackage( $oNewTitle, $oUser, $page_id ) ) {
			$oEventProducer->sendLog();
		}

		if ( !empty( $redirect_id ) ) {
			$oEventProducer = new DataWarehouseEventProducer( 'edit' );
			if ( $oEventProducer->buildMovePackage( $oOldTitle, $oUser, null, $redirect_id ) ) {
				$oEventProducer->sendLog();
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	static public function notifyPageHasChanged( $oPage ) {
		wfProfileIn( __METHOD__ );

		$username = $oPage->getUserText();
		if ( empty( $username ) ) {
			WikiaLogger::instance()->error( 'Cannot send log: invalid username', [
				'method' => __METHOD__
			] );
			wfProfileOut( __METHOD__ );
			return true;
		}

		$oUser = User::newFromName( $username );
		if ( !$oUser instanceof User ) {
			WikiaLogger::instance()->error( 'Cannot send log: invalid user object', [
				'method' => __METHOD__
			] );
			wfProfileOut( __METHOD__ );
			return true;
		}

		$oEventProducer = new DataWarehouseEventProducer( 'edit' );
		if ( is_object( $oEventProducer ) ) {
			if ( $oEventProducer->buildEditPackage( $oPage, $oUser) ) {
				$oEventProducer->sendLog();
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}
}
