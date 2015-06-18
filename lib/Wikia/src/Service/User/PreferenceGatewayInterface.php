<?php

namespace Wikia\Service\User;

interface PreferenceGatewayInterface {

	public function save( int $userId, array $preferences );
	public function find( int $userId );

}
