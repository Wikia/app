<?php
namespace Wikia\Service\User\Username;

class MediawikiUsernameService implements UsernameService {

	/**
	 * return username from database
	 *
	 * @param $id int
	 * @param $fallback string
	 * @return string username
	 */
	public function getUsername( $id, $fallback ) {

		return $id == 0 ? $fallback : \User::whoIs( $id );
	}
}
