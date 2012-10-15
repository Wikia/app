<?php

/**
 * Utility class for working with blacklists
 */
class SpamRegexBatch {
	/**
	 * Build a set of regular expressions matching URLs with the list of regex fragments.
	 * Returns an empty list if the input list is empty.
	 *
	 * @param array $lines list of fragments which will match in URLs
	 * @param int $batchSize largest allowed batch regex;
	 *                       if 0, will produce one regex per line
	 * @return array
	 */
	static function buildRegexes( $lines, BaseBlacklist $blacklist, $batchSize=4096 ) {
		# Make regex
		# It's faster using the S modifier even though it will usually only be run once
		//$regex = 'https?://+[a-z0-9_\-.]*(' . implode( '|', $lines ) . ')';
		//return '/' . str_replace( '/', '\/', preg_replace('|\\\*/|', '/', $regex) ) . '/Sim';
		$regexes = array();
		$regexStart = $blacklist->getRegexStart();
		$regexEnd = $blacklist->getRegexEnd( $batchSize );
		$build = false;
		foreach( $lines as $line ) {
			if( substr( $line, -1, 1 ) == "\\" ) {
				// Final \ will break silently on the batched regexes.
				// Skip it here to avoid breaking the next line;
				// warnings from getBadLines() will still trigger on
				// edit to keep new ones from floating in.
				continue;
			}
			// FIXME: not very robust size check, but should work. :)
			if( $build === false ) {
				$build = $line;
			} elseif( strlen( $build ) + strlen( $line ) > $batchSize ) {
				$regexes[] = $regexStart .
					str_replace( '/', '\/', preg_replace('|\\\*/|u', '/', $build) ) .
					$regexEnd;
				$build = $line;
			} else {
				$build .= '|';
				$build .= $line;
			}
		}
		if( $build !== false ) {
			$regexes[] = $regexStart .
				str_replace( '/', '\/', preg_replace('|\\\*/|u', '/', $build) ) .
				$regexEnd;
		}
		return $regexes;
	}

	/**
	 * Confirm that a set of regexes is either empty or valid.
	 *
	 * @param $regexes array set of regexes
	 * @return bool true if ok, false if contains invalid lines
	 */
	static function validateRegexes( $regexes ) {
		foreach( $regexes as $regex ) {
			wfSuppressWarnings();
			$ok = preg_match( $regex, '' );
			wfRestoreWarnings();

			if( $ok === false ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Strip comments and whitespace, then remove blanks
	 *
	 * @param $lines array
	 * @return array
	 */
	static function stripLines( $lines ) {
		return array_filter(
			array_map( 'trim',
				preg_replace( '/#.*$/', '',
					$lines ) ) );
	}

	/**
	 * Do a sanity check on the batch regex.
	 *
	 * @param $lines string unsanitized input lines
	 * @param $fileName string optional for debug reporting
	 * @return array of regexes
	 */
	static function buildSafeRegexes( $lines, BaseBlacklist $blacklist, $fileName=false ) {
		$lines = SpamRegexBatch::stripLines( $lines );
		$regexes = SpamRegexBatch::buildRegexes( $lines, $blacklist );
		if( SpamRegexBatch::validateRegexes( $regexes ) ) {
			return $regexes;
		} else {
			// _Something_ broke... rebuild line-by-line; it'll be
			// slower if there's a lot of blacklist lines, but one
			// broken line won't take out hundreds of its brothers.
			if( $fileName ) {
				wfDebugLog( 'SpamBlacklist', "Spam blacklist warning: bogus line in $fileName\n" );
			}
			return SpamRegexBatch::buildRegexes( $lines, $blacklist, 0 );
		}
	}

	/**
	 * Returns an array of invalid lines
	 *
	 * @param array $lines
	 * @return array of input lines which produce invalid input, or empty array if no problems
	 */
	static function getBadLines( $lines, BaseBlacklist $blacklist ) {
		$lines = SpamRegexBatch::stripLines( $lines );

		$badLines = array();
		foreach( $lines as $line ) {
			if( substr( $line, -1, 1 ) == "\\" ) {
				// Final \ will break silently on the batched regexes.
				$badLines[] = $line;
			}
		}

		$regexes = SpamRegexBatch::buildRegexes( $lines, $blacklist );
		if( SpamRegexBatch::validateRegexes( $regexes ) ) {
			// No other problems!
			return $badLines;
		}

		// Something failed in the batch, so check them one by one.
		foreach( $lines as $line ) {
			$regexes = SpamRegexBatch::buildRegexes( array( $line ), $blacklist );
			if( !SpamRegexBatch::validateRegexes( $regexes ) ) {
				$badLines[] = $line;
			}
		}
		return $badLines;
	}

	/**
	 * Build a set of regular expressions from the given multiline input text,
	 * with empty lines and comments stripped.
	 *
	 * @param $source string
	 * @param $fileName bool|string optional, for reporting of bad files
	 * @return array of regular expressions, potentially empty
	 */
	static function regexesFromText( $source, BaseBlacklist $blacklist, $fileName=false ) {
		$lines = explode( "\n", $source );
		return SpamRegexBatch::buildSafeRegexes( $lines, $blacklist, $fileName );
	}

	/**
	 * Build a set of regular expressions from a MediaWiki message.
	 * Will be correctly empty if the message isn't present.
	 *
	 * @param $message string
	 * @return array of regular expressions, potentially empty
	 */
	static function regexesFromMessage( $message, BaseBlacklist $blacklist ) {
		$source = wfMsgForContent( $message );
		if( $source && !wfEmptyMsg( $message, $source ) ) {
			return SpamRegexBatch::regexesFromText( $source, $blacklist );
		} else {
			return array();
		}
	}
}

