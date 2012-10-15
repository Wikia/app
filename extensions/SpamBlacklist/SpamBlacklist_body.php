<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

class SpamBlacklist extends BaseBlacklist {
	var $files = array( "http://meta.wikimedia.org/w/index.php?title=Spam_blacklist&action=raw&sb_ver=1" );
	var $ignoreEditSummary = false;

	/**
	 * Returns the code for the blacklist implementation
	 *
	 * @return string
	 */
	protected function getBlacklistType() {
		return 'spam';
	}

	/**
	 * @param Title $title
	 * @param string $text Text of section, or entire text if $editPage!=false
	 * @param string $section Section number or name
	 * @param EditSummary $editSummary Edit summary if one exists, some people use urls there too
	 * @param EditPage $editPage EditPage if EditFilterMerged was called, null otherwise
	 * @return Matched text if the edit should not be allowed, false otherwise
	 */
	function filter( &$title, $text, $section, $editsummary = '', EditPage &$editPage = null ) {
		/**
		 * @var $wgParser Parser
		 */
		global $wgParser, $wgUser;

		$fname = 'wfSpamBlacklistFilter';
		wfProfileIn( $fname );

		# These don't do anything, commenting out...
		#$this->title = $title;
		#$this->text = $text;
		#$this->section = $section;
		$text = str_replace( '．', '.', $text ); //@bug 12896

		$blacklists = $this->getBlacklists();
		$whitelists = $this->getWhitelists();

		if ( count( $blacklists ) ) {
			# Run parser to strip SGML comments and such out of the markup
			# This was being used to circumvent the filter (see bug 5185)
			if ( $editPage ) {
				$editInfo = $editPage->mArticle->prepareTextForEdit( $text );
				$out = $editInfo->output;
			} else {
				$options = new ParserOptions();
				$text = $wgParser->preSaveTransform( $text, $title, $wgUser, $options );
				$out = $wgParser->parse( $text, $title, $options );
			}
			$newLinks = array_keys( $out->getExternalLinks() );
			$oldLinks = $this->getCurrentLinks( $title );
			$addedLinks = array_diff( $newLinks, $oldLinks );

			// We add the edit summary if one exists
			if ( !$this->ignoreEditSummary && !empty( $editsummary ) ) {
				$addedLinks[] = $editsummary;
			}

			wfDebugLog( 'SpamBlacklist', "Old URLs: " . implode( ', ', $oldLinks ) );
			wfDebugLog( 'SpamBlacklist', "New URLs: " . implode( ', ', $newLinks ) );
			wfDebugLog( 'SpamBlacklist', "Added URLs: " . implode( ', ', $addedLinks ) );

			$links = implode( "\n", $addedLinks );

			# Strip whitelisted URLs from the match
			if( is_array( $whitelists ) ) {
				wfDebugLog( 'SpamBlacklist', "Excluding whitelisted URLs from " . count( $whitelists ) .
					" regexes: " . implode( ', ', $whitelists ) . "\n" );
				foreach( $whitelists as $regex ) {
					wfSuppressWarnings();
					$newLinks = preg_replace( $regex, '', $links );
					wfRestoreWarnings();
					if( is_string( $newLinks ) ) {
						// If there wasn't a regex error, strip the matching URLs
						$links = $newLinks;
					}
				}
			}

			# Do the match
			wfDebugLog( 'SpamBlacklist', "Checking text against " . count( $blacklists ) .
				" regexes: " . implode( ', ', $blacklists ) . "\n" );
			$retVal = false;
			foreach( $blacklists as $regex ) {
				wfSuppressWarnings();
				$matches = array();
				$check = preg_match( $regex, $links, $matches );
				wfRestoreWarnings();
				if( $check ) {
					wfDebugLog( 'SpamBlacklist', "Match!\n" );
					$ip = wfGetIP();
					wfDebugLog( 'SpamBlacklistHit', "$ip caught submitting spam: {$matches[0]}\n" );
					$retVal = $matches[0];
				break;
				}
			}
		} else {
			$retVal = false;
		}

		wfProfileOut( $fname );
		return $retVal;
	}

	/**
	 * Look up the links currently in the article, so we can
	 * ignore them on a second run.
	 *
	 * WARNING: I can add more *of the same link* with no problem here.
	 * @param $title Title
	 * @return array
	 */
	function getCurrentLinks( $title ) {
		$dbr = wfGetDB( DB_SLAVE );
		$id = $title->getArticleId(); // should be zero queries
		$res = $dbr->select( 'externallinks', array( 'el_to' ),
			array( 'el_from' => $id ), __METHOD__ );
		$links = array();
		foreach ( $res as $row ) {
			$links[] = $row->el_to;
		}
		return $links;
	}

	/**
	 * Returns the start of the regex for matches
	 *
	 * @return string
	 */
	public function getRegexStart() {
		return '/(?:https?:)\/\/+[a-z0-9_\-.]*(';
	}

	/**
	 * Returns the end of the regex for matches
	 *
	 * @param $batchSize
	 * @return string
	 */
	public function getRegexEnd( $batchSize ) {
		return ')' . parent::getRegexEnd( $batchSize );
	}
}
