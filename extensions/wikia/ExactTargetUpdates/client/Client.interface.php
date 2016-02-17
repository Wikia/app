<?php
namespace Wikia\ExactTarget;

interface Client {
	public function createUser( array $aUserData );

	public function deleteSubscriber( $userId );

	public function createSubscriber( $userEmail );
}
