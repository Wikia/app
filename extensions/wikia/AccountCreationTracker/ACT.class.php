<?php

class AccountCreationTracker extends WikiaObject {

	protected function getDb( $type = DB_SLAVE ) {
		return $this->wf->getDb( $type, array(), $this->wg->ExternalDatawareDB );
	}

	public function trackAccount( User $user, $hash ) {
		if( !empty( $hash ) ) {
			$dbw = $this->getDb( DB_MASTER );

			$dbw->insert( 'user_tracker', array( 'utr_user_id' => $user->getId(), 'utr_user_hash' => $hash ) );
			$dbw->commit();
		}
	}

	public function getAccountsByUser( User $user ) {
		$results = array();

		$dbr = $this->getDb( DB_SLAVE );
		$res = $dbr->query( "SELECT utr_user_id FROM user_tracker WHERE utr_user_hash = ( SELECT utr_user_hash FROM user_tracker WHERE utr_user_id = '" . $user->getId() . "' )");

		while( $row = $dbr->fetchObject($res) ) {
			$user = User::newFromId( $row->utr_user_id );;
			if( $user->getId() ) {
				$results[] = $user;
			}
		}

		return $results;
	}

}
