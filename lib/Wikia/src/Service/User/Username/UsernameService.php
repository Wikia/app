<?php

namespace Wikia\Service\User\Username;

interface UsernameService{
	/**
	 * For experiment time we are comparing using getUsername by Id, and using string from denormalized table.
	 * This is the reasone to keep fallback.
	 * We will remove fallback if experiment success, or remove whole code if fail.
	 *
	 * @param $id int
	 * @param $fallback string
	 * @return string username
	 */
	public function getUsername( $id, $fallback );
}
