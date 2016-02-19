<?php
namespace Wikia\ExactTarget;

interface Client {
	public function updateUser( array $userData );

	public function deleteSubscriber( $userId );

	public function createSubscriber( $userEmail );
}
