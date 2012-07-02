<?php

/**
 * Email Blacklisting
 */
class EmailBlacklist extends BaseBlacklist {

	/**
	 * Returns the code for the blacklist implementation
	 *
	 * @return string
	 */
	protected function getBlacklistType() {
		return 'email';
	}

	/**
	 * Checks a User object for a blacklisted e-mail address
	 *
	 * @param User $user
	 * @return bool True on valid email
	 */
	public function checkUser( User $user ) {
		$blacklists = $this->getBlacklists();
		$whitelists = $this->getWhitelists();

		// The email to check
		$email = $user->getEmail();

		if ( !count( $blacklists ) ) {
			// Nothing to check
			return true;
		}

		// Check for whitelisted e-mail addresses
		if ( is_array( $whitelists ) ) {
			wfDebugLog( 'SpamBlacklist', "Excluding whitelisted e-mail addresses from " . count( $whitelists ) .
				" regexes: " . implode( ', ', $whitelists ) . "\n" );
			foreach ( $whitelists as $regex ) {
				if ( preg_match( $regex, $email ) )  {
					// Whitelisted email
					return true;
				}
			}
		}


		# Do the match
		wfDebugLog( 'SpamBlacklist', "Checking e-mail address against " . count( $blacklists ) .
			" regexes: " . implode( ', ', $blacklists ) . "\n" );
		foreach ( $blacklists as $regex ) {
			if ( preg_match( $regex, $email ) ) {
				return false;
			}
		}

		return true;
	}
}
